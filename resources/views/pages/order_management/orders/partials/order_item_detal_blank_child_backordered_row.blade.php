<tr style="color:rgba(22, 22, 23, 1) !important;border-bottom: 2px solid #d7d7d7;background-color:rgb(251 251 251)" id="collapse_child_<?php echo $backOrderedShipping->order_item_detail_id; ?>" class="collapse collapse-child-{{ $backOrderedShipping->order_item_id }} text-center mob-cbr-row">
    {{-- <td><input data-itemNumber="{{ $backOrderedShipping->order_item_id }}" type="checkbox" value="{{ $backOrderedShipping->order_item_id }}" name="subcheckbox<?php echo $backOrderedShipping->order_item_id; ?>" id='subcheck' class="chkItem"></td> --}}
    <td class="mob-cbr-checkbox">
        <input type="hidden" name="items[{{ $backOrderedShipping->order_item_id }}][{{ $backOrderedShipping->order_item_detail_id }}][blks][{{$key+1}}][shipping_order_detail_id]" value="{{ $backOrderedShipping->id }}">
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
    <td class="mobile-blank-child-cell mobile-blank-child-remake"><i class="fa fa-plus-circle " style="color: rgb(182 182 182);" aria-hidden="true" title="Add to remake"></i></td>
    <td class="mobile-blank-child-cell-size mobile-blank-child-backorder-size" style="outline: unset; text-align:end">
        <input type="hidden" name="items[{{ $backOrderedShipping->order_item_id }}][{{ $backOrderedShipping->order_item_detail_id }}][blks][{{$key+1}}][size_id]" value="{{ $backOrderedShipping->size_id }}">
        <input type="hidden" name="items[{{ $backOrderedShipping->order_item_id }}][{{ $backOrderedShipping->order_item_detail_id }}][blks][{{$key+1}}][size_name]" value="{{ $backOrderedShipping->size_name ?? '' }}">
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
        @else
            {{ $backOrderedShipping->size_name }}
        @endif
    </td>
    <td style="outline: unset"></td>
    <td style="outline: unset"></td>
    <td style="outline: unset" class="mobile-blank-child-cell-backorder mobile-blank-child-order-backorder-qty">
        <input type="number" class="invoice-inputs text-center order-qty" name="items[{{ $backOrderedShipping->order_item_id }}][{{ $backOrderedShipping->order_item_detail_id }}][blks][{{$key+1}}][order_qty]" value="{{ $backOrderedShipping->order_qty }}" readonly>
    </td>
        @php
            $shippedQty = $backOrderedShipping->shipped_qty;
            $backOrderedQty = $backOrderedShipping->back_ordered_qty;
            if($shippedQty != '' && ($backOrderedQty == null || $backOrderedQty == '')){
                $backOrderedQty = $backOrderedShipping->order_qty - $shippedQty;
            }
        @endphp
    <td class="mobile-blank-child-cell-backorder mobile-blank-child-order-backorder-shipped">
        <input type="number" class="invoice-inputs text-center emergency-edit-{{$backOrderedShipping->notify_status}} shipping-input shipping-qty item-detail-shipped-qty-{{ $backOrderedShipping->order_item_detail_id }} item-shipped-qty-{{ $backOrderedShipping->order_item_id }}" name="items[{{ $backOrderedShipping->order_item_id }}][{{ $backOrderedShipping->order_item_detail_id }}][blks][{{$key+1}}][shipped_qty]" value="{{$shippedQty}}" min="0" max="{{$backOrderedShipping->order_qty}}" data-item-id="{{ $backOrderedShipping->order_item_id }}" onchange="updateBackorderedQty(this)"/>
    </td>

    <td class=" mobile-blank-child-cell-backorder mobile-blank-child-order-backorder-backed" data-label="Back Ordered Qty">
        <input type="number" class="invoice-inputs text-center shipping-input backed-qty item-detail-backed-qty-{{ $backOrderedShipping->order_item_detail_id }} item-backed-qty-{{ $backOrderedShipping->order_item_id }}" name="items[{{ $backOrderedShipping->order_item_id }}][{{ $backOrderedShipping->order_item_detail_id }}][blks][{{$key+1}}][back_ordered_qty]" value="{{$backOrderedQty}}" readonly/>
    </td>

    <td class="mob-cbr-cell" data-label="Est Delivery">
        <input type="text" class="invoice-inputs text-center emergency-edit-{{$backOrderedShipping->notify_status}} shipping-datepicker shipping-input itemEstDiliveryDate" placeholder="MM/DD/YY" name="items[{{ $backOrderedShipping->order_item_id }}][{{ $backOrderedShipping->order_item_detail_id }}][blks][{{$key+1}}][est_delivery_date]" value="{{ date_format(date_create($backOrderedShipping->est_delivery_date),"m/d/Y"); }}"/>
    </td>
    <td class="mob-cbr-cell" data-label="Courier">
        <select  class="CourierService CourierService-select invoice-inputs text-center emergency-edit-{{$backOrderedShipping->notify_status}} shipping-input" name="items[{{ $backOrderedShipping->order_item_id }}][{{ $backOrderedShipping->order_item_detail_id }}][blks][{{$key+1}}][CourierService]"   id="CourierService{{  $backOrderedShipping->order_item_detail_id  }}">
            <option value="">Select Courier</option>
            <option value="UPS" @if( $backOrderedShipping->CourierService  == "UPS") selected="selected" @endif>UPS</option>
            <option value="FedEx" @if( $backOrderedShipping->CourierService  == "FedEx") selected="selected" @endif>FedEx</option>
            <option value="DHL" @if( $backOrderedShipping->CourierService  == "DHL") selected="selected" @endif>DHL</option>
            <option value="Other" @if( $backOrderedShipping->CourierService  == "Other") selected="selected" @endif>Other</option>
        </select>
    </td>
    <td class="mob-cbr-cell" data-label="Tracking Number">
        <input
            type="text"
            {{-- onkeyup="addTrackingNo(this)" --}}
            class="txtTrackingNo invoice-inputs text-center emergency-edit-{{$backOrderedShipping->notify_status}} shipping-input"
            data-itemNumber="{{ $backOrderedShipping->order_item_detail_id }}"
            name="items[{{ $backOrderedShipping->order_item_id }}][{{ $backOrderedShipping->order_item_detail_id }}][blks][{{$key+1}}][tracking_no]"
            id="txtTrackNo{{ $backOrderedShipping->order_item_detail_id  }}"
            value="{{ $backOrderedShipping->tracking_no  }}"
        />
    </td>

    <td class="mob-cbr-cell" data-label="Tracking Link">
        <input
            type="text"
            {{-- onkeyup="addTrackingLink(this)" --}}
            class="txtTrackingLink invoice-inputs text-center emergency-edit-{{$backOrderedShipping->notify_status}} shipping-input"
            data-itemNumber="{{ $backOrderedShipping->order_item_detail_id }}"
            name="items[{{ $backOrderedShipping->order_item_id }}][{{ $backOrderedShipping->order_item_detail_id }}][blks][{{$key+1}}][tracking_link]"
            id="txtTrackLink{{ $backOrderedShipping->order_item_detail_id  }}"
            value="{{ $backOrderedShipping->tracking_link }}"
        />
    </td>

    <td class="mob-cbr-cell mob-cbr-status-cell" data-label="Notify" style="vertical-align: middle;">
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

    <td style="vertical-align: middle;" class="mob-cbr-cell mob-cbr-notified-cell text-center" data-label="Notified By">
            <p class="notify-user">{!! $shipTrait->getNotifiedByBackOrdered($backOrderedShipping->id) !!}</p>
        {{-- @endif --}}
    </td>
</tr>
