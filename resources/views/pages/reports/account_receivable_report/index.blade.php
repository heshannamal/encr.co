@extends('layouts.app', ['activePage' => 'ar_report', 'titlePage' => __('AR Report')])

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
        min-width: 8rem !important;
        width: auto !important;
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
    .selectbox-div{
        border: 1px solid #B3B3B3;
        border-radius: 1rem;
        padding: 1%;
        padding-left: 6%;
    }
    .searchbox-layout{
        margin-top: 0 !important;
        width: 100% !important;
        height: 29px;
        font-size: .7rem;
        color: #B3B3B3;
        border: unset;
    }
    #admin_clear_btn{
        border-color: #285e45;
        background-color: #f5365c;
        box-shadow: unset;
    }
    #payment_received_btn{
        border-color: #1a3a2c;
        background-color: #0cda51;
        box-shadow: unset;
    }
    #payMultipleModal .table td {
        padding: .2rem 1.5rem;
    }
    .no-top-border{
        border-top: none !important;
    }
    #order_summary_filter label{
        width: 76%;
    }
    div.dataTables_wrapper div.dataTables_filter input{
        width: 95%;
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
        <span>Accounts receivable</span>
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
                    <div class="row filter_row row-for-date-options ml-auto" style="padding-bottom: 2px; margin:5px;">
                        <label class="d_flex_and_align_center" style="margin: 0;cursor: pointer;">
                            <input type="radio" name="dateFilter" style="display: none" value="thisMonth">
                            <span class="font_color date_p" >This month</span>
                        </label>
                    </div>

                    <div class="row filter_row row-for-date-options" style="padding-bottom: 2px; margin:5px;">
                        <label class="d_flex_and_align_center" style="margin: 0;cursor: pointer;">
                            <input type="radio" name="dateFilter" style="display: none" value="lastMonth">
                            <span class="font_color date_p">Last month</span>
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
                            <span class="font_color date_p">Last year to date</span>
                        </label>
                    </div>

                    <div class="row filter_row row-for-date-options" style="padding-bottom: 2px; margin:5px;">
                        <label class="d_flex_and_align_center" style="margin: 0;cursor: pointer;">
                            <input type="radio" name="dateFilter" style="display: none" value="thisQuarter">
                            <span class="font_color date_p">This quarter</span>
                        </label>
                    </div>
                </div>

                <div class="row" style="margin-left: 18px; margin-right: 30px; padding-bottom: 7px;">
                    <div class="row filter_row" style="padding-bottom: 2px;">
                        <p class="font_color date_p d_flex_and_align_center">Rep |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center select-width-style" style="padding-left: 7px;">
                            <select id="user_filter" name="user_filter" class="date_selection summary-select2">
                                <option value="all">All</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row filter_row ml-4" style="padding-bottom: 2px;">
                        <p class="font_color date_p d_flex_and_align_center">Team type |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center select-width-style" style="padding-left: 7px;">
                            <select id="team_type_filter" name="team_type_filter" class="date_selection summary-select2">
                                <option value='0' selected>Without Internal Teams</option>
                                <option value='1'>With Internal Teams</option>
                            </select>
                        </div>
                    </div>
                    <div style="margin-left: 45px;">
                        <div class="row d_flex_and_align_center" style="padding-bottom: 2px;height: 100%;">
                            <button class="date_p filter_btn" type="button" id="pin-filter" title="Filter" style="height: 100%;">
                                <i class="fa fa-filter"></i>&nbsp;&nbsp;Filter
                            </button>
                        </div>
                    </div><div class="row filter_row ml-auto" style="padding-bottom: 2px;margin:5px;width: fit-content;">
                        <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;color: black;">Number of sale |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                            <span class="d_flex_and_align_center text-right" style="height: 1.5rem;background-color:#F8F8F8;width: 100%;color:black" id="number_of_sale">0</span>
                        </div>
                    </div>
                    <div class="row filter_row" style="padding-bottom: 2px;margin:5px;width: fit-content;">
                        <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;color: black;">Total ($) |  </p>
                        <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                            <span class="d_flex_and_align_center text-right" style="height: 1.5rem;background-color:#F8F8F8;width: 100%;color:black" id="total_sale">0.00</span>
                        </div>
                    </div>
                    <div >
                        <div class="row d_flex_and_align_center " style="padding-bottom: 2px;margin: 5px;">
                            <button class="date_p excel_btn" type="button" id="exportButton" title="Filter" style="height: 100%;">
                                <i class="fa fa-download"></i>&nbsp;&nbsp;Excel
                            </button>
                        </div>
                    </div>
                    <div >
                        <div class="row d_flex_and_align_center " style="padding-bottom: 2px;margin: 5px;">
                            <button class="date_p excel_btn" type="button" id="save-report" title="savereport" style="height: 100%;">
                                <i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save
                            </button>
                        </div>
                    </div>
                </div>
            </form>


            <div class="order_sammary_table" style="">
                @if(Gate::check('create bulk invoice'))
                <div class="col-md-2 mt-2" style="display:flex;">
                    <input type="hidden" id="pay_multiple_invoices" name="pay_multiple_invoices[]" value="" />
                    <button type="submit" class="btn multiple-pay-button btn-secondary btn-sm" title="Mark as paid" style="background-color: rgb(94 145 105);color:white;display:none" id="pay_multiple"><i class="far fa-check-circle"></i><small>Mark as paid (<span id="invoice_checked_count"></span>)</small></button>

                    <form action="{{ route('create_bulk_invoice') }}" method="POST">
                        @csrf
                        <input type="hidden" id="make_bulk_invoices" name="make_bulk_invoices" value="" />
                        <button type="submit" class="btn make-bulk-invoice btn-secondary btn-sm" title="Make bulk invoice" style="background-color: #b3b3b3;color:black;display:none" id="make_bulk_invoice"><i class="far fa-check-circle"></i><small>Make bulk invoice (<span id="make_bulk_invoice_count"></span>)</small></button>
                    </form>

                </div>
                @endif
                <table class="table align-items-center" id="order_summary" style="min-width: 100%;">

                    <thead style="background-color: #717070;">
                        <th scope="col" class="table_header_text">
                            <input type="checkbox" class="checkbox_of_invoice_all" id="checkbox_of_invoice_all" />
                        </th>
                        <th scope="col" class="table_header_text">ORDER NO</th>
                        <th scope="col" class="table_header_text">ORGANIZATION NAME</th>
                        <th scope="col" class="table_header_text">SALES LEAD</th>
                        <th scope="col" class="table_header_text">ITEM QTY</th>
                        <th scope="col" class="table_header_text" style="text-align: right;">TOTAL ($)</th>
                        <th scope="col" class="table_header_text" style="text-align: right;">PAID ($)</th>
                        <th scope="col" class="table_header_text" style="text-align: right;">BALANCE ($)</th>
                        <th scope="col" class="table_header_text">CREATED DATE</th>
                        <th scope="col" class="table_header_text">PRODUCTION DATE</th>
                        <th scope="col" class="table_header_text">IN HAND DUE DATE</th>
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

<!-- Payment Received Modal -->
<div class="modal fade" id="paymentReceivedModal" tabindex="-1" role="dialog" aria-labelledby="paymentReceivedModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form>
          @csrf <!-- Include CSRF token for security -->
          <div class="modal-header">
            <h5 class="modal-title" id="paymentReceivedModalLabel">Payment Received</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- Image upload section -->
            <div class="form-group only_for_payment">
              <label for="payment_image">Upload Payment Image</label>
              <input type="file" class="form-control-file" id="payment_image" name="payment_image" accept="image/*">
            </div>

            <!-- Image preview -->
            <div class="form-group only_for_payment">
              <img id="imagePreview" src="#" alt="Payment Image Preview" style="display:none; max-width: 100%; height: auto;" />
            </div>

            <!-- Description textarea -->
            <div class="form-group">
              <label for="description">Payment Description</label>
              <textarea class="form-control" name="description" id="other_payment_description" rows="3" placeholder="Enter a description of the payment" required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="submit_payment_received" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>



  <!-- Modal -->
<div class="modal fade" id="comfirm_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header" style="padding-bottom: unset;">
          {{-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> --}}
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="col" style="display: flex;flex-wrap: wrap;justify-content: center;">
            <h2>Payment Options</h2>
            <p>Choose the appropriate action for payment:</p>
          </div>
        </div>
        <div class="modal-footer" style="padding-top: unset;display: flex;flex-wrap: wrap;justify-content: center;">

          <button type="button" class="btn btn-primary" id="admin_clear_btn">Clear by Admin</button>
          <button type="button" class="btn btn-primary" id="payment_received_btn">Payment Received</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Pay multile modal -->
<div class="modal fade" id="payMultipleModal" tabindex="-1" role="dialog" aria-labelledby="payMultipleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="max-width:1125px !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payMultipleModalLabel" style="font-size: 1.2rem;">TRANSACTION </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="multiplePayForm" action="{{ route('do_pay_multiple_orders') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <table class="table align-items-center ml-auto">
                        <thead style="background-color: grey;color: white;">
                            <th scope="col" class="text-center">Order Number</th>
                            <th scope="col" class="text-center">Organization Name</th>
                            <th scope="col" class="text-center">Total amount</th>
                            <th scope="col" class="text-center">Paid amount</th>
                            <th scope="col" class="text-center">Balance to pay</th>
                            <th scope="col" class="text-center">Payment amount</th>
                        </thead>
                        <tbody id="selectedInvoiceTr">

                        </tbody>
                        <tbody class="no-top-border">

                            <tr>
                                <td class="no-top-border" colspan="4" id="debit_acc_summary_line_1" ></td>
                                <td class="text-right no-top-border" style="font-weight:800;font-size: 1rem;">Total Paid Amount:  </td>
                                <td class="no-top-border">
                                    <input type="text" name="total_sum_of_payment" id="total_sum_of_payment" value="0.00" class="form-control text-right" style="font-weight:800;" >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="transaction_id" value="001">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-1 mt-3" style="padding: 0rem 1rem;">
                                    <label for="upload_image">Upload Image for payment reference</label>
                                    <input type="file" id="upload_image" name="other_front" accept="image/png, image/jpeg" class="form-control" style="width: auto;height: auto;" onchange="previewImage(event)">
                                </div>

                                <div class="form-group" id="imagePreview2" style="display:none;padding: 0rem 1rem;">
                                    <img id="uploaded_image" src="" alt="Uploaded Image" style="width: auto; height: 5rem;">
                                    <button type="button" id="removeImage">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-1 mt-3" style="padding: 0rem 1rem;">
                                    <label for="upload_image">Upload Image for payment reference back</label>
                                    <input type="file" id="upload_image2" name="other_back" accept="image/png, image/jpeg" class="form-control" style="width: auto;height: auto;" onchange="previewImage2(event)">
                                </div>

                                <div class="form-group" id="imagePreview22" style="display:none;padding: 0rem 1rem;">
                                    <img id="uploaded_image2" src="" alt="Uploaded Image" style="width: auto; height: 5rem;">
                                    <button type="button" id="removeImage2">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="payment_reference text">Payment reference text</label><br>
                                <textarea name="payment_reference" class="form-control" id="payment_reference" cols="30" rows="3" style="width: 100%;"></textarea>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmGroupPay">Pay</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Reason Type Modal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>


<script>
    $('#confirmGroupPay').click(function(e) {
        e.preventDefault(); // Prevent default button action
        $(".se-pre-con").fadeIn('slow'); // Show loading animation

        // Submit the form
        $('#multiplePayForm').submit();
    });
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('uploaded_image');
            output.src = reader.result;
            document.getElementById('imagePreview2').style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]); // Preview the image
    }
    function previewImage2(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('uploaded_image2');
            output.src = reader.result;
            document.getElementById('imagePreview22').style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]); // Preview the image
    }

    // Remove image functionality
    document.getElementById('removeImage').addEventListener('click', function() {
        document.getElementById('upload_image').value = ''; // Clear file input
        document.getElementById('uploaded_image').src = ''; // Clear image preview
        document.getElementById('imagePreview2').style.display = 'none'; // Hide image preview area
    });
    // Remove image functionality
    document.getElementById('removeImage2').addEventListener('click', function() {
        document.getElementById('upload_image2').value = ''; // Clear file input
        document.getElementById('uploaded_image2').src = ''; // Clear image preview
        document.getElementById('imagePreview22').style.display = 'none'; // Hide image preview area
    });
    $(document).ready(function() {
        // When image is selected, display the image preview
        $('#payment_image').change(function(event) {
            var input = event.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result);
                    $('#imagePreview').show();
                };
                reader.readAsDataURL(input.files[0]);
            }
        });
    });
    document.getElementById('exportButton').addEventListener('click', function() {
        // Get the table body element
        var tableBody = document.querySelector("#order_summary tbody");

        var dataTablesEmptyCell = document.querySelector("#order_summary tbody .dataTables_empty");

        // Check if the table contains the "No data available" message
        if (dataTablesEmptyCell) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "No data available in table",

                });
            return; // Exit the function
        }


        // Get the table element
        var table = document.getElementById("order_summary");

        // Convert the table to a worksheet
        var workbook = XLSX.utils.table_to_book(table, { sheet: "Order Summary" });

        // Export the worksheet to an Excel file
        XLSX.writeFile(workbook, 'order_summary.xlsx');
    });

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

        // Step 1: Add custom date sort
        jQuery.extend(jQuery.fn.dataTable.ext.type.order, {
            "date-custom-pre": function (dateStr) {
                if (!dateStr) return 0;
                var parts = dateStr.split('/');
                return parts.length === 3
                    ? parseInt(parts[2] + parts[0].padStart(2, '0') + parts[1].padStart(2, '0'))
                    : 0;
            },
            "date-custom-asc": function (a, b) {
                return a - b;
            },
            "date-custom-desc": function (a, b) {
                return b - a;
            }
        });

        var table = $('#order_summary').DataTable({
            paging: true,
            scrollX: true,
            pageLength: $('#page_length').val(),
            searching: true,
            ordering: true,
            info: false,
            fixedHeader: true,
            lengthChange: false,
            bSort: false,
            language: {
                search: '<i class="fas fa-search"></i>',
                searchPlaceholder: 'Payables Search'
            },
            columnDefs: [
                { targets: [0], orderable: false },
                { targets: [5], className: "text-right" },
                { targets: [2], className: "org-name" },
                { targets: [1, 4, 5, 6, 7, 8], className: "text-center" },
                { targets: [8, 9, 10], type: "date-custom" }
            ]
        });

        function make_summary_table() {
            $('.se-pre-con').fadeIn();
            var formData = new FormData($('#summary_filter_form')[0]);

            $.ajax({
                url: "{{ route('get_ar_report_data') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    $('#total_sale').text(parseFloat(response.total_sale).toFixed(2));
                    $('#number_of_sale').text(response.number_of_sale);
                    updateTable(response.orders);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        function save_summary_report() {
            $('.se-pre-con').fadeIn();
            var formData = new FormData($('#summary_filter_form')[0]);

            $.ajax({
                url: "{{ route('save_ar_report_data') }}",
                type: 'POST',
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    $('.se-pre-con').fadeOut();

                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function updateTable(data) {
            table.clear();
            var data = Object.values(data);
            console.log(data);
            data.forEach(function(order) {

                table.row.add([
                    '<input type="checkbox" class="checkbox_of_invoice" value="'+order.id+'" id="checkbox_of_invoice_'+order.id+'"  />',
                    '<a style="color:black !important" href="#" class="edit-order" data-value="'+order.id+'">'+order.order_no+'</a>',
                    order.organization_details.organization_name,
                    order.user_details.name,
                    calculateTotalQty(order.order_items),
                    '<td style="text-align: right;">' + parseFloat(order.order_total).toFixed(2) + '</td>',
                    '<td style="text-align: right;">' + parseFloat(order.Received_totalPayment).toFixed(2) + '</td>',
                    '<td style="text-align: right;">' + parseFloat(order.balance_to_be_paid).toFixed(2) + '</td>',
                    order.open_date,
                    order.production_date,
                    order.due_date
                ]);
            });

            table.draw();
            table.page.len(parseInt($('#page_length').val())).draw();
            $('.se-pre-con').fadeOut();
            function calculateTotalQty(orderItems) {
                return orderItems
                    .filter(item => item && item.deleted_at == null && item.active == 1)
                    .reduce((sum, item) => sum + parseInt(item.qty || 0, 10), 0);
            }
        }

        $('#pin-filter').on('click', function() {
            make_summary_table();
        });
        $('#save-report').on('click', function() {
            save_summary_report();
        });

        $('#page_length').on('change', function() {
            table.page.len(parseInt($(this).val())).draw();
        });
        $('#user_filter').on('change', function() {
            make_summary_table();
        });
        $('#team_type_filter').on('change', function() {
            make_summary_table();
        });
        $("body").on("click", ".edit-order", function(){
            var orderId = $(this).data('value');
            window.open('order_details/edit/'+orderId+'/order?active_tab=order', '_blank');
        });
        $('#checkbox_of_invoice_all').change(function() {
            var checked = $(this).is(':checked');
            $('.checkbox_of_invoice').prop('checked', checked).trigger('change');
        });

        var invoice_array = [];
        function is_same_org_selected() {
            let is_same_organization = true;
            let organization_name = null;

            // Get all selected checkboxes across pages
            let table = $('#order_summary').DataTable();
            let selectedRows = table.$('.checkbox_of_invoice:checked', { page: 'all' });

            selectedRows.each(function() {
                var current_org_name = $(this).closest('tr').find('.org-name').text().trim();

                if (organization_name === null) {
                    organization_name = current_org_name;
                } else if (organization_name !== current_org_name) {
                    is_same_organization = false;
                    return false; // Break loop
                }
            });

            return is_same_organization;
        }
        $('body').on('change', '.checkbox_of_invoice', function() {
            var value = $(this).val();

            if ($(this).is(':checked')) {
                if (!invoice_array.includes(value)) {
                    invoice_array.push(value);
                }
            } else {
                var index = invoice_array.indexOf(value);
                if (index > -1) {
                    invoice_array.splice(index, 1);
                }
            }





            $('#invoice_checked_count').text(invoice_array.length);
            $('#make_bulk_invoice_count').text(invoice_array.length);

            if (invoice_array.length > 0) {
                $('#pay_multiple').show();
                $('#pay_multiple_invoices').val(invoice_array);
                $('#make_bulk_invoices').val(invoice_array);
                if((is_same_org_selected())){
                    $('#make_bulk_invoice').show();
                    $('#payment_received_btn').show();
                }else{
                    $('#make_bulk_invoice').hide();
                    $('#payment_received_btn').hide();
                }
            } else {
                $('#pay_multiple').hide();
                $('#make_bulk_invoice').hide();
                $('#pay_multiple_invoices').val('');
                $('#make_bulk_invoices').val('');
            }
        });



        $('body').on('click', '.multiple-pay-button', function(e) {
            e.preventDefault();

            $('.only_for_payment').hide();
            $('#imagePreview').attr('src', '');
            $('#payment_image').val('');

            $('#comfirm_modal').modal('show');
        });
        $('body').on('click', '#admin_clear_btn', function(e) {
            e.preventDefault();
            $('#comfirm_modal').modal('hide');
            $('#paymentReceivedModalLabel').text('CLEAR BY ADMIN');
            $('.only_for_payment').hide();
            $('#paymentReceivedModal').modal('show');
        });
        $('body').on('click', '#payment_received_btn', function(e) {
            e.preventDefault();
            $('#comfirm_modal').modal('hide');
            $('#paymentReceivedModalLabel').text('RECEIVED PAYMENTS');
            $('.only_for_payment').show();
            $('#imagePreview').hide();

            $(".se-pre-con").fadeIn('slow');

            var arrayData = $('#pay_multiple_invoices').val();

            var invoiceArray = arrayData.split(',');

            invoiceArray = invoiceArray.map(function(item) {
                return item.trim();
            });

            $.ajax({
                    url:"{{ route('get_multiple_order_details') }}",
                    type: "POST",
                    data: {
                        'order_ids': invoiceArray,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (data) {
                        $(".se-pre-con").fadeOut('slow');

                        $('#selectedInvoiceTr').empty();

                        var orders = data.data;
                        orders.sort((a, b) => a.id - b.id);

                        if (orders && orders.length > 0) {
                            var totalAmount = 0.00;
                            orders.forEach(function(invoice) {

                                let organizationName = invoice.organization_details.organization_name;
                                if (organizationName.length > 50) {
                                    organizationName = organizationName.substring(0, 50) + '...';
                                }
                                var row = `
                                            <tr>
                                                <td class="text-center"><a style="color:black !important" href="#" class="edit-order" data-value="${invoice.id}">${invoice.order_no}</a></td>
                                                <td class="text-left">${organizationName}</td>
                                                <td class="text-right total-amount-to-pay">${parseFloat(invoice.order_total).toFixed(2)}</td>
                                                <td class="text-right paid-amount-total">${invoice.payment_status.total_payment}</td>
                                                <td class="text-right paid-amount-total">${parseFloat(invoice.payment_status.balance_to_be_paid).toFixed(2)}</td>
                                                <td>
                                                    <input type="text" max="${invoice.payment_status.balance_to_be_paid}" class="invoice_payment_amount form-control text-right" name="payment_amount[${invoice.id}]" value="${parseFloat(invoice.payment_status.balance_to_be_paid).toFixed(2)}">
                                                    <input type="hidden" max="${invoice.payment_status.balance_to_be_paid}" class="invoice_payment_amount_orginal form-control text-right" value="${parseFloat(invoice.payment_status.balance_to_be_paid).toFixed(2)}">
                                                </td>
                                            </tr>
                                        `;
                                        $('#selectedInvoiceTr').append(row);

                                        totalAmount += invoice.payment_status.balance_to_be_paid;
                            });

                            var totalRow = `
                                            <tr>
                                                <td class="hard-top-border"></td>
                                                <td class="hard-top-border"></td>
                                                <td class="hard-top-border"></td>
                                                <td class="hard-top-border"></td>
                                                <td class="text-right hard-top-border" style="font-weight:800">Invoice Total : </td>
                                                <td class="hard-top-border">
                                                    <input type="hidden" name="total_amount" id="total_paid_amount" value="${parseFloat(totalAmount).toFixed(2)}">
                                                    <input type="text" value="${parseFloat(totalAmount).toFixed(2)}" class="form-control text-right" style="font-weight:800" readonly>
                                                </td>
                                            </tr>
                                        `;
                            $('#selectedInvoiceTr').append(totalRow);

                            $('#transaction_amount_cash,#total_sum_of_payment').val(parseFloat(totalAmount).toFixed(2));

                            $('#payMultipleModal').modal('show');
                        }
                    }
                });

                $(".se-pre-con").fadeOut('slow');

        });
        $(document).on('change', '#total_sum_of_payment', function() {
            handlePaymentValues();
        });
        function handlePaymentValues() {
            $(".se-pre-con").fadeIn('slow');
            var total_paid_amount = parseFloat($('#total_sum_of_payment').val()) || 0;
            var total_invoice_amount = parseFloat($('#total_paid_amount').val()) || 0;


            if (total_paid_amount > total_invoice_amount) {
                $('#debit_acc_summary_line_1').html('');
                var overPayment = (total_paid_amount - total_invoice_amount).toFixed(2);
                var htmlContent1 = '<p style="margin: 0;font-weight: 600;color: grey;">Excess payment for this transaction = $' + overPayment + '</p>';
                $('#debit_acc_summary_line_1').html(htmlContent1);
            }

            if (total_paid_amount < total_invoice_amount) {
                $('#debit_acc_summary_line_1').html('');
                var remaining_payment = (total_invoice_amount - total_paid_amount ).toFixed(2);
                var htmlContent1 = '<p style="margin: 0;font-weight: 600;color: grey;">Remaining payment for this transaction = $' + remaining_payment + '</p>';

                $('#debit_acc_summary_line_1').html(htmlContent1);

            }
            if (total_paid_amount > 0) {

                let total = 0;
                let is_exeed = false;

                $('#selectedInvoiceTr').find('tr').each(function () {
                    let $row = $(this);
                    let $input = $row.find('td .invoice_payment_amount');
                    let $originalInput = $row.find('td .invoice_payment_amount_orginal');

                    let originalBalance = parseFloat($originalInput.val()) || 0;
                    let value = parseFloat($input.val()) || 0;

                    total += originalBalance;

                    if(!is_exeed){
                        if(total >  (total_paid_amount)){
                            $($input).val((originalBalance - total + (total_paid_amount)).toFixed(2)).trigger('change');
                            is_exeed = true;
                        }else{
                            $($input).val((originalBalance).toFixed(2)).trigger('change');
                        }
                    }else{
                        $($input).val((0).toFixed(2)).trigger('change');
                    }
                });

            }

            if (total_paid_amount == total_invoice_amount) {
                console.log('Payment settled');
                // $('#transaction_amount_debit').prop('readonly', true);
                $('#debit_acc_summary_line_1, #debit_acc_summary_line_2').html('');
            }

            $(".se-pre-con").fadeOut('slow');
        }

        $(document).on('input', '.invoice_payment_amount', function() {
            calculateTotalAmount();
        });

        function calculateTotalAmount() {
            var totalAmount = 0;
            $('.invoice_payment_amount').each(function() {
                var amount = parseFloat($(this).val());
                if (!isNaN(amount)) {
                    totalAmount += amount;
                }
            });
            $('#total_sum_of_payment').val(totalAmount.toFixed(2));

        }

        $('body').on('click', '.make-bulk-invoice', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Create Bulk Invoice',
                text: 'Do you want to create bulk invoice?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                reverseButtons: true
            }).then((result) => {
                console.log(result);

                if (result.value) {
                    $(this).closest('form').submit();
                } else {
                    console.log('Form submission canceled.');
                }
            });
        });


    $('#submit_payment_received').click(function(e) {
        e.preventDefault();

        var arrayData = $('#pay_multiple_invoices').val();
        var invoiceArray = arrayData.split(',').map(function(item) {
            return item.trim();
        });

        var paymentImage = $('#payment_image')[0].files[0];
        var paymentDescription = $('#other_payment_description').val();

        if (!paymentDescription) {
            Swal.fire(
                'Incomplete Form',
                'Please enter a description.',
                'warning'
            );
            return;
        }

        var formData = new FormData();
        formData.append('payment_image', paymentImage);
        formData.append('description', paymentDescription);
        formData.append('invoices', invoiceArray);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: "{{ route('order_mark_as_paid') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(response) {
                $(".se-pre-con").fadeOut('slow');
                Swal.fire(
                    'Payment Submitted!',
                    'The payment has been successfully submitted.',
                    'success'
                );
                location.reload();
            },
            error: function(xhr, status, error) {
                $(".se-pre-con").fadeOut('slow');
                Swal.fire(
                    'Error!',
                    'There was an error processing the payment. Please try again.',
                    'error'
                );
            }
        });
    });


    function setDates(dateType) {
        var startDate, endDate;
        var currentDate = new Date();

        switch (dateType) {
            case 'thisMonth':
                startDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
                endDate = currentDate; // Use today's date as the end date
                break;
            case 'lastMonth':
                startDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1, 1);
                endDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 0);
                break;
            case 'thisYear':
                startDate = new Date(currentDate.getFullYear(), 0, 1);
                endDate = currentDate; // Use today's date as the end date
                break;
            case 'lastYearToday':
                startDate = new Date(currentDate.getFullYear() - 1, 0, 1);
                endDate = new Date(currentDate.getFullYear() - 1, currentDate.getMonth(), currentDate.getDate());
                break;
            case 'thisQuarter':
                var quarter = Math.floor((currentDate.getMonth() + 3) / 3);
                startDate = new Date(currentDate.getFullYear(), (quarter - 1) * 3, 1);
                endDate = currentDate; // Use today's date as the end date
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


        make_summary_table();
    });



</script>

@endsection
