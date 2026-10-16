@extends('layouts.app', ['activePage' => 'order', 'titlePage' => __('Invoice')])

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
       INVOICE
       ========================================================= */

    #invoice_print {
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

    .invoice-header {
        width: 100%;

        display: flex;

        justify-content: space-between;
        align-items: flex-start;
    }


    /*
     * TOP DIAMOND LOGO
     */
    .invoice-header-logo {
        width: 220px;

        height: auto;

        display: block;
    }


    .invoice-heading {
        text-align: right;
    }


    .invoice-heading h1 {
        margin: 0 0 10px 0;

        padding: 0;

        color: #ef3d61;

        font-size: 42px;

        line-height: 1;

        font-weight: 700;
    }


    .invoice-heading p {
        margin: 2px 0;

        padding: 0;

        color: #24283a;

        font-size: 12px;

        line-height: 1.3;

        font-weight: 500;
    }


    /* =========================================================
       ORDER INFO
       ========================================================= */

    .invoice-order-info {
        width: 54%;

        margin-top: 12px;
    }


    .invoice-info-row {
        display: grid;

        grid-template-columns: 115px 1fr;

        align-items: center;

        min-height: 31px;

        border: none !important;
    }


    .invoice-info-label {
        font-size: 12px;

        line-height: 1.2;

        font-weight: 700;
    }


    .invoice-info-value {
        font-size: 12px;

        line-height: 1.2;

        font-weight: 500;
    }


    /* =========================================================
       DIVIDER
       ========================================================= */

    .invoice-divider {
        width: 100%;

        height: 1px;

        margin: 18px 0 14px 0;

        background: #e1e1e1;
    }


    /* =========================================================
       ADDRESS
       ========================================================= */

    .invoice-address-grid {
        width: 100%;

        display: grid;

        grid-template-columns: 1fr 1fr;

        column-gap: 30px;
    }


    .invoice-address-box {
        width: 100%;
    }


    .invoice-address-title {
        min-height: 30px;

        display: flex;

        align-items: center;

        border: none !important;

        font-size: 12px;

        line-height: 1.2;

        font-weight: 700;
    }


    .invoice-address-line {
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

    .invoice-items-wrap {
        width: 100%;

        margin-top: 10px;
    }


    .invoice-items-table {
        width: 100%;

        margin: 0;

        border-collapse: collapse;

        table-layout: fixed;
    }


    .invoice-items-table thead th {
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


    .invoice-items-table tbody td {
        padding: 7px 5px;

        border-left: 1px solid #d0d0d0;

        border-right: 1px solid #d0d0d0;

        border-bottom: 1px solid #d0d0d0;

        color: #181818;

        font-size: 11.5px;

        line-height: 1.25;

        vertical-align: middle;
    }


    .invoice-items-table th:nth-child(1),
    .invoice-items-table td:nth-child(1) {
        width: 52%;
    }


    .invoice-items-table th:nth-child(2),
    .invoice-items-table td:nth-child(2) {
        width: 10%;
    }


    .invoice-items-table th:nth-child(3),
    .invoice-items-table td:nth-child(3) {
        width: 13%;
    }


    .invoice-items-table th:nth-child(4),
    .invoice-items-table td:nth-child(4) {
        width: 5%;
    }


    .invoice-items-table th:nth-child(5),
    .invoice-items-table td:nth-child(5) {
        width: 11%;
    }


    .invoice-items-table th:nth-child(6),
    .invoice-items-table td:nth-child(6) {
        width: 9%;
    }


    .invoice-item-name {
        text-align: left;

        overflow-wrap: anywhere;
    }


    .invoice-center {
        text-align: center;
    }


    .invoice-right {
        text-align: right;
    }


    /* =========================================================
       BOTTOM
       ========================================================= */

    .invoice-bottom-section {
        width: 100%;

        display: grid;

        grid-template-columns: 57% 43%;

        align-items: start;

        margin-top: 18px;
    }


    /* =========================================================
       THANK YOU
       ========================================================= */

    .invoice-thank-you {
        padding-top: 10px;

        text-align: center;
    }


    .invoice-thank-you h2 {
        margin: 0 0 28px 0;

        color: #343864;

        font-size: 28px;

        line-height: 1.2;

        font-weight: 700;
    }


    /*
     * BOTTOM LOGO — NORMAL SIZE
     */
    .invoice-thank-you img {
        width: 320px;

        max-width: 82%;

        height: auto;

        display: block;

        margin: 0 auto;
    }


    /* =========================================================
       SUMMARY
       ========================================================= */

    .invoice-summary-table {
        width: 100%;

        margin: 0;

        border-collapse: collapse;

        border: none !important;
    }


    .invoice-summary-table,
    .invoice-summary-table tbody,
    .invoice-summary-table tr,
    .invoice-summary-table th,
    .invoice-summary-table td {
        border: none !important;

        outline: none !important;

        box-shadow: none !important;
    }


    .invoice-summary-table th,
    .invoice-summary-table td {
        padding: 8px 7px;

        font-size: 12px;

        line-height: 1.15;
    }


    .invoice-summary-table th {
        width: 67%;

        text-align: left;

        font-weight: 700;
    }


    .invoice-summary-table td {
        width: 33%;

        text-align: right;

        font-weight: 500;
    }


    .invoice-summary-total th,
    .invoice-summary-total td {
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

    #invoice_pdf_workspace {
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
    .invoice-a4-page {
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


    .invoice-a4-body {
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
     * Continuation pages
     */
    .invoice-continuation-page .invoice-a4-body {
        padding-top: 18px;
    }


    /* =========================================================
       PAGE NUMBER
       ========================================================= */

    .invoice-a4-footer {
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

    .invoice-a4-page tr,
    .invoice-a4-page th,
    .invoice-a4-page td {
        page-break-inside: avoid !important;

        break-inside: avoid !important;
    }


    .invoice-a4-page .invoice-bottom-section,
    .invoice-a4-page .invoice-summary-table {
        page-break-inside: avoid !important;

        break-inside: avoid !important;
    }

</style>



<div class="se-pre-con"></div>



@foreach ($orders as $order)


<div id="invoice_print">


    <input
        type="hidden"
        id="invoice_id"
        value="{{ $order->id }}"
    >


    <input
        type="hidden"
        id="invoice_organization_name"
        value="{{ $order->organizationDetails['organization_name'] }}"
    >



    {{-- =====================================================
         TOP
         ===================================================== --}}

    <div id="invoice_top_section">


        <div class="invoice-header">


            <div>

                <img
                    src="{{ asset('argon') }}/img/encore/logo1.png"
                    class="invoice-header-logo"
                    alt="Encore Custom"
                >

            </div>



            <div class="invoice-heading">


                <h1>
                    INVOICE
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

        <div class="invoice-order-info">


            <div class="invoice-info-row">

                <div class="invoice-info-label">

                    Organization :

                </div>


                <div class="invoice-info-value">

                    {{ $order->organizationDetails['organization_name'] }}

                </div>

            </div>



            <div class="invoice-info-row">

                <div class="invoice-info-label">

                    Order # :

                </div>


                <div class="invoice-info-value">

                    {{ $order->order_no }}

                </div>

            </div>



            <div class="invoice-info-row">

                <div class="invoice-info-label">

                    Status :

                </div>


                <div class="invoice-info-value">

                    {{ $order->statusDetails['status_name'] }}

                </div>

            </div>



            <div class="invoice-info-row">

                <div class="invoice-info-label">

                    Sales Rep :

                </div>


                <div class="invoice-info-value">

                    {{ $order->userDetails['name'] }}

                </div>

            </div>


        </div>



        <div class="invoice-divider"></div>



        {{-- =================================================
             SHIPPING + BILLING
             ================================================= --}}

        <div class="invoice-address-grid">



            {{-- SHIPPING --}}

            <div class="invoice-address-box">


                <div class="invoice-address-title">

                    Shipping Address:

                </div>



                <div class="invoice-address-line">

                    {{ $order->contactDetails['first_name'] }}

                    {{ $order->contactDetails['last_name'] }}

                </div>



                @if ($order->is_new_shipping_address == 1)


                    @if (!empty($order->apartment))

                        <div class="invoice-address-line">

                            {{ $order->apartment }}

                        </div>

                    @endif


                    @if (!empty($order->street))

                        <div class="invoice-address-line">

                            {{ $order->street }}

                        </div>

                    @endif


                    @if (
                        !empty($order->city) ||
                        !empty($order->state) ||
                        !empty($order->postal_code)
                    )

                        <div class="invoice-address-line">

                            {{ $order->city }}

                            {{ $order->state }}

                            {{ $order->postal_code }}

                        </div>

                    @endif


                    @if (!empty($order->country))

                        <div class="invoice-address-line">

                            {{ $order->country }}

                        </div>

                    @endif



                @elseif ($order->is_new_shipping_address == 2)


                    @if (!empty($order->contactDetails['apartment']))

                        <div class="invoice-address-line">

                            {{ $order->contactDetails['apartment'] }}

                        </div>

                    @endif


                    @if (!empty($order->contactDetails['shipping_street']))

                        <div class="invoice-address-line">

                            {{ $order->contactDetails['shipping_street'] }}

                        </div>

                    @endif


                    @if (
                        !empty($order->contactDetails['shipping_city']) ||
                        !empty($order->contactDetails['shipping_state']) ||
                        !empty($order->contactDetails['shipping_zip'])
                    )

                        <div class="invoice-address-line">

                            {{ $order->contactDetails['shipping_city'] }}

                            {{ $order->contactDetails['shipping_state'] }}

                            {{ $order->contactDetails['shipping_zip'] }}

                        </div>

                    @endif


                    @if (!empty($order->contactDetails['shipping_country']))

                        <div class="invoice-address-line">

                            {{ $order->contactDetails['shipping_country'] }}

                        </div>

                    @endif



                @else


                    @if (!empty($order->contactDetails['apartment2']))

                        <div class="invoice-address-line">

                            {{ $order->contactDetails['apartment2'] }}

                        </div>

                    @endif


                    @if (!empty($order->contactDetails['shipping_street_2']))

                        <div class="invoice-address-line">

                            {{ $order->contactDetails['shipping_street_2'] }}

                        </div>

                    @endif


                    @if (
                        !empty($order->contactDetails['shipping_city_2']) ||
                        !empty($order->contactDetails['shipping_state_2']) ||
                        !empty($order->contactDetails['shipping_zip_2'])
                    )

                        <div class="invoice-address-line">

                            {{ $order->contactDetails['shipping_city_2'] }}

                            {{ $order->contactDetails['shipping_state_2'] }}

                            {{ $order->contactDetails['shipping_zip_2'] }}

                        </div>

                    @endif


                    @if (!empty($order->contactDetails['shipping_country_2']))

                        <div class="invoice-address-line">

                            {{ $order->contactDetails['shipping_country_2'] }}

                        </div>

                    @endif


                @endif



                @if (!empty($order->phone_no))

                    <div class="invoice-address-line">

                        {{ $order->phone_no }}

                    </div>

                @endif


                @if (!empty($order->email))

                    <div class="invoice-address-line">

                        {{ $order->email }}

                    </div>

                @endif


            </div>



            {{-- BILLING --}}

            <div class="invoice-address-box">


                <div class="invoice-address-title">

                    Billing Address:

                </div>



                @if (!empty($order->billingDetails))


                    <div class="invoice-address-line">

                        {{ $order->billingDetails['first_name'] }}

                        {{ $order->billingDetails['last_name'] }}

                    </div>


                    @if (!empty($order->billingDetails['apartment']))

                        <div class="invoice-address-line">

                            {{ $order->billingDetails['apartment'] }}

                        </div>

                    @endif


                    @if (!empty($order->billingDetails['street']))

                        <div class="invoice-address-line">

                            {{ $order->billingDetails['street'] }}

                        </div>

                    @endif


                    @if (
                        !empty($order->billingDetails['city']) ||
                        !empty($order->billingDetails['state']) ||
                        !empty($order->billingDetails['postal_code'])
                    )

                        <div class="invoice-address-line">

                            {{ $order->billingDetails['city'] }}

                            {{ $order->billingDetails['state'] }}

                            {{ $order->billingDetails['postal_code'] }}

                        </div>

                    @endif


                    @if (!empty($order->billingDetails['country']))

                        <div class="invoice-address-line">

                            {{ $order->billingDetails['country'] }}

                        </div>

                    @endif


                    @if (!empty($order->billingDetails['phone_no']))

                        <div class="invoice-address-line">

                            {{ $order->billingDetails['phone_no'] }}

                        </div>

                    @endif


                    @if (!empty($order->billingDetails['email']))

                        <div class="invoice-address-line">

                            {{ $order->billingDetails['email'] }}

                        </div>

                    @endif



                @else


                    <div class="invoice-address-line">

                        {{ $order->contactDetails['first_name'] }}

                        {{ $order->contactDetails['last_name'] }}

                    </div>


                    @if (!empty($order->apartment))

                        <div class="invoice-address-line">

                            {{ $order->apartment }}

                        </div>

                    @endif


                    @if (!empty($order->street))

                        <div class="invoice-address-line">

                            {{ $order->street }}

                        </div>

                    @endif


                    @if (
                        !empty($order->city) ||
                        !empty($order->state) ||
                        !empty($order->postal_code)
                    )

                        <div class="invoice-address-line">

                            {{ $order->city }}

                            {{ $order->state }}

                            {{ $order->postal_code }}

                        </div>

                    @endif


                    @if (!empty($order->country))

                        <div class="invoice-address-line">

                            {{ $order->country }}

                        </div>

                    @endif


                    @if (!empty($order->phone_no))

                        <div class="invoice-address-line">

                            {{ $order->phone_no }}

                        </div>

                    @endif


                    @if (!empty($order->email))

                        <div class="invoice-address-line">

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
        id="invoice_items_section"
        class="invoice-items-wrap"
    >


        <table
            id="invoice_items"
            class="invoice-items-table"
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


                    <th class="invoice-right">

                        UNIT PRICE($)

                    </th>


                    <th class="invoice-right">

                        TOTAL($)

                    </th>


                </tr>


            </thead>



            <tbody>


                @foreach ($order->orderItems as $orderItem)


                    <tr>


                        <td class="invoice-item-name">

                            {{
                                $orderItem->display_name
                                ??
                                $orderItem->productDetails['product_name']
                            }}

                        </td>


                        <td class="invoice-center">

                            {{ $orderItem->statusDetails['status_name'] }}

                        </td>


                        <td class="invoice-center">

                            {{ $orderItem->est_delivery_date }}

                        </td>


                        <td class="invoice-center">

                            {{ $orderItem->qty }}

                        </td>


                        <td class="invoice-right">

                            {{ number_format($orderItem->unit_price, 2) }}

                        </td>


                        <td class="invoice-right">

                            {{ number_format($orderItem->total, 2) }}

                        </td>


                    </tr>


                @endforeach


            </tbody>


        </table>


    </div>



    {{-- =====================================================
         BOTTOM / TOTALS
         ===================================================== --}}

    <div
        id="invoice_bottom_section"
        class="invoice-bottom-section"
    >


        @can('show order price')


            <div class="invoice-thank-you">


                <h2>

                    Thank you for your business!

                </h2>


                <img
                    src="{{ asset('argon') }}/img/encore/logo_dark.png"
                    alt="Encore Custom"
                >


            </div>



            <div>


                <table class="invoice-summary-table">


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
                            {{ $order->organizationDetails['sales_tax'] }}%
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

                            {{ number_format($processingFee, 2) }}

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



                    <tr class="invoice-summary-total">


                        <th>

                            ORDER TOTAL ($) :

                        </th>


                        <td>

                            {{
                                number_format(
                                    $order->order_total
                                    +
                                    $processingFee,
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
        id="invoice_redirect_link"
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
            'invoice-a4-page';


        if (
            continuation
        ) {


            page.classList.add(
                'invoice-continuation-page'
            );


        }


        var body =
            document.createElement(
                'div'
            );


        body.className =
            'invoice-a4-body';


        var inner =
            document.createElement(
                'div'
            );


        var footer =
            document.createElement(
                'div'
            );


        footer.className =
            'invoice-a4-footer';


        body.appendChild(
            inner
        );


        page.appendChild(
            body
        );


        page.appendChild(
            footer
        );


        page._invoiceBody =
            body;


        page._invoiceInner =
            inner;


        page._invoiceFooter =
            footer;


        return page;


    }



    /* =========================================================
       CREATE ITEMS SECTION
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
            'invoice-items-wrap';


        var table =
            sourceTable.cloneNode(
                false
            );


        table.removeAttribute(
            'id'
        );


        table.className =
            'invoice-items-table';


        /*
         * Repeat header on every continuation page.
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
         * FIRST PAGE HEADER
         */
        if (
            type === 'single' ||
            type === 'first'
        ) {


            page._invoiceInner.appendChild(

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


            page._invoiceInner.appendChild(

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


            page._invoiceInner.appendChild(

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
            page._invoiceBody.clientHeight
            -
            PDF_SAFETY_PX;


        var required =
            page._invoiceInner.scrollHeight;


        var fits =
            required <=
            available;


        page.remove();


        return fits;


    }



    /* =========================================================
       FIND MAXIMUM ROW END
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
       CHECK REMAINING ITEMS + TOTALS
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


        var finalPage =
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
            finalPage
        );


    }



    /* =========================================================
       BEST SPLIT FOR LAST TWO PAGES
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
         * Maximum products a normal middle page can hold.
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
         * Always leave at least one product while testing.
         */
        var maximumSplit =
            Math.min(

                maximumMiddleEnd,

                total - 1

            );


        /*
         * Start with fullest page 2.
         *
         * Move rows to final page only if necessary
         * for items + totals to fit.
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


            var finalFits =
                await pageFits(
                    workspace,
                    finalPage
                );


            if (
                finalFits
            ) {


                return {

                    middleEnd:
                        split,

                    finalStart:
                        split

                };


            }


        }


        /*
         * More than two continuation pages required.
         */
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

    async function generateInvoicePdf() {


        var workspace =
            null;


        try {


            var invoiceIdElement =
                document.getElementById(
                    'invoice_id'
                );


            var organizationElement =
                document.getElementById(
                    'invoice_organization_name'
                );


            var top =
                document.getElementById(
                    'invoice_top_section'
                );


            var table =
                document.getElementById(
                    'invoice_items'
                );


            var bottom =
                document.getElementById(
                    'invoice_bottom_section'
                );


            if (
                !invoiceIdElement ||
                !organizationElement ||
                !top ||
                !table ||
                !bottom
            ) {


                throw new Error(
                    'Invoice PDF source elements are missing.'
                );


            }


            var invoiceId =
                invoiceIdElement.value;


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
                    'Invoice item table is invalid.'
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
                    'invoice_pdf_workspace'
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
                'invoice_pdf_workspace';


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
             * Try complete invoice on one A4 page.
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
                 * Fill page 1 as much as possible.
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
                        'No invoice items fit on page 1.'
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


                /* =============================================
                   SMART CONTINUATION PAGINATION
                   ============================================= */

                while (
                    current <
                    total
                ) {


                    /*
                     * First:
                     *
                     * Can ALL remaining items + totals
                     * fit on this continuation page?
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
                     * If all remaining items + totals don't fit,
                     * calculate best last-two-page split.
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
                            'An invoice row is too tall for A4.'
                        );


                    }


                    /*
                     * Last two pages found.
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
                     * More middle pages needed.
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
                 * Defensive fallback:
                 *
                 * if items ended exactly on a middle page
                 * but totals haven't been added.
                 */
                if (
                    current ===
                    total
                ) {


                    var lastChunk =
                        chunks[
                            chunks.length - 1
                        ];


                    if (
                        lastChunk &&
                        lastChunk.type !==
                        'final'
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
                'Invoice PDF pages:',
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
               RENDER EACH HTML A4 PAGE
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


                page._invoiceFooter.textContent =

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
                    canvas.width <
                    100 ||
                    canvas.height <
                    100
                ) {


                    throw new Error(
                        'Invoice PDF canvas is empty.'
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
                '_Invoice_'
                +
                invoiceId
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
                        'invoice_redirect_link'
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

                'Invoice PDF generation failed:',

                error

            );


            if (
                workspace
            ) {


                workspace.remove();


            }


            $('.se-pre-con').hide();


            alert(
                'Unable to generate Invoice PDF. Check console.'
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


                    generateInvoicePdf();


                },
                800
            );


        }
    );


})();

</script>

@endsection
