@extends('layouts.app', ['activePage' => 'Team Stores', 'titlePage' => __('Team Stores')])

@section('content')
<style>
    .usps-import-card {
        background:#fff;
        border:1px solid #e9ecef;
        border-radius:10px;
        box-shadow:0 2px 10px rgba(0,0,0,.04);
        padding:20px;
        margin-bottom:20px;
    }

    .usps-import-title {
        margin:0 0 6px;
        font-size:20px;
        font-weight:700;
        color:#32325d;
    }

    .usps-import-subtitle {
        color:#8898aa;
        font-size:12px;
        margin-bottom:18px;
    }

    .usps-import-table-wrap {
        width:100%;
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
    }

    .usps-import-table {
        min-width:1350px;
        margin-bottom:0;
    }

    .usps-import-table th {
        background:#717070;
        color:#fff;
        font-size:11px;
        font-weight:700;
        white-space:nowrap;
        vertical-align:middle !important;
    }

    .usps-import-table td {
        vertical-align:middle !important;
        min-width:120px;
    }

    .usps-import-table .form-control {
        min-width:120px;
        font-size:12px;
        height:36px;
    }

    .usps-import-table input[type="file"] {
        min-width:220px;
        font-size:11px;
    }

    .usps-import-badge {
        display:inline-flex;
        align-items:center;
        border-radius:14px;
        padding:4px 8px;
        font-size:10px;
        font-weight:700;
        white-space:nowrap;
    }

    .usps-import-badge.success {
        background:#e9fbf5;
        color:#117a65;
    }

    .usps-import-badge.warning {
        background:#fff7d6;
        color:#8a5a00;
    }

    .usps-import-badge.danger {
        background:#fee2e2;
        color:#991b1b;
    }

    .usps-import-actions {
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:10px;
        flex-wrap:wrap;
        margin-top:15px;
    }

    .usps-import-header-list {
        display:flex;
        flex-wrap:wrap;
        gap:6px;
        margin-top:8px;
    }

    .usps-import-header-chip {
        background:#f3f4f6;
        color:#525f7f;
        border-radius:12px;
        padding:4px 8px;
        font-size:10px;
    }
</style>

<div class="container-fluid" style="padding-top:20px;padding-bottom:40px;">
    <div class="usps-import-card">
        <h3 class="usps-import-title">Import USPS Shipping History</h3>
        <div class="usps-import-subtitle">
            Upload XLSX, XLS, or CSV. The file is previewed first; nothing is saved until you click Save All Imported Labels.
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(session('import_errors'))
            <div class="alert alert-danger">
                <strong>Import Errors:</strong>
                <ul style="margin-bottom:0;">
                    @foreach(session('import_errors') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ route('admin.usps-labels.import.store') }}"
              enctype="multipart/form-data">
            @csrf

            <div class="row align-items-end">
                <div class="col-md-9">
                    <div class="form-group mb-0">
                        <label>USPS Shipping History File</label>
                        <input type="file"
                               name="xlsx_file"
                               class="form-control"
                               accept=".xlsx,.xls,.csv"
                               required>

                        @error('xlsx_file')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fa fa-search"></i>
                        Upload & Preview
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if(is_array($previewRows) && count($previewRows))
        <div class="usps-import-card">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;flex-wrap:wrap;">
                <div>
                    <h4 class="usps-import-title" style="font-size:17px;">
                        Review Imported Data
                    </h4>
                    <div class="usps-import-subtitle" style="margin-bottom:0;">
                        {{ count($previewRows) }} row(s) from <strong>{{ $sourceFileName }}</strong>. Edit any value and optionally attach a PDF label to each row.
                    </div>
                </div>

                <div style="font-size:11px;color:#717070;">
                    Uncheck a row to skip it.
                </div>
            </div>

            @if(!empty($detectedHeaders))
                <div style="margin-top:12px;font-size:11px;color:#717070;">
                    Detected columns:
                    <div class="usps-import-header-list">
                        @foreach($detectedHeaders as $header)
                            <span class="usps-import-header-chip">{{ $header }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST"
                  action="{{ route('admin.usps-labels.import.save') }}"
                  enctype="multipart/form-data"
                  id="usps-import-save-form">
                @csrf

                <div class="usps-import-table-wrap" style="margin-top:18px;">
                    <table class="table table-bordered usps-import-table">
                        <thead>
                            <tr>
                                <th style="min-width:55px;text-align:center;">Save</th>
                                <th>Source Row</th>
                                <th>Reference Number</th>
                                <th>Tracking Number</th>
                                <th>Service Type</th>
                                <th>Cost</th>
                                <th>Date</th>
                                <th>Order</th>
                                <th>Shipment</th>
                                <th>Existing PDF</th>
                                <th>Upload / Replace Label PDF</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($previewRows as $row)
                                @php
                                    $i = $row['index'];
                                @endphp
                                <tr>
                                    <td style="text-align:center;">
                                        <input type="checkbox"
                                               name="rows[{{ $i }}][include]"
                                               value="1"
                                               checked>
                                    </td>

                                    <td>
                                        #{{ $row['source_row'] }}
                                    </td>

                                    <td>
                                        <input type="text"
                                               class="form-control"
                                               name="rows[{{ $i }}][reference_number]"
                                               value="{{ $row['reference_number'] }}"
                                               required>
                                    </td>

                                    <td>
                                        <input type="text"
                                               class="form-control"
                                               name="rows[{{ $i }}][tracking_number]"
                                               value="{{ $row['tracking_number'] }}"
                                               required>
                                    </td>

                                    <td>
                                        <input type="text"
                                               class="form-control"
                                               name="rows[{{ $i }}][service_type]"
                                               value="{{ $row['service_type'] }}">
                                    </td>

                                    <td>
                                        <input type="number"
                                               class="form-control"
                                               name="rows[{{ $i }}][cost]"
                                               value="{{ $row['cost'] }}"
                                               min="0"
                                               step="0.01">
                                    </td>

                                    <td>
                                        <input type="date"
                                               class="form-control"
                                               name="rows[{{ $i }}][date]"
                                               value="{{ $row['date'] }}">
                                    </td>

                                    <td>
                                        @if($row['order_exists'])
                                            <span class="usps-import-badge success">
                                                <i class="fa fa-check" style="margin-right:4px;"></i>
                                                Found
                                            </span>
                                        @else
                                            <span class="usps-import-badge danger">
                                                <i class="fa fa-times" style="margin-right:4px;"></i>
                                                Not Found
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($row['shipment_exists'])
                                            <span class="usps-import-badge warning">
                                                Update #{{ $row['existing_shipment_id'] }}
                                            </span>
                                        @else
                                            <span class="usps-import-badge success">
                                                Create New
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($row['existing_label'])
                                            <span class="usps-import-badge success">
                                                PDF Saved
                                            </span>
                                        @else
                                            <span class="usps-import-badge warning">
                                                No PDF
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <input type="file"
                                               name="label_files[{{ $i }}]"
                                               accept="application/pdf,.pdf">
                                        <div style="font-size:9px;color:#8898aa;margin-top:4px;">
                                            Optional. Uploading replaces the saved PDF for this shipment.
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="usps-import-actions">
                    <div style="font-size:11px;color:#8898aa;">
                        Tracking URL is generated automatically from the tracking number.
                    </div>

                    <button type="submit"
                            class="btn btn-success"
                            id="save-usps-import-btn">
                        <i class="fa fa-save"></i>
                        Save All Imported Labels
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection

@push('js')
<script>
    $('#usps-import-save-form').on('submit', function () {
        $('#save-usps-import-btn')
            .prop('disabled', true)
            .html('<i class="fa fa-spinner fa-spin"></i> Saving...');
    });
</script>
@endpush
