@extends('layouts.app', ['activePage' => 'order', 'titlePage' => __('Quote')])

@section('content')

<style>

    /* =========================================================
       LOADER
       ========================================================= */

    .se-pre-con {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        z-index: 99999;

        background:
            url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif")
            center no-repeat #ffffff99;
    }


    /* =========================================================
       QUOTE
       ========================================================= */

    #quote_print {
        max-width: 900px;
        margin: 0 auto;
        padding: 28px 34px;

        background: #ffffff;
        color: #151515;

        font-family: Arial, Helvetica, sans-serif;

        box-sizing: border-box;
    }


    /* =========================================================
       HEADER
       ========================================================= */

    .quote-header {
        width: 100%;

        display: flex;

        justify-content: space-between;
        align-items: flex-start;
    }


    /*
     * TOP DIAMOND LOGO
     */
    .quote-header-logo {
        width: 220px;
        height: auto;
        display: block;
    }


    .quote-heading {
        text-align: right;
    }


    .quote-heading h1 {
        margin: 0 0 10px 0;
        padding: 0;

        color: #ef3d61;

        font-size: 42px;
        line-height: 1;

        font-weight: 700;
    }


    .quote-heading p {
        margin: 2px 0;
        padding: 0;

        color: #24283a;

        font-size: 12px;
        line-height: 1.3;

        font-weight: 500;
    }


    /* =========================================================
       ORDER INFORMATION
       ========================================================= */

    .quote-order-info {
        width: 54%;
        margin-top: 12px;
    }


    .quote-info-row {
        display: grid;

        grid-template-columns: 115px 1fr;

        align-items: center;

        min-height: 31px;

        border: none !important;
    }


    .quote-info-label {
        font-size: 12px;
        line-height: 1.2;

        font-weight: 700;
    }


    .quote-info-value {
        font-size: 12px;
        line-height: 1.2;

        font-weight: 500;
    }


    /* =========================================================
       DIVIDER
       ========================================================= */

    .quote-divider {
        width: 100%;
        height: 1px;

        margin: 18px 0 14px 0;

        background: #e1e1e1;
    }


    /* =========================================================
       ADDRESSES
       ========================================================= */

    .quote-address-grid {
        width: 100%;

        display: grid;

        grid-template-columns: 1fr 1fr;

        column-gap: 30px;
    }


    .quote-address-box {
        width: 100%;
    }


    .quote-address-title {
        min-height: 30px;

        display: flex;
        align-items: center;

        border: none !important;

        font-size: 12px;
        line-height: 1.2;

        font-weight: 700;
    }


    .quote-address-line {
        min-height: 29px;

        display: flex;
        align-items: center;

        border: none !important;

        font-size: 12px;
        line-height: 1.25;

        overflow-wrap: anywhere;
    }


    /* =========================================================
       ITEMS
       ========================================================= */

    .quote-items-wrap {
        width: 100%;
        margin-top: 10px;
    }


    .quote-items-table {
        width: 100%;

        margin: 0;

        border-collapse: collapse;

        table-layout: fixed;
    }


    .quote-items-table thead th {
        padding: 5px;

        background: #d4d4d4;

        border: 1px solid #c6c6c6;

        color: #151515;

        font-size: 10px;
        line-height: 1.1;

        font-weight: 700;

        letter-spacing: 0.5px;

        white-space: nowrap;

        vertical-align: middle;
    }


    .quote-items-table tbody td {
        padding: 7px 5px;

        border-left: 1px solid #d0d0d0;
        border-right: 1px solid #d0d0d0;
        border-bottom: 1px solid #d0d0d0;

        color: #181818;

        font-size: 11.5px;
        line-height: 1.25;

        vertical-align: middle;
    }


    .quote-items-table th:nth-child(1),
    .quote-items-table td:nth-child(1) {
        width: 52%;
    }


    .quote-items-table th:nth-child(2),
    .quote-items-table td:nth-child(2) {
        width: 10%;
    }


    .quote-items-table th:nth-child(3),
    .quote-items-table td:nth-child(3) {
        width: 13%;
    }


    .quote-items-table th:nth-child(4),
    .quote-items-table td:nth-child(4) {
        width: 5%;
    }


    .quote-items-table th:nth-child(5),
    .quote-items-table td:nth-child(5) {
        width: 11%;
    }


    .quote-items-table th:nth-child(6),
    .quote-items-table td:nth-child(6) {
        width: 9%;
    }


    .quote-item-name {
        text-align: left;

        overflow-wrap: anywhere;
    }


    .quote-center {
        text-align: center;
    }


    .quote-right {
        text-align: right;
    }


    /* =========================================================
       BOTTOM
       ========================================================= */

    .quote-bottom-section {
        width: 100%;

        display: grid;

        grid-template-columns: 57% 43%;

        align-items: start;

        margin-top: 18px;
    }


    /* =========================================================
       THANK YOU
       ========================================================= */

    .quote-thank-you {
        padding-top: 10px;

        text-align: center;
    }


    .quote-thank-you h2 {
        margin: 0 0 28px 0;

        color: #343864;

        font-size: 28px;
        line-height: 1.2;

        font-weight: 700;
    }


    /*
     * LOWER LOGO
     */
    .quote-thank-you img {
        width: 320px;

        max-width: 82%;

        height: auto;

        display: block;

        margin: 0 auto;
    }


    /* =========================================================
       TOTALS
       ========================================================= */

    .quote-summary-table {
        width: 100%;

        margin: 0;

        border-collapse: collapse;

        border: none !important;
    }


    .quote-summary-table,
    .quote-summary-table tbody,
    .quote-summary-table tr,
    .quote-summary-table th,
    .quote-summary-table td {
        border: none !important;

        outline: none !important;

        box-shadow: none !important;
    }


    .quote-summary-table th,
    .quote-summary-table td {
        padding: 8px 7px;

        font-size: 12px;

        line-height: 1.15;
    }


    .quote-summary-table th {
        width: 67%;

        text-align: left;

        font-weight: 700;
    }


    .quote-summary-table td {
        width: 33%;

        text-align: right;

        font-weight: 500;
    }


    .quote-summary-total th,
    .quote-summary-total td {
        padding-top: 13px;

        padding-bottom: 10px;

        border: none !important;

        font-size: 21px;

        line-height: 1.1;

        font-weight: 700;
    }


    /* =========================================================
       A4 HTML WORKSPACE
       ========================================================= */

    #quote_pdf_workspace {
        position: fixed;

        left: 0;
        top: 0;

        width: 900px;

        background: #ffffff;

        z-index: 99998;

        pointer-events: none;

        overflow: visible;
    }


    /*
     * 900 x 1273 = A4 ratio
     */
    .quote-a4-page {
        position: relative;

        width: 900px !important;
        height: 1273px !important;

        min-width: 900px !important;
        max-width: 900px !important;

        min-height: 1273px !important;
        max-height: 1273px !important;

        margin: 0 !important;

        padding: 0 !important;

        overflow: hidden;

        background: #ffffff;

        box-sizing: border-box;

        color: #151515;

        font-family: Arial, Helvetica, sans-serif;
    }


    .quote-a4-body {
        position: absolute;

        left: 0;
        right: 0;

        top: 0;
        bottom: 32px;

        padding: 25px 34px 0 34px;

        overflow: hidden;

        box-sizing: border-box;
    }


    /*
     * Continuation pages start close to the top.
     */
    .quote-continuation-page .quote-a4-body {
        padding-top: 18px;
    }


    /* =========================================================
       PAGE NUMBER
       ========================================================= */

    .quote-a4-footer {
        position: absolute;

        right: 34px;

        bottom: 10px;

        color: #666666;

        font-size: 9px;

        line-height: 1;

        white-space: nowrap;
    }


    /* =========================================================
       PAGE BREAK SAFETY
       ========================================================= */

    .quote-a4-page tr,
    .quote-a4-page th,
    .quote-a4-page td {
        page-break-inside: avoid !important;

        break-inside: avoid !important;
    }


    .quote-a4-page .quote-bottom-section,
    .quote-a4-page .quote-summary-table {
        page-break-inside: avoid !important;

        break-inside: avoid !important;
    }

</style>



<div class="se-pre-con"></div>



@foreach ($orders as $order)


<div id="quote_print">


    <input
        type="hidden"
        id="quote_id"
        value="{{ $order->id }}"
    >


    <input
        type="hidden"
        id="quote_organization_name"
        value="{{ optional($order->organizationDetails)['organization_name'] ?? 'Quote' }}"
    >



    {{-- =====================================================
         TOP
         ===================================================== --}}

    <div id="quote_top_section">


        <div class="quote-header">


            <div>

                <img
                    src="{{ asset('argon') }}/img/encore/logo1.png"
                    class="quote-header-logo"
                    alt="Encore Custom"
                >

            </div>


            <div class="quote-heading">


                <h1>
                    QUOTE
                </h1>


                <p>
                    Encore Custom
                </p>


                <p>
                    891 4th st.
                </p>


                <p>
                    San Rafael, CA 94901
                </p>


            </div>


        </div>



        {{-- =================================================
             ORDER INFO
             ================================================= --}}

        <div class="quote-order-info">


            <div class="quote-info-row">

                <div class="quote-info-label">
                    Organization :
                </div>

                <div class="quote-info-value">

                    {{ optional($order->organizationDetails)['organization_name'] ?? 'N/A' }}

                </div>

            </div>


            <div class="quote-info-row">

                <div class="quote-info-label">
                    Order # :
                </div>

                <div class="quote-info-value">

                    {{ $order->order_no }}

                </div>

            </div>


            <div class="quote-info-row">

                <div class="quote-info-label">
                    Status :
                </div>

                <div class="quote-info-value">

                    {{ optional($order->statusDetails)['status_name'] ?? 'N/A' }}

                </div>

            </div>


            <div class="quote-info-row">

                <div class="quote-info-label">
                    Sales Rep :
                </div>

                <div class="quote-info-value">

                    {{ optional($order->userDetails)['name'] ?? 'N/A' }}

                </div>

            </div>


        </div>



        <div class="quote-divider"></div>



        {{-- =================================================
             ADDRESS
             ================================================= --}}

        <div class="quote-address-grid">


            {{-- =================================================
                 SHIPPING
                 ================================================= --}}

            <div class="quote-address-box">


                <div class="quote-address-title">
                    Shipping Address:
                </div>


                <div class="quote-address-line">

                    {{ optional($order->contactDetails)['first_name'] }}

                    {{ optional($order->contactDetails)['last_name'] }}

                </div>



                @if ($order->is_new_shipping_address == 1)


                    @if (!empty($order->apartment))

                        <div class="quote-address-line">
                            {{ $order->apartment }}
                        </div>

                    @endif


                    @if (!empty($order->street))

                        <div class="quote-address-line">
                            {{ $order->street }}
                        </div>

                    @endif


                    @if (
                        !empty($order->city) ||
                        !empty($order->state) ||
                        !empty($order->postal_code)
                    )

                        <div class="quote-address-line">

                            {{ $order->city }}

                            {{ $order->state }}

                            {{ $order->postal_code }}

                        </div>

                    @endif


                    @if (!empty($order->country))

                        <div class="quote-address-line">
                            {{ $order->country }}
                        </div>

                    @endif



                @elseif ($order->is_new_shipping_address == 2)


                    @if (!empty($order->contactDetails['apartment']))

                        <div class="quote-address-line">

                            {{ $order->contactDetails['apartment'] }}

                        </div>

                    @endif


                    @if (!empty($order->contactDetails['shipping_street']))

                        <div class="quote-address-line">

                            {{ $order->contactDetails['shipping_street'] }}

                        </div>

                    @endif


                    @if (
                        !empty($order->contactDetails['shipping_city']) ||
                        !empty($order->contactDetails['shipping_state']) ||
                        !empty($order->contactDetails['shipping_zip'])
                    )

                        <div class="quote-address-line">

                            {{ $order->contactDetails['shipping_city'] }}

                            {{ $order->contactDetails['shipping_state'] }}

                            {{ $order->contactDetails['shipping_zip'] }}

                        </div>

                    @endif


                    @if (!empty($order->contactDetails['shipping_country']))

                        <div class="quote-address-line">

                            {{ $order->contactDetails['shipping_country'] }}

                        </div>

                    @endif



                @else


                    @if (!empty($order->contactDetails['apartment2']))

                        <div class="quote-address-line">

                            {{ $order->contactDetails['apartment2'] }}

                        </div>

                    @endif


                    @if (!empty($order->contactDetails['shipping_street_2']))

                        <div class="quote-address-line">

                            {{ $order->contactDetails['shipping_street_2'] }}

                        </div>

                    @endif


                    @if (
                        !empty($order->contactDetails['shipping_city_2']) ||
                        !empty($order->contactDetails['shipping_state_2']) ||
                        !empty($order->contactDetails['shipping_zip_2'])
                    )

                        <div class="quote-address-line">

                            {{ $order->contactDetails['shipping_city_2'] }}

                            {{ $order->contactDetails['shipping_state_2'] }}

                            {{ $order->contactDetails['shipping_zip_2'] }}

                        </div>

                    @endif


                    @if (!empty($order->contactDetails['shipping_country_2']))

                        <div class="quote-address-line">

                            {{ $order->contactDetails['shipping_country_2'] }}

                        </div>

                    @endif


                @endif



                @if (!empty($order->phone_no))

                    <div class="quote-address-line">
                        {{ $order->phone_no }}
                    </div>

                @endif


                @if (!empty($order->email))

                    <div class="quote-address-line">
                        {{ $order->email }}
                    </div>

                @endif


            </div>



            {{-- =================================================
                 BILLING
                 ================================================= --}}

            <div class="quote-address-box">


                <div class="quote-address-title">
                    Billing Address:
                </div>



                @if (!empty($order->billingDetails))


                    <div class="quote-address-line">

                        {{ $order->billingDetails['first_name'] }}

                        {{ $order->billingDetails['last_name'] }}

                    </div>


                    @if (!empty($order->billingDetails['apartment']))

                        <div class="quote-address-line">

                            {{ $order->billingDetails['apartment'] }}

                        </div>

                    @endif


                    @if (!empty($order->billingDetails['street']))

                        <div class="quote-address-line">

                            {{ $order->billingDetails['street'] }}

                        </div>

                    @endif


                    @if (
                        !empty($order->billingDetails['city']) ||
                        !empty($order->billingDetails['state']) ||
                        !empty($order->billingDetails['postal_code'])
                    )

                        <div class="quote-address-line">

                            {{ $order->billingDetails['city'] }}

                            {{ $order->billingDetails['state'] }}

                            {{ $order->billingDetails['postal_code'] }}

                        </div>

                    @endif


                    @if (!empty($order->billingDetails['country']))

                        <div class="quote-address-line">

                            {{ $order->billingDetails['country'] }}

                        </div>

                    @endif


                    @if (!empty($order->billingDetails['phone_no']))

                        <div class="quote-address-line">

                            {{ $order->billingDetails['phone_no'] }}

                        </div>

                    @endif


                    @if (!empty($order->billingDetails['email']))

                        <div class="quote-address-line">

                            {{ $order->billingDetails['email'] }}

                        </div>

                    @endif



                @else


                    <div class="quote-address-line">

                        {{ optional($order->contactDetails)['first_name'] }}

                        {{ optional($order->contactDetails)['last_name'] }}

                    </div>


                    @if (!empty($order->apartment))

                        <div class="quote-address-line">
                            {{ $order->apartment }}
                        </div>

                    @endif


                    @if (!empty($order->street))

                        <div class="quote-address-line">
                            {{ $order->street }}
                        </div>

                    @endif


                    @if (
                        !empty($order->city) ||
                        !empty($order->state) ||
                        !empty($order->postal_code)
                    )

                        <div class="quote-address-line">

                            {{ $order->city }}

                            {{ $order->state }}

                            {{ $order->postal_code }}

                        </div>

                    @endif


                    @if (!empty($order->country))

                        <div class="quote-address-line">
                            {{ $order->country }}
                        </div>

                    @endif


                    @if (!empty($order->phone_no))

                        <div class="quote-address-line">
                            {{ $order->phone_no }}
                        </div>

                    @endif


                    @if (!empty($order->email))

                        <div class="quote-address-line">
                            {{ $order->email }}
                        </div>

                    @endif


                @endif


            </div>


        </div>


    </div>



    {{-- =====================================================
         ITEMS
         ===================================================== --}}

    <div
        id="quote_items_section"
        class="quote-items-wrap"
    >


        <table
            id="quote_items"
            class="quote-items-table"
        >


            <thead>


                <tr>


                    <th>
                        ITEM
                    </th>


                    <th>
                        STATUS
                    </th>


                    <th>
                        EST DELIVERY
                    </th>


                    <th>
                        QTY
                    </th>


                    <th class="quote-right">
                        UNIT PRICE($)
                    </th>


                    <th class="quote-right">
                        TOTAL($)
                    </th>


                </tr>


            </thead>



            <tbody>


                @foreach ($order->orderItems as $orderItem)


                    <tr>


                        <td class="quote-item-name">

                            {{
                                $orderItem->display_name
                                ??
                                optional($orderItem->productDetails)['product_name']
                            }}

                        </td>


                        <td class="quote-center">

                            {{ optional($orderItem->statusDetails)['status_name'] }}

                        </td>


                        <td class="quote-center">

                            {{ $orderItem->est_delivery_date }}

                        </td>


                        <td class="quote-center">

                            {{ $orderItem->qty }}

                        </td>


                        <td class="quote-right">

                            {{ number_format($orderItem->unit_price, 2) }}

                        </td>


                        <td class="quote-right">

                            {{ number_format($orderItem->total, 2) }}

                        </td>


                    </tr>


                @endforeach


            </tbody>


        </table>


    </div>



    {{-- =====================================================
         BOTTOM
         ===================================================== --}}

    <div
        id="quote_bottom_section"
        class="quote-bottom-section"
    >


        @can('show order price')


            <div class="quote-thank-you">


                <h2>
                    Thank you for your business!
                </h2>


                <img
                    src="{{ asset('argon') }}/img/encore/logo_dark.png"
                    alt="Encore Custom"
                >


            </div>



            <div>


                <table class="quote-summary-table">


                    <tr>

                        <th>
                            SUBTOTAL ($) :
                        </th>

                        <td>

                            {{ number_format($order->sub_total, 2) }}

                        </td>

                    </tr>


                    <tr>

                        <th>

                            SALES TAX ($)
                            {{ optional($order->organizationDetails)['sales_tax'] }}%
                            RATE :

                        </th>

                        <td>

                            {{ number_format($order->sales_tax, 2) }}

                        </td>

                    </tr>


                    <tr>

                        <th>
                            SHIPPING ($) :
                        </th>

                        <td>

                            {{ number_format($order->shipping, 2) }}

                        </td>

                    </tr>


                    <tr>

                        <th>
                            ARTWORK ($) :
                        </th>

                        <td>

                            {{ number_format($order->artwork, 2) }}

                        </td>

                    </tr>


                    <tr>

                        <th>
                            PROCESSING FEE ($) :
                        </th>

                        <td>

                            {{ number_format($processingFee ?? 0, 2) }}

                        </td>

                    </tr>



                    @php

                        if ($order->discountType == 2) {

                            $discountValue =
                                $order->discount;

                        } else {

                            $totalWithoutdisc =
                                $order->sub_total
                                +
                                $order->sales_tax
                                +
                                $order->shipping
                                +
                                $order->artwork;

                            $discountPercentage =
                                $order->discount;

                            $discountValue =
                                ($totalWithoutdisc / 100)
                                *
                                $discountPercentage;

                        }

                    @endphp



                    @if ($order->discount_hidation == 1)


                        @if ($order->discountType == 2)


                            <tr>

                                <th>
                                    DISCOUNT VALUE ($) :
                                </th>

                                <td>

                                    {{ number_format($discountValue, 2) }}

                                </td>

                            </tr>


                        @elseif ($order->discountType == 1)


                            <tr>

                                <th>

                                    DISCOUNT VALUE
                                    {{ $order->discount }}%
                                    ($) :

                                </th>

                                <td>

                                    {{ number_format($discountValue, 2) }}

                                </td>

                            </tr>


                        @endif


                    @endif



                    <tr class="quote-summary-total">

                        <th>
                            ORDER TOTAL ($) :
                        </th>

                        <td>

                            {{
                                number_format(
                                    $order->order_total
                                    +
                                    ($processingFee ?? 0),
                                    2
                                )
                            }}

                        </td>

                    </tr>


                </table>


            </div>


        @endcan


    </div>



    <a
        href="{{ url('order_details/edit') }}/{{ $order->id }}/order?active_tab=order"
        id="quote_redirect_link"
        style="display:none;"
    >
        redirect
    </a>


</div>


@endforeach



<script>

(function () {

    'use strict';


    /* =========================================================
       CONFIG
       ========================================================= */

    var PDF_WIDTH_PX =
        900;


    var PDF_HEIGHT_PX =
        1273;


    var PDF_SAFETY_PX =
        10;



    /* =========================================================
       WAIT HELPERS
       ========================================================= */

    function waitLayout() {


        return new Promise(function (resolve) {


            requestAnimationFrame(function () {


                requestAnimationFrame(function () {


                    resolve();


                });


            });


        });


    }



    function waitFonts() {


        if (
            document.fonts &&
            document.fonts.ready
        ) {


            return document.fonts.ready.catch(
                function () {


                    return true;


                }
            );


        }


        return Promise.resolve();


    }



    function waitImages(element) {


        var images =
            Array.prototype.slice.call(

                element.querySelectorAll(
                    'img'
                )

            );


        var promises =
            images.map(function (image) {


                if (
                    image.complete &&
                    image.naturalWidth > 0
                ) {


                    return Promise.resolve();


                }


                return new Promise(function (resolve) {


                    var finished =
                        false;


                    function done() {


                        if (
                            finished
                        ) {


                            return;


                        }


                        finished =
                            true;


                        resolve();


                    }


                    image.addEventListener(
                        'load',
                        done,
                        {
                            once: true
                        }
                    );


                    image.addEventListener(
                        'error',
                        done,
                        {
                            once: true
                        }
                    );


                    setTimeout(
                        done,
                        4000
                    );


                });


            });


        return Promise.all(
            promises
        );


    }



    /* =========================================================
       CREATE A4 HTML PAGE
       ========================================================= */

    function createA4Page(
        continuation
    ) {


        var page =
            document.createElement(
                'div'
            );


        page.className =
            'quote-a4-page';


        if (
            continuation
        ) {


            page.classList.add(
                'quote-continuation-page'
            );


        }


        var body =
            document.createElement(
                'div'
            );


        body.className =
            'quote-a4-body';


        var inner =
            document.createElement(
                'div'
            );


        var footer =
            document.createElement(
                'div'
            );


        footer.className =
            'quote-a4-footer';


        body.appendChild(
            inner
        );


        page.appendChild(
            body
        );


        page.appendChild(
            footer
        );


        page._quoteBody =
            body;


        page._quoteInner =
            inner;


        page._quoteFooter =
            footer;


        return page;


    }



    /* =========================================================
       CREATE ITEMS TABLE
       ========================================================= */

    function createItemsSection(
        sourceTable,
        sourceHead,
        rows,
        start,
        end
    ) {


        var wrapper =
            document.createElement(
                'div'
            );


        wrapper.className =
            'quote-items-wrap';


        var table =
            sourceTable.cloneNode(
                false
            );


        table.removeAttribute(
            'id'
        );


        table.className =
            'quote-items-table';


        /*
         * Repeat header on every page.
         */
        table.appendChild(

            sourceHead.cloneNode(
                true
            )

        );


        var tbody =
            document.createElement(
                'tbody'
            );


        for (
            var i = start;
            i < end;
            i++
        ) {


            if (
                rows[i]
            ) {


                tbody.appendChild(

                    rows[i].cloneNode(
                        true
                    )

                );


            }


        }


        table.appendChild(
            tbody
        );


        wrapper.appendChild(
            table
        );


        return wrapper;


    }



    /* =========================================================
       BUILD PAGE
       ========================================================= */

    function buildPage(
        type,
        start,
        end,
        top,
        bottom,
        table,
        head,
        rows
    ) {


        var continuation =
            (
                type === 'middle' ||
                type === 'final'
            );


        var page =
            createA4Page(
                continuation
            );


        /*
         * HEADER / ADDRESSES
         */
        if (
            type === 'single' ||
            type === 'first'
        ) {


            page._quoteInner.appendChild(

                top.cloneNode(
                    true
                )

            );


        }


        /*
         * PRODUCTS
         */
        if (
            end > start
        ) {


            page._quoteInner.appendChild(

                createItemsSection(

                    table,

                    head,

                    rows,

                    start,

                    end

                )

            );


        }


        /*
         * TOTALS
         */
        if (
            type === 'single' ||
            type === 'final'
        ) {


            page._quoteInner.appendChild(

                bottom.cloneNode(
                    true
                )

            );


        }


        return page;


    }



    /* =========================================================
       PAGE FIT
       ========================================================= */

    async function pageFits(
        workspace,
        page
    ) {


        workspace.appendChild(
            page
        );


        await waitImages(
            page
        );


        await waitFonts();


        await waitLayout();


        var available =
            page._quoteBody.clientHeight
            -
            PDF_SAFETY_PX;


        var required =
            page._quoteInner.scrollHeight;


        var fits =
            required <=
            available;


        page.remove();


        return fits;


    }



    /* =========================================================
       FIND MAX ITEMS THAT FIT
       ========================================================= */

    async function findMaximumEnd(
        workspace,
        type,
        start,
        limit,
        top,
        bottom,
        table,
        head,
        rows
    ) {


        var best =
            start;


        for (
            var end = start + 1;
            end <= limit;
            end++
        ) {


            var test =
                buildPage(

                    type,

                    start,

                    end,

                    top,

                    bottom,

                    table,

                    head,

                    rows

                );


            var fits =
                await pageFits(
                    workspace,
                    test
                );


            if (
                !fits
            ) {


                break;


            }


            best =
                end;


        }


        return best;


    }



    /* =========================================================
       CAN REMAINING ITEMS + TOTALS FIT NOW?
       ========================================================= */

    async function canFinishOnFinalPage(
        workspace,
        start,
        total,
        top,
        bottom,
        table,
        head,
        rows
    ) {


        var page =
            buildPage(

                'final',

                start,

                total,

                top,

                bottom,

                table,

                head,

                rows

            );


        return await pageFits(
            workspace,
            page
        );


    }



    /* =========================================================
       FIND BEST PENULTIMATE/FNAL SPLIT
       =========================================================

       Example:

       Old:
       page 2 = 28 rows + huge empty area
       page 3 = 1 row + totals

       New:
       Search backward and determine whether:

       page 2 = remaining rows + totals

       fits.

       If not, find the largest possible page 2 while
       making page 3 contain enough rows + totals.

       ========================================================= */

    async function findBestSplitForLastTwoPages(
        workspace,
        current,
        total,
        top,
        bottom,
        table,
        head,
        rows
    ) {


        /*
         * Maximum rows a normal continuation page can hold.
         */
        var maximumMiddleEnd =
            await findMaximumEnd(

                workspace,

                'middle',

                current,

                total,

                top,

                bottom,

                table,

                head,

                rows

            );


        if (
            maximumMiddleEnd <=
            current
        ) {


            return null;


        }


        /*
         * Keep at least one product for final page while
         * searching.
         */
        var maximumSplit =
            Math.min(

                maximumMiddleEnd,

                total - 1

            );


        /*
         * Start with the fullest possible page 2 and move
         * products toward page 3 only when necessary.
         */
        for (
            var split = maximumSplit;
            split > current;
            split--
        ) {


            var finalPage =
                buildPage(

                    'final',

                    split,

                    total,

                    top,

                    bottom,

                    table,

                    head,

                    rows

                );


            var fits =
                await pageFits(

                    workspace,

                    finalPage

                );


            if (
                fits
            ) {


                return {

                    middleEnd:
                        split,

                    finalStart:
                        split

                };


            }


        }


        return {

            middleEnd:
                maximumMiddleEnd,

            finalStart:
                null

        };


    }



    /* =========================================================
       CREATE PDF
       ========================================================= */

    async function createPdf() {


        if (
            window.jspdf &&
            window.jspdf.jsPDF
        ) {


            return new window.jspdf.jsPDF({

                orientation:
                    'portrait',

                unit:
                    'mm',

                format:
                    'a4'

            });


        }


        if (
            typeof window.jsPDF ===
            'function'
        ) {


            return new window.jsPDF(
                'p',
                'mm',
                'a4'
            );


        }


        if (
            typeof window.html2pdf !==
            'function'
        ) {


            throw new Error(
                'Neither jsPDF nor html2pdf is loaded.'
            );


        }


        var temp =
            document.createElement(
                'div'
            );


        temp.style.position =
            'fixed';


        temp.style.left =
            '0';


        temp.style.top =
            '0';


        temp.style.width =
            '1px';


        temp.style.height =
            '1px';


        temp.textContent =
            ' ';


        document.body.appendChild(
            temp
        );


        var worker =
            window.html2pdf()

                .set({

                    margin:
                        0,

                    jsPDF: {

                        unit:
                            'mm',

                        format:
                            'a4',

                        orientation:
                            'portrait'

                    },

                    html2canvas: {

                        scale:
                            1,

                        logging:
                            false

                    }

                })

                .from(temp)

                .toPdf();


        var pdf =
            await worker.get(
                'pdf'
            );


        temp.remove();


        if (
            pdf.internal &&
            typeof pdf.internal.getNumberOfPages ===
                'function' &&
            typeof pdf.deletePage ===
                'function'
        ) {


            while (
                pdf.internal.getNumberOfPages() >
                1
            ) {


                pdf.deletePage(

                    pdf.internal.getNumberOfPages()

                );


            }


        }


        return pdf;


    }



    /* =========================================================
       RENDER PAGE
       ========================================================= */

    async function renderPage(
        page
    ) {


        await waitImages(
            page
        );


        await waitFonts();


        await waitLayout();


        var options = {

            scale:
                2,

            useCORS:
                true,

            allowTaint:
                true,

            letterRendering:
                true,

            logging:
                false,

            backgroundColor:
                '#ffffff',

            width:
                PDF_WIDTH_PX,

            height:
                PDF_HEIGHT_PX,

            windowWidth:
                PDF_WIDTH_PX,

            windowHeight:
                PDF_HEIGHT_PX,

            scrollX:
                0,

            scrollY:
                0

        };


        if (
            typeof window.html2canvas ===
            'function'
        ) {


            return window.html2canvas(

                page,

                options

            );


        }


        if (
            typeof window.html2pdf !==
            'function'
        ) {


            throw new Error(
                'html2canvas/html2pdf is not loaded.'
            );


        }


        var worker =
            window.html2pdf()

                .set({

                    html2canvas:
                        options

                })

                .from(page)

                .toCanvas();


        return worker.get(
            'canvas'
        );


    }



    /* =========================================================
       MAIN
       ========================================================= */

    async function generateQuotePdf() {


        var workspace =
            null;


        try {


            var quoteIdElement =
                document.getElementById(
                    'quote_id'
                );


            var organizationElement =
                document.getElementById(
                    'quote_organization_name'
                );


            var top =
                document.getElementById(
                    'quote_top_section'
                );


            var table =
                document.getElementById(
                    'quote_items'
                );


            var bottom =
                document.getElementById(
                    'quote_bottom_section'
                );


            if (
                !quoteIdElement ||
                !organizationElement ||
                !top ||
                !table ||
                !bottom
            ) {


                throw new Error(
                    'Quote PDF source elements are missing.'
                );


            }


            var quoteId =
                quoteIdElement.value;


            var organizationName =
                organizationElement.value;


            var head =
                table.querySelector(
                    'thead'
                );


            var body =
                table.querySelector(
                    'tbody'
                );


            if (
                !head ||
                !body
            ) {


                throw new Error(
                    'Quote item table is invalid.'
                );


            }


            var rows =
                Array.prototype.slice.call(

                    body.querySelectorAll(
                        'tr'
                    )

                );


            var total =
                rows.length;


            /* =================================================
               WORKSPACE
               ================================================= */

            var oldWorkspace =
                document.getElementById(
                    'quote_pdf_workspace'
                );


            if (
                oldWorkspace
            ) {


                oldWorkspace.remove();


            }


            workspace =
                document.createElement(
                    'div'
                );


            workspace.id =
                'quote_pdf_workspace';


            document.body.appendChild(
                workspace
            );


            await waitFonts();


            await waitLayout();


            /* =================================================
               CALCULATE PAGES
               ================================================= */

            var chunks =
                [];


            /*
             * First try everything on page 1.
             */
            var single =
                buildPage(

                    'single',

                    0,

                    total,

                    top,

                    bottom,

                    table,

                    head,

                    rows

                );


            if (
                await pageFits(
                    workspace,
                    single
                )
            ) {


                chunks.push({

                    type:
                        'single',

                    start:
                        0,

                    end:
                        total

                });


            }
            else {


                /*
                 * Find the maximum items that fit on page 1.
                 */
                var firstEnd =
                    await findMaximumEnd(

                        workspace,

                        'first',

                        0,

                        total,

                        top,

                        bottom,

                        table,

                        head,

                        rows

                    );


                if (
                    firstEnd <=
                    0
                ) {


                    throw new Error(
                        'No quote items fit on page 1.'
                    );


                }


                chunks.push({

                    type:
                        'first',

                    start:
                        0,

                    end:
                        firstEnd

                });


                var current =
                    firstEnd;


                /*
                ==================================================
                SMART CONTINUATION PAGINATION
                ==================================================

                This is the important fix.

                At the beginning of every continuation page:

                1. Try ALL remaining products + totals.
                2. If they fit, make THIS the final page.
                3. Otherwise calculate the best possible split.
                ==================================================
                */

                while (
                    current <
                    total
                ) {


                    /*
                     * Can all remaining items + totals fit here?
                     */
                    var canFinish =
                        await canFinishOnFinalPage(

                            workspace,

                            current,

                            total,

                            top,

                            bottom,

                            table,

                            head,

                            rows

                        );


                    if (
                        canFinish
                    ) {


                        chunks.push({

                            type:
                                'final',

                            start:
                                current,

                            end:
                                total

                        });


                        current =
                            total;


                        break;


                    }


                    /*
                     * Find the best split between the next
                     * continuation page and the final page.
                     */
                    var pair =
                        await findBestSplitForLastTwoPages(

                            workspace,

                            current,

                            total,

                            top,

                            bottom,

                            table,

                            head,

                            rows

                        );


                    if (
                        !pair ||
                        pair.middleEnd <= current
                    ) {


                        throw new Error(
                            'A quote item row is too tall for A4.'
                        );


                    }


                    /*
                     * If a final-page split was found,
                     * these are the last two pages.
                     */
                    if (
                        pair.finalStart !==
                        null
                    ) {


                        chunks.push({

                            type:
                                'middle',

                            start:
                                current,

                            end:
                                pair.middleEnd

                        });


                        chunks.push({

                            type:
                                'final',

                            start:
                                pair.finalStart,

                            end:
                                total

                        });


                        current =
                            total;


                        break;


                    }


                    /*
                     * More than two pages are still needed.
                     *
                     * Fill this middle page as much as possible.
                     */
                    chunks.push({

                        type:
                            'middle',

                        start:
                            current,

                        end:
                            pair.middleEnd

                    });


                    current =
                        pair.middleEnd;


                }


                /*
                 * Defensive case:
                 *
                 * If every product somehow got consumed by
                 * middle pages, still append totals.
                 */
                if (
                    current === total
                ) {


                    var lastChunk =
                        chunks[
                            chunks.length - 1
                        ];


                    if (
                        lastChunk &&
                        lastChunk.type !== 'final'
                    ) {


                        chunks.push({

                            type:
                                'final',

                            start:
                                total,

                            end:
                                total

                        });


                    }


                }


            }


            console.log(
                'Quote PDF pages:',
                chunks
            );


            /* =================================================
               CREATE PDF
               ================================================= */

            var pdf =
                await createPdf();


            if (
                pdf.internal &&
                typeof pdf.internal.getNumberOfPages ===
                    'function' &&
                typeof pdf.deletePage ===
                    'function'
            ) {


                while (
                    pdf.internal.getNumberOfPages() >
                    1
                ) {


                    pdf.deletePage(

                        pdf.internal.getNumberOfPages()

                    );


                }


            }


            var totalPages =
                chunks.length;


            /* =================================================
               RENDER
               ================================================= */

            for (
                var pageIndex = 0;
                pageIndex < totalPages;
                pageIndex++
            ) {


                var chunk =
                    chunks[
                        pageIndex
                    ];


                var page =
                    buildPage(

                        chunk.type,

                        chunk.start,

                        chunk.end,

                        top,

                        bottom,

                        table,

                        head,

                        rows

                    );


                page._quoteFooter.textContent =

                    'Page '
                    +
                    (
                        pageIndex + 1
                    )
                    +
                    ' of '
                    +
                    totalPages;


                workspace.appendChild(
                    page
                );


                await waitImages(
                    page
                );


                await waitFonts();


                await waitLayout();


                var canvas =
                    await renderPage(
                        page
                    );


                if (
                    !canvas ||
                    canvas.width < 100 ||
                    canvas.height < 100
                ) {


                    throw new Error(
                        'Quote PDF canvas is empty.'
                    );


                }


                var image =
                    canvas.toDataURL(

                        'image/jpeg',

                        0.98

                    );


                if (
                    pageIndex >
                    0
                ) {


                    pdf.addPage();


                }


                if (
                    typeof pdf.setPage ===
                    'function'
                ) {


                    pdf.setPage(

                        pageIndex + 1

                    );


                }


                pdf.addImage(

                    image,

                    'JPEG',

                    0,

                    0,

                    210,

                    297

                );


                page.remove();


            }


            /* =================================================
               DOWNLOAD
               ================================================= */

            var safeName =
                organizationName

                    .replace(
                        /[\\/:*?"<>|]+/g,
                        '_'
                    )

                    .trim();


            pdf.save(

                safeName
                +
                '_Quote_'
                +
                quoteId
                +
                '.pdf'

            );


            workspace.remove();


            workspace =
                null;


            $('.se-pre-con').hide();


            setTimeout(function () {


                var redirect =
                    document.getElementById(
                        'quote_redirect_link'
                    );


                if (
                    redirect
                ) {


                    window.location.href =
                        redirect.href;


                }


            }, 1500);


        }
        catch (error) {


            console.error(

                'Quote PDF generation failed:',

                error

            );


            if (
                workspace
            ) {


                workspace.remove();


            }


            $('.se-pre-con').hide();


            alert(
                'Unable to generate Quote PDF. Check console.'
            );


        }


    }



    /* =========================================================
       START
       ========================================================= */

    window.addEventListener(
        'load',
        function () {


            setTimeout(
                function () {


                    generateQuotePdf();


                },
                800
            );


        }
    );


})();

</script>

@endsection
