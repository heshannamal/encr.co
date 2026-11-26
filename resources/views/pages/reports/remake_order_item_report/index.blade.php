@extends('layouts.app', ['activePage' => 'remake_order_item_report', 'titlePage' => __('Remake Order Item Report')])

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


@if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif

<div class=" mb-5 content-position">

    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Remake Order Item Report</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection


    <div class="col-md-12" style="margin-top: 15px; margin-bottom: 25px; padding-bottom: 20px;" id="scrollTable">
        <div class="card" style="border: unset;">
            <form id="summary_filter_form">
                @csrf
                <div class="row" style="margin: 10px;">
                    <div class="row filter_row"  style="padding-bottom: 2px;margin:5px">
                        <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                            <select id="page_length" class="date_selection">
                                <option value="5">5 per page</option>
                                <option value="10">10 per page</option>
                                <option value="20" selected>20 per page</option>
                                <option value="50">50 per page</option>
                            </select>
                        </div>
                    </div>
                    <div class="row filter_row" style="padding-bottom: 2px;margin:5px">
                        <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">Start Date |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                            <input type="text" name="start_date" class="summary-datepicker invoice-inputs" style="height: 2rem;background-color:#F8F8F8;border: 1px solid #DEDEDE;" id="start_date">
                        </div>
                    </div>
                    <div class="row filter_row" style="padding-bottom: 2px;margin:5px">
                        <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">End Date |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                            <input type="text" name="end_date" class="summary-datepicker invoice-inputs" style="height: 2rem;background-color:#F8F8F8;border: 1px solid #DEDEDE;" id="end_date">
                        </div>
                    </div>
                    <div class="row filter_row" style="padding-bottom: 2px;margin:5px">
                        <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                            <select id="filtercolumn" name="filtercolumn" class="date_selection summary-select2">
                                <option value="created_at" selected>Based on Remake Date</option>
                                <option value="est_delivery_date">Based on Estimate Delivery Date</option>
                                <option value="ex_factory_date">Based on Ex-factory Date</option>
                            </select>
                        </div>
                    </div>
                    <div style="margin-left: 45px;">
                        <div class="row d_flex_and_align_center" style="padding-bottom: 2px;height: 100%;">
                            <button class="date_p filter_btn" type="button" id="pin-filter" title="Filter" style="height: 100%;">
                                <i class="fa fa-filter"></i>&nbsp;&nbsp;Filter
                            </button>
                        </div>
                    </div>
                    <div class="row filter_row row-for-date-options ml-auto" style="padding-bottom: 2px; margin:5px;">
                        <label class="d_flex_and_align_center" style="margin: 0;cursor: pointer;">
                            <input type="radio" name="dateFilter" style="display: none" value="thisMonth">
                            <span class="font_color date_p" >This month</span>
                        </label>
                    </div>

                    <div class="row filter_row row-for-date-options" style="padding-bottom: 2px; margin:5px;background-color: rgb(123, 216, 237);">
                        <label class="d_flex_and_align_center" style="margin: 0;cursor: pointer;">
                            <input type="radio" name="dateFilter" class="active-radio" style="display: none" value="lastMonth" checked>
                            <span class="font_color date_p" style="color: white;">Last month</span>
                        </label>
                    </div>

                    <div class="row filter_row row-for-date-options" style="padding-bottom: 2px; margin:5px;">
                        <label class="d_flex_and_align_center" style="margin: 0;cursor: pointer;">
                            <input type="radio" name="dateFilter" style="display: none" value="thisYear">
                            <span class="font_color date_p">This year</span>
                        </label>
                    </div>

                    <div class="row filter_row row-for-date-options" style="padding-bottom: 2px; margin:5px;">
                        <label class="d_flex_and_align_center" style="margin: 0;cursor: pointer;">
                            <input type="radio" name="dateFilter" style="display: none" value="lastYearToday">
                            <span class="font_color date_p">Last year today</span>
                        </label>
                    </div>

                    <div class="row filter_row row-for-date-options" style="padding-bottom: 2px; margin:5px;">
                        <label class="d_flex_and_align_center" style="margin: 0;cursor: pointer;">
                            <input type="radio" name="dateFilter" style="display: none" value="thisQuarter">
                            <span class="font_color date_p">This quarter</span>
                        </label>
                    </div>
                </div>
            </form>


            <div class="order_sammary_table" style="">
                <table class="table align-items-center" id="order_summary" style="min-width: 100%;">

                    <thead style="background-color: #717070;">
                        <th scope="col" class="table_header_text">ORDER NO</th>
                        <th scope="col" class="table_header_text">ORGANIZATION NAME</th>
                        <th scope="col" class="table_header_text">REMAKE DATE</th>
                        <th scope="col" class="table_header_text">ITEM NAME</th>
                        <th scope="col" class="table_header_text">SIZE</th>
                        <th scope="col" class="table_header_text">QTY</th>
                        <th scope="col" class="table_header_text">ESTIMATE DELIVERY DATE</th>
                        <th scope="col" class="table_header_text">EX FACTORY DATE</th>
                        <th scope="col" class="table_header_text">STATUS</th>
                        <th scope="col" class="table_header_text">REASON</th>
                        <th scope="col" class="table_header_text">REMAKE BY</th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
            <div  style="padding-top: 10px;">
            <div id="pagination_controls" class="row justify-content-center" style="width: 100%;">
                {{-- pagination bar paste here --}}
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>


<script>

    $('.summary-datepicker').datepicker();
    $('.summary-select2').select2();

    $(document).ready(function() {

        let hoverTimeout;

        if ($('#minimize_icon').css('display') != 'none') {
            $('#minimize_icon')[0].click();
        }

        $('#sidenav-main').hover(
            function() {
                hoverTimeout = setTimeout(function() {
                    if ($('#maximize_icon').css('display') != 'none') {
                        $('#maximize_icon').click();
                    }
                }, 500);
            },
            function() {
                clearTimeout(hoverTimeout);
                if ($('#minimize_icon').css('display') != 'none') {
                    $('#minimize_icon')[0].click();
                }
            }
        );

        $('input[name="dateFilter"]').on('click', function() {
            $('#start_date').val('');
            $('#end_date').val('');
            if ($(this).is(':checked')) {
                if ($(this).hasClass('active-radio')) {
                    $(this).prop('checked', false).removeClass('active-radio');
                    $(this).closest('.row-for-date-options').css('background-color', '#F8F8F8');
                    $(this).closest('.row-for-date-options').find('label span').css('color', 'black');
                } else {
                    $('input[name="dateFilter"]').removeClass('active-radio');
                    $(this).addClass('active-radio');
                    $('.row-for-date-options').css('background-color', '#F8F8F8');
                    $('.row-for-date-options label span').css('color', 'black');
                    $(this).closest('.row-for-date-options').css('background-color', '#7bd8ed');
                    $(this).closest('.row-for-date-options').find('label span').css('color', 'white');
                }
            }
        });

        $('#start_date, #end_date').focus(function() {
            $('input[name="dateFilter"]').prop('checked', false);
        });

        var table = $('#order_summary').DataTable({
            "paging": true,
            scrollX: true,
            "pageLength": $('#page_length').val(),
            "searching": false,
            "ordering": true,
            "info": false,
            "lengthChange": false,
            "columnDefs": [{
                        "targets": [0, 2, 4, 5, 6, 7, 8],
                        "className": "text-center"
                    }]
        });

        function make_summary_table() {
            $('.se-pre-con').fadeIn();
            var formData = new FormData($('#summary_filter_form')[0]);

            $.ajax({
                url: "{{ route('get_remake_order_item_report_data') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    updateTable(response.items || response.orders || []);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    $('.se-pre-con').fadeOut();
                }
            });
        }

        function updateTable(data) {
            table.clear();
            var data = Object.values(data);
            data.forEach(function(item) {
                var orderNoHtml = item.order_id
                    ? '<a style="color:black !important" href="#" class="edit-order" data-value="' + item.order_id + '">' + (item.order_no || '-') + '</a>'
                    : (item.order_no || '-');
                var orgHtml = item.organization_id
                    ? '<a style="color:black !important" href="#" class="edit-organization" data-value="' + item.organization_id + '">' + (item.organization_name || '-') + '</a>'
                    : (item.organization_name || '-');
                var itemNameHtml = (item.order_id && item.order_item_id)
                    ? '<a style="color:black !important" href="#" class="edit-order-item" data-order-id="' + item.order_id + '" data-item-id="' + item.order_item_id + '">' + (item.item_name || '-') + '</a>'
                    : (item.item_name || '-');

                table.row.add([
                    orderNoHtml,
                    orgHtml,
                    item.remake_date || '-',
                    itemNameHtml,
                    item.size || '-',
                    item.qty !== undefined && item.qty !== null ? item.qty : 0,
                    item.est_delivery_date || '-',
                    item.ex_factory_date || '-',
                    item.status || '-',
                    item.reason || '-',
                    item.remake_by || '-'
                ]);
            });

            table.draw();
            $('.se-pre-con').fadeOut();
        }

        $('#pin-filter').on('click', function() {
            make_summary_table();
        });

        $('#page_length').on('change', function() {
            table.page.len(parseInt($(this).val())).draw();
        });
        $('#user_filter').on('change', function() {
            make_summary_table();
        });
        $("body").on("click", ".edit-organization", function(){
            var orgrId = $(this).data('value');
            window.open('organizations/info/'+orgrId);
        });
        $("body").on("click", ".edit-order", function(){
            var orderId = $(this).data('value');
            window.open('order_details/edit/'+orderId+'/order?active_tab=order', '_blank');
        });
        $("body").on("click", ".edit-order-item", function(){
            var orderId = $(this).data('order-id');
            var itemId = $(this).data('item-id');
            window.open('orderitem/info/'+orderId+'/'+itemId, '_blank');
        });

    function setDates(dateType) {
        var startDate, endDate;
        var currentDate = new Date();

        switch (dateType) {
            case 'thisMonth':
                startDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
                endDate = currentDate;
                break;
            case 'lastMonth':
                startDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1, 1);
                endDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 0);
                break;
            case 'thisYear':
                startDate = new Date(currentDate.getFullYear(), 0, 1);
                endDate = currentDate;
                break;
            case 'lastYearToday':
                startDate = new Date(currentDate.getFullYear() - 1, 0, 1);
                endDate = new Date(currentDate.getFullYear() - 1, currentDate.getMonth(), currentDate.getDate());
                break;
            case 'thisQuarter':
                var quarter = Math.floor((currentDate.getMonth() + 3) / 3);
                startDate = new Date(currentDate.getFullYear(), (quarter - 1) * 3, 1);
                endDate = currentDate;
                break;
            default:
                startDate = '';
                endDate = '';
        }

        if (startDate) {
            $('#start_date').val(formatDate(startDate));
        }
        if (endDate) {
            $('#end_date').val(formatDate(endDate));
        }
        make_summary_table();
    }
    function formatDate(date) {
        var day = String(date.getDate()).padStart(2, '0');
        var month = String(date.getMonth() + 1).padStart(2, '0');
        var year = date.getFullYear();
        return month + '/' + day + '/' + year;
    }

    setDates($('input[name="dateFilter"]:checked').val());

    $('input[name="dateFilter"]').on('change', function() {
        setDates($(this).val());
    });

    });

</script>

@endsection

