@extends('layouts.app', ['activePage' => 'Shipping', 'titlePage' => __('Shipping')])



@section('sub-sidebar-content')



<style>

    .label-page {

        padding: 20px 22px 40px;

    }



    .label-page-header {

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 12px;

        flex-wrap: wrap;

        margin-bottom: 16px;

    }



    .label-page-title {

        margin: 0;

        font-size: 20px;

        font-weight: 700;

        color: #32325d;

    }



    .label-page-subtitle {

        margin-top: 4px;

        font-size: 12px;

        color: #8898aa;

    }



    .label-page-actions,

    .label-form-actions {

        display: flex;

        gap: 8px;

        flex-wrap: wrap;

        align-items: center;

    }



    .label-btn {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        gap: 6px;

        min-height: 36px;

        padding: 8px 12px;

        border: 1px solid #dedede;

        border-radius: 7px;

        background: #fff;

        color: #555 !important;

        font-size: 12px;

        font-weight: 600;

        text-decoration: none !important;

        cursor: pointer;

    }



    .label-btn:hover {

        color: #17a589 !important;

        border-color: #17a589;

    }



    .label-btn-primary {

        background: #17a589;

        border-color: #17a589;

        color: #fff !important;

    }



    .label-btn-primary:hover {

        background: #12836e;

        color: #fff !important;

    }



    .label-btn-danger {

        border-color: #f2c4c4;

        color: #b42318 !important;

    }



    .label-btn-warning {

        border-color: #f0c36d;

        color: #8a5a00 !important;

    }



    .label-btn:disabled {

        opacity: .55;

        cursor: not-allowed;

    }



    .label-bulk-bar {

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 12px;

        flex-wrap: wrap;

        background: #fff;

        border: 1px solid #eceff3;

        border-radius: 12px;

        padding: 13px 15px;

        margin-bottom: 16px;

        box-shadow: 0 2px 8px rgba(0, 0, 0, .03);

    }



    .bulk-edit-help {

        font-size: 11px;

        color: #8898aa;

        margin-top: 4px;

        max-width: 760px;

        line-height: 1.45;

    }



    .bulk-select-all {

        display: inline-flex;

        align-items: center;

        gap: 7px;

        margin-top: 8px;

        font-size: 12px;

        font-weight: 600;

        color: #525f7f;

        cursor: pointer;

    }



    .bulk-select-all input,

    .bulk-record-select {

        width: 17px;

        height: 17px;

        cursor: pointer;

    }



    .bulk-record-select:disabled {

        cursor: not-allowed;

        opacity: .45;

    }



    .label-bulk-fee-total {

        margin-top: 5px;

        font-size: 12px;

        font-weight: 700;

        color: #117a65;

    }



    .label-card {

        background: #fff;

        border: 1px solid #eceff3;

        border-radius: 12px;

        margin-bottom: 16px;

        overflow: hidden;

        box-shadow: 0 2px 8px rgba(0, 0, 0, .04);

    }



    .label-card-header {

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 12px;

        flex-wrap: wrap;

        padding: 15px 18px;

        background: #fafbfc;

        border-bottom: 1px solid #edf0f3;

    }



    .label-card-header.bulk-collapsible {

        cursor: pointer;

        user-select: none;

    }



    .label-card-header.bulk-collapsible:hover {

        background: #f5f7f9;

    }



    .label-card-header-left {

        display: flex;

        align-items: center;

        gap: 11px;

        min-width: 0;

    }



    .label-card-header-right {

        display: flex;

        align-items: center;

        gap: 10px;

        flex-wrap: wrap;

    }



    .label-order {

        font-size: 15px;

        font-weight: 700;

        color: #32325d;

    }



    .label-shipment {

        margin-top: 3px;

        font-size: 11px;

        color: #8898aa;

    }



    .label-status {

        display: inline-flex;

        padding: 4px 9px;

        border-radius: 14px;

        font-size: 10px;

        font-weight: 700;

        text-transform: uppercase;

    }



    .label-status.draft {

        background: #f3f4f6;

        color: #6b7280;

    }



    .label-status.created {

        background: rgba(23, 165, 137, .12);

        color: #17a589;

    }



    .label-status.canceled {

        background: #fee2e2;

        color: #991b1b;

    }



    .label-status.refund_requested {

        background: #fff7d6;

        color: #92400e;

    }



    .label-status.review_required,

    .label-status.edit_review,

    .label-status.creating,

    .label-status.legacy {

        background: #fff1e6;

        color: #9a3412;

    }



    .label-collapse-btn {

        width: 30px;

        height: 30px;

        border: 1px solid #e3e6ea;

        border-radius: 7px;

        background: #fff;

        color: #6b7280;

        display: inline-flex;

        align-items: center;

        justify-content: center;

        cursor: pointer;

        padding: 0;

    }



    .label-collapse-btn:hover {

        color: #17a589;

        border-color: #17a589;

    }



    /*

     * IMPORTANT:

     * Everything except the order header is inside .label-card-content.

     * Bulk collapse hides this WHOLE wrapper, so no summary/form/actions remain visible.

     */

    .label-card-content {

        display: block;

    }

    .label-card-body {
        padding: 18px;
        width: 100%;
        box-sizing: border-box;
    }

    .label-card-content {
        width: 100%;
        box-sizing: border-box;
    }

    .label-card-body > .label-section,
    .label-card-body > form,
    .label-card-body > .label-form-actions,
    .label-card-body > .label-danger-note,
    .label-card-body > .label-note {
        width: 100%;
        box-sizing: border-box;
    }

    .label-status-wrap {
        display: flex;
        align-items: center;
    }



    .label-summary {

        display: grid;

        grid-template-columns: repeat(5, minmax(0, 1fr));

        gap: 10px;

        margin-bottom: 16px;

    }



    .label-summary-item {

        padding: 10px 12px;

        border: 1px solid #edf0f3;

        border-radius: 9px;

        background: #fafbfc;

    }



    .label-summary-item small {

        display: block;

        margin-bottom: 4px;

        color: #9aa3ad;

        text-transform: uppercase;

        font-size: 9px;

        font-weight: 700;

        letter-spacing: .04em;

    }



    .label-summary-item strong {

        display: block;

        font-size: 12px;

        color: #39404a;

        word-break: break-word;

    }



    .label-section {

        border: 1px solid #eceff3;

        border-radius: 10px;

        padding: 14px;

        margin-bottom: 14px;

    }



    .label-section-title {

        font-size: 11px;

        font-weight: 700;

        color: #525f7f;

        text-transform: uppercase;

        letter-spacing: .04em;

        margin-bottom: 10px;

    }



    .label-grid {

        display: grid;

        grid-template-columns: repeat(2, minmax(0, 1fr));

        gap: 12px;

    }



    .label-grid-3 {

        grid-template-columns: repeat(3, minmax(0, 1fr));

    }



    .label-field.wide {

        grid-column: 1 / -1;

    }



    .label-field label {

        display: block;

        margin-bottom: 4px;

        color: #717070;

        font-size: 11px;

        font-weight: 600;

    }



    .label-field input,

    .label-field textarea,

    .label-field select {

        width: 100%;

        border: 1px solid #dedede;

        border-radius: 7px;

        padding: 8px 10px;

        font-size: 13px;

        color: #32325d;

        background: #fff;

    }



    .label-readonly {

        min-height: 38px;

        padding: 8px 10px;

        border: 1px solid #edf0f3;

        background: #fafbfc;

        border-radius: 7px;

        font-size: 13px;

        color: #4a5568;

    }



    .label-note {

        padding: 10px 12px;

        margin-bottom: 14px;

        border-radius: 8px;

        background: #fff8e1;

        color: #7a5a00;

        font-size: 11px;

    }



    .label-danger-note {

        padding: 10px 12px;

        margin-bottom: 14px;

        border-radius: 8px;

        background: #fff1f1;

        color: #9b1c1c;

        font-size: 11px;

    }



    .label-form-actions {

        margin-top: 12px;

    }



    .label-inline-form {

        display: inline;

        margin: 0;

    }



    .label-fee-badge {

        display: inline-flex;

        align-items: center;

        gap: 5px;

        padding: 5px 9px;

        border-radius: 14px;

        background: #e8f8f3;

        color: #117a65;

        font-size: 10px;

        font-weight: 700;

        white-space: nowrap;

    }



    .label-fee-badge.loading,

    .label-fee-badge.stale {

        background: #f3f4f6;

        color: #6b7280;

    }



    .label-fee-badge.error {

        background: #fee2e2;

        color: #991b1b;

    }



    .label-fee-panel {

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 12px;

        flex-wrap: wrap;

        padding: 13px 14px;

        margin-bottom: 14px;

        border: 1px solid #d9eee8;

        border-radius: 10px;

        background: #f6fffc;

    }



    .label-fee-title {

        font-size: 11px;

        font-weight: 700;

        color: #525f7f;

        text-transform: uppercase;

        letter-spacing: .04em;

        margin-bottom: 3px;

    }



    .label-fee-amount {

        font-size: 22px;

        line-height: 1.1;

        font-weight: 700;

        color: #117a65;

    }



    .label-fee-message {

        margin-top: 4px;

        font-size: 10px;

        color: #8898aa;

    }



    .label-field .is-invalid {

        border-color: #e3342f !important;

        box-shadow: 0 0 0 1px rgba(227, 52, 47, .08);

    }



    .label-field-error {

        margin-top: 4px;

        color: #e3342f;

        font-size: 10px;

        font-weight: 600;

    }



    .shared-change-flash {

        animation: sharedFieldFlash .7s ease;

    }



    @keyframes sharedFieldFlash {

        0% { box-shadow: 0 0 0 2px rgba(23, 165, 137, .35); }

        100% { box-shadow: none; }

    }



    @media(max-width: 991px) {

        .label-summary {

            grid-template-columns: repeat(2, minmax(0, 1fr));

        }

    }



    @media(max-width: 767px) {

        .label-page {

            padding: 12px 10px 30px;

        }



        .label-summary,

        .label-grid,

        .label-grid-3 {

            grid-template-columns: 1fr;

        }



        .label-page-actions,

        .label-form-actions {

            width: 100%;

        }



        .label-page-actions .label-btn,

        .label-form-actions .label-btn {

            flex: 1 1 auto;

        }



        .label-field input,

        .label-field textarea,

        .label-field select {

            font-size: 16px !important;

        }

    }

</style>



<div>

    @include('pages.stores.layouts.top_header')

    @yield('stores_header')



    <div class="">



        @if($bulkMode)

            <div class="label-bulk-bar">

                <div>

                    <label class="bulk-select-all">

                        <input type="checkbox" id="bulk_edit_select_all">

                        Select all

                    </label>



                    @if(count($draftShipmentIds))

                        <div class="label-bulk-fee-total" id="label_bulk_fee_total">

                            Estimated USPS postage: calculating...

                        </div>

                    @endif

                </div>



                <div class="label-page-actions">

                    @if(count($draftShipmentIds))

                        <form method="POST"
                              action="{{ route('usps.label.bulk-create') }}"
                              class="label-inline-form"
                              id="label_bulk_create_form">
                            @csrf

                            <button type="submit"
                                    class="label-btn label-btn-primary"
                                    id="label_bulk_create_btn"
                                    disabled>
                                <i class="fa fa-plus-circle"></i>
                                <span id="label_bulk_create_text">Create Selected Labels (0)</span>
                            </button>
                        </form>

                    @endif



                    <form method="POST"
                          action="{{ route('usps.label.bulk-download') }}"
                          class="label-inline-form"
                          id="label_bulk_zip_form">
                        @csrf

                        <button type="submit"
                                class="label-btn"
                                id="label_bulk_zip_btn"
                                disabled>
                            <i class="fa fa-download"></i>
                            <span id="label_bulk_zip_text">Download Selected ZIP (0)</span>
                        </button>
                    </form>



                    <form method="POST"
                          action="{{ route('usps.label.bulk-print') }}"
                          class="label-inline-form"
                          id="label_bulk_pdf_form">
                        @csrf

                        <button type="submit"
                                class="label-btn"
                                id="label_bulk_pdf_btn"
                                disabled>
                            <i class="fa fa-file-pdf-o"></i>
                            <span id="label_bulk_pdf_text">Download Selected PDF (0)</span>
                        </button>
                    </form>

                </div>

            </div>

        @endif



        @foreach($records as $record)

            @php

                $shipment = $record['shipment'];

                $profile = $record['profile'];

                $status = $profile->status ?: 'draft';

                $statusText = ucwords(str_replace('_', ' ', $status));

            @endphp



            <div class="label-card"

                 id="shipment-{{ $shipment->id }}"

                 data-shipment-id="{{ $shipment->id }}">



                <div class="label-card-header {{ $bulkMode ? 'bulk-collapsible' : '' }}"

                     @if($bulkMode)

                         data-target="#label-card-content-{{ $shipment->id }}"

                         role="button"

                         tabindex="0"

                         aria-expanded="false"

                     @endif>



                    <div class="label-card-header-left">

                        @if($bulkMode)

                            <input type="checkbox"
                                   class="bulk-record-select"
                                   value="{{ $shipment->id }}"
                                   data-shipment-id="{{ $shipment->id }}"
                                   data-is-draft="{{ $status === 'draft' ? '1' : '0' }}"
                                   data-has-pdf="{{ $record['has_saved_pdf'] ? '1' : '0' }}"
                                   @if($status !== 'draft' && !$record['has_saved_pdf']) disabled @endif
                                   title="@if($status === 'draft') Select this draft for label creation/shared changes @elseif($record['has_saved_pdf']) Select this created label for bulk PDF/ZIP download @else No saved label PDF available @endif">

                        @endif



                        <div>

                            <div class="label-order">Order #{{ $shipment->store_order_no }}</div>

                        </div>

                    </div>



                    <div class="label-card-header-right">

                        @if($status === 'draft')

                            <span class="label-fee-badge loading"

                                  id="label-header-fee-{{ $shipment->id }}">

                                <i class="fa fa-spinner fa-spin"></i> Checking fee...

                            </span>

                        @elseif($profile->actual_postage !== null)

                            <span class="label-fee-badge">

                                USPS ${{ number_format((float) $profile->actual_postage, 2) }}

                            </span>

                        @endif



                        <span class="label-status {{ $status }}">{{ $statusText }}</span>



                        @if($bulkMode)

                            <button type="button"

                                    class="label-collapse-btn"

                                    aria-label="Expand order"

                                    title="Expand order">

                                <i class="fa fa-chevron-down"></i>

                            </button>

                        @endif

                    </div>

                </div>



                {{-- Everything below the header is inside this wrapper. --}}

                <div class="label-card-content"

                     id="label-card-content-{{ $shipment->id }}"

                     @if($bulkMode) style="display:none;" @endif>



                    <div class="label-card-body">



                        <div class="label-summary">

                            <div class="label-summary-item">

                                <small>Shipping Name</small>

                                <strong>{{ $shipment->shipping_name ?: 'N/A' }}</strong>

                            </div>



                            <div class="label-summary-item">

                                <small>Service</small>

                                <strong>{{ $shipment->service ?: $shipment->selected_rate ?: 'N/A' }}</strong>

                            </div>



                            <div class="label-summary-item">

                                <small>Quoted Rate</small>

                                <strong>${{ number_format((float) $shipment->rate, 2) }}</strong>

                            </div>



                            <div class="label-summary-item">

                                <small>Tracking</small>

                                <strong>{{ $shipment->tracking_number ?: 'Not created' }}</strong>

                            </div>



                            <div class="label-summary-item">

                                <small>Actual Postage</small>

                                <strong>

                                    {{ $profile->actual_postage !== null ? '$' . number_format((float) $profile->actual_postage, 2) : 'N/A' }}

                                </strong>

                            </div>

                        </div>



                        @if($status === 'draft')



                            <form method="POST"

                                  action="{{ route('usps.create_lable') }}"

                                  class="label-create-form"

                                  data-shipment-id="{{ $shipment->id }}"

                                  data-quote-url="{{ route('usps.label.quote', ['id' => $shipment->id]) }}"

                                  data-save-url="{{ route('usps.label.save-draft', ['id' => $shipment->id]) }}"

                                  data-quote-ready="0"

                                  data-dirty="0">

                                @csrf



                                <input type="hidden" name="shipment_id" value="{{ $shipment->shipment_id }}">



                                <div class="label-section">

                                    <div class="label-section-title">Recipient</div>



                                    <div class="label-grid">

                                        <div class="label-field">

                                            <label>First Name</label>

                                            <input type="text"

                                                   name="recipient_first_name"

                                                   value="{{ $profile->recipient_first_name }}"

                                                   required>

                                        </div>



                                        <div class="label-field">

                                            <label>Last Name</label>

                                            <input type="text"

                                                   name="recipient_last_name"

                                                   value="{{ $profile->recipient_last_name }}">

                                        </div>



                                        <div class="label-field wide">

                                            <label>Address Line 1</label>

                                            <input type="text"

                                                   name="recipient_street"

                                                   value="{{ $profile->recipient_street }}"

                                                   required>

                                        </div>



                                        <div class="label-field wide">

                                            <label>Address Line 2</label>

                                            <input type="text"

                                                   name="recipient_street2"

                                                   value="{{ $profile->recipient_street2 }}">

                                        </div>



                                        <div class="label-field">

                                            <label>City</label>

                                            <input type="text"

                                                   name="recipient_city"

                                                   value="{{ $profile->recipient_city }}"

                                                   required>

                                        </div>



                                        <div class="label-field">

                                            <label>State</label>

                                            <input type="text"

                                                   maxlength="2"

                                                   name="recipient_state"

                                                   value="{{ $profile->recipient_state }}"

                                                   required>

                                        </div>



                                        <div class="label-field">

                                            <label>ZIP / ZIP+4</label>

                                            <input type="text"

                                                   name="recipient_zip"

                                                   value="{{ $profile->recipient_zip }}"

                                                   required>

                                        </div>



                                        <div class="label-field">

                                            <label>Phone</label>

                                            <input type="text"

                                                   name="recipient_phone"

                                                   value="{{ $profile->recipient_phone }}">

                                        </div>



                                        <div class="label-field wide">

                                            <label>Email</label>

                                            <input type="email"

                                                   name="recipient_email"

                                                   value="{{ $profile->recipient_email }}">

                                        </div>

                                    </div>

                                </div>



                                <div class="label-section">

                                    <div class="label-section-title">Shipping</div>



                                    <div class="label-grid">

                                        <div class="label-field">

                                            <label>Shipping Date</label>

                                            <input type="date"

                                                   name="mailing_date"

                                                   min="{{ $record['min_mailing_date'] }}"

                                                   value="{{ $record['mailing_date'] }}"

                                                   required>

                                        </div>



                                        <div class="label-field">

                                            <label>Mail Class</label>

                                            <select name="mail_class" required>

                                                <option value="USPS_GROUND_ADVANTAGE"

                                                    {{ $shipment->selected_rate === 'USPS_GROUND_ADVANTAGE' ? 'selected' : '' }}>

                                                    USPS Ground Advantage

                                                </option>



                                                <option value="PRIORITY_MAIL"

                                                    {{ $shipment->selected_rate === 'PRIORITY_MAIL' ? 'selected' : '' }}>

                                                    Priority Mail

                                                </option>



                                                <option value="PRIORITY_MAIL_EXPRESS"

                                                    {{ $shipment->selected_rate === 'PRIORITY_MAIL_EXPRESS' ? 'selected' : '' }}>

                                                    Priority Mail Express

                                                </option>

                                            </select>

                                        </div>

                                    </div>

                                </div>



                                <div class="label-section">

                                    <div class="label-section-title">Package</div>



                                    <div class="label-grid label-grid-3">

                                        <div class="label-field">

                                            <label>Weight (lb)</label>

                                            <input type="number"

                                                   step="any"

                                                   min="0.01"

                                                   name="weight_lb"

                                                   value="{{ $profile->weight_lb }}"

                                                   required>

                                        </div>



                                        <div class="label-field">

                                            <label>Length (in)</label>

                                            <input type="number"

                                                   step="any"

                                                   min="0.1"

                                                   name="length_in"

                                                   value="{{ $profile->length_in }}"

                                                   required>

                                        </div>



                                        <div class="label-field">

                                            <label>Width (in)</label>

                                            <input type="number"

                                                   step="any"

                                                   min="0.1"

                                                   name="width_in"

                                                   value="{{ $profile->width_in }}"

                                                   required>

                                        </div>



                                        <div class="label-field">

                                            <label>Height (in)</label>

                                            <input type="number"

                                                   step="any"

                                                   min="0.1"

                                                   name="height_in"

                                                   value="{{ $profile->height_in }}"

                                                   required>

                                        </div>

                                    </div>

                                </div>



                                <div class="label-fee-panel">

                                    <div>

                                        <div class="label-fee-title">Estimated USPS Postage</div>



                                        <div class="label-fee-amount"

                                             id="label-fee-amount-{{ $shipment->id }}">

                                            Checking...

                                        </div>



                                        <div class="label-fee-message"

                                             id="label-fee-message-{{ $shipment->id }}">

                                            Getting the current USPS commercial rate before label purchase.

                                        </div>

                                    </div>



                                    <button type="button"

                                            class="label-btn js-refresh-label-fee">

                                        <i class="fa fa-refresh"></i> Refresh Fee

                                    </button>

                                </div>



                                <div class="label-form-actions">

                                    <button type="submit"

                                            formaction="{{ route('usps.label.save-draft', ['id' => $shipment->id]) }}"

                                            class="label-btn">

                                        <i class="fa fa-save"></i> Save Draft

                                    </button>



                                    <button type="submit"

                                            class="label-btn label-btn-primary js-create-label"

                                            data-title="Create USPS Label"

                                            data-message="Create USPS postage for order #{{ $shipment->store_order_no }}?"

                                            disabled>

                                        <i class="fa fa-tag"></i> Create USPS Label

                                    </button>

                                </div>

                            </form>



                        @else



                            @if(in_array($status, ['review_required', 'edit_review', 'creating'], true))

                                <div class="label-danger-note">

                                    This label requires review. Verify the USPS transaction before another purchase attempt.

                                </div>

                            @endif



                            <div class="label-section">

                                <div class="label-section-title">Label Details</div>

                                <div class="label-grid label-grid-3">

                                    <div class="label-field">

                                        <label>Tracking Number</label>

                                        <div class="label-readonly">
                                            {{ $shipment->tracking_number ?: 'N/A' }}
                                        </div>

                                    </div>

                                    <div class="label-field">

                                        <label>Shipping Date</label>

                                        <div class="label-readonly">
                                            {{ $record['mailing_date'] ?: 'N/A' }}
                                        </div>

                                    </div>

                                    <div class="label-field">

                                        <label>Mail Class</label>

                                        <div class="label-readonly">
                                            {{ $shipment->selected_rate ?: 'N/A' }}
                                        </div>

                                    </div>

                                    <div class="label-field">

                                        <label>Status</label>

                                        <div class="label-readonly label-status-wrap">
                                            <span class="label-status {{ $status }}">
                                                {{ $statusText }}
                                            </span>
                                        </div>

                                    </div>

                                </div>

                            </div>



                            <div class="label-section">

                                <div class="label-section-title">Recipient</div>



                                <div class="label-grid">

                                    <div class="label-field">

                                        <label>Name</label>

                                        <div class="label-readonly">

                                            {{ trim($profile->recipient_first_name . ' ' . $profile->recipient_last_name) }}

                                        </div>

                                    </div>



                                    <div class="label-field">

                                        <label>Email</label>

                                        <div class="label-readonly">{{ $profile->recipient_email ?: 'N/A' }}</div>

                                    </div>



                                    <div class="label-field wide">

                                        <label>Address</label>

                                        <div class="label-readonly">

                                            {{ $profile->recipient_street }}

                                            @if($profile->recipient_street2)

                                                , {{ $profile->recipient_street2 }}

                                            @endif

                                            , {{ $profile->recipient_city }},

                                            {{ $profile->recipient_state }}

                                            {{ $profile->recipient_zip }}

                                        </div>

                                    </div>

                                </div>

                            </div>



                            @if($record['can_edit_package'])

                                <form method="POST"

                                      action="{{ route('usps.label.edit', ['id' => $shipment->id]) }}"

                                      class="js-usps-confirm"

                                      data-title="Update USPS Label"

                                      data-message="Submit these eligible package changes to USPS? Postage may change.">

                                    @csrf



                                    <div class="label-section">

                                        <div class="label-section-title">Editable Package</div>



                                        <div class="label-grid label-grid-3">

                                            <div class="label-field">

                                                <label>Weight (lb)</label>

                                                <input type="number"

                                                       step="any"

                                                       min="0.01"

                                                       name="weight_lb"

                                                       value="{{ $profile->weight_lb }}"

                                                       required>

                                            </div>



                                            <div class="label-field">

                                                <label>Length (in)</label>

                                                <input type="number"

                                                       step="any"

                                                       min="0.1"

                                                       name="length_in"

                                                       value="{{ $profile->length_in }}"

                                                       required>

                                            </div>



                                            <div class="label-field">

                                                <label>Width (in)</label>

                                                <input type="number"

                                                       step="any"

                                                       min="0.1"

                                                       name="width_in"

                                                       value="{{ $profile->width_in }}"

                                                       required>

                                            </div>



                                            <div class="label-field">

                                                <label>Height (in)</label>

                                                <input type="number"

                                                       step="any"

                                                       min="0.1"

                                                       name="height_in"

                                                       value="{{ $profile->height_in }}"

                                                       required>

                                            </div>

                                        </div>



                                        <div class="label-form-actions">

                                            <button type="submit" class="label-btn label-btn-primary">

                                                <i class="fa fa-pencil"></i> Update Package

                                            </button>

                                        </div>

                                    </div>

                                </form>

                            @else

                                <div class="label-section">

                                    <div class="label-section-title">Package</div>



                                    <div class="label-grid">

                                        <div class="label-field">

                                            <label>Weight</label>

                                            <div class="label-readonly">{{ $profile->weight_lb }} lb</div>

                                        </div>



                                        <div class="label-field">

                                            <label>Dimensions</label>

                                            <div class="label-readonly">

                                                {{ $profile->length_in }} × {{ $profile->width_in }} × {{ $profile->height_in }} in

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            @endif



                            <div class="label-form-actions">

                                @if($record['has_saved_pdf'])

                                    <a href="{{ route('usps.label.view', ['id' => $shipment->id]) }}"

                                       target="_blank"

                                       class="label-btn label-btn-primary">

                                        <i class="fa fa-eye"></i> View Label

                                    </a>



                                    <a href="{{ route('usps.label.download', ['id' => $shipment->id]) }}"

                                       class="label-btn">

                                        <i class="fa fa-download"></i> Download

                                    </a>



                                    <a href="{{ route('usps.label.print', ['id' => $shipment->id]) }}"

                                       target="_blank"

                                       class="label-btn">

                                        <i class="fa fa-print"></i> Print

                                    </a>

                                @elseif($record['legacy_label_url'])

                                    <a href="{{ $record['legacy_label_url'] }}"

                                       target="_blank"

                                       class="label-btn label-btn-primary">

                                        <i class="fa fa-external-link"></i> Existing Label

                                    </a>

                                @endif



                                @if($record['tracking_url'])

                                    <a href="{{ $record['tracking_url'] }}"

                                       target="_blank"

                                       class="label-btn">

                                        <i class="fa fa-external-link"></i> Tracking

                                    </a>

                                @endif



                                @if($record['can_reprint'])

                                    <form method="POST"

                                          action="{{ route('usps.label.reprint', ['id' => $shipment->id]) }}"

                                          class="label-inline-form js-usps-confirm"

                                          data-title="USPS Reprint"

                                          data-message="Use one USPS API reprint for this label?">

                                        @csrf



                                        <button type="submit" class="label-btn">

                                            <i class="fa fa-refresh"></i> USPS Reprint

                                        </button>

                                    </form>

                                @endif



                                @if($record['can_cancel_refund'])

                                    <form method="POST"

                                          action="{{ route('usps.label.cancel-refund', ['id' => $shipment->id]) }}"

                                          class="label-inline-form js-usps-confirm"

                                          data-title="Cancel / Refund"

                                          data-message="Submit this unused USPS label for cancellation/refund?">

                                        @csrf



                                        <button type="submit" class="label-btn label-btn-danger">

                                            <i class="fa fa-ban"></i> Cancel / Refund

                                        </button>

                                    </form>

                                @endif



                                @if($record['can_replace'])

                                    <form method="POST"

                                          action="{{ route('usps.label.replace', ['id' => $shipment->id]) }}"

                                          class="label-inline-form js-usps-confirm"

                                          data-title="Prepare Replacement"

                                          data-message="Prepare a new editable draft for this shipment?">

                                        @csrf



                                        <button type="submit" class="label-btn label-btn-warning">

                                            <i class="fa fa-repeat"></i> Prepare Replacement

                                        </button>

                                    </form>

                                @endif

                            </div>



                        @endif

                    </div>

                </div>

            </div>

        @endforeach

    </div>

</div>



@endsection



@push('js')

<script>

    const labelFeeState = {};



    const sharedBulkFields = [

        'mailing_date',

        'mail_class',

        'weight_lb',

        'length_in',

        'width_in',

        'height_in'

    ];



    function getBulkSelectedIds() {
        const ids = [];

        $('.bulk-record-select:checked:not(:disabled)').each(function () {
            ids.push(String(this.value));
        });

        return ids;
    }

    function getBulkSelectedDraftIds() {
        const ids = [];

        $('.bulk-record-select:checked:not(:disabled)[data-is-draft="1"]').each(function () {
            ids.push(String(this.value));
        });

        return ids;
    }

    function getBulkSelectedPdfIds() {
        const ids = [];

        $('.bulk-record-select:checked:not(:disabled)[data-has-pdf="1"]').each(function () {
            ids.push(String(this.value));
        });

        return ids;
    }

    function updateBulkSelectAllState() {
        const $boxes = $('.bulk-record-select:not(:disabled)');
        const checked = $boxes.filter(':checked').length;

        $('#bulk_edit_select_all')
            .prop('checked', $boxes.length > 0 && checked === $boxes.length)
            .prop('indeterminate', checked > 0 && checked < $boxes.length);
    }

    function updateBulkFileActionState() {
        const pdfCount = getBulkSelectedPdfIds().length;

        $('#label_bulk_zip_btn').prop('disabled', pdfCount === 0);
        $('#label_bulk_pdf_btn').prop('disabled', pdfCount === 0);

        $('#label_bulk_zip_text').text(
            'Download Selected ZIP (' + pdfCount + ')'
        );

        $('#label_bulk_pdf_text').text(
            'Download Selected PDF (' + pdfCount + ')'
        );
    }

    $(document).on('change', '#bulk_edit_select_all', function () {
        $('.bulk-record-select:not(:disabled)').prop('checked', this.checked);

        updateBulkSelectAllState();
        updateBulkFileActionState();
        updateBulkFeeSummary();
    });

    $(document).on('click change', '.bulk-record-select', function (e) {
        e.stopPropagation();

        updateBulkSelectAllState();
        updateBulkFileActionState();
        updateBulkFeeSummary();
    });

    function toggleBulkLabelCard($header) {

        const target = $header.data('target');



        if (!target) {

            return;

        }



        const $content = $(target);

        const $icon = $header.find('.label-collapse-btn i');

        const isOpen = $content.is(':visible');



        if (isOpen) {

            $content.stop(true, true).slideUp(180);



            $header.attr('aria-expanded', 'false');



            $icon

                .removeClass('fa-chevron-up')

                .addClass('fa-chevron-down');



            $header.find('.label-collapse-btn')

                .attr('aria-label', 'Expand order')

                .attr('title', 'Expand order');

        } else {

            $content.stop(true, true).slideDown(180);



            $header.attr('aria-expanded', 'true');



            $icon

                .removeClass('fa-chevron-down')

                .addClass('fa-chevron-up');



            $header.find('.label-collapse-btn')

                .attr('aria-label', 'Collapse order')

                .attr('title', 'Collapse order');

        }

    }



    $(document).on('click', '.label-card-header.bulk-collapsible', function (e) {

        if ($(e.target).closest('.bulk-record-select').length) {

            return;

        }



        e.preventDefault();

        toggleBulkLabelCard($(this));

    });



    $(document).on('keydown', '.label-card-header.bulk-collapsible', function (e) {

        if (e.key === 'Enter' || e.key === ' ') {

            if ($(e.target).is('.bulk-record-select')) {

                return;

            }



            e.preventDefault();

            toggleBulkLabelCard($(this));

        }

    });



    function setLabelFeeState(form, state, amount, message) {

        const $form = $(form);

        const shipmentId = String($form.data('shipment-id'));

        const $amount = $('#label-fee-amount-' + shipmentId);

        const $message = $('#label-fee-message-' + shipmentId);

        const $header = $('#label-header-fee-' + shipmentId);

        const $createButton = $form.find('.js-create-label');



        if (!labelFeeState[shipmentId]) {

            labelFeeState[shipmentId] = {};

        }



        labelFeeState[shipmentId].state = state;

        labelFeeState[shipmentId].amount = amount === null ? null : parseFloat(amount);
        labelFeeState[shipmentId].message = message || null;



        $header.removeClass('loading stale error');

        $createButton.prop('disabled', state !== 'ready');



        if (state === 'loading') {

            $form.attr('data-quote-ready', '0');

            $amount.text('Checking...');

            $message.text(message || 'Getting the current USPS commercial rate.');



            $header

                .addClass('loading')

                .html('<i class="fa fa-spinner fa-spin"></i> Checking fee...');

        } else if (state === 'ready') {

            $form.attr('data-quote-ready', '1');



            const formatted = '$' + parseFloat(amount).toFixed(2);



            $amount.text(formatted);

            $message.text(message || 'Estimated USPS postage for the current label details.');

            $header.text('USPS ' + formatted);

        } else if (state === 'stale') {

            $form.attr('data-quote-ready', '0');

            $amount.text('Refresh required');

            $message.text(message || 'Details changed. Refreshing the USPS fee.');



            $header

                .addClass('stale')

                .html('<i class="fa fa-refresh"></i> Refresh fee');

        } else {

            $form.attr('data-quote-ready', '0');

            $amount.text('Unavailable');

            $message.text(message || 'Unable to get a USPS postage quote.');



            $header

                .addClass('error')

                .html('<i class="fa fa-exclamation-triangle"></i> Fee unavailable');

        }



        updateBulkFeeSummary();

    }



    function clearLabelValidationErrors(form) {

        $(form).find('.is-invalid').removeClass('is-invalid');

        $(form).find('.label-field-error').remove();

    }



    function showLabelValidationError(form, field, message) {

        if (!field) {

            return;

        }



        const $input = $(form).find('[name="' + field + '"]').first();



        if (!$input.length) {

            return;

        }



        $input.addClass('is-invalid');



        const $field = $input.closest('.label-field');



        $field.find('.label-field-error').remove();

        $field.append(

            $('<div class="label-field-error"></div>').text(message || 'Invalid value.')

        );



        const $content = $input.closest('.label-card-content');



        if ($content.length && !$content.is(':visible')) {

            const $header = $content.siblings('.label-card-header.bulk-collapsible');



            if ($header.length) {

                toggleBulkLabelCard($header);

            } else {

                $content.show();

            }

        }

    }



    function friendlyValidationFallback(field, message) {

        if (message && message.indexOf('validation.') !== 0) {

            return message;

        }



        const fallback = {

            recipient_state: 'Recipient state must be exactly 2 letters, for example CA.',

            recipient_zip: 'Recipient ZIP code must be 5 digits or ZIP+4.',

            recipient_email: 'Recipient email must be a valid email address.',

            weight_lb: 'Package weight must be between 0.01 and 70 lb.',

            length_in: 'Package length must be between 0.1 and 130 in.',

            width_in: 'Package width must be between 0.1 and 130 in.',

            height_in: 'Package height must be between 0.1 and 130 in.',

            mail_class: 'Please select a supported USPS mail class.',

            mailing_date: 'Shipping date must be today or a future date.'

        };



        return fallback[field] || 'Please check this label field and try again.';

    }



    async function quoteLabelFee(form) {

        if (!form) {

            return false;

        }



        clearLabelValidationErrors(form);



        if (!form.checkValidity()) {

            setLabelFeeState(

                form,

                'error',

                null,

                'Complete all required label fields before checking the USPS fee.'

            );



            return false;

        }



        setLabelFeeState(

            form,

            'loading',

            null,

            'Getting the current USPS commercial rate.'

        );



        try {

            const response = await fetch($(form).data('quote-url'), {

                method: 'POST',

                headers: {

                    'Accept': 'application/json',

                    'X-Requested-With': 'XMLHttpRequest'

                },

                body: new FormData(form)

            });



            const data = await response.json();



            if (!response.ok || !data.success) {

                let field = data.field || null;

                let message = data.message || 'Unable to get USPS postage.';



                if (data.errors) {

                    const firstKey = field || Object.keys(data.errors)[0];



                    if (

                        firstKey &&

                        data.errors[firstKey] &&

                        data.errors[firstKey][0]

                    ) {

                        field = firstKey;

                        message = data.errors[firstKey][0];

                    }

                }



                message = friendlyValidationFallback(field, message);



                if (field) {

                    showLabelValidationError(form, field, message);

                }



                setLabelFeeState(form, 'error', null, message);



                return false;

            }



            const serviceText = data.service ? data.service : 'USPS';



            setLabelFeeState(

                form,

                'ready',

                data.estimated_postage,

                serviceText + ' — estimated postage before purchase.'

            );



            return true;

        } catch (error) {

            setLabelFeeState(

                form,

                'error',

                null,

                error && error.message

                    ? error.message

                    : 'Unable to get USPS postage.'

            );



            return false;

        }

    }



    function queueLabelQuote(form) {

        if (!form) {

            return;

        }



        clearTimeout(form._labelFeeTimer);



        form._labelFeeTimer = setTimeout(function () {

            quoteLabelFee(form);

        }, 500);

    }



    function markDraftFormChanged(form, fieldName) {

        if (!form) {

            return;

        }



        const $form = $(form);



        $form.attr('data-dirty', '1');



        const $input = $form.find('[name="' + fieldName + '"]').first();



        $input.removeClass('is-invalid');

        $input.closest('.label-field').find('.label-field-error').remove();



        setLabelFeeState(

            form,

            'stale',

            null,

            'Details changed. Refreshing the USPS fee.'

        );



        queueLabelQuote(form);

    }



    function copySharedFieldToCheckedDrafts(sourceForm, fieldName, value) {

        const sourceId = String($(sourceForm).data('shipment-id'));

        const selectedIds = getBulkSelectedDraftIds();



        if (selectedIds.indexOf(sourceId) === -1) {

            return;

        }



        selectedIds.forEach(function (shipmentId) {

            if (shipmentId === sourceId) {

                return;

            }



            const targetForm = $('.label-create-form[data-shipment-id="' + shipmentId + '"]').get(0);



            if (!targetForm) {

                return;

            }



            const $target = $(targetForm).find('[name="' + fieldName + '"]').first();



            if (!$target.length) {

                return;

            }



            $target.val(value);

            $target.addClass('shared-change-flash');



            setTimeout(function () {

                $target.removeClass('shared-change-flash');

            }, 750);



            markDraftFormChanged(targetForm, fieldName);

        });

    }



    $(document).on(

        'input change',

        '.label-create-form input:not([name="_token"]):not([name="shipment_id"]), ' +

        '.label-create-form select, .label-create-form textarea',

        function () {

            const form = $(this).closest('.label-create-form').get(0);

            const fieldName = this.name;



            if (!form || !fieldName) {

                return;

            }



            markDraftFormChanged(form, fieldName);



            if (sharedBulkFields.indexOf(fieldName) !== -1) {

                copySharedFieldToCheckedDrafts(form, fieldName, $(this).val());

            }

        }

    );



    $(document).on('click', '.js-refresh-label-fee', function (e) {

        e.preventDefault();



        const form = $(this).closest('.label-create-form').get(0);



        quoteLabelFee(form);

    });



    function getSelectedDraftForms() {
        const forms = [];

        getBulkSelectedDraftIds().forEach(function (shipmentId) {
            const form = $('.label-create-form[data-shipment-id="' + shipmentId + '"]').get(0);

            if (form) {
                forms.push(form);
            }
        });

        return forms;
    }

    function updateBulkFeeSummary() {
        updateBulkFileActionState();

        const selectedForms = getSelectedDraftForms();
        const selectedCount = selectedForms.length;

        const $bulkButton = $('#label_bulk_create_btn');
        const $bulkText = $('#label_bulk_create_text');
        const $bulkTotal = $('#label_bulk_fee_total');

        if (!$bulkButton.length) {
            return;
        }

        $bulkText.text('Create Selected Labels (' + selectedCount + ')');

        if (!selectedCount) {
            $bulkButton.prop('disabled', true);

            if ($bulkTotal.length) {
                const selectedPdfCount = getBulkSelectedPdfIds().length;

                if (selectedPdfCount > 0) {
                    $bulkTotal.text(
                        selectedPdfCount +
                        ' saved label PDF(s) selected for ZIP/PDF download.'
                    );
                } else {
                    $bulkTotal.text(
                        'Select draft orders for creation, or created labels for PDF/ZIP download.'
                    );
                }
            }

            return;
        }

        let total = 0;
        let readyCount = 0;
        let dirtyCount = 0;

        selectedForms.forEach(function (form) {
            const id = String($(form).data('shipment-id'));
            const state = labelFeeState[id];

            if (
                state &&
                state.state === 'ready' &&
                state.amount !== null
            ) {
                total += parseFloat(state.amount);
                readyCount++;
            }

            if ($(form).attr('data-dirty') === '1') {
                dirtyCount++;
            }
        });

        // Available whenever at least one draft is checked.
        $bulkButton.prop('disabled', false);

        if (!$bulkTotal.length) {
            return;
        }

        if (readyCount === selectedCount) {
            let text =
                'Selected USPS postage total: $' +
                total.toFixed(2) +
                ' for ' +
                selectedCount +
                ' label(s).';

            if (dirtyCount > 0) {
                text +=
                    ' Changed selected draft(s) will be saved automatically before creation.';
            }

            $bulkTotal.text(text);
        } else {
            $bulkTotal.text(
                'Selected labels: ' +
                selectedCount +
                '. USPS fees ready: ' +
                readyCount +
                '/' +
                selectedCount +
                '.'
            );
        }
    }

    function expandDraftCardForForm(form) {
        const $content = $(form).closest('.label-card-content');

        if (!$content.length || $content.is(':visible')) {
            return;
        }

        const $header = $content.siblings(
            '.label-card-header.bulk-collapsible'
        );

        if ($header.length) {
            toggleBulkLabelCard($header);
        } else {
            $content.show();
        }
    }

    async function saveSelectedDraftForm(form) {
        if ($(form).attr('data-dirty') !== '1') {
            return {
                success: true,
                skipped: true
            };
        }

        const response = await fetch($(form).data('save-url'), {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new FormData(form)
        });

        let data = {};

        try {
            data = await response.json();
        } catch (e) {
            data = {};
        }

        if (!response.ok || !data.success) {
            let message =
                data.message ||
                'Unable to save the selected USPS label draft.';

            if (data.errors) {
                const firstKey = Object.keys(data.errors)[0];

                if (
                    firstKey &&
                    data.errors[firstKey] &&
                    data.errors[firstKey][0]
                ) {
                    message = data.errors[firstKey][0];
                }
            }

            throw new Error(message);
        }

        $(form).attr('data-dirty', '0');

        return data;
    }

    function getSelectedPostageTotal(forms) {
        let total = 0;

        forms.forEach(function (form) {
            const id = String($(form).data('shipment-id'));
            const state = labelFeeState[id];

            if (
                state &&
                state.state === 'ready' &&
                state.amount !== null
            ) {
                total += parseFloat(state.amount);
            }
        });

        return total;
    }

    function setBulkCreateBusy(busy, text) {
        const $button = $('#label_bulk_create_btn');
        const $text = $('#label_bulk_create_text');

        $button.prop('disabled', !!busy);

        if (text) {
            $text.text(text);
        } else if (!busy) {
            $text.text(
                'Create Selected Labels (' +
                getBulkSelectedDraftIds().length +
                ')'
            );
        }
    }

    async function confirmSelectedBulkCreate(count, total) {
        const message =
            'Create ' +
            count +
            ' selected USPS label(s)? Estimated USPS postage total: $' +
            total.toFixed(2) +
            '.';

        if (!window.Swal) {
            return window.confirm(message);
        }

        const result = await Swal.fire({
            title: 'Create Selected USPS Labels',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Create ' + count + ' Label(s)'
        });

        return !!(result.isConfirmed || result.value);
    }

    function getFirstInvalidFieldLabel(form) {
        const invalid = form.querySelector(':invalid');

        if (!invalid) {
            return 'Invalid or missing label details';
        }

        const label = $(invalid)
            .closest('.label-field')
            .find('label')
            .first()
            .text()
            .trim();

        return label
            ? label + ' is invalid or incomplete'
            : 'Invalid or missing label details';
    }

    function getBulkOrderLabel(form) {
        const orderText = $(form)
            .closest('.label-card')
            .find('.label-order')
            .first()
            .text()
            .trim();

        return orderText || ('Shipment #' + String($(form).data('shipment-id')));
    }

    function formatSkippedBulkReasons(skipped) {
        if (!skipped.length) {
            return '';
        }

        const visible = skipped.slice(0, 4).map(function (item) {
            return item.order + ': ' + item.reason;
        });

        let text = visible.join(' | ');

        if (skipped.length > visible.length) {
            text += ' | +' + (skipped.length - visible.length) + ' more skipped';
        }

        return text;
    }

    async function confirmEligibleBulkCreate(eligibleForms, skipped) {
        const total = getSelectedPostageTotal(eligibleForms);
        const count = eligibleForms.length;

        let message =
            'Create ' +
            count +
            ' valid selected USPS label(s)? Estimated USPS postage total: $' +
            total.toFixed(2) +
            '.';

        if (skipped.length) {
            message +=
                ' ' +
                skipped.length +
                ' selected record(s) will be skipped because they have errors.';
        }

        if (!window.Swal) {
            return window.confirm(message);
        }

        let html =
            '<div style="text-align:left;">' +
                '<div style="margin-bottom:8px;">' +
                    'Ready to create: <strong>' + count + '</strong><br>' +
                    'Estimated USPS postage: <strong>$' + total.toFixed(2) + '</strong>' +
                '</div>';

        if (skipped.length) {
            html +=
                '<div style="padding:8px 10px;background:#fff7e6;border-radius:6px;font-size:12px;">' +
                    '<strong>Skipped: ' + skipped.length + '</strong><br>' +
                    $('<div>').text(formatSkippedBulkReasons(skipped)).html() +
                '</div>';
        }

        html += '</div>';

        const result = await Swal.fire({
            title: 'Create Selected USPS Labels',
            html: html,
            icon: skipped.length ? 'warning' : 'question',
            showCancelButton: true,
            confirmButtonText: 'Create ' + count + ' Label(s)'
        });

        return !!(result.isConfirmed || result.value);
    }

    $(document).on(
        'submit',
        '#label_bulk_create_form',
        async function (e) {
            e.preventDefault();

            const bulkForm = this;
            const selectedForms = getSelectedDraftForms();

            if (!selectedForms.length) {
                if (window.Swal) {
                    Swal.fire(
                        'USPS Labels',
                        'Select at least one draft order first.',
                        'info'
                    );
                } else {
                    alert('Select at least one draft order first.');
                }

                updateBulkFeeSummary();

                return false;
            }

            const eligibleForms = [];
            const skipped = [];

            /*
             * Process checked records one by one.
             * Any error skips only that record and the loop continues.
             */
            for (let i = 0; i < selectedForms.length; i++) {
                const form = selectedForms[i];
                const order = getBulkOrderLabel(form);

                setBulkCreateBusy(
                    true,
                    'Checking ' +
                    (i + 1) +
                    '/' +
                    selectedForms.length +
                    '...'
                );

                // Browser validation failure -> skip this order.
                if (!form.checkValidity()) {
                    skipped.push({
                        form: form,
                        order: order,
                        reason: getFirstInvalidFieldLabel(form)
                    });

                    continue;
                }

                // USPS fee error -> skip this order.
                let quoted = false;

                try {
                    quoted = await quoteLabelFee(form);
                } catch (error) {
                    quoted = false;
                }

                if (!quoted) {
                    const shipmentId = String($(form).data('shipment-id'));
                    const state = labelFeeState[shipmentId];

                    skipped.push({
                        form: form,
                        order: order,
                        reason:
                            state && state.message
                                ? state.message
                                : 'USPS postage fee could not be calculated'
                    });

                    continue;
                }

                // Draft-save error -> skip this order.
                try {
                    await saveSelectedDraftForm(form);
                } catch (error) {
                    skipped.push({
                        form: form,
                        order: order,
                        reason:
                            error && error.message
                                ? error.message
                                : 'Draft could not be saved'
                    });

                    continue;
                }

                eligibleForms.push(form);
            }

            setBulkCreateBusy(false);
            updateBulkFeeSummary();

            /*
             * If all selected records failed, don't submit anything.
             */
            if (!eligibleForms.length) {
                const reasonText = formatSkippedBulkReasons(skipped);

                if (window.Swal) {
                    Swal.fire({
                        title: 'No Labels Can Be Created',
                        text:
                            reasonText ||
                            'All selected records contain errors and were skipped.',
                        icon: 'error'
                    });
                } else {
                    alert(
                        reasonText ||
                        'All selected records contain errors and were skipped.'
                    );
                }

                if (skipped.length && skipped[0].form) {
                    expandDraftCardForForm(skipped[0].form);
                    skipped[0].form.reportValidity();
                }

                return false;
            }

            /*
             * Confirm only the records that survived validation/quote/save.
             */
            const confirmed = await confirmEligibleBulkCreate(
                eligibleForms,
                skipped
            );

            if (!confirmed) {
                updateBulkFeeSummary();

                return false;
            }

            /*
             * Submit ONLY eligible records.
             * Skipped records are not sent to bulkCreateLabels().
             */
            $(bulkForm)
                .find('input[name="shipment_ids[]"], input[name="precheck_errors[]"]')
                .remove();

            eligibleForms.forEach(function (form) {
                $('<input>', {
                    type: 'hidden',
                    name: 'shipment_ids[]',
                    value: String($(form).data('shipment-id'))
                }).appendTo(bulkForm);
            });

            /*
             * Send client-side skipped/error details too, so the final result
             * after the whole batch completes can show every error.
             */
            skipped.forEach(function (item) {
                $('<input>', {
                    type: 'hidden',
                    name: 'precheck_errors[]',
                    value: item.order + ': ' + item.reason
                }).appendTo(bulkForm);
            });

            setBulkCreateBusy(
                true,
                'Creating ' +
                eligibleForms.length +
                ' Label(s)...'
            );

            /*
             * Native submit bypasses this async handler.
             * Server-side bulkCreateLabels() also catches a USPS purchase
             * error for one shipment and continues with the rest.
             */
            bulkForm.submit();

            return false;
        }
    );

    function prepareSelectedPdfDownloadForm(form) {
        const selectedIds = getBulkSelectedPdfIds();

        if (!selectedIds.length) {
            if (window.Swal) {
                Swal.fire(
                    'USPS Labels',
                    'Select at least one created label with a saved PDF.',
                    'info'
                );
            } else {
                alert('Select at least one created label with a saved PDF.');
            }

            return false;
        }

        $(form).find('input[name="shipment_ids[]"]').remove();

        selectedIds.forEach(function (shipmentId) {
            $('<input>', {
                type: 'hidden',
                name: 'shipment_ids[]',
                value: shipmentId
            }).appendTo(form);
        });

        return true;
    }

    $(document).on('submit', '#label_bulk_zip_form', function (e) {
        if (!prepareSelectedPdfDownloadForm(this)) {
            e.preventDefault();
            return false;
        }

        return true;
    });

    $(document).on('submit', '#label_bulk_pdf_form', function (e) {
        if (!prepareSelectedPdfDownloadForm(this)) {
            e.preventDefault();
            return false;
        }

        return true;
    });

    $(document).on('submit', '.js-usps-confirm', function (e) {

        if (this.dataset.confirmed === '1') {

            return true;

        }



        if (!window.Swal) {

            return window.confirm(

                $(this).data('message') || 'Continue?'

            );

        }



        e.preventDefault();



        const form = this;



        Swal.fire({

            title: $(form).data('title') || 'USPS Label',

            text: $(form).data('message') || 'Continue?',

            icon: 'warning',

            showCancelButton: true,

            confirmButtonText: 'Continue'

        }).then(function (result) {

            if (result.isConfirmed || result.value) {

                form.dataset.confirmed = '1';

                form.submit();

            }

        });



        return false;

    });



    $(document).on('click', '.js-create-label', function (e) {

        const button = this;

        const form = button.form;



        if (!form || !form.reportValidity()) {

            return;

        }



        if ($(form).attr('data-quote-ready') !== '1') {

            e.preventDefault();



            if (window.Swal) {

                Swal.fire(

                    'USPS Postage Required',

                    'Refresh the USPS postage fee before creating this label.',

                    'info'

                );

            } else {

                alert('Refresh the USPS postage fee before creating this label.');

            }



            return;

        }



        const shipmentId = String($(form).data('shipment-id'));

        const quote = labelFeeState[shipmentId];

        const quotedAmount = quote && quote.amount !== null

            ? '$' + parseFloat(quote.amount).toFixed(2)

            : 'Unavailable';



        const message =

            'Estimated USPS postage: ' + quotedAmount +

            '. Create USPS postage for this order now?';



        if (!window.Swal) {

            if (!window.confirm(message)) {

                e.preventDefault();

            }



            return;

        }



        e.preventDefault();



        Swal.fire({

            title: 'Create USPS Label',

            text: message,

            icon: 'warning',

            showCancelButton: true,

            confirmButtonText: 'Create Label'

        }).then(function (result) {

            if (result.isConfirmed || result.value) {

                if (typeof form.requestSubmit === 'function') {

                    form.requestSubmit(button);

                } else {

                    button.classList.remove('js-create-label');

                    button.click();

                }

            }

        });

    });



    function showCompletedBulkResult() {
        @if(session('usps_bulk_result'))
            const result = @json(session('usps_bulk_result'));
            const errors = Array.isArray(result.errors) ? result.errors : [];
            const created = parseInt(result.created || 0, 10);
            const failed = parseInt(result.failed || errors.length || 0, 10);

            let html =
                '<div style="text-align:left;">' +
                    '<div style="margin-bottom:10px;font-size:14px;">' +
                        '<strong>Created:</strong> ' + created + '<br>' +
                        '<strong>Errors / Skipped:</strong> ' + failed +
                    '</div>';

            if (errors.length) {
                html +=
                    '<div style="max-height:300px;overflow:auto;border:1px solid #f3d3d3;' +
                    'background:#fff8f8;border-radius:7px;padding:8px 10px;">';

                errors.forEach(function (error) {
                    html +=
                        '<div style="padding:6px 0;border-bottom:1px solid #f2e5e5;' +
                        'font-size:12px;word-break:break-word;">' +
                            $('<div>').text(error).html() +
                        '</div>';
                });

                html += '</div>';
            }

            html += '</div>';

            if (window.Swal) {
                Swal.fire({
                    title: errors.length
                        ? 'Bulk Label Creation Completed - Some Orders Failed'
                        : 'Bulk Label Creation Completed',
                    html: html,
                    icon: errors.length ? 'warning' : 'success',
                    confirmButtonText: 'OK',
                    width: 720
                });
            } else {
                let text =
                    'Created: ' + created +
                    '\nErrors / Skipped: ' + failed;

                if (errors.length) {
                    text += '\n\n' + errors.join('\n');
                }

                alert(text);
            }
        @endif
    }

    $(document).ready(function () {

        updateBulkSelectAllState();
        updateBulkFileActionState();
        updateBulkFeeSummary();

        // Show the completed bulk result AFTER the controller has processed
        // every selected order and redirected back to this page.
        showCompletedBulkResult();



        const forms = $('.label-create-form').toArray();



        /*

         * Quote sequentially to avoid hitting USPS with all rate requests

         * at exactly the same moment on a bulk page.

         */

        (async function () {

            for (let i = 0; i < forms.length; i++) {

                await quoteLabelFee(forms[i]);

            }

        })();

    });

</script>

@endpush



@section('content')

    @include('pages.stores.layouts.sidebar', [

        'sub_content' => 'overview',

        'store' => $store

    ])

@endsection
