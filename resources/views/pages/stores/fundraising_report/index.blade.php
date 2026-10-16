@extends('layouts.app', ['activePage' => 'Team Stores', 'titlePage' => __('Team Stores')])

@section('sub-sidebar-content')

<style>
    .main_card {
        margin-top: 20px;
        border: unset;
        padding-bottom: 15px;
        border-radius: unset;
    }

    .accounting_header {
        font-size: 18px;
    }
    .card_div {
        padding: 15px;
        padding-bottom: 5px;
    }
    .per_page {
        font-size: 11px;
        color: #717070;
        font-weight: 500;
        margin-bottom: unset;
    }
    .search_icon {
        padding-top: 3px;
        padding-right: 6px;
    }
    .search_input {
        height: 25px;
        border: unset;
        width: 160px;
    }
    .table_header_text {
        color: white;
        height: 40px;
    }
    .accounting_sub_header {
        font-size: 19px;
    }
    .timeline_topic {
        font-size: 13px;
        color: #4E4C4C;
        font-weight: 600;
        margin-bottom: unset;
    }
    .timeline_details {
        font-size: 13px;
        color: #717070;
        font-weight: 400;
        margin-bottom: unset;
    }
    .account_topic {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: unset;
    }
    .account_details {
        font-size: 13px;
        font-weight: 400;
        margin-bottom: unset;
    }
    .account_details1 {
        font-size: 17px;
        font-weight: 600;
        margin-bottom: unset;
    }
    .timeline_row {
        margin: unset;
    }
    .timeline_topic_div {
        padding-bottom: 5px;
        width: 7rem;
    }
    .account_summary_div {
        padding-bottom: 5px;
        width: 11rem;
    }
    .account_summary_details_div {
        width: 5rem;
        text-align: right;
    }

    @media (max-width: 767px) {
        /* .card_div {
            padding: 10px 5px;
        }
        .account_summary_div {
            padding-bottom: 5px;
            width: 100%;
        }
        .account_summary_details_div {
            width: 100%;
            text-align: left;
        } */

        .header-layout {
            margin-bottom: 0 !important;
            height: auto !important;
            min-height: 0 !important;
        }

        /* Prevent iOS Safari from auto-zooming on focus */
        input[type="text"],
        input[type="number"],
        input[type="search"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        input[type="url"],
        select,
        textarea,
        .form-control,
        .select2-selection,
        .select2-search__field,
        .select2-search input {
            font-size: 16px !important;
        }
    }

</style>


<div class="container-fluid mb-5" style="background-color: transparent;padding: 0 !important;">
    <div class="se-pre-con"></div>

    @include('pages.stores.layouts.top_header')

    @yield('stores_header')

    <div class="card col-lg-12 main_card" style="margin-top: 20px;">
        <div class="row">
            <div class="card_div col-md-10 mb-3">
                <strong class="accounting_header">Fundraising Report</strong>
            </div>
            <div class="card_div col-md-2 mb-3 text-right">
                <button type="button" class="view_store_btn" id="export_fundraising" style="width: 5rem">Export</button>
            </div>
            <div class="col-lg-12">
                    <div class="" style="padding-top: 5px; padding-bottom: 5px;">
                        <p>You are currently collected a total fundraising amount of ${{number_format($totalFundraising,2)}} from all {{$store->StoreOrders->where('is_payment_success', 1)->where('active', 1)->count()}} order(s) to-date. <br>
                        Your net fundraising is ${{number_format($totalFundraising * 97/100,2)}}</p>
                    </div>

                    <div class="row timeline_row">
                        <div class="account_summary_div" >
                            <p class="account_topic">Fundraising Collected ($) </p>
                        </div>
                        <div class="account_summary_details_div">
                            <p class="account_details">{{number_format($totalFundraising,2)}}</p>
                        </div>
                    </div>

                    <div class="row timeline_row">
                        <div class="account_summary_div" >
                            <p class="timeline_topic">Card Processing Fees ($)</p>
                        </div>
                        <div class="account_summary_details_div">
                            <p class="timeline_details">{{number_format($totalFundraising * 3/100,2)}}</p>
                        </div>
                    </div>

                    <div class="row timeline_row">
                        <div class="account_summary_div" >
                            <p class="account_topic" style="font-size: 17px">Net Fundraising ($)</p>
                        </div>
                        <div class="account_summary_details_div">
                            <p class="account_details1">{{number_format($totalFundraising * 97/100,2)}}</p>
                        </div>
                    </div>
            </div>
        </div>

        <hr style="margin: unset; margin-bottom: 15px; margin-top: 10px;">

    </div>

</div>

<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" style="background-color: #f5f5f5;">
      <div class="modal-header">
        <h5 class="modal-title" id="exportModalLabel">Export Store Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true" aria-label="Close">x</button>
      </div>

      <div class="modal-body text-center" style="padding: 10px;">
        <div id="pdf-content" style="background-color: white; padding: 15px;padding: 1rem 5rem;">

          <div class="row mx-3 my-5">
            <div class="col-md-6 text-left">
              <span>{{ $store->coach_name }}</span><br>
              <span>{{ $store->service_phone }}</span>
            </div>
          </div>

          <div class="col-md-12 my-5 d-flex align-items-center text-left" style="gap: 1rem;">
            <img src="{{ asset($store->themeDetails->primary_logo) }}" alt="store logo" style="max-width: 120px;">
            <div style="font-size: 1.25rem; font-weight: 600;">{{ $store->store_name }}</div>
          </div>

          <div class="col-md-12 text-center my-8">
            <div style="width: 15rem; height: 6rem; border: 3px solid #000; margin: 0 auto; padding: 20px; display: flex; flex-direction: column; justify-content: center; align-items: center; font-size: 1.3rem; font-weight: 600;">
              <span>Total Fundraising</span>
              <span>${{number_format($totalFundraising * 97/100,2)}}</span>
            </div>
          </div>

        </div>

        <!-- Download Button -->
        <button id="download_pdf" class="btn btn-primary mt-3">Download PDF</button>
      </div>
    </div>
  </div>
</div>




<script>
    $(document).ready(function() {
    $('#export_fundraising').on('click', function() {
        $('#exportModal').modal('show');
    });

    $('#download_pdf').on('click', function () {
        var element = document.getElementById('pdf-content');

        var opt = {
            margin:       0.5,
            filename:     'my-document.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
        };

        html2pdf().from(element).set(opt).save();
    });
});

</script>

@endsection
@section('content')
    @include('pages.stores.layouts.sidebar', ['sub_content' => 'fundraising_report'])
@endsection

