@extends('layouts.app', ['activePage' => 'org_wise_product_report', 'titlePage' => __('Organization Wise Product Report')])

@section('content')
<style>
    .content-position {
        padding-left: 15px !important;
        padding-right: 15px !important;
    }
    .print_btn {
        padding-right: 3%;
        padding-left: 2%;
    }
    .table_header_text {
        color: white;
        height: 40px;
    }
    .order_sammary_table {
        padding-top: 5px;
        overflow-x: auto;
        padding-left: 15PX;
        padding-right: 15PX;
        padding-bottom: 15px;
    }
    .production_text {
        padding-left: 10px;
        color: rgb(94, 94, 94);
    }
    .filter_row {
        margin-left: unset;
        padding-left: 8px;
        padding-right: 9px;
        background-color: #F8F8F8;
        border: 1px solid#DEDEDE;
        border-radius: 5px;
        padding-top: 2px;
    }
    .date_selection {
        background-color: transparent;
        padding: unset;
        border: unset;
        color: #47D6B6;
        font-size: 11px;
    }
    .date_p {
        margin: unset;
        font-size: 11px;
        color: black;
        font-weight: 500;
    }
    .filter_btn {
        padding: 5px;
        text-align: center;
        width: 70px;
        background-color: #2dce89;
        border: none;
        cursor: pointer;
        color: white !important;
    }
    .excel_btn {
        padding: 5px;
        text-align: center;
        width: 70px;
        border: 1px solid#DEDEDE;
        /* background-color: #c9cecc; */
        cursor: pointer;
        color: rgb(0, 0, 0) !important;
    }

    .table-bottom-details2 {
        color: #020202
    }
    .header-layout {
        margin-bottom: 2rem !important;
    }
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        display: none;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
    }
    .select-border-style{
        border: 1px solid #b3b3b3 !important;
        border-radius: 0rem !important;
    }
    .select2-selection--single{
        background-color: #F8F8F8 !important;
    }
    .d_flex_and_align_center{
        display: flex;
        align-items: center;
    }
    .select-width-style .select2.select2-container.select2-container--default{
        width: 8rem !important;
    }
    .select-width-style-item .select2.select2-container.select2-container--default{
        width: 10rem !important;
    }
    .page-item .page-link, .page-item span {
        border-radius: 0 !important;
        font-size: 0.7rem;
    }
    .page-item.active .page-link {
        z-index: 1;
        color: grey;
        border-color: #cccccc;
        background-color: #e9e9e9;
        box-shadow:none;
    }
    .table thead th, .table tbody td {
        padding-top: 0;
        padding-bottom: 0;
    }
    .table tbody td {
        padding-top: 7.5px;
        padding-bottom: 7.5px;
    }
    table.dataTable thead .sorting:before, table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:before, table.dataTable thead .sorting_desc_disabled:after {
        bottom: 0.6rem !important;
    }
    table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
        right: .7rem !important;
    }
    table.dataTable thead .sorting:before, table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:before, table.dataTable thead .sorting_desc_disabled:after {
    bottom: .65em;
    }
    table.dataTable thead .sorting:before,table.dataTable thead .sorting_asc:before,table.dataTable thead .sorting_desc:before,table.dataTable thead .sorting_asc_disabled:before,table.dataTable thead .sorting_desc_disabled:before {
        content: "\f0de";
        font-family: FontAwesome;
    }
    table.dataTable thead .sorting:after,table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting_desc:after,table.dataTable thead .sorting_asc_disabled:after,table.dataTable thead .sorting_desc_disabled:after {
        content: "\f0dd";
        font-family: FontAwesome;
        right: .65rem !important;
    }
</style>
<div class=" mb-5 content-position">

    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Organization Wise Product Report</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12" style="margin-top: 15px; margin-bottom: 25px; padding-bottom: 20px;" id="scrollTable">
        <div class="card" style="border: unset;">
            <form id="sales_tax_filter_form">
                @csrf
                <div class="row" style="margin: 10px;">
                    <div class="row filter_row" style="padding-bottom: 2px;margin:5px">
                        <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">Start Date |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                            <input type="text" name="start_date" class="summary-datepicker invoice-inputs" style="height: 2rem;background-color:#F8F8F8;border: 1px solid #DEDEDE;" value="{{ request()->get('start_date') }}" id="start_date">
                        </div>
                    </div>
                    <div class="row filter_row" style="padding-bottom: 2px;margin:5px">
                        <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">End Date |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                            <input type="text" name="end_date" class="summary-datepicker invoice-inputs" style="height: 2rem;background-color:#F8F8F8;border: 1px solid #DEDEDE;" value="{{ request()->get('end_date') }}" id="end_date">
                        </div>
                    </div>
                    <div class="row filter_row" style="padding-bottom: 2px;margin:5px">
                        <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">Organization |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center select-width" style="padding-left: 7px;">
                            <select name="organization_id" id="organization_id" class="select2">
                                <option value="all">All Organizations</option>
                                @foreach($organizations as $organization)
                                    <option value="{{ $organization->id }}" {{ request()->get('organization_id') == $organization->id ? 'selected' : '' }}>{{ $organization->organization_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row " style="padding-bottom: 2px;margin:5px">
                        <div class="d_flex_and_align_center" style="padding-bottom: 2px;height: 100%;">
                            <button class="date_p filter_btn" type="button" id="pin-filter" title="Filter" style="height: 2.3rem;">
                                <i class="fa fa-filter"></i>&nbsp;&nbsp;Filter
                            </button>
                        </div>
                    </div>
                    <div cclass="row " style="padding-bottom: 2px;margin:5px">
                        <div class="d_flex_and_align_center" style="padding-bottom: 2px;height: 100%;">
                            <button class="date_p excel_btn" type="button" id="clear-filter" title="Clear filter" style="height: 100%;border-radius: 5px">
                                <i class="fa fa-times"></i>&nbsp;&nbsp;Clear
                            </button>
                        </div>
                    </div>
                    <div cclass="row ml-auto" style="padding-bottom: 2px;margin:5px">
                        <div class="d_flex_and_align_center" style="padding-bottom: 2px;height: 100%;">
                            <button class="date_p excel_btn" type="button" id="export-report" title="export report" style="height: 100%;border-radius: 5px">
                                <i class="fa fa-download"></i>&nbsp;&nbsp;Export
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="col-md-12 table-responsive order_sammary_table" style="padding-top: 0px;">
                <table class="table align-items-center" id="organization_wise_product_report">

                    <thead style="background-color: rgba(50, 50, 50, 1) !important;">
                        <tr>
                            <th scope="col" class="table_header_text text-center">Product No</th>
                            <th scope="col" class="table_header_text text-center">Product Name</th>
                            <th scope="col" class="table_header_text text-center">Quantity Ordered</th>
                            <th scope="col" class="table_header_text text-center">Default Price</th>
                            <th scope="col" class="table_header_text text-left">Order Numbers
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productList as $productNo => $productData)
                            <tr>
                                <td>{{ $productData['product']->sub_product_no ?? 'N/A' }}</td>
                                <td>{{ $productData['product']->product_name ?? 'N/A' }}</td>
                                <td class="text-center">{{ $productData['qty'] }}</td>
                                <td class="text-right">{{ number_format($productData['product']->default_price ?? 0, 2) }}</td>
                                <td class="text-left">
                                    @foreach ($productData['orders'] as $orderId)
                                        <a href="{{ url('/order_details/edit/' . $orderId . '/order?active_tab=order') }}" target="_blank" style="text-decoration: underline;color: #2dce89;">#{{ $orderId }}</a>{{ !$loop->last ? ',' : '' }}
                                    @endforeach
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>
<script>
    $(document).ready(function() {
        $('.summary-datepicker').datepicker({
            dateFormat: 'mm/dd/yy'
        });
        $('#organization_wise_product_report').DataTable({
            "paging": true,
            "pageLength": 50,
            "searching": true,
            "ordering": true,
            "info": true,
             "lengthChange": false,
             "language": {
                "search": "Search:",
                "paginate": {
                    "previous": "<",
                    "next": ">"
                }
            },
             "columnDefs": [
                { "orderable": false, "targets": [4] }
            ]
        });
        $('#organization_id').select2();
        $('#pin-filter').on('click', function() {
            $('.se-pre-con').show();
            const rootURL = '{{ route('reports.org_wise_product_report') }}';
            const startDate = $('#start_date').val();
            const endDate =  $('#end_date').val();
            const organizationId = $('#organization_id').val();
            let queryParams = [];
            if (startDate) {
                queryParams.push('start_date=' + encodeURIComponent(startDate));
            }
            if (endDate) {
                queryParams.push('end_date=' + encodeURIComponent(endDate));
            }
            if (organizationId && organizationId !== 'all') {
                queryParams.push('organization_id=' + encodeURIComponent(organizationId));
            }
            const queryString = queryParams.length ? '?' + queryParams.join('&') : '';
            const newURL = rootURL + queryString;
            window.location.href = newURL;
        });
        $('#clear-filter').on('click', function() {
            $('.se-pre-con').show();
            window.location.href = '{{ route('reports.org_wise_product_report') }}';
        });
        $('#export-report').on('click', function() {
            $('.se-pre-con').show();

            $.ajax({
                url: '{{ route('reports.org_wise_product_report_export') }}',
                method: 'GET',
                data:{
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val(),
                    organization_id: $('#organization_id').val(),
                    _token: '{{ csrf_token() }}'
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    const url = window.URL.createObjectURL(new Blob([response]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'org_wise_product_report.xlsx');
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    $('.se-pre-con').hide();
                },
                error: function() {
                    $('.se-pre-con').hide();
                    alert('Failed to export report. Please try again.');
                }
            });
        });
    });
</script>

@endsection
