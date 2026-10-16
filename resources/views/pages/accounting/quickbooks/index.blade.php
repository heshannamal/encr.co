<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>QuickBooks - Sales Receipt</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css"
        rel="stylesheet"
    >

    <style>
        :root {
            --qb-green: #2ca01c;
            --qb-green-dark: #1f7a14;
            --qb-blue: #0077c5;
            --qb-text: #2d333a;
            --qb-muted: #6b7280;
            --qb-border: #d7dce1;
            --qb-soft: #f4f5f7;
            --qb-page: #f6f7f8;
            --qb-warning: #fff8e1;
            --qb-warning-border: #f6cf65;
            --qb-danger: #c62828;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--qb-page);
            color: var(--qb-text);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
            font-size: 13px;
        }

        .qb-loading {
            position: fixed;
            inset: 0;
            z-index: 99999;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, .74);
            backdrop-filter: blur(2px);
        }

        .qb-loading-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 20px;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 12px 30px rgba(0, 0, 0, .12);
            font-weight: 600;
        }

        .qb-topbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            min-height: 58px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 10px 22px;
            background: #fff;
            border-bottom: 1px solid var(--qb-border);
            box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
        }

        .qb-topbar-left,
        .qb-topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .qb-brand {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 700;
        }

        .qb-brand-mark {
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: #fff;
            background: var(--qb-green);
            font-weight: 800;
        }

        .qb-btn {
            min-height: 34px;
            border-radius: 4px;
            padding: 6px 14px;
            font-size: 13px;
            font-weight: 600;
        }

        .qb-btn-primary {
            border: 1px solid var(--qb-green);
            color: #fff;
            background: var(--qb-green);
        }

        .qb-btn-primary:hover {
            border-color: var(--qb-green-dark);
            background: var(--qb-green-dark);
            color: #fff;
        }

        .qb-btn-outline {
            border: 1px solid #8d949a;
            background: #fff;
            color: #374151;
        }

        .qb-btn-outline:hover {
            background: #f3f4f6;
        }

        .qb-btn-blue {
            border: 1px solid var(--qb-blue);
            color: #fff;
            background: var(--qb-blue);
        }

        .qb-shell {
            width: min(1500px, calc(100% - 28px));
            margin: 18px auto 42px;
        }

        .qb-notice {
            margin-bottom: 14px;
            padding: 10px 14px;
            border: 1px solid #f0c36d;
            border-radius: 5px;
            background: #fff8dc;
            color: #6b4f00;
        }

        .qb-receipt {
            margin-bottom: 24px;
            border: 1px solid #cfd4da;
            border-radius: 3px;
            background: #fff;
            box-shadow: 0 2px 7px rgba(0, 0, 0, .06);
            overflow: hidden;
        }

        .qb-receipt.is-refund {
            border-top: 4px solid var(--qb-blue);
        }

        .qb-receipt:not(.is-refund) {
            border-top: 4px solid var(--qb-green);
        }

        .qb-receipt-header {
            display: flex;
            justify-content: space-between;
            gap: 24px;
            padding: 22px 26px 18px;
        }

        .qb-title-wrap {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .qb-doc-icon {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--qb-border);
            border-radius: 4px;
            background: #fff;
            color: #4b5563;
            font-size: 18px;
        }

        .qb-document-title {
            margin: 0;
            font-size: 22px;
            font-weight: 500;
            line-height: 1.15;
        }

        .qb-document-subtitle {
            margin-top: 5px;
            color: var(--qb-muted);
            font-size: 12px;
        }

        .qb-status-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 8px;
            padding: 3px 8px;
            border-radius: 999px;
            background: #edf7eb;
            color: #237a19;
            font-size: 11px;
            font-weight: 700;
        }

        .qb-total-head {
            min-width: 180px;
            text-align: right;
        }

        .qb-total-head .label {
            color: var(--qb-muted);
            font-size: 10px;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .qb-total-head .amount {
            margin-top: 2px;
            font-size: 29px;
            font-weight: 700;
            line-height: 1.05;
        }

        .qb-total-head .linked {
            margin-top: 5px;
            color: var(--qb-green-dark);
            font-size: 11px;
        }

        .qb-receipt-body {
            padding: 0 26px 26px;
        }

        .qb-section {
            padding: 16px 0;
            border-top: 1px solid #e7eaed;
        }

        .qb-section:first-child {
            border-top: 0;
        }

        .qb-label {
            display: block;
            margin-bottom: 5px;
            color: #5e6670;
            font-size: 11px;
            font-weight: 600;
        }

        .qb-input,
        .qb-select,
        .qb-textarea {
            width: 100%;
            border: 1px solid #aeb5bb;
            border-radius: 3px;
            background: #fff;
            color: #252a2e;
            font-size: 13px;
            outline: 0;
            transition: border-color .15s, box-shadow .15s;
        }

        .qb-input,
        .qb-select {
            height: 34px;
            padding: 5px 9px;
        }

        .qb-textarea {
            min-height: 96px;
            resize: vertical;
            padding: 8px 9px;
            line-height: 1.45;
        }

        .qb-input:focus,
        .qb-select:focus,
        .qb-textarea:focus {
            border-color: var(--qb-blue);
            box-shadow: 0 0 0 1px var(--qb-blue);
        }

        .ts-wrapper.single .ts-control {
            min-height: 34px;
            border: 1px solid #aeb5bb;
            border-radius: 3px;
            padding: 5px 9px;
            box-shadow: none;
            font-size: 13px;
        }

        .ts-wrapper.focus .ts-control {
            border-color: var(--qb-blue);
            box-shadow: 0 0 0 1px var(--qb-blue);
        }

        .qb-field-note {
            margin-top: 4px;
            color: var(--qb-muted);
            font-size: 11px;
        }

        .qb-divider-title {
            margin-bottom: 9px;
            color: #4b5563;
            font-size: 12px;
            font-weight: 700;
        }

        .qb-grid-table-wrap {
            overflow-x: auto;
            border: 1px solid #cfd4da;
        }

        .qb-grid {
            width: 100%;
            min-width: 1080px;
            margin: 0;
            border-collapse: collapse;
        }

        .qb-grid thead th {
            height: 34px;
            padding: 6px 7px;
            border-right: 1px solid #d9dde1;
            border-bottom: 1px solid #cfd4da;
            background: #f4f5f6;
            color: #59616a;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .qb-grid tbody td {
            height: 39px;
            padding: 3px 5px;
            border-right: 1px solid #eceff1;
            border-bottom: 1px solid #e4e7e9;
            vertical-align: middle;
            background: #fff;
        }

        .qb-grid tbody tr:hover td {
            background: #fafbfc;
        }

        .qb-grid .line-index {
            width: 44px;
            text-align: center;
            color: var(--qb-muted);
        }

        .qb-grid-input,
        .qb-grid-select {
            width: 100%;
            min-height: 30px;
            border: 1px solid transparent;
            border-radius: 2px;
            background: transparent;
            padding: 4px 6px;
            font-size: 12px;
        }

        .qb-grid-input:focus,
        .qb-grid-select:focus {
            border-color: var(--qb-blue);
            outline: 0;
            background: #fff;
        }

        .qb-grid .text-money {
            text-align: right;
        }

        .qb-grid .text-center {
            text-align: center;
        }

        .qb-add-line {
            margin-top: 9px;
            border: 0;
            background: transparent;
            color: var(--qb-blue);
            font-size: 12px;
            font-weight: 700;
        }

        .qb-add-line:hover {
            text-decoration: underline;
        }

        .qb-delete-line {
            color: #b42318;
            cursor: pointer;
            font-size: 15px;
        }

        .qb-lower {
            display: grid;
            grid-template-columns: minmax(320px, 1fr) 360px;
            gap: 36px;
            margin-top: 18px;
        }

        .qb-notes-box {
            border-top: 1px solid #e7eaed;
            padding-top: 13px;
        }

        .qb-summary {
            margin-left: auto;
            width: 100%;
        }

        .qb-summary-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 6px 0;
            font-size: 13px;
        }

        .qb-summary-row .name {
            color: #59616a;
        }

        .qb-summary-row.discount {
            align-items: center;
        }

        .qb-summary-row.discount .value {
            color: var(--qb-danger);
        }

        .qb-discount-editor {
            display: grid;
            grid-template-columns: 135px 100px 88px;
            align-items: center;
            gap: 6px;
        }

        .qb-discount-editor select,
        .qb-discount-editor input {
            height: 30px;
            border: 1px solid #aeb5bb;
            border-radius: 3px;
            background: #fff;
            padding: 4px 7px;
            font-size: 12px;
        }

        .qb-discount-editor input {
            text-align: right;
        }

        .qb-discount-result {
            min-width: 88px;
            text-align: right;
            color: var(--qb-danger);
            font-weight: 600;
        }

        .qb-tax-editor {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
        }

        .qb-tax-editor input {
            width: 100px;
            height: 30px;
            border: 1px solid #aeb5bb;
            border-radius: 3px;
            background: #fff;
            padding: 4px 7px;
            text-align: right;
            font-size: 12px;
        }

        .qb-tax-rate-note {
            min-width: 74px;
            color: var(--qb-muted);
            font-size: 11px;
            text-align: right;
        }

        .qb-summary-row.total {
            margin-top: 6px;
            padding-top: 11px;
            border-top: 1px solid #aeb5bb;
            font-size: 16px;
            font-weight: 700;
        }

        .qb-discount-banner {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin-top: 12px;
            padding: 8px 10px;
            border: 1px solid var(--qb-warning-border);
            border-radius: 4px;
            background: var(--qb-warning);
            color: #624b00;
        }

        .qb-discount-banner strong {
            color: var(--qb-danger);
        }

        .qb-actions {
            position: sticky;
            bottom: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin: 24px -26px -26px;
            padding: 12px 26px;
            border-top: 1px solid var(--qb-border);
            background: rgba(255, 255, 255, .97);
            backdrop-filter: blur(5px);
        }

        .qb-actions-left,
        .qb-actions-right {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .qb-small-status {
            color: var(--qb-muted);
            font-size: 11px;
        }

        .qb-required {
            color: #b42318;
        }

        @media (max-width: 991px) {
            .qb-shell {
                width: calc(100% - 16px);
                margin-top: 8px;
            }

            .qb-topbar {
                padding: 8px 10px;
            }

            .qb-brand {
                display: none;
            }

            .qb-receipt-header {
                padding: 16px;
            }

            .qb-receipt-body {
                padding: 0 16px 18px;
            }

            .qb-lower {
                grid-template-columns: 1fr;
                gap: 14px;
            }

            .qb-summary {
                max-width: none;
            }

            .qb-actions {
                margin: 18px -16px -18px;
                padding: 10px 16px;
            }
        }

        @media (max-width: 640px) {
            .qb-topbar-right .save-all-records {
                display: none;
            }

            .qb-receipt-header {
                flex-direction: column;
            }

            .qb-total-head {
                text-align: left;
            }

            .qb-actions {
                align-items: stretch;
                flex-direction: column;
            }

            .qb-actions-left,
            .qb-actions-right {
                width: 100%;
            }

            .qb-actions-right .qb-btn {
                flex: 1;
            }
        }
    </style>
</head>

<body>

<div class="qb-loading" id="qbLoader">
    <div class="qb-loading-card">
        <div class="spinner-border spinner-border-sm text-success" role="status"></div>
        <span>Working with QuickBooks...</span>
    </div>
</div>

<div class="qb-topbar">
    <div class="qb-topbar-left">
        <button
            type="button"
            class="qb-btn qb-btn-outline"
            onclick="window.location.href='{{ route('allTransactions') }}'"
        >
            <i class="bi bi-arrow-left"></i>
            Back
        </button>

        <div class="qb-brand">
            <span class="qb-brand-mark">qb</span>
            <span>QuickBooks Sales Receipts</span>
        </div>
    </div>

    <div class="qb-topbar-right">
        <button
            type="button"
            class="qb-btn qb-btn-outline save-all-records"
        >
            Save all
        </button>

        <button
            type="button"
            class="qb-btn qb-btn-primary export-all-records"
        >
            Export all to QuickBooks
        </button>
    </div>
</div>

<div class="qb-shell">

    @if(($alreadySyncedCount ?? 0) > 0)
        <div class="qb-notice">
            <i class="bi bi-info-circle me-1"></i>
            {{ $alreadySyncedCount }} selected payment record(s) were already synced and were not loaded again.
        </div>
    @endif

    @forelse($salesReceiptDataList as $key => $salesReceiptData)

        @php
            $isRefund = (int) ($salesReceiptData['is_refund'] ?? 0) === 1;

            $formKey = implode('_', [
                $salesReceiptData['order_id'] ?? 0,
                $salesReceiptData['record_id'] ?? 0,
                preg_replace(
                    '/[^A-Za-z0-9_-]/',
                    '_',
                    (string) ($salesReceiptData['payment_type'] ?? 'payment')
                ),
                $salesReceiptData['from_tsr_module'] ?? 0,
                $salesReceiptData['is_refund'] ?? 0,
            ]);

            $docNumber = (string) (
                ($isRefund ? $refund_receipt_no : $receipt_no) + $key
            );

            $discountAmount = round(
                (float) ($salesReceiptData['discount_amount'] ?? 0),
                2
            );

            $discountType =
                ($salesReceiptData['discount_type'] ?? 'amount') === 'percent'
                    ? 'percent'
                    : 'amount';

            $discountValue = $discountType === 'percent'
                ? (float) (
                    $salesReceiptData['discount_value']
                    ?? $salesReceiptData['discount_percent']
                    ?? 0
                )
                : (float) (
                    $salesReceiptData['discount_value']
                    ?? $discountAmount
                );

            $discountLabel =
                $salesReceiptData['discount_label']
                ?? (
                    $discountType === 'percent'
                        ? 'Order Discount (' . rtrim(
                            rtrim(
                                number_format($discountValue, 4),
                                '0'
                            ),
                            '.'
                        ) . '%)'
                        : 'Order Discount'
                );

            $lineSubtotal = 0.00;

            foreach (($salesReceiptData['line_items'] ?? []) as $lineItem) {
                $lineSubtotal += (float) ($lineItem['amount'] ?? 0);
            }

            $expectedTotal = round(
                (float) ($salesReceiptData['amount'] ?? 0),
                2
            );

            $sourceTaxAmount = array_key_exists(
                'tax_amount',
                $salesReceiptData
            )
                ? round(
                    (float) $salesReceiptData['tax_amount'],
                    2
                )
                : round(
                    $expectedTotal
                    - ($lineSubtotal - $discountAmount),
                    2
                );

            if (abs($sourceTaxAmount) < 0.005) {
                $sourceTaxAmount = 0.00;
            }
        @endphp

        <div
            class="qb-receipt {{ $isRefund ? 'is-refund' : '' }}"
            data-receipt-card="{{ $formKey }}"
        >

            <form
                id="quickbook_data_form_{{ $formKey }}"
                class="qb-receipt-form"
                data-form-key="{{ $formKey }}"
                data-expected-total="{{ number_format($expectedTotal, 2, '.', '') }}"
            >
                @csrf

                <input
                    type="hidden"
                    name="order_id"
                    value="{{ $salesReceiptData['order_id'] }}"
                >

                <input
                    type="hidden"
                    name="amount"
                    value="{{ number_format($expectedTotal, 2, '.', '') }}"
                >

                <input
                    type="hidden"
                    name="record_id"
                    value="{{ $salesReceiptData['record_id'] }}"
                >

                <input
                    type="hidden"
                    name="payment_type"
                    value="{{ $salesReceiptData['payment_type'] }}"
                >

                <input
                    type="hidden"
                    name="transaction_created_at"
                    value="{{ $salesReceiptData['transaction_created_at'] }}"
                >

                <input
                    type="hidden"
                    name="from_tsr_module"
                    value="{{ $salesReceiptData['from_tsr_module'] }}"
                >

                <input
                    type="hidden"
                    name="is_refund"
                    value="{{ $salesReceiptData['is_refund'] ?? 0 }}"
                >

                <input
                    type="hidden"
                    name="doc_number"
                    value="{{ $docNumber }}"
                >

                {{-- Native QuickBooks discount fields. Discount is not an items[] row. --}}
                <input
                    type="hidden"
                    name="discount_amount"
                    value="{{ number_format($discountAmount, 2, '.', '') }}"
                >

                <input
                    type="hidden"
                    name="discount_percent"
                    value="{{ $discountType === 'percent' ? $discountValue : '' }}"
                >



                <input
                    type="hidden"
                    name="discount_label"
                    value="{{ $discountLabel }}"
                >

                <input
                    type="hidden"
                    name="discount_taxable"
                    value="{{ !empty($salesReceiptData['discount_taxable']) ? 1 : 0 }}"
                >

                <input
                    type="hidden"
                    name="discount_class"
                    value="{{ $salesReceiptData['discount_class'] ?? 'Encore Clothing:Team Sales' }}"
                >

                <div class="qb-receipt-header">
                    <div class="qb-title-wrap">
                        <div class="qb-doc-icon">
                            <i class="bi bi-receipt"></i>
                        </div>

                        <div>
                            <h1 class="qb-document-title">
                                {{ $isRefund ? 'Refund receipt' : 'Sales receipt' }}
                            </h1>

                            <div class="qb-document-subtitle">
                                Order {{ $salesReceiptData['reference_no'] ?? $salesReceiptData['order_id'] }}
                                &nbsp;•&nbsp;
                                {{ $salesReceiptData['payment_type'] ?? 'Payment' }}
                                payment #{{ $salesReceiptData['record_id'] }}
                            </div>

                            <div class="qb-status-chip receipt-status-chip">
                                <i class="bi bi-circle-fill" style="font-size:6px;"></i>
                                Ready
                            </div>
                        </div>
                    </div>

                    <div class="qb-total-head">
                        <div class="label">Amount</div>

                        <div class="amount">
                            ${{ number_format($expectedTotal, 2) }}
                        </div>

                        <div class="linked">
                            {{ $isRefund ? '1 linked refund' : '1 linked deposit' }}
                        </div>
                    </div>
                </div>

                <div class="qb-receipt-body">

                    <div class="qb-section">
                        <div class="row g-3 align-items-end">

                            <div class="col-lg-4 col-md-6">
                                <label class="qb-label">
                                    Customer <span class="qb-required">*</span>
                                </label>

                                <select
                                    name="customer_id"
                                    class="qb-select qb-tom-select"
                                    data-required-label="Customer"
                                    required
                                >
                                    <option value="">Select customer</option>

                                    @foreach($customers as $customer)
                                        <option
                                            value="{{ $customer->id }}"
                                            {{ (string) ($salesReceiptData['customer_id'] ?? '') === (string) $customer->id ? 'selected' : '' }}
                                        >
                                            {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label class="qb-label">Customer email</label>

                                <input
                                    type="email"
                                    name="email"
                                    class="qb-input"
                                    value="{{ $salesReceiptData['email'] ?? '' }}"
                                >
                            </div>

                            <div class="col-lg-4">
                                <div class="form-check pb-2">
                                    <input
                                        class="form-check-input"
                                        name="send_later"
                                        type="checkbox"
                                        id="send_later_{{ $formKey }}"
                                        {{ !empty($salesReceiptData['send_later']) ? 'checked' : '' }}
                                    >

                                    <label
                                        class="form-check-label"
                                        for="send_later_{{ $formKey }}"
                                    >
                                        Send later
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="qb-field-note">
                            {{ $isRefund ? 'Refund' : 'Payment' }}
                            amount of ${{ number_format($expectedTotal, 2) }}
                            recorded on
                            {{ date('m/d/Y', strtotime($salesReceiptData['transaction_created_at'])) }}.
                        </div>
                    </div>

                    <div class="qb-section">
                        <div class="row g-3">

                            <div class="col-lg-4">
                                <label class="qb-label">Billing address</label>

                                <textarea
                                    class="qb-textarea"
                                    name="billing_address"
                                >{{ $salesReceiptData['billing_address'] ?? '' }}</textarea>

                                <label class="qb-label mt-3">Shipping to</label>

                                <textarea
                                    class="qb-textarea"
                                    name="shipping_address"
                                >{{ $salesReceiptData['shipping_address'] ?? '' }}</textarea>
                            </div>

                            <div class="col-lg-8">
                                <div class="row g-3">

                                    <div class="col-lg-4 col-md-6">
                                        <label class="qb-label">
                                            {{ $isRefund ? 'Refund receipt date' : 'Sales receipt date' }}
                                        </label>

                                        <input
                                            type="date"
                                            name="receipt_date"
                                            class="qb-input"
                                            value="{{ $salesReceiptData['receipt_date'] ?? '' }}"
                                        >
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <label class="qb-label">
                                            {{ $isRefund ? 'Refund receipt no.' : 'Sales receipt no.' }}
                                        </label>

                                        <input
                                            type="text"
                                            class="qb-input"
                                            value="{{ $docNumber }}"
                                            readonly
                                        >
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <label class="qb-label">Payment method</label>

                                        <select
                                            name="payment_method_id"
                                            class="qb-select qb-tom-select"
                                        >
                                            <option value="">Select payment method</option>

                                            @foreach($paymentMethods as $method)
                                                <option
                                                    value="{{ $method->id }}"
                                                    {{ (string) ($salesReceiptData['payment_method_id'] ?? '') === (string) $method->id ? 'selected' : '' }}
                                                >
                                                    {{ $method->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <label class="qb-label">Reference no.</label>

                                        <input
                                            type="text"
                                            name="reference_no"
                                            class="qb-input"
                                            value="{{ $salesReceiptData['reference_no'] ?? '' }}"
                                        >
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <label class="qb-label">
                                            {{ $isRefund ? 'Refund from' : 'Deposit to' }}
                                            <span class="qb-required">*</span>
                                        </label>

                                        @if($isRefund)
                                            <select
                                                name="refund_from_account_id"
                                                class="qb-select qb-tom-select"
                                                data-required-label="Refund from account"
                                            >
                                                <option value="">Select account</option>

                                                @foreach($refundFromAccounts as $account)
                                                    <option
                                                        value="{{ $account->id }}"
                                                        {{ (string) ($salesReceiptData['refund_from_account_id'] ?? $salesReceiptData['deposit_account_id'] ?? '') === (string) $account->id ? 'selected' : '' }}
                                                    >
                                                        {{ $account->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <select
                                                name="deposit_account_id"
                                                class="qb-select qb-tom-select"
                                                data-required-label="Deposit account"
                                            >
                                                <option value="">Select account</option>

                                                @foreach($depositAccounts as $account)
                                                    <option
                                                        value="{{ $account->id }}"
                                                        {{ (string) ($salesReceiptData['deposit_account_id'] ?? '') === (string) $account->id ? 'selected' : '' }}
                                                    >
                                                        {{ $account->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <label class="qb-label">PO number</label>

                                        <input
                                            type="text"
                                            name="po_number"
                                            class="qb-input"
                                            value="{{ $salesReceiptData['po_number'] ?? '' }}"
                                        >
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <label class="qb-label">Ship via</label>

                                        <input
                                            type="text"
                                            name="ship_via"
                                            class="qb-input"
                                            value="{{ $salesReceiptData['ship_via'] ?? '' }}"
                                        >
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <label class="qb-label">Shipping date</label>

                                        <input
                                            type="date"
                                            name="shipping_date"
                                            class="qb-input"
                                            value="{{ $salesReceiptData['shipping_date'] ?? '' }}"
                                        >
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <label class="qb-label">Tracking no.</label>

                                        <input
                                            type="text"
                                            name="tracking_no"
                                            class="qb-input"
                                            value="{{ $salesReceiptData['tracking_no'] ?? '' }}"
                                        >
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <label class="qb-label">Sales rep</label>

                                        <input
                                            type="text"
                                            name="sales_rep"
                                            class="qb-input"
                                            value="{{ $salesReceiptData['sales_rep'] ?? '' }}"
                                        >
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <label class="qb-label">Class / location</label>

                                        <select
                                            name="location"
                                            class="qb-select qb-tom-select"
                                        >
                                            <option value="">Select class / location</option>

                                            @foreach($locations as $location)
                                                <option
                                                    value="{{ $location->id }}"
                                                    {{ (string) ($salesReceiptData['location'] ?? '') === (string) $location->id ? 'selected' : '' }}
                                                >
                                                    {{ $location->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <label class="qb-label">Shipping from</label>

                                        <input
                                            type="text"
                                            name="shipping_from"
                                            class="qb-input"
                                            value="{{ $salesReceiptData['shipping_from'] ?? '891 4th St, San Rafael, CA 94901-3242' }}"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="qb-section">
                        <div class="qb-divider-title">
                            Product / service details
                        </div>

                        <div class="qb-grid-table-wrap">
                            <table class="qb-grid">
                                <thead>
                                    <tr>
                                        <th style="width:44px;">#</th>
                                        <th style="width:190px;">Product / service</th>
                                        <th style="width:120px;">SKU</th>
                                        <th>Description</th>
                                        <th style="width:80px;" class="text-center">Qty</th>
                                        <th style="width:105px;" class="text-end">Rate</th>
                                        <th style="width:110px;" class="text-end">Amount</th>
                                        <th style="width:60px;" class="text-center">Tax</th>
                                        <th style="width:190px;">Class</th>
                                        <th style="width:48px;"></th>
                                    </tr>
                                </thead>

                                <tbody class="qb-tbody">
                                    @foreach(($salesReceiptData['line_items'] ?? []) as $index => $item)
                                        <tr>
                                            <td class="line-index">
                                                {{ $index + 1 }}
                                            </td>

                                            <td>
                                                <select
                                                    name="items[{{ $index }}][product]"
                                                    class="qb-grid-select product-select"
                                                >
                                                    <option value="">Select product</option>

                                                    @foreach($lines as $line)
                                                        <option
                                                            value="{{ $line['Name'] }}"
                                                            {{ (string) ($item['product'] ?? '') === (string) $line['Name'] ? 'selected' : '' }}
                                                        >
                                                            {{ $line['Name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>

                                            <td>
                                                <input
                                                    type="text"
                                                    name="items[{{ $index }}][sku]"
                                                    class="qb-grid-input"
                                                    value="{{ $item['sku'] ?? '' }}"
                                                >
                                            </td>

                                            <td>
                                                <input
                                                    type="text"
                                                    name="items[{{ $index }}][description]"
                                                    class="qb-grid-input"
                                                    value="{{ $item['description'] ?? '' }}"
                                                >
                                            </td>

                                            <td>
                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    min="0"
                                                    name="items[{{ $index }}][qty]"
                                                    class="qb-grid-input text-center line-qty"
                                                    value="{{ $item['qty'] ?? 1 }}"
                                                >
                                            </td>

                                            <td>
                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    name="items[{{ $index }}][rate]"
                                                    class="qb-grid-input text-money line-rate"
                                                    value="{{ number_format((float) ($item['rate'] ?? 0), 2, '.', '') }}"
                                                >
                                            </td>

                                            <td>
                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    name="items[{{ $index }}][amount]"
                                                    class="qb-grid-input text-money line-amount"
                                                    value="{{ number_format((float) ($item['amount'] ?? 0), 2, '.', '') }}"
                                                >
                                            </td>

                                            <td class="text-center">
                                                <input
                                                    type="checkbox"
                                                    name="items[{{ $index }}][tax]"
                                                    class="form-check-input"
                                                    {{ !empty($item['tax']) ? 'checked' : '' }}
                                                >
                                            </td>

                                            <td>
                                                <input
                                                    type="text"
                                                    name="items[{{ $index }}][class]"
                                                    class="qb-grid-input"
                                                    value="{{ $item['class'] ?? '' }}"
                                                >
                                            </td>

                                            <td class="text-center">
                                                <i
                                                    class="bi bi-trash qb-delete-line"
                                                    title="Delete line"
                                                ></i>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <button
                            type="button"
                            class="qb-add-line add-qb-row"
                        >
                            <i class="bi bi-plus-circle me-1"></i>
                            Add lines
                        </button>

                        <div class="qb-lower">
                            <div class="qb-notes-box">
                                <label class="qb-label">Memo / private note</label>

                                <div class="qb-field-note">
                                    Order ID {{ $salesReceiptData['order_id'] }},
                                    payment record {{ $salesReceiptData['record_id'] }},
                                    {{ $salesReceiptData['payment_type'] }}.
                                    This information is included in the QuickBooks private note automatically.
                                </div>
                            </div>

                            <div class="qb-summary">
                                <div class="qb-summary-row">
                                    <span class="name">Subtotal</span>
                                    <span class="value js-subtotal">
                                        ${{ number_format($lineSubtotal, 2) }}
                                    </span>
                                </div>

                                @if(!$isRefund)
                                    <div class="qb-summary-row discount">
                                        <span class="name js-discount-label">
                                            Discount
                                        </span>

                                        <div class="qb-discount-editor">
                                            <select
                                                name="discount_type"
                                                class="discount-type-select"
                                                title="Choose percentage or fixed discount"
                                            >
                                                <option
                                                    value="percent"
                                                    {{ $discountType === 'percent' ? 'selected' : '' }}
                                                >
                                                    Discount percent
                                                </option>

                                                <option
                                                    value="amount"
                                                    {{ $discountType === 'amount' ? 'selected' : '' }}
                                                >
                                                    Discount value
                                                </option>
                                            </select>

                                            <input
                                                type="number"
                                                min="0"
                                                step="0.01"
                                                name="discount_value"
                                                class="discount-value-input"
                                                value="{{ rtrim(rtrim(number_format($discountValue, 4, '.', ''), '0'), '.') ?: '0' }}"
                                            >

                                            <span class="qb-discount-result js-discount">
                                                -${{ number_format($discountAmount, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                <div class="qb-summary-row">
                                    <span class="name">
                                        Sales tax
                                    </span>

                                    <div class="qb-tax-editor">
                                        <input
                                            type="number"
                                            min="0"
                                            step="0.01"
                                            name="tax_amount"
                                            class="tax-amount-input"
                                            value="{{ number_format($sourceTaxAmount, 2, '.', '') }}"
                                            title="Sales tax amount from the source payment"
                                        >

                                        <span class="qb-tax-rate-note js-tax-rate-note">
                                            Source tax
                                        </span>
                                    </div>
                                </div>

                                <div class="qb-summary-row total">
                                    <span class="name">Total</span>
                                    <span class="value js-total">
                                        ${{ number_format($expectedTotal, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="qb-actions">
                        <div class="qb-actions-left">
                            <span class="qb-small-status js-save-status">
                                Not saved in Encore Cloud yet
                            </span>
                        </div>

                        <div class="qb-actions-right">
                            <button
                                type="button"
                                class="qb-btn qb-btn-outline save-quickbook-data"
                                data-form-key="{{ $formKey }}"
                            >
                                Save
                            </button>

                            <button
                                type="button"
                                class="qb-btn qb-btn-primary export-to-quickbooks"
                                data-form-key="{{ $formKey }}"
                                {{ (int) ($salesReceiptData['export_status'] ?? 0) === 1 ? 'disabled' : '' }}
                            >
                                Export to QuickBooks
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    @empty
        <div class="qb-notice">
            No unsynced payment records are available to display.
        </div>
    @endforelse
</div>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
(function () {
    'use strict';

    const loader = document.getElementById('qbLoader');

    const qbItems = @json($lines);

    function showLoader() {
        if (loader) {
            loader.style.display = 'flex';
        }
    }

    function hideLoader() {
        if (loader) {
            loader.style.display = 'none';
        }
    }

    function money(value) {
        const number = Number(value || 0);

        return '$' + number.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function parseNumber(value) {
        const number = parseFloat(value);

        return Number.isFinite(number)
            ? number
            : 0;
    }

    function escapeHtml(value) {
        return String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function initTomSelect(root) {
        (root || document)
            .querySelectorAll('.qb-tom-select')
            .forEach(function (element) {
                if (!element.tomselect) {
                    new TomSelect(element, {
                        maxOptions: 500,
                        create: false,
                        allowEmptyOption: true
                    });
                }
            });
    }

    function updateRowNumbers(form) {
        form.querySelectorAll('.qb-tbody tr')
            .forEach(function (row, index) {
                const indexCell = row.querySelector('.line-index');

                if (indexCell) {
                    indexCell.textContent = index + 1;
                }

                row.querySelectorAll('[name^="items["]')
                    .forEach(function (element) {
                        element.name = element.name.replace(
                            /items\[\d+\]/,
                            'items[' + index + ']'
                        );
                    });
            });
    }

    function discountableSubtotal(form) {
        const excludedProducts = new Set([
            'shipping',
            'credit card processing fee',
            'paypal fee',
            'authorize.net fee'
        ]);

        let subtotal = 0;

        form.querySelectorAll('.qb-tbody tr')
            .forEach(function (row) {
                const product = String(
                    row.querySelector('[name*="[product]"]')?.value || ''
                ).trim().toLowerCase();

                if (excludedProducts.has(product)) {
                    return;
                }

                subtotal += parseNumber(
                    row.querySelector('.line-amount')?.value
                );
            });

        return subtotal;
    }

    function syncDiscountFields(form) {
        const typeElement =
            form.querySelector('[name="discount_type"]');

        const valueElement =
            form.querySelector('[name="discount_value"]');

        const amountElement =
            form.querySelector('[name="discount_amount"]');

        const percentElement =
            form.querySelector('[name="discount_percent"]');

        const labelElement =
            form.querySelector('[name="discount_label"]');

        if (!typeElement || !valueElement || !amountElement) {
            return 0;
        }

        const type =
            typeElement.value === 'percent'
                ? 'percent'
                : 'amount';

        let value = Math.max(
            0,
            parseNumber(valueElement.value)
        );

        const base = Math.max(
            0,
            discountableSubtotal(form)
        );

        let amount = 0;
        let label = 'Order Discount';

        if (type === 'percent') {
            amount = base * value / 100;

            if (percentElement) {
                percentElement.value = value;
            }

            label =
                'Order Discount ('
                + Number(value.toFixed(4)).toString()
                + '%)';
        } else {
            amount = value;

            if (percentElement) {
                percentElement.value = '';
            }
        }

        amount = Math.max(
            0,
            Math.round((amount + Number.EPSILON) * 100) / 100
        );

        amountElement.value = amount.toFixed(2);

        if (labelElement) {
            labelElement.value = label;
        }

        const labelText =
            form.querySelector('.js-discount-label');

        if (labelText) {
            labelText.textContent =
                type === 'percent'
                    ? 'Discount (' + Number(value.toFixed(4)).toString() + '%)'
                    : 'Discount';
        }

        return amount;
    }

    function refreshTotals(form) {
        let subtotal = 0;

        form.querySelectorAll('.line-amount')
            .forEach(function (input) {
                subtotal += parseNumber(input.value);
            });

        const discount = syncDiscountFields(form);

        /*
         * Source tax is authoritative for this imported payment. The controller
         * resolves a matching QBO TaxCode/TaxRate and sends TxnTaxDetail so QBO
         * receives this exact tax amount.
         */
        const sourceTax = Math.max(
            0,
            parseNumber(
                form.querySelector('[name="tax_amount"]')?.value
            )
        );

        const taxableBase =
            Math.max(
                0,
                discountableSubtotal(form) - discount
            );

        const effectiveTaxPercent =
            sourceTax > 0 && taxableBase > 0
                ? (sourceTax / taxableBase) * 100
                : 0;

        const rateNote =
            form.querySelector('.js-tax-rate-note');

        if (rateNote) {
            rateNote.textContent =
                effectiveTaxPercent > 0
                    ? Number(effectiveTaxPercent.toFixed(4)).toString() + '%'
                    : 'No tax';
        }

        const calculatedTotal =
            subtotal
            - discount
            + sourceTax;

        const subtotalElement =
            form.querySelector('.js-subtotal');

        const discountElement =
            form.querySelector('.js-discount');

        const totalElement =
            form.querySelector('.js-total');

        if (subtotalElement) {
            subtotalElement.textContent = money(subtotal);
        }

        if (discountElement) {
            discountElement.textContent =
                discount > 0
                    ? '-' + money(discount)
                    : money(0);
        }

        if (totalElement) {
            totalElement.textContent = money(calculatedTotal);
            totalElement.dataset.calculatedTotal =
                calculatedTotal.toFixed(2);
        }
    }

    function validateForExport(form) {
        const customer = form.querySelector('[name="customer_id"]');

        if (!customer || !customer.value) {
            return 'Please select a QuickBooks customer.';
        }

        const isRefund =
            parseInt(
                form.querySelector('[name="is_refund"]')?.value || '0',
                10
            ) === 1;

        const account = isRefund
            ? form.querySelector('[name="refund_from_account_id"]')
            : form.querySelector('[name="deposit_account_id"]');

        if (!account || !account.value) {
            return isRefund
                ? 'Please select the QuickBooks refund account.'
                : 'Please select the QuickBooks deposit account.';
        }

        const discountType =
            form.querySelector('[name="discount_type"]')?.value;

        const discountValue = Math.max(
            0,
            parseNumber(
                form.querySelector('[name="discount_value"]')?.value
            )
        );

        if (
            !isRefund
            && discountType === 'percent'
            && discountValue > 100
        ) {
            return 'Discount percent cannot be greater than 100%.';
        }

        if (
            !isRefund
            && discountType === 'amount'
            && discountValue > discountableSubtotal(form) + 0.009
        ) {
            return 'Discount value cannot be greater than the discountable subtotal.';
        }

        const rows = form.querySelectorAll('.qb-tbody tr');

        if (!rows.length) {
            return 'At least one Product / Service line is required.';
        }

        for (const row of rows) {
            const product = row.querySelector(
                'select[name*="[product]"]'
            );

            if (!product || !product.value) {
                return 'Please select a Product / Service for every line.';
            }
        }

        refreshTotals(form);

        const expectedTotal = parseNumber(
            form.querySelector('[name="amount"]')?.value
        );

        const calculatedTotal = parseNumber(
            form.querySelector('.js-total')?.dataset.calculatedTotal
        );

        if (
            Math.abs(calculatedTotal - expectedTotal) >= 0.02
        ) {
            return (
                'Receipt total '
                + money(calculatedTotal)
                + ' must match this payment amount '
                + money(expectedTotal)
                + '. Adjust the line items or discount before exporting.'
            );
        }

        return null;
    }

    async function responseJson(response) {
        const text = await response.text();

        try {
            return text
                ? JSON.parse(text)
                : {};
        } catch (error) {
            return {
                success: false,
                error:
                    'The server returned an invalid response. '
                    + text.substring(0, 500)
            };
        }
    }

    async function submitReceipt(form, exportStatus) {
        if (exportStatus === 1) {
            const validationError = validateForExport(form);

            if (validationError) {
                return {
                    success: false,
                    validation: true,
                    error: validationError
                };
            }
        }

        const formData = new FormData(form);
        formData.set('export_status', exportStatus);

        const response = await fetch(
            '{{ route('quickbooks.import_sales_receipt') }}',
            {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            }
        );

        const data = await responseJson(response);

        if (!response.ok && !data.error) {
            data.error =
                'QuickBooks request failed with HTTP '
                + response.status + '.';
        }

        return data;
    }

    function markSaved(form) {
        const status = form.querySelector('.js-save-status');
        const chip = form.closest('.qb-receipt')
            ?.querySelector('.receipt-status-chip');

        if (status) {
            status.innerHTML =
                '<i class="bi bi-check-circle me-1 text-success"></i>'
                + 'Saved in Encore Cloud';
        }

        if (chip) {
            chip.innerHTML =
                '<i class="bi bi-circle-fill" style="font-size:6px;"></i>'
                + ' Saved';
        }
    }

    function markSynced(form, result) {
        const status = form.querySelector('.js-save-status');
        const chip = form.closest('.qb-receipt')
            ?.querySelector('.receipt-status-chip');
        const button = form.querySelector('.export-to-quickbooks');

        if (status) {
            status.innerHTML =
                '<i class="bi bi-check-circle-fill me-1 text-success"></i>'
                + 'Synced to QuickBooks';
        }

        if (chip) {
            chip.innerHTML =
                '<i class="bi bi-check-circle-fill"></i>'
                + ' Synced';
        }

        if (button) {
            button.disabled = true;
            button.textContent = 'Synced';
        }
    }

    document.addEventListener('click', async function (event) {
        const saveButton = event.target.closest('.save-quickbook-data');

        if (saveButton) {
            const formKey = saveButton.dataset.formKey;
            const form = document.getElementById(
                'quickbook_data_form_' + formKey
            );

            if (!form) {
                return;
            }

            showLoader();

            try {
                const result = await submitReceipt(form, 0);

                hideLoader();

                if (result.success) {
                    markSaved(form);

                    await Swal.fire({
                        icon: 'success',
                        title: 'Saved',
                        text: 'Sales receipt details were saved without syncing to QuickBooks.',
                        confirmButtonColor: '#2ca01c'
                    });
                } else {
                    await Swal.fire({
                        icon: 'error',
                        title: 'Save failed',
                        text: result.error || 'Unable to save this receipt.',
                        confirmButtonColor: '#c62828'
                    });
                }
            } catch (error) {
                hideLoader();
                await Swal.fire({
                    icon: 'error',
                    title: 'Save failed',
                    text: error.message || 'Unexpected error.',
                    confirmButtonColor: '#c62828'
                });
            } finally {
                hideLoader();
            }

            return;
        }

        const exportButton = event.target.closest('.export-to-quickbooks');

        if (exportButton) {
            const formKey = exportButton.dataset.formKey;
            const form = document.getElementById(
                'quickbook_data_form_' + formKey
            );

            if (!form) {
                return;
            }

            const confirmation = await Swal.fire({
                icon: 'question',
                title: 'Export to QuickBooks?',
                text: 'This payment will create one QuickBooks receipt and cannot be exported a second time.',
                showCancelButton: true,
                confirmButtonText: 'Export',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#2ca01c'
            });

            if (!confirmation.isConfirmed) {
                return;
            }

            showLoader();

            try {
                const result = await submitReceipt(form, 1);

                hideLoader();

                if (result.success) {
                    markSynced(form, result);

                    if (result.already_exported) {
                        await Swal.fire({
                            icon: 'info',
                            title: 'Already synced',
                            text: result.message || 'This payment was already synced.',
                            confirmButtonColor: '#0077c5'
                        });
                    } else if (result.amount_mismatch) {
                        await Swal.fire({
                            icon: 'warning',
                            title: 'Exported with total difference',
                            html:
                                'QuickBooks created the receipt, but its calculated total was '
                                + '<b>' + money(result.quickbooks_amount) + '</b>'
                                + ' while the payment amount is '
                                + '<b>' + money(result.expected_amount) + '</b>.'
                                + '<br><br>Source tax: <b>'
                                + money(result.source_tax_amount)
                                + '</b>; QuickBooks tax: <b>'
                                + money(result.quickbooks_tax_amount)
                                + '</b>.'
                                + '<br><br>Please review the QuickBooks tax rate returned for this receipt.',
                            confirmButtonColor: '#2ca01c'
                        });
                    } else {
                        await Swal.fire({
                            icon: 'success',
                            title: 'Exported',
                            text: result.message || 'Sales receipt exported successfully.',
                            confirmButtonColor: '#2ca01c'
                        });
                    }
                } else {
                    await Swal.fire({
                        icon: result.validation ? 'warning' : 'error',
                        title: result.validation
                            ? 'Complete required fields'
                            : 'QuickBooks export failed',
                        text: result.error || 'Unable to export this receipt.',
                        confirmButtonColor: result.validation
                            ? '#0077c5'
                            : '#c62828'
                    });
                }
            } catch (error) {
                hideLoader();
                await Swal.fire({
                    icon: 'error',
                    title: 'QuickBooks export failed',
                    text: error.message || 'Unexpected error.',
                    confirmButtonColor: '#c62828'
                });
            } finally {
                hideLoader();
            }

            return;
        }

        const addButton = event.target.closest('.add-qb-row');

        if (addButton) {
            const form = addButton.closest('form');
            const tbody = form?.querySelector('.qb-tbody');

            if (!form || !tbody) {
                return;
            }

            const index = tbody.querySelectorAll('tr').length;

            const options = qbItems
                .map(function (item) {
                    return '<option value="'
                        + escapeHtml(item.Name || '')
                        + '">'
                        + escapeHtml(item.Name || '')
                        + '</option>';
                })
                .join('');

            const row = document.createElement('tr');

            row.innerHTML = `
                <td class="line-index">${index + 1}</td>

                <td>
                    <select
                        name="items[${index}][product]"
                        class="qb-grid-select product-select"
                    >
                        <option value="">Select product</option>
                        ${options}
                    </select>
                </td>

                <td>
                    <input
                        type="text"
                        name="items[${index}][sku]"
                        class="qb-grid-input"
                    >
                </td>

                <td>
                    <input
                        type="text"
                        name="items[${index}][description]"
                        class="qb-grid-input"
                    >
                </td>

                <td>
                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        name="items[${index}][qty]"
                        class="qb-grid-input text-center line-qty"
                        value="1"
                    >
                </td>

                <td>
                    <input
                        type="number"
                        step="0.01"
                        name="items[${index}][rate]"
                        class="qb-grid-input text-money line-rate"
                        value="0.00"
                    >
                </td>

                <td>
                    <input
                        type="number"
                        step="0.01"
                        name="items[${index}][amount]"
                        class="qb-grid-input text-money line-amount"
                        value="0.00"
                    >
                </td>

                <td class="text-center">
                    <input
                        type="checkbox"
                        name="items[${index}][tax]"
                        class="form-check-input"
                    >
                </td>

                <td>
                    <input
                        type="text"
                        name="items[${index}][class]"
                        class="qb-grid-input"
                        value="Encore Clothing:Team Sales"
                    >
                </td>

                <td class="text-center">
                    <i
                        class="bi bi-trash qb-delete-line"
                        title="Delete line"
                    ></i>
                </td>
            `;

            tbody.appendChild(row);
            updateRowNumbers(form);
            refreshTotals(form);

            return;
        }

        const deleteButton = event.target.closest('.qb-delete-line');

        if (deleteButton) {
            const row = deleteButton.closest('tr');
            const form = deleteButton.closest('form');
            const tbody = row?.parentElement;

            if (!row || !form || !tbody) {
                return;
            }

            if (tbody.querySelectorAll('tr').length <= 1) {
                await Swal.fire({
                    icon: 'warning',
                    title: 'Line required',
                    text: 'A sales receipt must contain at least one line.',
                    confirmButtonColor: '#0077c5'
                });

                return;
            }

            const confirmation = await Swal.fire({
                icon: 'warning',
                title: 'Delete this line?',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#c62828'
            });

            if (confirmation.isConfirmed) {
                row.remove();
                updateRowNumbers(form);
                refreshTotals(form);
            }

            return;
        }
    });

    document.addEventListener('input', function (event) {
        const form = event.target.closest('.qb-receipt-form');

        if (!form) {
            return;
        }

        if (
            event.target.classList.contains('line-qty')
            || event.target.classList.contains('line-rate')
        ) {
            const row = event.target.closest('tr');

            if (row) {
                const qty = parseNumber(
                    row.querySelector('.line-qty')?.value
                );

                const rate = parseNumber(
                    row.querySelector('.line-rate')?.value
                );

                const amountInput =
                    row.querySelector('.line-amount');

                if (amountInput) {
                    amountInput.value = (qty * rate).toFixed(2);
                }
            }
        }

        if (
            event.target.classList.contains('line-qty')
            || event.target.classList.contains('line-rate')
            || event.target.classList.contains('line-amount')
            || event.target.classList.contains('discount-value-input')
            || event.target.classList.contains('tax-amount-input')
        ) {
            refreshTotals(form);
        }
    });

    document.addEventListener('change', function (event) {
        const form = event.target.closest('.qb-receipt-form');

        if (!form) {
            return;
        }

        if (
            event.target.classList.contains('discount-type-select')
            || event.target.classList.contains('product-select')
        ) {
            refreshTotals(form);
        }
    });

    document.querySelector('.save-all-records')
        ?.addEventListener('click', async function () {
            const forms = Array.from(
                document.querySelectorAll('.qb-receipt-form')
            );

            if (!forms.length) {
                return;
            }

            showLoader();

            let saved = 0;
            let failed = 0;

            try {
                for (const form of forms) {
                    const result = await submitReceipt(form, 0);

                    if (result.success) {
                        saved++;
                        markSaved(form);
                    } else {
                        failed++;
                    }
                }
                hideLoader();
            } finally {
                hideLoader();
            }

            await Swal.fire({
                icon: failed ? 'warning' : 'success',
                title: failed ? 'Save completed with issues' : 'All receipts saved',
                text:
                    saved + ' saved, '
                    + failed + ' failed.',
                confirmButtonColor: failed ? '#0077c5' : '#2ca01c'
            });
        });

    document.querySelector('.export-all-records')
        ?.addEventListener('click', async function () {
            const forms = Array.from(
                document.querySelectorAll('.qb-receipt-form')
            ).filter(function (form) {
                const button = form.querySelector(
                    '.export-to-quickbooks'
                );

                return button && !button.disabled;
            });

            if (!forms.length) {
                await Swal.fire({
                    icon: 'info',
                    title: 'Nothing to export',
                    text: 'All loaded payments are already synced.',
                    confirmButtonColor: '#0077c5'
                });

                return;
            }

            const confirmation = await Swal.fire({
                icon: 'question',
                title: 'Export all to QuickBooks?',
                text: forms.length + ' unsynced payment receipt(s) will be exported sequentially.',
                showCancelButton: true,
                confirmButtonText: 'Export all',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#2ca01c'
            });

            if (!confirmation.isConfirmed) {
                return;
            }

            showLoader();

            let imported = 0;
            let skipped = 0;
            let failed = 0;
            let mismatch = 0;
            let firstError = '';

            try {
                /*
                 * Sequential export is intentional.
                 * It avoids simultaneous document-number generation and reduces
                 * the chance of QuickBooks throttling/race conditions.
                 */
                for (const form of forms) {
                    const result = await submitReceipt(form, 1);

                    hideLoader();

                    if (result.success) {
                        if (result.already_exported) {
                            skipped++;
                        } else {
                            imported++;
                        }

                        if (result.amount_mismatch) {
                            mismatch++;
                        }

                        markSynced(form, result);
                    } else {
                        failed++;

                        if (!firstError) {
                            firstError =
                                result.error
                                || 'One receipt failed to export.';
                        }
                    }
                }
            } finally {
                hideLoader();
            }

            await Swal.fire({
                icon: failed || mismatch ? 'warning' : 'success',
                title:
                    failed || mismatch
                        ? 'QuickBooks export completed with warnings'
                        : 'All receipts exported',
                html:
                    '<b>' + imported + '</b> imported'
                    + '<br><b>' + skipped + '</b> already synced'
                    + '<br><b>' + failed + '</b> failed'
                    + '<br><b>' + mismatch + '</b> total mismatch'
                    + (
                        firstError
                            ? '<br><br>' + escapeHtml(firstError)
                            : ''
                    ),
                confirmButtonColor:
                    failed || mismatch
                        ? '#0077c5'
                        : '#2ca01c'
            });
        });

    initTomSelect(document);

    document.querySelectorAll('.qb-receipt-form')
        .forEach(function (form) {
            refreshTotals(form);
        });
})();
</script>

</body>
</html>
