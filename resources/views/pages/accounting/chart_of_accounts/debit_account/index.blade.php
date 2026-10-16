@extends('layouts.app', ['activePage' => 'debit_account', 'titlePage' => __('Debit Account')])

@section('content')
<style>
    .form-field {
        display: flex;
        margin-bottom: 1rem;
        flex-direction: row;
        flex-wrap: nowrap;
        align-items: center;
    }
    .form-lable {
        width: 33%;
    }
    .form-input {
        width: 100%;
    }
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
        display: none;
    }
    div.alphabet {
        display: table;
        width: 100%;
        margin-bottom: 1em;
    }
    div.alphabet span {
        display: table-cell;
        color: #b3b3b3;
        cursor: pointer;
        text-align: center;
        width: 3.5%;
        border: 1px solid #e8e8e8;
    }
    div.alphabet span:hover {
        box-shadow: 2px 2px 5px #e8e8e8;
    }
    div.alphabet span.active {
        color: black;
    }
    .add-btn-position {
        width: 84px;
        position: relative;
        right: -29px;
    }
    .btn-text-position {
        position: relative;
        right: -6%;
        font-size: 15px;
    }
    .content-position {
        position: relative;
        top: -25px;
    }
    .add-btn-text {
        position: relative;
        right: -13px;
    }
    .btns-text {
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
    }
    .btns-text:hover {
        color: #909090 ;
    }
    .btns-style {
        width: 100%;
        height: 100%;
        background-color: #909090;
        border: unset;
        border-radius: 5px;
    }
    .btns-card:hover {
        background-color: #ffffff
    }
    .btns-padding {
        padding-left: 0.2rem;
        padding-right: 0.2rem;
    }
    .btns-right-position {
        position: relative;
        right: 14px;
    }
    .btn-top {
        position: relative;
        top: 11px;
    }
    @media only screen and (min-device-width : 768px) and (max-device-width : 1024px) {
   .btn_set{
    max-width: none;
    flex:none;
    right:0px;

   }
   .div_display{
    display:none;
   }
   .div_align{
    justify-content: center;
   }
   .search_orga{
    width:200% !important;
   }
   .pagina001{
        flex-wrap: wrap;
     }
  }@media only screen and (min-device-width : 834px) and (max-device-width : 1024px) and (orientation : portrait) {

    }
    .hide {
  display: none;
}

.filter {
        padding-bottom: 0rem;
        position: relative;
        width: 98%;
        left: 1%;
        top: -0.25rem;
        border-radius: 6px !important;
    }
    .search1 {
        position: relative;
        margin-top: -0.6rem;
        margin-bottom: 1rem;
    }
    .card{
        background-color: white;
        border: none;
        border-radius: 0rem;
    }
    .styled-button{
        outline: unset;
        color: #d3d3d3;
        background-color: #fafafa;;
        border: 1px solid #d3d3d3;
        padding: .3rem;
        padding-left: .7rem;
        padding-right: .7rem;
        margin: 0rem;
        cursor: pointer;
    }
    .searchbox-layout{
        margin-top: 0 !important;
        width: 100% !important;
        height: 29px;
        font-size: .9rem;
        color: #B3B3B3;
        border: unset;
    }
    .new-style-table table.dataTable thead .sorting:before,table.dataTable thead .sorting_asc:before,table.dataTable thead .sorting_desc:before,table.dataTable thead .sorting_asc_disabled:before,table.dataTable thead .sorting_desc_disabled:before {
        content: "\f0de";
        font-family: FontAwesome;
    }
    .new-style-table table.dataTable thead .sorting:after,table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting_desc:after,table.dataTable thead .sorting_asc_disabled:after,table.dataTable thead .sorting_desc_disabled:after {
        content: "\f0dd";
        font-family: FontAwesome;
        right: .65rem !important;
    }
    .new-style-table table thead tr{
        background-color: grey;
        color: white;
        height: 40px;
        font-size: .7rem;
    }
    .new-style-table table tr{
        background-color: white;
        color: grey;
        min-height: 40px;
        font-size: .7rem;
        border-bottom: 1px solid #b3b3b3;
    }
    .new-style-table table tbody tr:hover{
        background-color: #f6f6ff;
    }
    .new-style-table th, .new-style-table td {
        padding: 10px;
    }
    .table-responsive .table tbody td , .table-responsive .table tbody td a {
        padding: 0.4rem 1rem !important;
        font-size: .9rem !important;
        color: rgba(22, 22, 23, 1) !important;
    }
    .new-style-table table thead tr{
        background-color: rgba(50, 50, 50, 1) !important;
        height: 40px;
    }
    .btn-inside-table button{
        width: 100% !important;
        padding: 5% 3% !important;
        font-size: .7rem !important;
        height: 2.1rem;
        font-size: .7rem !important;
    }
    body {
        font-family: 'Open Sans', 'sans-serif' !important;
    }
    .hide {
        display: none;
    }
    .btn-green-filled {
        outline: unset !important;
        width: fit-content;
        padding: .5rem 1rem;
        color: white;
        background-color: #47D6B6;
        border: 2px solid #47D6B6;
        font-weight: 700;
        font-size: .7rem;
        cursor: pointer;
    }
</style>

@if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection


    <div class="col-md-12">
        <div class="card">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-9 mt-3">
                            <span>Select Financial Year &nbsp;<span>
                            <select id="financial_year" name="financial_year">
                                @foreach($yearList as $year)
                                    <option value="{{ $year }}" {{ isset($financial_year) && $financial_year == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        @can('add debit record')
                        <div class="col-md-3 mt-3 text-right">
                            <button class="btn-green-filled ml-auto" style="outline: unset;" href="#" data-toggle="modal" data-target="#debit_create_modal" title="Add Debit">
                                Add Debit
                            </button>
                        </div>
                        @endcan
                    </div>
                </div>
                <div class="col-md-12 mt-3 mb-3 new-style-table">
                    <div class="table-responsive">
                        <table class="table align-items-center" id="debit_account_table">
                            <thead>

                                <th scope="col" class="transaction-id">Transaction ID</th>
                                <th scope="col" class="debit-task">+ / -</th>
                                <th scope="col" class="current-value">Current Value</th>
                                <th scope="col" class="debit-description">Description</th>
                                <th scope="col" class="pay-for">Pay for</th>
                                <th scope="col" class="created-at">Created At</th>
                            </thead>

                            <tbody>
                                @foreach ($DebitAccountRecords as $DebitAccountRecord)
                                        <tr>
                                            <td class="transaction-id">
                                                <a href="javascript:void(0);" class="show-image"
                                                   data-image-url="{{ $DebitAccountRecord->image_url ? url('public/' . $DebitAccountRecord->image_url) : asset('assets/img/products/product defaul image.jpg') }}"
                                                   data-transaction-id="{{ $DebitAccountRecord->transaction_id }}">
                                                    {{ $DebitAccountRecord->transaction_id }}
                                                </a>
                                            </td>
                                            <td class="debit-task text-right">{!! $DebitAccountRecord->task !!}</td>
                                            <td class="current-value text-right">{{$DebitAccountRecord->current_value}}</td>
                                            <td class="debit-description">{{$DebitAccountRecord->description}}</td>
                                            <td class="pay-for">{{$DebitAccountRecord->pay_for ?? 'DWC'}}</td>
                                            <td class="created-at">{{ $DebitAccountRecord->created_at->format('m/d/Y') }}</td>
                                        </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</div>
<!-- Modal Structure -->
<div class="modal fade" id="debit_create_modal" tabindex="-1" role="dialog" aria-labelledby="debitCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="debitCreateModalLabel">Add Debit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="debit_create_form">
                    <h5 class="modal-title">Current debit account balance = ${{$currentDebitValue}}</h5>
                    <!-- Transaction ID -->
                    <div class="form-group mt-3">
                        <label for="transaction_id">Transaction ID</label>
                        <input type="text" class="form-control" id="transaction_id" value="{{$transactionID}}" name="transaction_id" readonly>
                    </div>

                    <!-- Amount -->
                    <div class="form-group">
                        <label for="payment_amount">Amount</label>
                        <input type="number" step="0.01" class="form-control" id="payment_amount" name="amount" required>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="3" required></textarea>
                    </div>

                    <!-- Pay for -->
                    <div class="form-group">
                        <label for="pay_for">Pay for</label>
                        <select class="form-control" name="pay_for" id="pay_for" disabled>
                            <option value="DWC" selected>DWC</option>
                        </select>
                    </div>

                    <!-- Current Value -->
                    <div class="form-group" style="display: none">
                        <label for="current_value">Current debit account</label>
                        <input type="number" step="0.01" class="form-control" id="current_value" value="{{$currentDebitValue}}" name="current_value" readonly>
                    </div>

                    <!-- New Current Value -->
                    <div class="form-group">
                        <label for="new_current_value">New debit account balance</label>
                        <p id="new_current_value_text">{{$currentDebitValue}}</p>
                        <input type="number" step="0.01" class="form-control" id="new_current_value" name="new_current_value" value="{{$currentDebitValue}}" style="display: none">
                    </div>

                    <div class="form-group mb-1 mt-3">
                        <label for="upload_image">Upload Image for payment reference</label>
                        <input type="file" id="upload_image" name="upload_image" accept="image/png, image/jpeg" class="form-control" style="width: auto;height: auto;" onchange="previewImage(event)">
                    </div>

                    <div class="form-group" id="imagePreview" style="display:none;">
                        <img id="uploaded_image" src="" alt="Uploaded Image" style="width: auto; height: 5rem;">
                        <button type="button" id="removeImage">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save_debit">Save Debit</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="imageModalLabel" style="font-size: 1.2rem;">Transaction Image</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
          <img id="transactionImage" src="" alt="Transaction Image" style="max-width: 100%; height: auto;">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

@section('order-header')
    <span>DEBIT ACCOUNT - ${{$currentDebitValue}}</span>
@endsection

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('uploaded_image');
            output.src = reader.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    document.getElementById('removeImage').addEventListener('click', function() {
        document.getElementById('upload_image').value = '';
        document.getElementById('uploaded_image').src = '';
        document.getElementById('imagePreview').style.display = 'none';
    });
</script>

<script>

    $(document).ready(function () {

        var debit_account_table = $('#debit_account_table').DataTable({
                colReorder: false,
                stateSave: true,
                "autoWidth": false,
                "pageLength": 50,
                "bSort" : false,
                language: {
                    search: '<i class="fas fa-search"></i>',
                    searchPlaceholder: 'Debit Search'
                }
            });

    });

    $(document).ready(function() {
        $("#financial_year").change(function() {
            $(".se-pre-con").fadeIn('slow');
            var selectedYear = $(this).val();
            var baseUrl = "{{ url('/') }}";
            window.location.href = baseUrl + "/chart_of_accounts/debit_account?financial_year=" + selectedYear;
        });
    });

    $(document).ready(function() {
        $('.show-image').click(function() {
            var imageUrl = $(this).data('image-url');
            var transactionId = $(this).data('transaction-id');

            $('#transactionImage').attr('src', imageUrl);

            $('#imageModalLabel').text('Transaction Image #' + transactionId);

            $('#imageModal').modal('show');
        });
    });

    $('#save_debit').on('click', function () {
        var form = $('#debit_create_form')[0];

        var formData = new FormData(form);

        var amount = parseFloat($('#payment_amount').val());
        var current_value = parseFloat($('#current_value').val());
        var new_value = current_value - amount;

        formData.append('new_current_value', new_value);

        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: "{{ route('chart_of_accounts.save_debit_record') }}",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#debit_create_modal').modal('hide');
                // location.reload();
            },
            error: function (error) {
                console.log('Failed to save debit record.');
                // location.reload();
            }
        });
    });

    $(document).on('change', '#current_value, #payment_amount', function() {

        var current_value = parseFloat($('#current_value').val()) || 0;
        var payment_amount = parseFloat($('#payment_amount').val()) || 0;

        $('#new_current_value').val((current_value + payment_amount).toFixed(2));
        $('#new_current_value_text').text((current_value + payment_amount).toFixed(2));
    });


</script>



@endsection
