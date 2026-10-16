{{-- <tr style="color:black;border-bottom: 2px solid #d7d7d7;background-color:rgb(251 251 251)" id="collapse_child_<?php echo $orderItemDetail->id; ?>" class="collapse collapse-child-{{ $orderItem->id }} text-center">
    <td style="background-color:white"><input data-itemNumber="{{ $orderItem->id }}" type="checkbox" value="{{ $seqData[$orderItem->id][$orderItemDetail->id][$seq]['sub_checkbox_value'] }}" name="subcheckbox<?php echo $orderItem->id; ?>" id='subcheck' class="chkItemChild seqcheckbox{{ $orderItemDetail->id }}"></td>
    <td style="background-color: white"><i class="fa fa-plus-circle" style="color: rgb(182 182 182);" aria-hidden="true" title="Add to remake" onclick="addToRemake()" ></i></td>
    <td style="outline: unset; text-align:end">
        <input type="hidden" name="items[{{ $orderItem->id }}][{{ $orderItemDetail->id }}][{{ $key }}][size_id]" value="{{ $orderItemDetail->size_id }}">


        <input type="hidden" name="items[{{ $orderItem->id }}][{{ $orderItemDetail->id }}][{{ $key }}][size_name]" value="{{ $seqData[$orderItem->id][$orderItemDetail->id][$seq]['rowSizeName'] }}">
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
    <td style="outline: unset">
        <input type="hidden" name="items[{{ $orderItem->id }}][{{ $orderItemDetail->id }}][{{ $key }}][seq_name]" value="{{ 'player_'.$seq }}">
        <input type="hidden" name="items[{{ $orderItem->id }}][{{ $orderItemDetail->id }}][{{ $key }}][player_name]" value="{{ $orderItemDetail->playerDetails['player_'.$seq] ?? '' }}">
    </td>
    <td style="outline: unset">
        {{ $orderItemDetail['numseq_'.$seq] ?? '' }}
        <input type="hidden" name="items[{{ $orderItem->id }}][{{ $orderItemDetail->id }}][{{ $key }}][seq_number]" value="{{ 'numseq_'.$seq }}">
        <input type="hidden" name="items[{{ $orderItem->id }}][{{ $orderItemDetail->id }}][{{ $key }}][player_number]" value="{{ $orderItemDetail['numseq_'.$seq] ?? '' }}">
    </td>
    <td style="outline: unset">
        <input type="number" class="invoice-inputs text-center order-qty" name="items[{{ $orderItem->id }}][{{ $orderItemDetail->id }}][{{ $key }}][order_qty]" value="{{ $seqData[$orderItem->id][$orderItemDetail->id][$seq]['orderQty'] }}" readonly>
    </td>
    <td>

        <input type="number" class="invoice-inputs text-center shipping-input shipping-qty item-detail-shipped-qty-{{ $orderItemDetail->id }} item-shipped-qty-{{ $orderItem->id }}" name="items[{{ $orderItem->id }}][{{ $orderItemDetail->id }}][{{ $key }}][shipped_qty]" value="{{$shippedQty}}" min="0" max="1" data-item-detail-id="{{ $orderItemDetail->id }}" data-item-id="{{ $orderItem->id }}" onchange="updateBackorderedQty(this)"/>
    </td>

    <td>
        <input type="number" class="invoice-inputs text-center shipping-input backed-qty item-detail-backed-qty-{{ $orderItemDetail->id }} item-backed-qty-{{ $orderItem->id }}" name="items[{{ $orderItem->id }}][{{ $orderItemDetail->id }}][{{ $key }}][back_ordered_qty]" value="{{$seqData[$orderItem->id][$orderItemDetail->id][$seq]['backOrderedQty']}}" readonly/>
    </td>

    <td>
        <input type="text" class="invoice-inputs text-center shipping-datepicker shipping-input itemEstDiliveryDate" placeholder="MM/DD/YY" name="items[{{ $orderItem->id }}][{{ $orderItemDetail->id }}][{{ $key }}][est_delivery_date]" value="{{ date_format(date_create($shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'no', 'no', 'numseq_'.$seq, null, 'est_delivery_date')),"m/d/Y") }}"/>
    </td>
    <td>
        <input
            type="text"
            class="txtTrackingNo invoice-inputs text-center shipping-input"
            data-itemNumber="{{ $orderItemDetail->id }}"
            name="items[{{ $orderItem->id }}][{{ $orderItemDetail->id }}][{{ $key }}][tracking_no]"
            id="txtTrackNo{{ $orderItemDetail->id  }}"
            value="{!! $seqData[$orderItem->id][$orderItemDetail->id][$seq]['tracking_no_value'] !!}"
        />
    </td>

    <td>
        <input
            type="text"
            class="txtTrackingLink invoice-inputs text-center shipping-input"
            data-itemNumber="{{ $orderItemDetail->id }}"
            name="items[{{ $orderItem->id }}][{{ $orderItemDetail->id }}][{{ $key }}][tracking_link]"
            id="txtTrackLink{{ $orderItemDetail->id  }}"
            value="{!! $seqData[$orderItem->id][$orderItemDetail->id][$seq]['tracking_link_value'] !!}"
        />
    </td>

    <td style="vertical-align: middle;">
        @if ($seqData[$orderItem->id][$orderItemDetail->id][$seq]['Notify_value'] == 1)
            <input type="hidden" class="notified-row">
            <p class="notify-status notify-sent">Sent</p>
        @else
            <input type="hidden" class="unnotified-row unnotified-item-{{ $orderItem->id }} unnotified-item-detail-{{ $orderItemDetail->id }}">
            <p class="notify-status notify-not-sent">Not Sent</p>
        @endif
    </td>

    <td style="vertical-align: middle;" class="text-center">
            <p class="notify-user">{!! $seqData[$orderItem->id][$orderItemDetail->id][$seq]['notified_by_value'] !!}</p>
    </td>
</tr> --}}

<script>
function show_rosters(order_item, item_detail, player_detail, size_details) {

    if (true) {

        var order_item_id = order_item.id;
        var order_item_detail_id = item_detail.id;

        if ($('.sub_row_by_script_' + order_item_detail_id).length > 0) {

            if ($('.sub_row_by_script_' + order_item_detail_id + ':hidden').length > 0) {

                $('.sub_row_by_script_' + order_item_detail_id).show();
                $('.sub_row_by_script_blanks' + order_item_detail_id).show();

                $('#toggle_icon_' + order_item_detail_id)
                    .removeClass('fa-angle-right')
                    .addClass('fa-angle-down');

            } else {

                $('.sub_row_by_script_' + order_item_detail_id).hide();
                $('.sub_row_by_script_blanks' + order_item_detail_id).hide();

                $('#toggle_icon_' + order_item_detail_id)
                    .addClass('fa-angle-right')
                    .removeClass('fa-angle-down');
            }

        } else {

            $('#toggle_icon_' + order_item_detail_id)
                .removeClass('fa-angle-right')
                .addClass('fa-angle-down');

            var seq = @json($seqData);
            var seqArr = @json($seqArr);

            var detailRow = '';

            var orderItemDetail = seq[order_item_id][order_item_detail_id];

            seqArr.forEach(function (sequence) {

                if (orderItemDetail[sequence]) {

                    var sizeName = '';

                    if (size_details['size_name'] == 'Youth Small') {
                        sizeName = 'YS';
                    } else if (size_details['size_name'] == 'Youth Medium') {
                        sizeName = 'YM';
                    } else if (size_details['size_name'] == 'Youth Large') {
                        sizeName = 'YL';
                    } else if (size_details['size_name'] == 'Adult XSmall') {
                        sizeName = 'AXS';
                    } else if (size_details['size_name'] == 'Adult Small') {
                        sizeName = 'AS';
                    } else if (size_details['size_name'] == 'Adult Medium') {
                        sizeName = 'AM';
                    } else if (size_details['size_name'] == 'Adult Large') {
                        sizeName = 'AL';
                    } else if (size_details['size_name'] == 'Adult XLarge') {
                        sizeName = 'AXL';
                    } else if (size_details['size_name'] == 'Adult XXLarge') {
                        sizeName = 'AXXL';
                    } else if (size_details['size_name'] == 'Kids') {
                        sizeName = 'Kids';
                    } else if (size_details['size_name'] == 'XSmall') {
                        sizeName = 'XS';
                    } else if (size_details['size_name'] == 'Small') {
                        sizeName = 'S';
                    } else if (size_details['size_name'] == 'Medium') {
                        sizeName = 'M';
                    } else if (size_details['size_name'] == 'Large') {
                        sizeName = 'L';
                    } else if (size_details['size_name'] == 'XLarge') {
                        sizeName = 'XL';
                    } else if (size_details['size_name'] == 'N/A') {
                        sizeName = 'N/A';
                    } else if (size_details['size_name'] == 'Extra Size One') {
                        sizeName = (order_item.extra_size == '1')
                            ? 'Extra Size One'
                            : order_item.extra_size;
                    } else if (size_details['size_name'] == 'Extra Size Two') {
                        sizeName = (order_item.extra_size_two == '1')
                            ? 'Extra Size Two'
                            : order_item.extra_size_two;
                    } else if (size_details['size_name'] == 'Extra Size Three') {
                        sizeName = (order_item.extra_size_three == '1')
                            ? 'Extra Size Three'
                            : order_item.extra_size_three;
                    }


                    /* =====================================================
                       NOTIFY
                       ===================================================== */

                    var notifyTd =
                        '<td class="mobile-child-notify" style="vertical-align: middle;">';

                    if (orderItemDetail[sequence].Notify_value == 1) {

                        notifyTd +=
                            '<input type="hidden" class="notified-row">';

                        notifyTd +=
                            '<p class="notify-status notify-sent" id="remake_item_' +
                            orderItemDetail[sequence].sub_checkbox_value +
                            '">Sent</p>';

                    } else if (orderItemDetail[sequence].Notify_value == 2) {

                        notifyTd +=
                            '<input type="hidden" class="notified-row">';

                        notifyTd +=
                            '<p class="notify-status notify-sent" id="remake_item_' +
                            orderItemDetail[sequence].sub_checkbox_value +
                            '">Re-Sent</p>';

                    } else if (orderItemDetail[sequence].Notify_value == 3) {

                        notifyTd +=
                            '<input type="hidden" class="notified-row">';

                        notifyTd +=
                            '<p class="notify-status notify-remake" id="remake_item_' +
                            orderItemDetail[sequence].sub_checkbox_value +
                            '">Re-Make</p>';

                    } else {

                        notifyTd +=
                            '<input type="hidden" class="unnotified-row unnotified-item-' +
                            order_item_id +
                            ' unnotified-item-detail-' +
                            order_item_detail_id +
                            '">';

                        notifyTd +=
                            '<p class="notify-status notify-not-sent" id="remake_item_' +
                            orderItemDetail[sequence].sub_checkbox_value +
                            '">Not Sent</p>';
                    }

                    notifyTd += '</td>';


                    /* =====================================================
                       SAVED STATUS
                       ===================================================== */

                    var savedStatusInput = '';

                    if (orderItemDetail[sequence].is_saved == 1) {

                        savedStatusInput =
                            '<input type="hidden" class="saved-row saved-item-' +
                            order_item_id +
                            ' saved-item-detail-' +
                            order_item_detail_id +
                            '">';

                    } else {

                        savedStatusInput =
                            '<input type="hidden" class="unsaved-row unsaved-item-' +
                            order_item_id +
                            ' unsaved-item-detail-' +
                            order_item_detail_id +
                            '">';
                    }


                    /* =====================================================
                       MOBILE CHILD CARD
                       ===================================================== */

                    detailRow +=

                        '<tr ' +

                        'style="color:rgba(22, 22, 23, 1) !important;' +
                        'border-bottom:2px solid #d7d7d7;' +
                        'background-color:rgb(251 251 251)" ' +

                        'class="text-center ' +
                        'script_maked ' +
                        'mobile-child-card ' +
                        'sub_row_hide_by_script_' + order_item_id + ' ' +
                        'sub_row_by_script_' + order_item_detail_id + ' ' +
                        'remake-edit-' + orderItemDetail[sequence].Notify_value +
                        '">' +


                        /* =================================================
                           CHECKBOX
                           ================================================= */

                        '<td class="mobile-child-checkbox">' +

                            savedStatusInput +

                            '<input ' +
                            'data-itemNumber="' + order_item_id + '" ' +
                            'type="checkbox" ' +
                            'value="' + orderItemDetail[sequence].sub_checkbox_value + '" ' +
                            'name="subcheckbox' + order_item_id + '" ' +
                            'id="subcheck" ' +
                            'class="chkItemChild emergency-edit-' +
                                orderItemDetail[sequence].Notify_value +
                                ' forChecking' +
                                order_item_id +
                                ' seqcheckbox' +
                                order_item_detail_id + '" ' +
                            'data-saved-status="' +
                                orderItemDetail[sequence].is_saved +
                            '">' +

                        '</td>' +


                        /* =================================================
                           ADD TO REMAKE
                           ================================================= */

                        '<td class="mobile-child-add">' +

                            '<i class="fa fa-plus-circle ' +
                            'emergency-edit-' +
                            orderItemDetail[sequence].Notify_value +
                            '" ' +

                            'aria-hidden="true" ' +
                            'title="Add to remake" ' +

                            'onclick="addToRemake(' +
                            orderItemDetail[sequence].sub_checkbox_value +
                            ')" ' +

                            'data-shipment_id="' +
                            orderItemDetail[sequence].sub_checkbox_value +
                            '">' +

                            '</i>' +

                        '</td>' +


                        /* =================================================
                           SIZE
                           ================================================= */

                        '<td class="mobile-child-size">' +

                            '<div class="mobile-child-value">' +

                                '<input type="hidden" ' +
                                'value="' + sequence + '" ' +
                                'class="sequence-value">' +

                                '<input type="hidden" ' +
                                'name="items[' +
                                    order_item_id +
                                '][' +
                                    order_item_detail_id +
                                '][' +
                                    sequence +
                                '][size_id]" ' +
                                'value="' + item_detail.size_id + '">' +

                                '<input type="hidden" ' +
                                'name="items[' +
                                    order_item_id +
                                '][' +
                                    order_item_detail_id +
                                '][' +
                                    sequence +
                                '][size_name]" ' +
                                'value="' +
                                    orderItemDetail[sequence].rowSizeName +
                                '">' +

                                sizeName +

                            '</div>' +

                        '</td>' +


                        /* =================================================
                           PLAYER
                           ================================================= */

                        '<td class="mobile-child-player">' +

                            '<span class="mobile-child-label">Player</span>' +

                            '<div class="mobile-child-value">' +

                                (player_detail['player_' + sequence] ?? '') +

                                '<input type="hidden" ' +
                                'name="items[' +
                                    order_item_id +
                                '][' +
                                    order_item_detail_id +
                                '][' +
                                    sequence +
                                '][seq_name]" ' +
                                'value="player_' + sequence + '">' +

                                '<input type="hidden" ' +
                                'name="items[' +
                                    order_item_id +
                                '][' +
                                    order_item_detail_id +
                                '][' +
                                    sequence +
                                '][player_name]" ' +
                                'value="' +
                                    (player_detail['player_' + sequence] ?? '') +
                                '">' +

                            '</div>' +

                        '</td>' +


                        /* =================================================
                           PLAYER NUMBER
                           ================================================= */

                        '<td class="mobile-child-number">' +

                            '<span class="mobile-child-label">Number</span>' +

                            '<div class="mobile-child-value">' +

                                (item_detail['numseq_' + sequence] ?? '') +

                                '<input type="hidden" ' +
                                'name="items[' +
                                    order_item_id +
                                '][' +
                                    order_item_detail_id +
                                '][' +
                                    sequence +
                                '][seq_number]" ' +
                                'value="numseq_' + sequence + '">' +

                                '<input type="hidden" ' +
                                'name="items[' +
                                    order_item_id +
                                '][' +
                                    order_item_detail_id +
                                '][' +
                                    sequence +
                                '][player_number]" ' +
                                'value="' +
                                    (item_detail['numseq_' + sequence] ?? '') +
                                '">' +

                            '</div>' +

                        '</td>' +


                        /* =================================================
                           ORDER QTY
                           ================================================= */

                        '<td class="mobile-child-order-qty mobile-child-field">' +

                            '<span class="mobile-child-label">Order Qty</span>' +

                            '<input type="number" ' +
                            'class="invoice-inputs text-center order-qty" ' +
                            'name="items[' +
                                order_item_id +
                            '][' +
                                order_item_detail_id +
                            '][' +
                                sequence +
                            '][order_qty]" ' +
                            'value="' +
                                orderItemDetail[sequence].orderQty +
                            '" readonly>' +

                        '</td>' +


                        /* =================================================
                           SHIPPED QTY
                           ================================================= */

                        '<td class="mobile-child-shipped mobile-child-field">' +

                            '<span class="mobile-child-label">Shipped</span>' +

                            '<input type="number" ' +
                            'class="invoice-inputs text-center emergency-edit-' +
                                orderItemDetail[sequence].Notify_value +
                                ' shipping-input shipping-qty ' +
                                'item-detail-shipped-qty-' +
                                order_item_detail_id +
                                ' item-shipped-qty-' +
                                order_item_id + '" ' +

                            'name="items[' +
                                order_item_id +
                            '][' +
                                order_item_detail_id +
                            '][' +
                                sequence +
                            '][shipped_qty]" ' +

                            'value="' +
                                orderItemDetail[sequence].shippedQty +
                            '" ' +

                            'min="0" ' +
                            'max="1" ' +

                            'data-item-detail-id="' +
                                order_item_detail_id +
                            '" ' +

                            'data-item-id="' +
                                order_item_id +
                            '" ' +

                            'onchange="updateBackorderedQty(this)"/>' +

                        '</td>' +


                        /* =================================================
                           BACKORDERED
                           ================================================= */

                        '<td class="mobile-child-backordered mobile-child-field">' +

                            '<span class="mobile-child-label">Backordered</span>' +

                            '<input type="number" ' +
                            'class="invoice-inputs text-center shipping-input backed-qty ' +
                                'item-detail-backed-qty-' +
                                order_item_detail_id +
                                ' item-backed-qty-' +
                                order_item_id + '" ' +

                            'name="items[' +
                                order_item_id +
                            '][' +
                                order_item_detail_id +
                            '][' +
                                sequence +
                            '][back_ordered_qty]" ' +

                            'value="' +
                                orderItemDetail[sequence].backOrderedQty +
                            '" readonly/>' +

                        '</td>' +


                        /* =================================================
                           DELIVERY
                           ================================================= */

                        '<td class="mobile-child-delivery mobile-child-field">' +

                            '<span class="mobile-child-label">Est. Delivery</span>' +

                            '<input type="text" ' +

                            'class="invoice-inputs text-center emergency-edit-' +
                                orderItemDetail[sequence].Notify_value +
                                ' shipping-datepicker shipping-input itemEstDiliveryDate" ' +

                            'placeholder="MM/DD/YY" ' +

                            'name="items[' +
                                order_item_id +
                            '][' +
                                order_item_detail_id +
                            '][' +
                                sequence +
                            '][est_delivery_date]" ' +

                            'value="' +
                                formatDate(
                                    orderItemDetail[sequence].est_delivery_date
                                ) +
                            '">' +

                        '</td>' +


                        /* =================================================
                           COURIER
                           ================================================= */

                        '<td class="mobile-child-courier mobile-child-field ' +
                            (orderItemDetail[sequence].CourierService_value || '') +
                        '">' +

                            '<span class="mobile-child-label">Courier</span>' +

                            '<select ' +

                            'class="CourierService CourierService-select invoice-inputs text-center emergency-edit-' +
                                orderItemDetail[sequence].Notify_value +
                                ' shipping-input" ' +

                            'data-itemNumber="' +
                                order_item_detail_id +
                            '" ' +

                            'name="items[' +
                                order_item_id +
                            '][' +
                                order_item_detail_id +
                            '][' +
                                sequence +
                            '][CourierService]" ' +

                            'id="CourierService' +
                                order_item_detail_id +
                            '">' +

                                '<option value="">Select Courier</option>' +

                                '<option value="UPS" ' +
                                    ((orderItemDetail[sequence].CourierService_value == "UPS")
                                        ? 'selected="selected"'
                                        : '') +
                                '>UPS</option>' +

                                '<option value="FedEx" ' +
                                    ((orderItemDetail[sequence].CourierService_value == "FedEx")
                                        ? 'selected="selected"'
                                        : '') +
                                '>FedEx</option>' +

                                '<option value="DHL" ' +
                                    ((orderItemDetail[sequence].CourierService_value == "DHL")
                                        ? 'selected="selected"'
                                        : '') +
                                '>DHL</option>' +

                                '<option value="Other" ' +
                                    ((orderItemDetail[sequence].CourierService_value == "Other")
                                        ? 'selected="selected"'
                                        : '') +
                                '>Other</option>' +

                            '</select>' +

                        '</td>' +


                        /* =================================================
                           TRACKING NUMBER
                           ================================================= */

                        '<td class="mobile-child-tracking mobile-child-field">' +

                            '<span class="mobile-child-label">Tracking #</span>' +

                            '<input type="text" ' +

                            'class="txtTrackingNo invoice-inputs emergency-edit-' +
                                orderItemDetail[sequence].Notify_value +
                                ' text-center shipping-input" ' +

                            'data-itemNumber="' +
                                order_item_detail_id +
                            '" ' +

                            'name="items[' +
                                order_item_id +
                            '][' +
                                order_item_detail_id +
                            '][' +
                                sequence +
                            '][tracking_no]" ' +

                            'id="txtTrackNo' +
                                order_item_detail_id +
                            '" ' +

                            'value="' +
                                (orderItemDetail[sequence].tracking_no_value ?? '') +
                            '">' +

                        '</td>' +


                        /* =================================================
                           TRACKING LINK
                           ================================================= */

                        '<td class="mobile-child-tracking-link mobile-child-field">' +

                            '<span class="mobile-child-label">Tracking Link</span>' +

                            '<input type="text" ' +

                            'class="txtTrackingLink invoice-inputs emergency-edit-' +
                                orderItemDetail[sequence].Notify_value +
                                ' text-center shipping-input" ' +

                            'data-itemNumber="' +
                                order_item_detail_id +
                            '" ' +

                            'name="items[' +
                                order_item_id +
                            '][' +
                                order_item_detail_id +
                            '][' +
                                sequence +
                            '][tracking_link]" ' +

                            'id="txtTrackLink' +
                                order_item_detail_id +
                            '" ' +

                            'value="' +
                                (orderItemDetail[sequence].tracking_link_value ?? '') +
                            '">' +

                        '</td>' +


                        /* =================================================
                           NOTIFY
                           ================================================= */

                        notifyTd.replace(
                            '<td class="mobile-child-notify"',
                            '<td class="mobile-child-notify mobile-child-field"'
                        ).replace(
                            'style="vertical-align: middle;"',
                            ''
                        ).replace(
                            '<p class="notify-status',
                            '<span class="mobile-child-label">Notify</span><p class="notify-status'
                        ) +


                        /* =================================================
                           NOTIFIED BY
                           ================================================= */

                        '<td class="text-center mobile-child-notified-by mobile-child-field">' +

                            '<span class="mobile-child-label">Notified By</span>' +

                            '<p class="notify-user">' +
                                (orderItemDetail[sequence].notified_by_value ?? '') +
                            '</p>' +

                        '</td>' +


                        '</tr>';
                }
            });


            $('.row-item-detail-' + order_item_detail_id).after(detailRow);
        }

        $('.shipping-datepicker').datepicker({
            minDate: 0
        });
    }
}


function formatDate(dateString) {

    if (!dateString) {
        return '';
    }

    var dateComponents = dateString.split('-');

    var formattedDate =
        dateComponents[1] +
        '/' +
        dateComponents[2] +
        '/' +
        dateComponents[0];

    return formattedDate;
}


function sub_row_hide_by_script(order_item_id) {
    $('.sub_row_hide_by_script_' + order_item_id).hide();
}
$(window).on('load', function () {

    $('.parent-expand-button').each(function () {

        var button = this;
        var $button = $(button);

        // First click
        $button.trigger('click');

        var targetSelector = $button.attr('data-bs-target');

        if (targetSelector) {

            $(targetSelector).one('shown.bs.collapse', function () {

                // Expand animation finished
                setTimeout(function () {

                    // Second click - Collapse
                    $button.trigger('click');

                }, 100);

            });

        }

    });

});
</script>
