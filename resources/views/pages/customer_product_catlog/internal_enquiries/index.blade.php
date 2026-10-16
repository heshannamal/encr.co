@extends('layouts.app', ['activePage' => 'enquiries', 'titlePage' => __('Enquiries')])

@section('content')
    <style>
        .main-content {
            background-color: #F8F8F8;

        }
        .container-fluid {
            margin-bottom: 1rem !important;
        }
        .enquiry-name {
            padding: 0.4rem 1rem !important;
        }
        .table_row {
            background-color: transparent !important;
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
            border-top: 1px solid #e9ecef !important;
        }
        .new-style-table table tbody tr:hover{
            background-color: #f6f6ff;
        }
        .new-style-table th, .new-style-table td {
            padding: 10px;
            vertical-align: middle !important;
        }
        .new-style-table .dataTables_info {
            color:#b3b3b3;
        }
        .new-style-table table thead tr{
            background-color: rgba(50, 50, 50, 1) !important;
        }
        .new-style-table .table tbody td , .new-style-table .table tbody td a {
            padding: 0.4rem 1rem !important;
            font-size: .9rem !important;
            color: rgba(22, 22, 23, 1) !important;
        }
        .pagination_current_btn {
            background-color: rgb(232, 232, 232);
            color: rgb(166, 166, 166);
            border-radius: unset;
            border: 1px solid rgb(166, 166, 166) !important;
            padding: 10px 12px;
            font-weight: 300;
        }
        .pagination_current_btn:hover {
            background-color: rgb(232, 232, 232);
            color: rgb(166, 166, 166);
            border-radius: unset;
            border: 1px solid rgb(166, 166, 166) !important;
            padding: 10px 12px;
            font-weight: 300;
        }
        .table_row:hover {
            background-color: #f6f6ff !important;
            cursor: pointer;
        }
        #editEnquiryForm {
            font-size: 14px;
        }
        .modal_detail_topic {
            color: gray;
        }
        .enquiry-message {
            max-width: 200px;   /* කොළමට අවශ්‍ය විතරක් width දාන්න */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

    </style>

<div class="container-fluid mb-5 content-position">
    {{-- <div class="se-pre-con"></div> --}}

    @section('order-header')
        <span>ENQUIRIES</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection


    <div class="card-body" style="margin-bottom: 1%; background-color: white;">
        <div class="row mb-3" style="border-bottom: 1px solid #c7c7c7">
            <div class="col-lg-4">
                <div class="form-group d-flex align-items-center" style="position: absolute; bottom:-13px">
                  <label for="rowsPerPageSelect" class="col-form-label" style="color: #838383">Show rows per page</label>
                  <select class="form-control form-control-alternative form-control-sm rounded-pill ml-2" id="rowsPerPageSelect" style="color:rgb(22, 199, 140); border-radius: 1rem; border: 1px solid #aeadad; width: 65px; height: 35px; font-size: 15px; background-color:#f0f0f0">
                    <option value="25" selected>25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                  </select>
                </div>
              </div>
            <div class="col-lg-5 input-group-prepend mt-3 mb-3">

            </div>
            <div class="col-lg-4"></div>
        </div>
        <div style="width: 100%; overflow-x: auto; white-space: nowrap;">
            <table style="text-align: center; min-width: 1200px;" class="table table-striped">
                <thead>
                    <tr style="background-color: rgba(50, 50, 50, 1); color:white;">
                        <th style="width:8%; padding: 0.4rem;">ENQUIRY NO <i class="fa fa-sort ml-auto" onclick="renderRecords('enquiry_no');" style="color: white; cursor:pointer"></i></th>
                        <th style="width:8%; padding: 0.4rem;">NAME <i class="fa fa-sort ml-auto" onclick="renderRecords('name');" style="color: white; cursor:pointer"></i></th>
                        <th style="width:8%; padding: 0.4rem;">EMAIL <i class="fa fa-sort ml-auto" onclick="renderRecords('email');" style="color: white; cursor:pointer"></i></th>
                        <th style="width:8%; padding: 0.4rem;">PHONE NO <i class="fa fa-sort ml-auto" onclick="renderRecords('phone_number');" style="color: white; cursor:pointer"></i></th>
                        <th style="width:8%; padding: 0.4rem;">TEAM NAME <i class="fa fa-sort ml-auto" onclick="renderRecords('team_name');" style="color: white; cursor:pointer"></i></th>
                        <th style="width:8%; padding: 0.4rem;">SPORT <i class="fa fa-sort ml-auto" onclick="renderRecords('sport');" style="color: white; cursor:pointer"></i></th>
                        <th style="width:8%; padding: 0.4rem;">MESSAGE <i class="fa fa-sort ml-auto" onclick="renderRecords('message');" style="color: white; cursor:pointer"></i></th>
                    </tr>
                </thead>
                <tbody id="tbodyrows">
                    @foreach ($enquiries as $enquiry)
                        <tr class="table_row">
                            <td class="enquiry-name"><a href="#" class="edit" data-value="{{$enquiry->id}}">EN-{{$enquiry->id}}</a></td>
                            <td class="enquiry-name"><a href="#" class="edit" data-value="{{$enquiry->id}}">{{$enquiry->name}}</a></td>
                            <td class="enquiry-name">{{$enquiry->email}}</td>
                            <td class="enquiry-name">{{$enquiry->phone_number}}</td>
                            <td class="enquiry-name">{{$enquiry->team_name}}</td>
                            <td class="enquiry-name">{{$enquiry->sport}}</td>
                            <td class="enquiry-message enquiry-name" title="{{ $enquiry->message }}">
                                {{ $enquiry->message }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <!-- Pagination Section -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <!-- Left side: Item count -->
            <div id="itemsCount" style="color: #b3b3b3; font-size: 14px;"></div>

            <!-- Right side: Pagination buttons -->
            <div id="pagination" class="d-flex"></div>
        </div>

    </div>

</div>

<div class="modal fade" id="editEnquiryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 800px;">
      <div class="modal-content">
        <div class="modal-header">
            <div class="card-header d-flex justify-content-between align-items-center" style="padding-left: 5%; padding-right: 5%">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 style="color: black">Order Enquire Details</h1>
                    </div>
                    <div class="col-lg-12">
                        <p style="color: grey">Refer the full order enquiry below.</p>
                    </div>
                </div>
            </div>

            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">&times;</span></button>
        </div>
        <div class="modal-body" style="padding: 0% 7% !important;">
          <form id="editEnquiryForm">
            <input type="hidden" id="hidden_enquiry_id">
            <div class="mb-3">
                <div class="row" style="margin: unset;">
                    <div class="col-lg-3" style="padding: unset;">
                        <span class="modal_detail_topic">Enquiry No</span>
                    </div>
                    <div class="col-lg-8" style="padding: unset;">
                        <span id="enquiry_id"></span>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="row" style="margin: unset;">
                    <div class="col-lg-3" style="padding: unset;">
                        <span class="modal_detail_topic">Received Date</span>
                    </div>
                    <div class="col-lg-8" style="padding: unset;">
                        <span id="received_date"></span>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 mt-4" style="padding: unset; padding-top: 20px !important;">
                <h3 style="color: black">CONTACT DETAILS</h3>
            </div>

            <div class="mb-3">
                <div class="row" style="margin: unset;">
                    <div class="col-lg-3" style="padding: unset;">
                        <span class="modal_detail_topic">Name</span>
                    </div>
                    <div class="col-lg-8" style="padding: unset;">
                        <span id="enquiry_name"></span>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="row" style="margin: unset;">
                    <div class="col-lg-3" style="padding: unset;">
                        <span class="modal_detail_topic">Email</span>
                    </div>
                    <div class="col-lg-8" style="padding: unset;">
                        <span id="enquiry_email"></span>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="row" style="margin: unset;">
                    <div class="col-lg-3" style="padding: unset;">
                        <span class="modal_detail_topic">Phone Number</span>
                    </div>
                    <div class="col-lg-8" style="padding: unset;">
                        <span id="phone_number"></span>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="row" style="margin: unset;">
                    <div class="col-lg-3" style="padding: unset;">
                        <span class="modal_detail_topic">Team Name</span>
                    </div>
                    <div class="col-lg-8" style="padding: unset;">
                        <span id="enquiry_team_name"></span>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="row" style="margin: unset;">
                    <div class="col-lg-3" style="padding: unset;">
                        <span class="modal_detail_topic">Sport</span>
                    </div>
                    <div class="col-lg-8" style="padding: unset;">
                        <span id="enquiry_sport"></span>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="row" style="margin: unset;">
                    <div class="col-lg-3" style="padding: unset;">
                        <span class="modal_detail_topic">Message</span>
                    </div>
                    <div class="col-lg-8" style="padding: unset;">
                        <span id="message"></span>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 mt-4" style="padding: unset; padding-top: 20px !important;">
                <h3 style="color: black">ITEMS</h3>
            </div>

            <div class="col-lg-12 mt-2 mb-4" style="padding: unset;">
                <table style="display:table; font-size:15px; width:100%" class="table-striped">
                    <tr style="height: 45px;background-color: #616060;color:white; text-align: center">
                        <th style="text-align: left">&nbsp;&nbsp;ITEM</th>
                        <th>PRODUCT NO </th>
                        <th>UNIT PRICE ($)</th>
                        <th>PATTERN CODE</th>
                    </tr>
                    <tbody id="modal_body">
                        <tr style="height: 45px; border-bottom: 1px solid #959595; text-align: center">
                            <td style="color: #616060; text-align: left">&nbsp;&nbsp;<span id="product_name"></span></td>
                            <td style="color: #616060"><span id="product_no"></span></td>
                            <td style="color: #616060"><span id="product_price"></span></td>
                            <td style="color: #616060"><span id="pattern_code"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>


<script>

    document.addEventListener("DOMContentLoaded", function() {
        const rows = document.querySelectorAll("#tbodyrows .table_row");
        const rowsPerPageSelect = document.getElementById("rowsPerPageSelect");
        const paginationDiv = document.getElementById("pagination");
        const itemsCountDiv = document.getElementById("itemsCount");

        let currentPage = 1;
        let rowsPerPage = parseInt(rowsPerPageSelect.value);

        function displayRows() {
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            rows.forEach((row, index) => {
                row.style.display = (index >= start && index < end) ? "" : "none";
            });

            renderPagination();
            renderItemsCount(start, end);
        }

        function renderPagination() {
            const pageCount = Math.ceil(rows.length / rowsPerPage);
            paginationDiv.innerHTML = "";

            for (let i = 1; i <= pageCount; i++) {
                const btn = document.createElement("button");
                btn.innerText = i;
                btn.className = "btn btn-sm mx-1 pagination_current_btn " + (i === currentPage ? "" : "");
                btn.addEventListener("click", function() {
                    currentPage = i;
                    displayRows();
                });
                paginationDiv.appendChild(btn);
            }
        }

        function renderItemsCount(start, end) {
            const total = rows.length;
            const showingStart = total === 0 ? 0 : start + 1;
            const showingEnd = end > total ? total : end;

            itemsCountDiv.innerText = `Showing ${showingStart} to ${showingEnd} of ${total} entries`;
        }

        rowsPerPageSelect.addEventListener("change", function() {
            rowsPerPage = parseInt(this.value);
            currentPage = 1;
            displayRows();
        });

        displayRows();
    });


    $(document).on('click', '.edit', function () {
        let enquiryId = $(this).data('value'); // button eken id ganna

        $.ajax({
            url: "{{ url('/enquiries') }}/" + enquiryId, // backend route ekata ganna
            type: 'GET',
            success: function (response) {
                console.log(response);
                // data modal eke input walata set karanna

                $('#enquiry_id').text("EN-" + response.enquiry.id);

                // Original timestamp
                let timestamp = response.enquiry.created_at;

                let dateOnly = timestamp.split('T')[0];

                $('#received_date').text(dateOnly);

                $('#enquiry_name').text(response.enquiry.name);
                $('#enquiry_email').text(response.enquiry.email);
                $('#phone_number').text(response.enquiry.phone_number);
                $('#enquiry_team_name').text(response.enquiry.team_name);
                $('#enquiry_sport').text(response.enquiry.sport);
                $('#message').text(response.enquiry.message);

                // hidden input ekak hadanna one nam separate id ekak dala use karanna
                $('#hidden_enquiry_id').val(response.enquiry.id);

                $('#product_name').text(response.product.product_name);
                $('#product_no').text(response.product.product_no);
                $('#product_price').text(response.product.default_price);
                $('#pattern_code').text(response.product.pattern_code);

                // modal open karanna
                $('#editEnquiryModal').modal('show');
            },
            error: function (xhr) {
                console.log("Error:", xhr.responseText);
            }
        });
    });


    $('.close').on('click', function() {
        $('#editEnquiryModal').modal('hide');
    });

</script>

@endsection
