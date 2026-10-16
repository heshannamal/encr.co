@extends('layouts.customer_team_store.app')

@section('content')

<style>
    .top-navbar {
        background-color: white;
        z-index: 99;
        position: fixed !important;
        top: 0;
        left: 0;
        width: 100%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .cart_topic_text {
        font-size: 33px;
    }
    .cart_items {
        /* padding-top: 15px; */
        padding-bottom: 10px !important;
        border-bottom: 1px solid rgb(231, 231, 231);
    }
    .cart_summary {
        max-width: 35%;
        width: 35%;
    }
    .item_price_div {
        width: 10%;
        text-align: right;
        padding-right: 16px;
    }
    .item_qty_div {
        padding-left: 25px;
    }
    .number-input-group {
        display: flex;
        align-items: center;
        width: 100px;
    }
    .input-group-prepend,
    .input-group-append {
        display: flex;
    }
    .min_pus_btn {
        padding: unset;
        width: 25px;
        height: 26px;
    }
    .item_qty_cart {
        height: 24px;
        text-align: center;
    }
    .btn-outline-secondary {
        color: white;
        border-color: unset;
        background-color: #B3B3B3;
    }
    .price_card {
        padding: 5px;
        padding-left: 10px;
        background-color: rgb(241, 241, 241);
        border: unset;
        padding-top: 10px;
        padding-bottom: 20px;
    }
    .price_card_row {
        padding-top: 5px;
        margin: unset;
        padding-right: 5px;
    }
    .size-item {
        font-size: 11px;
    }
    .size_name_lable {
        padding-top: 2px;
        padding-right: 6px;
        width: 100px;
        margin: unset;
    }
    .modal_footer {
        padding: 5px;
    }
    .plus_min_btn {
        padding-top: unset;
        padding-bottom: unset;
        height: 27px;
        padding-left: 6px;
        padding-right: 6px;
        margin-top: 2px;
    }
    .cart_image_size {
        width: 120px;
    }
    .items_prices_div {
        margin: unset;
        width: 40%;
    }
    .size_name_div {
        width: 40%;
    }
    .color-box {
        display: inline-block;
        width: 25px;
        height: 25px;
        border-radius: 5px;
        margin-right: 10px;
        transition: border 0.3s ease;
    }
    .color-box.active {
        border: 2px solid rgb(163, 163, 163);
    }
    @media (max-width: 595px) {
        .cart_image_size {
            width: 100px;
        }
        .number-input-group {
            width: 50px;
        }
        .size_name_div {
            width: 64%;
        }
        .items_prices_div {
            margin: unset;
            width: 78%;
            padding-left: 115px;
        }
        .item_price_div {
            width: 20%;
        }
    }

    /* Theme colour change */
    .modal_dark {
        background-color: #121212 !important;
        color: white !important;
    }
    .input_dark {
        background-color: transparent !important;
        color: white !important;
    }
    .minPus_btn_dark {
        background-color: rgb(71, 71, 71) !important;
        border: unset;
    }
    .cart_payment_dark {
        background-color: rgb(37, 37, 37) !important;
    }
    .cart_payment_text_darkThem {
        color: rgb(195, 195, 195) !important;
    }
    .color-box.active {
        border: 2px solid rgb(149, 224, 241);
        box-shadow: 0px 0px 10px 5px rgb(155 194 203 / 50%);
    }

@media (max-width: 767.98px) {

    /* =========================================
       MAIN CARD
       ========================================= */

    #cart-items .cart-item.cart_items {
        display: grid !important;

        grid-template-columns: 72px minmax(0, 1fr) 32px !important;

        width: 100% !important;
        margin: 0 0 12px !important;
        padding: 14px !important;

        border: 1px solid #e5e5e5 !important;
        border-radius: 12px !important;

        background: #fff !important;
        box-shadow: 0 2px 8px rgba(0,0,0,.06) !important;

        box-sizing: border-box !important;
    }


    /* =========================================
       ROW 1 - IMAGE
       ========================================= */

    #cart-items .cart-mobile-image {
        grid-column: 1 !important;
        grid-row: 1 !important;

        width: 72px !important;
        max-width: 72px !important;

        padding: 0 !important;
        margin: 0 !important;

        display: flex !important;
        align-items: flex-start !important;
        justify-content: flex-start !important;
    }

    #cart-items .cart-mobile-image a {
        width: 72px !important;
        height: 72px !important;
        display: block !important;
    }

    #cart-items .cart-mobile-image .cart_image_size {
        width: 72px !important;
        height: 72px !important;

        object-fit: cover !important;
        border-radius: 8px !important;
    }


    /* =========================================
       ROW 1 - PRODUCT NAME
       ========================================= */

    #cart-items .cart-mobile-product-info {
        grid-column: 2 !important;
        grid-row: 1 !important;

        width: auto !important;
        max-width: none !important;
        min-width: 0 !important;

        padding: 3px 8px 0 12px !important;
        margin: 0 !important;

        display: block !important;
    }

    #cart-items .cart-mobile-product-info > span:first-child {
        display: -webkit-box !important;

        -webkit-box-orient: vertical !important;
        -webkit-line-clamp: 2 !important;

        overflow: hidden !important;

        margin: 0 !important;

        font-size: 14px !important;
        line-height: 1.4 !important;
        font-weight: 600 !important;
    }


    /* =========================================
       ROW 1 - EDIT / DELETE
       ========================================= */

    #cart-items .cart-mobile-actions {
        grid-column: 3 !important;
        grid-row: 1 !important;

        width: 32px !important;
        max-width: 32px !important;

        padding: 0 !important;
        margin: 0 !important;

        display: flex !important;
        flex-direction: column !important;

        align-items: center !important;
        justify-content: flex-start !important;

        gap: 9px !important;
    }

    #cart-items .cart-mobile-actions .edit_btn_cart,
    #cart-items .cart-mobile-actions .delete_btn_cart {
        width: 24px !important;
        height: 24px !important;

        padding: 0 !important;
        margin: 0 !important;

        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }


    /* =========================================
       IMPORTANT:
       Let nested product information participate
       in the card grid.
       ========================================= */

    #cart-items .cart-mobile-product-info > .row {
        display: contents !important;
    }


    /* =========================================
       ROW 2 - SIZES
       ========================================= */

    #cart-items .cart-mobile-product-info
        > .row
        > .col-md-4:first-child {

        grid-column: 1 / -1 !important;
        grid-row: 2 !important;

        width: 100% !important;
        max-width: 100% !important;

        padding: 0 !important;
        margin: 16px 0 0 !important;

        display: block !important;
    }

    #cart-items .edit_size_click {
        display: block !important;

        margin: 0 0 5px !important;

        font-size: 12px !important;
        font-weight: 600 !important;
        line-height: 1.2 !important;
    }

    #cart-items .size-item {
        margin: 0 !important;
        padding: 0 !important;
    }

    #cart-items .size-item label {
        display: block !important;

        margin: 0 !important;

        color: #666 !important;

        font-size: 12px !important;
        line-height: 1.4 !important;
    }


    /* =========================================
       ROW 3 - NAME / NUMBER
       ========================================= */

    #cart-items .cart-mobile-product-info
        > .row
        > .col-md-4:nth-child(2) {

        grid-column: 1 / -1 !important;
        grid-row: 3 !important;

        width: 100% !important;
        max-width: 100% !important;

        padding: 0 !important;
        margin: 14px 0 0 !important;

        display: block !important;
    }

    .cart-mobile-name-number {
        width: 100% !important;

        display: grid !important;

        grid-template-columns: 1fr 1fr !important;

        column-gap: 15px !important;
    }

    .cart-mobile-custom-field {
        display: flex !important;
        flex-direction: column !important;

        min-width: 0 !important;
    }

    .cart-mobile-field-label {
        color: #666 !important;

        font-size: 11px !important;
        line-height: 1.2 !important;

        margin-bottom: 4px !important;
    }

    .cart-mobile-field-value {
        color: #333 !important;

        font-size: 13px !important;
        line-height: 1.3 !important;

        font-weight: 500 !important;

        word-break: break-word !important;
    }


    /* =========================================
       ROW 4 - QTY
       ========================================= */

    #cart-items .cart-mobile-qty {
        grid-column: 1 !important;
        grid-row: 4 !important;

        width: auto !important;
        max-width: none !important;

        padding: 0 !important;
        margin: 16px 0 0 !important;

        display: flex !important;
        flex-direction: column !important;

        align-items: flex-start !important;
    }

    #cart-items .cart-mobile-qty .gray_font {
        font-size: 11px !important;
    }

    #cart-items .item_qty_cart {
        width: 55px !important;
        height: 32px !important;

        margin: 4px 0 0 !important;

        padding: 4px !important;

        font-size: 13px !important;
        text-align: center !important;
    }


    /* =========================================
       ROW 4 - UNIT PRICE
       ========================================= */

    #cart-items .cart-mobile-each {
        grid-column: 2 !important;
        grid-row: 4 !important;

        width: auto !important;
        max-width: none !important;

        padding: 0 !important;
        margin: 16px 0 0 !important;

        display: flex !important;
        flex-direction: column !important;

        align-items: center !important;
    }

    #cart-items .cart-mobile-each .gray_font {
        font-size: 11px !important;
    }

    #cart-items .cart-mobile-each .font_size13 {
        margin-top: 4px !important;

        font-size: 13px !important;
        font-weight: 600 !important;
    }


    /* =========================================
       ROW 4 - TOTAL
       ========================================= */

    #cart-items .cart-mobile-total {
        grid-column: 3 !important;
        grid-row: 4 !important;

        width: auto !important;
        max-width: none !important;

        padding: 0 !important;
        margin: 16px 0 0 !important;

        display: flex !important;
        flex-direction: column !important;

        align-items: flex-end !important;
    }

    #cart-items .cart-mobile-total .gray_font {
        font-size: 11px !important;
    }

    #cart-items .cart-mobile-total .font_size13 {
        margin-top: 4px !important;

        font-size: 13px !important;
        font-weight: 600 !important;
    }
    .top-navbar {
        padding: unset;
    }
    .cart_topic_text {
        font-size: 23px;
    }
    /* .mobile_order_summary {
        min-height: 20rem !important;
        height: 20rem !important;
    } */
     .price_card {
        background-color: white;
     }
}

    /* End Theme colour change */

    @media (max-width: 768px) {

        /* Cart items area - remove large fixed height on mobile */
        .mobile_order_summary {
            height: auto !important;
            max-height: none !important;
            overflow-x: hidden !important;
            overflow-y: visible !important;
            /* padding-left: 0 !important; */
            /* padding-right: 0 !important; */
            width: 100%;
        }

        /* Make cart + summary stack vertically */
        .mobile_order_summary + .col-lg-3 {
            width: 100%;
            max-width: 100%;
            padding-left: 0;
            padding-right: 0;
            margin-top: 15px;
        }

        /* Summary card should come immediately after cart items */
        .mobile_order_summary + .col-lg-3 .price_card {
            margin-top: 0;
            width: 100%;
        }

        /* Keep subtotal row close to cart items */
        .mobile_order_summary > .row:last-child {
            margin-left: 0;
            margin-right: 0;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        .mobile_order_summary > .row:last-child > div:first-child {
            padding-left: 15px !important;
        }

        .mobile_order_summary > .row:last-child > div:last-child {
            padding-right: 15px !important;
        }
    }
</style>

<div class="navbar top-navbar  col-12 col-lg-12 {{ $teamStore->theme == 1 ? 'top_nav_dark' : '' }}" style=" background-color:white; z-index:99;">

    @include('pages.customer_team_store.layouts.header')

</div>


<div class="col-lg-12" style="padding-top: 110px; padding-left: 4%; padding-right: 4%;">

    <b class="cart_topic_text">Your Shopping Cart</b><br>
    <span class="cart_item_count"></span>
    <div id="mandotary_product_alert"></div>

    <div class="row" style="padding-top: 10px;">
        <div class="col-lg-9 mobile_order_summary" style="border-top: 1px solid rgb(231, 231, 231);">
            <div id="cart-items" class=""></div>

            <div class="row" style="padding-top: 10px; padding-bottom: 10px;">
                <div class="" style="padding-left: 145px;">
                    <span class="sub_total_item_count font_size13" style="font-weight: 600;"></span>
                </div>
                <div class="ml-auto " style="text-align: right; padding-right: 30px;">
                    <span id="sub-total-inItemList" class="font_size13" style="font-weight: 600;"></span>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card price_card {{ $teamStore->theme == 1 ? 'cart_payment_dark' : '' }}">
                <b>Order Summary</b>

                <div class="row price_card_row">
                    <div class="" style="padding-top: 10px;">
                        <span class="sub_total_cart_count gray_font {{ $teamStore->theme == 1 ? 'cart_payment_text_darkThem' : '' }}">Sub Total</span>
                    </div>
                    <div class="ml-auto " style="padding-top: 10px; text-align: right;">
                        <span id="sub_total" class="gray_font {{ $teamStore->theme == 1 ? 'cart_payment_text_darkThem' : '' }}"></span>
                    </div>
                </div>

                <div class="row price_card_row">
                    <div class="" style="">
                        <span class=" gray_font {{ $teamStore->theme == 1 ? 'cart_payment_text_darkThem' : '' }}">Sales tax fee {{$store->sales_tax}}% ($)</span>
                    </div>
                    <div class="ml-auto " style="text-align: right;">
                        <span id="sales_tax_rate" class="gray_font {{ $teamStore->theme == 1 ? 'cart_payment_text_darkThem' : '' }}">0.00</span>
                    </div>
                </div>
                <div class="row price_card_row">
                    <div class="" style="">
                        <span class=" gray_font {{ $teamStore->theme == 1 ? 'cart_payment_text_darkThem' : '' }}">Artwork & other fees ($)</span>
                    </div>
                    <div class="ml-auto " style="text-align: right;">
                        <span id="other_fee" class="gray_font {{ $teamStore->theme == 1 ? 'cart_payment_text_darkThem' : '' }}">0.00</span>
                    </div>
                </div>

                <div class="row price_card_row">
                    <div class="" style="">
                        <span class=" gray_font {{ $teamStore->theme == 1 ? 'cart_payment_text_darkThem' : '' }}">Shipping fee ($)</span>
                    </div>
                    <div class="ml-auto " style="text-align: right;">
                        <span id="shipping_fee" class="gray_font {{ $teamStore->theme == 1 ? 'cart_payment_text_darkThem' : '' }}">--</span>
                    </div>
                </div>

                <div class="row price_card_row">
                    <div class="" style="">
                        <span class=" " style="font-size: 15px; font-weight: 500;">Estimated Total ($)</span>
                    </div>
                    <div class="ml-auto " style="text-align: right;">
                        <span id="estimate_total" class="gray_font {{ $teamStore->theme == 1 ? 'cart_payment_text_darkThem' : '' }}" style="font-size: 15px; font-weight: 500;"></span>
                    </div>
                </div>
                @php
                    $primaryColor = $teamStore->primary_color ? $teamStore->primary_color : '#47D6B6';
                @endphp
                <div style="padding-top: 20px; text-align: center; padding-bottom: 20px;">
                    <button class="btn btn-success checkout_enabled" type="button" style="background-color: {{ $primaryColor }}; border: unset; width: 92%;" id="checkoutBtn" data-store-id="{{ $teamStore->store_id }}">Proceed to Checkout</button>
                </div>

                <div class="row" style="margin: unset;">
                    <div>
                        <img src="{{ asset('assets') }}/img/teamStore/status_icon.png" alt="image" style="width: 16px;">
                    </div>
                    <div style="width: 60%; padding-left: 7px;">
                        <span style="font-weight: 600;">Disclaimer</span>
                    </div>
                    <div style="padding-left: 23px;">
                        <span class="gray_font {{ $teamStore->theme == 1 ? 'cart_payment_text_darkThem' : '' }}">3% additional charge will be added to all card payments.</span>
                    </div>
                </div>

                <div class="col-md-12 mt-3" style="padding: 0px; padding-left: 23px;">
                    <img src="{{asset('argon')}}/img/icons/visa.png" style="height: 25px;" />
                    <img src="{{asset('argon')}}/img/icons/mastercard.png" class="ml-1" style="height: 25px;" />
                    <img src="{{asset('argon')}}/img/icons/discover.png" class="ml-1" style="height: 25px;" />
                    <img src="{{asset('argon')}}/img/icons/american_express.png" class="ml-1" style="height: 25px;" />
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="saved_cart_item_id">
</div>

<div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content  {{ $teamStore->theme == 1 ? 'modal_dark' : '' }}" style="width: fit-content">
            <div class="modal-header">
                <h5 class="modal-title  {{ $teamStore->theme == 1 ? 'modal_dark' : '' }}" id="sizesModalLabel">Set Size</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class=" {{ $teamStore->theme == 1 ? 'modal_dark' : '' }}" aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body" id="sizesModalBody">
                    <!-- Size inputs will be injected here -->
                </div>
            <div class="modal-footer modal_footer">
                <button type="button" class="btn btn-primary updateCartProductDetails" data-saving-type="size" style="background-color: {{ $teamStore->primary_color}}; border: unset;">Set Sizes</button>
            </div>
        </div>
    </div>
</div>


@include('pages.customer_team_store.layouts.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<script>

    appendCartProducts();

    $(document).ready(function() {

        $('#checkoutBtn').on('click', function() {
            var storeId = $(this).data('store-id');

            if ($(this).hasClass('checkout_enabled')) {
                window.location.href = "{{ makeStoreDomainRoute('proceedToCheckout') }}?store_id=" + storeId;
            }else{
                Swal.fire({
                    position: 'top',
                    icon: 'error',
                    title: 'You have not added all required products',
                    showConfirmButton: false,
                    timer: 4000,
                    toast: true
                });
            }
        });

        $(document).on('click', '.delete_btn_cart', function(event) {
            event.preventDefault();

            const productId = $(this).data('product-id');
            const cartItemId = $(this).data('cart-item-id');
            const storeId = '{{$store->id}}';

            Swal.fire({
                title: 'Are you sure?',
                text: "This product will be removed from your cart!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with AJAX request if confirmed
                    $.ajax({
                        url: '{{ makeStoreDomainRoute('cartDeleteStore') }}',
                        method: 'POST',
                        data: {
                            product_id: productId,
                            store_id: storeId,
                            cartItemId: cartItemId,
                            _token: '{{ csrf_token() }}'
                        },
                        beforeSend: function () {
                            $(".se-pre-con").fadeIn('slow');
                        },
                        success: function (data) {
                            // updateCart();
                            // appendCartProducts();

                            // // Show success alert
                            // Swal.fire({
                            //     position: 'top',
                            //     icon: 'success',
                            //     title: 'Product removed from cart!',
                            //     showConfirmButton: false,
                            //     timer: 4000,
                            //     toast: true
                            // });
                            location.reload();
                        },
                        error: function (error) {
                            console.error('Error fetching data:', error);

                            // Show error alert
                            Swal.fire({
                                position: 'top',
                                icon: 'error',
                                title: 'Failed to remove product!',
                                showConfirmButton: false,
                                timer: 4000,
                                toast: true
                            });
                        },
                        complete: function () {
                            $(".se-pre-con").fadeOut('slow');
                            updateCart();
                            appendCartProducts();
                        }
                    });
                }
            });
        });

        $(document).on('click', '.edit_size_click', function(event) {
            event.preventDefault();

            var cartItemId = $(this).data('store-item-id');
            var storeProductId = $(this).data('store-product-id');

            $('#saved_cart_item_id').val(cartItemId);

            getCartProductDetails(cartItemId, function (cartDetails) {

                let cartRecord = cartDetails.store_cart_items[0];

                let sizesHtml = `
                    <div class="px-3 pb-3">
                        <label class="size_name_lable fw-semibold">Select Size</label>
                        <select class="form-control size-dropdown mt-1" id="size-dropdown-${cartRecord.store_product_id}">
                            <option value="">-- Select Size --</option>
                            ${cartDetails.store_product.sizes.map(el =>
                                el.size
                                    ? `<option value="${el.size_id}" ${el.size_id == cartRecord.size_id ? 'selected' : ''}>
                                            ${el.size.size_name}
                                    </option>`
                                    : ``
                            ).join('')}
                        </select>
                    </div>
                `;

                // Quantity Row (cleaned styles)
                sizesHtml += `
                    <div class="px-3 pb-3">
                        <div class="d-flex">
                            <div class="col-3 p-0">
                                <button type="button"
                                    class="btn btn-outline-secondary w-100 minus-btn3 bundle-qty-btn">
                                    -
                                </button>
                            </div>

                            <div class="col-6 p-0">
                                <input type="number"
                                    step="1"
                                    min="${cartDetails.store_product.moq ?? 1}"
                                    data-product-id="${cartRecord.store_product_id}"
                                    id="size-qty-input"
                                    class="form-control text-center sizes_inputs"
                                    value="${cartRecord.qty}">
                            </div>

                            <div class="col-3 p-0">
                                <button type="button"
                                    class="btn btn-outline-secondary w-100 plus-btn3 bundle-qty-btn">
                                    +
                                </button>
                            </div>
                        </div>
                    </div>
                `;

                $('#sizesModalBody').html(sizesHtml);
            });

            // Increment quantity
            $(document).on('click', '.plus-btn3', function () {
                const $input = $(this).closest('.d-flex').find('.sizes_inputs');
                const currentVal = parseInt($input.val(), 10) || 0;
                const max = parseInt($input.attr('max'), 10);

                if (!isNaN(max) && currentVal >= max) {
                    $input.val(max);
                    return;
                }

                $input.val(currentVal + 1).trigger('change');
            });

            // Decrement quantity
            $(document).on('click', '.minus-btn3', function () {
                const $input = $(this).closest('.d-flex').find('.sizes_inputs');
                const currentVal = parseInt($input.val(), 10) || 0;
                const min = parseInt($input.attr('min'), 10) || 0;

                if (currentVal <= min) {
                    $input.val(min);
                    return;
                }

                $input.val(currentVal - 1).trigger('change');
            });

            $('#sizesModal').modal('show');

        });

        $(document).on('click', '.updateCartProductDetails', function() {

            let formData = new FormData();

            // PRODUCT ID (you forgot to define this earlier)
            let productId = $('#size-qty-input').data('product-id');

            // ---------------------------
            // SAVE SELECTED SIZE + QTY
            // ---------------------------

            let sizeId = $('#size-dropdown-' + productId).val();
            let qty = $('#size-qty-input').val();

            if (sizeId && qty > 0) {
                formData.append(`size`, sizeId);
                formData.append(`qty`, qty);
            }

            // ---------------------------
            // REQUIRED FIELDS
            // ---------------------------

            formData.append('store_product_id', productId);
            formData.append('store_id', "{{ $store->id }}");
            formData.append('saved_cart_item_id', $('#saved_cart_item_id').val());
            formData.append('type', 1);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: '{{ makeStoreDomainRoute("updateCartSize") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $(".se-pre-con").fadeIn();
                },
                success: function(response) {
                    if (response.status === "success") {
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 4000,
                            toast: true
                        });
                    } else {
                        Swal.fire({
                            position: 'top',
                            icon: 'warning',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 4000,
                            toast: true
                        });
                    }
                },
                error: function(xhr) {
                    let errorMessage = "Failed to add sizes to cart. Please try again.";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        position: 'top',
                        icon: 'error',
                        title: errorMessage,
                        showConfirmButton: false,
                        timer: 4000,
                        toast: true
                    });
                },
                complete: function() {
                    $('#sizesModal').modal('hide');
                    $('#colorModal').modal('hide');
                    updateCart();
                    appendCartProducts();
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        });

        $('.save_customer_details').on('click', function () {
            $('#customerAddressModal').modal('show');
        });

        $('.save_continue_btn').on('click', function (e) {
            e.preventDefault();

            var formData = $('#customerAddressForm').serialize();

            $('.se-pre-con').fadeIn('slow');

            $.ajax({
                url: '{{ makeStoreDomainRoute("customerTeamStorePersonalDetails") }}',
                method: 'POST',
                data: formData,
                success: function (response) {
                    $('.se-pre-con').fadeOut('slow');

                    if (response.success) {
                        $('#customerAddressModal').modal('hide');

                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: 'Customer address saved successfully.',
                            showConfirmButton: false,
                            timer: 4000,
                            toast: true
                        });

                        location.reload();

                    } else {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: 'There was an error, please try again.',
                            showConfirmButton: false,
                            timer: 4000,
                            toast: true
                        });

                        location.reload();
                    }
                },
                error: function (xhr) {
                    $('.se-pre-con').fadeOut('slow');

                    console.error(xhr);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'There was an error, please try again.',
                    });
                }
            });
        });

    });

    function mandotayUpdate() {

        var storeDetails = @json($store);
        var missingBundles = @json($missingBundles);
        var mandotaryProductArray1 = [];
        var mandotaryProductArray2 = [];

        console.log(missingBundles);

        storeDetails.store_added_products.forEach(element => {
            if (element.mandotary == 1) {
                mandotaryProductArray1.push(element);
            }
        });

        $.ajax({
            url: '{{ makeStoreDomainRoute('GetCustomerTeamStoreCart') }}',
            method: 'GET',
            data: {
                store_id: '{{$store->id}}',
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (data) {
                data.forEach(element => {
                    if (element.store_product.mandotary == 1 && element.store_product.active == 1) {
                        mandotaryProductArray2.push(element.store_product);
                    }
                });
            },
            error: function (error) {
                console.error('Error fetching data:', error);
            },
            complete: function () {

                const missingItems = mandotaryProductArray1.filter(item1 =>
                    !mandotaryProductArray2.some(item2 => item1.id === item2.id)
                );

                var missingBundleHTML = ``;

                if (missingItems.length > 0 || missingBundles.length > 0) {

                    $('#checkoutBtn').removeClass('checkout_enabled').addClass('checkout_disabled');

                    var htmlContent = `<div class="alert alert-warning mt-3" role="alert">
                                        <span style="font-size: 1.1rem; font-weight: 500;">You are missing required products!</span><br>`;

                    if (missingItems.length > 0) {
                        missingItems.forEach(element => {
                            var productUrl = `{{ makeStoreDomainRoute('TeamStoreProductDetails/${element.id}') }}`;

                            htmlContent += `<a style="color:#856404" href="${productUrl}" class="m-1" target="_blank">${element.product_name}</a><br>`;
                        });
                    }

                    if (missingBundles.length > 0) {
                        htmlContent += missingItems.length > 0 ? `<br>` : ``;
                        missingBundles.forEach(element => {

                            if (element.is_required == 0) {
                                htmlContent += `<span style="color:#856404" class="m-1">You added only ${element.available_count} out of ${element.total_count} items for the bundle ${element.category.category_name}</span><br>`;
                            }else{
                                if (element.is_required == 1 && element.available_count > 0) {
                                    htmlContent += `<span style="color:#856404" class="m-1">You added only ${element.available_count} out of ${element.total_count} items for the bundle '${element.category.category_name} (Required) </span><br>`;
                                }
                                if (element.is_required == 1 && element.available_count == 0) {
                                    htmlContent += `<br><span style="color:#856404" class="m-1">No items have been added for the bundle '${element.category.category_name} (Required) </span>`;
                                }
                            }
                        });
                    }

                    htmlContent += `</div>`;

                    $('#mandotary_product_alert').html(htmlContent);

                } else {
                    $('#checkoutBtn').removeClass('checkout_disabled').addClass('checkout_enabled');
                }


                $(".se-pre-con").fadeOut('slow');
            }
        });
    }

    function appendCartProducts(){

        mandotayUpdate();

        $.ajax({
            url: '{{ makeStoreDomainRoute('GetCustomerTeamStoreCart') }}',
            method: 'GET',
            data: {
                store_id: '{{$store->id}}',
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (data) {
                appendCartItems(data)
            },
            error: function (error) {
                console.error('Error fetching data:', error);
                $(".se-pre-con").fadeOut('slow');
            },
            complete: function () {

            }
        });
    }

    function appendCartItems(data) {

        const $container = $('#cart-items');
        $container.html('');

        $('.cart_item_count').text(data.length + ' Items');

        let subtotal = 0;

        data.forEach(item => {
            const imageUrl = item.store_product.images.length > 0
                ? `{{ asset('') }}/${item.store_product.images[0].url}`
                : '{{ asset('assets/img/products/default-loading.gif') }}';

            let sizesNameHtml = '';
            let colourHtml = '';
            let nameHtml = '';

            let totalAdditions = item.store_product.price_additions.reduce((sum, obj) => {
                return sum + (parseFloat(obj.addition_amount) || 0);
            }, 0);

            let defaultPrice = parseFloat(item.store_product.default_price) || 0;

            item.store_cart_items.forEach(store_cart_item => {
                if (store_cart_item.size_details) {
                    sizesNameHtml += `
                        <div class="size-item">
                            <label>${store_cart_item.size_details.size_name}</label>
                        </div>
                    `;
                }
            });


            // if (item.store_product.set_individual_name == 1 || item.store_product.set_individual_number == 1) {
            //     nameHtml = `<label style="color:grey;margin-top: .5rem;">`;

            //     if (item.store_product.set_individual_name == 1) {
            //         nameHtml += `Name: ${item.store_cart_items[0].custom_name || "N/A"}<br>`;
            //     }

            //     if (item.store_product.set_individual_number == 1) {
            //         const number = item.store_cart_items[0].custom_number;

            //         nameHtml += `Number: ${number === null || number === undefined || number === "" ? "N/A" : number}`;
            //         // nameHtml += `Number: ${item.store_cart_items[0].custom_number || "N/A"}`;
            //     }

            //     nameHtml += `</label>`;
            // } else {
            //     nameHtml = ``;
            // }

            if (item.store_product.set_individual_name == 1 || item.store_product.set_individual_number == 1) {

                nameHtml = `<div class="cart-mobile-name-number">`;

                if (item.store_product.set_individual_name == 1) {
                    const customName = item.store_cart_items[0].custom_name;

                    if (customName && customName.trim() !== '' && customName !== 'N/A') {
                        nameHtml += `
                            <div class="cart-mobile-custom-field">
                                <span class="cart-mobile-field-label">Name</span>
                                <span class="cart-mobile-field-value">${customName}</span>
                            </div>
                        `;
                    }
                }

                if (item.store_product.set_individual_number == 1) {
                    const number = item.store_cart_items[0].custom_number;

                    if (
                        number !== null &&
                        number !== undefined &&
                        number !== '' &&
                        number !== 'N/A'
                    ) {
                        nameHtml += `
                            <div class="cart-mobile-custom-field">
                                <span class="cart-mobile-field-label">Number</span>
                                <span class="cart-mobile-field-value">${number}</span>
                            </div>
                        `;
                    }
                }

                nameHtml += `</div>`;

            } else {
                nameHtml = ``;
            }


            const productId = item.store_product_id;
            const storeId = item.store_id;
            const productUrl = `{{ makeStoreDomainRoute('TeamStoreProductDetails/${productId}') }}?item_id=${item.id}`;

            const itemHtml = `
                <div class="cart-item row cart_items align-items-center" style="padding: 10px 0; border-bottom: 1px solid #eee;">
                    <!-- Product Image -->
                    <div class="col-2 position-relative d-flex justify-content-center cart-mobile-image">
                        <a href="${productUrl}" target="_blank">
                            <img src="${imageUrl}" alt="${item.store_product.product_name}" class="cart_image_size" style="object-fit: cover;">
                        </a>
                        ${item.store_product.mandotary == 1 ? `
                            <div class="required-badge"
                                style="position: absolute; top: 5%; right: 10%; background-color: #e51111; color: white; padding: 2px 8px; font-size: 8px; border-radius: 5px;">
                                Required
                            </div>` : ''}
                    </div>

                    <!-- Product Info -->
                    <div class="col-6 cart-mobile-product-info" style="padding-left: 15px;">
                        <span class="font_size13 d-block mb-1" style="font-weight: 400; font-size: 1rem;">
                            ${item.store_product.product_name}
                        </span>
                        <div class="row m-0">
                            <div class="col-md-4 p-1">
                                <span class="gray_font sizes-trigger w-100">
                                    <a href="#" style="color: #4aba58;font-size: 1rem;font-weight: 600;" class="edit_size_click"
                                        data-store-item-id="${item.id}" data-store-product-id="${item.store_product_id}">Sizes:</a>
                                    <div class="sizes-container">${sizesNameHtml || '<label style="color:red;">Set size.</label>'}</div>
                                </span>
                            </div>
                            <div class="col-md-4 p-1">
                                <span class="gray_font w-100">
                                    <div class="sizes-container">${nameHtml}</div>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Each Price -->
                    <div class="col-1 text-center d-flex flex-column justify-content-center cart-mobile-each">
                        <span class="gray_font">Each</span>
                        <span class="font_size13">$${(defaultPrice + totalAdditions).toFixed(2)}</span>
                    </div>

                    <!-- Quantity -->
                    <div class="col-1 text-center d-flex flex-column justify-content-center cart-mobile-qty">
                        <span class="gray_font">Qty</span>
                        <input type="text" class="form-control item_qty_cart mx-auto"
                            value="${item.qty}" min="0" readonly
                            style="width: 60px; text-align: center;">
                    </div>

                    <!-- Total -->
                    <div class="col-1 text-center d-flex flex-column justify-content-center cart-mobile-total">
                        <span class="gray_font">Total</span>
                        <span class="font_size13">$${((defaultPrice + totalAdditions) * item.qty).toFixed(2)}</span>
                    </div>

                    <!-- Actions -->
                    <div class="col-1 text-center d-flex flex-column justify-content-center align-items-center cart-mobile-actions" style="gap: 6px;">
                        <a href="${productUrl}" class="edit_btn_cart" data-product-id="${productId}"
                            title="Edit" style="cursor: pointer; color: grey; font-size: 1rem;">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <i class="fa fa-trash delete_btn_cart"
                            data-cart-item-id="${item.id}" data-product-id="${productId}"
                            title="Remove"
                            style="cursor: pointer; color: #d98181; font-size: 1rem;">
                        </i>
                    </div>
                </div>
            `;


            $container.append(itemHtml);

            subtotal += (defaultPrice + totalAdditions) * item.qty;
        });

        $('#sub_total').text(subtotal.toFixed(2));

        var sales_tax_rate = '{{$store->sales_tax}}';
        var sales_tax_value = sales_tax_rate * subtotal / 100;

        var feeSum = parseFloat('{{$store->handling_fee}}') + parseFloat('{{$store->service_charge}}') + parseFloat('{{$store->other}}');

        var otherFee = feeSum * subtotal / 100;

        $('#other_fee').text(otherFee.toFixed(2));
        $('#sales_tax_rate').text(sales_tax_value.toFixed(2));
        $('#estimate_total').text((subtotal + sales_tax_value + otherFee).toFixed(2));
    }

    function getCartProductDetails(cartItemId, callback) {
        $.ajax({
            url: '{{ makeStoreDomainRoute('GetCustomerTeamStoreCart') }}',
            method: 'GET',
            data: {
                store_id: '{{$store->id}}',
                _token: '{{ csrf_token() }}'
            },
            success: function (data) {

                var filteredItem = data.find(item => item.id == cartItemId);

                if (callback) {
                    callback(filteredItem);
                }
            },
            error: function (error) {
                console.error('Error fetching data:', error);
            }
        });
    }

</script>
@endsection
