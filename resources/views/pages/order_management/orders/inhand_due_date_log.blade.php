<style>
    th, td {
        vertical-align: middle !important;
    }
    .modal-title{
        margin-left: 1rem;
        color: black;
        font-size: 1.3rem;
    }
    .modal-xl{
        max-width:95%;
    }

    .table-responsive{
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
    }

    #inhand_due_log_table{
        min-width:900px;
    }

    #inhand_due_log_table th,
    #inhand_due_log_table td{
        white-space:nowrap;
        vertical-align:middle !important;
    }

    @media (max-width:768px){

        .modal-dialog{
            margin:10px;
        }

        .modal-body{
            padding:12px;
            margin-right:0 !important;
        }

        .modal-title{
            font-size:18px;
            margin-left:0;
        }

        #inhand_due_log_table{
            font-size:13px;
        }

        #inhand_due_log_table th,
        #inhand_due_log_table td{
            padding:8px;
        }
    }

    .desktop-log-table{
    display:block;
}

.mobile-log-cards{
    display:none;
}

/*------------------ Mobile ------------------*/

@media(max-width:768px){

    .desktop-log-table{
        display:none;
    }

    .mobile-log-cards{
        display:block;
    }

    .log-card{

        background:#fff;
        border-radius:14px;
        margin-bottom:18px;
        overflow:hidden;

        box-shadow:
            0 3px 12px rgba(0,0,0,.08);

        border:1px solid #ececec;
    }

    .log-card-header{

        background:#4E4C4C;
        color:#fff;

        display:flex;
        justify-content:space-between;
        align-items:center;

        padding:12px 16px;
    }

    .order-no{

        font-weight:600;
        font-size:15px;
    }

    .log-date{

        font-size:12px;
        opacity:.9;
    }

    .log-card-body{

        padding:14px 16px;
    }

    .log-row{

        display:flex;
        justify-content:space-between;
        align-items:flex-start;

        margin-bottom:12px;
        border-bottom:1px dashed #e5e5e5;
        padding-bottom:10px;
    }

    .log-row:last-child{
        border-bottom:none;
        margin-bottom:0;
        padding-bottom:0;
    }

    .log-row span{

        color:#777;
        font-size:13px;
        min-width:100px;
    }

    .log-row strong{

        text-align:right;
        color:#333;
        font-weight:600;
    }

    .reason{

        display:block;
    }

    .reason span{

        display:block;
        margin-bottom:8px;
    }

    .reason p{

        margin:0;
        color:#444;
        line-height:1.5;
        word-break:break-word;
    }
    .mobile_card_margin_unset {
        margin: unset !important;
    }
}
</style>
<div class="modal fade" id="modal_inhand_due_date_log" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">In Hand Due Date Log</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body" style="margin-right: 3%;">
                <div class="row mobile_card_margin_unset" style="width: 100%;margin-left: 15px;">
                    <div class="col-md-12">
                        <div class="table-responsive desktop-log-table">
                            <table class="table" id="inhand_due_log_table">
                                <thead>
                                    <tr style="color: white;background-color: #4E4C4C;height: 35px;">
                                        <th scope="col" style="padding-left: 10px;">Changed Date</th>
                                        <th scope="col">Order no</th>
                                        <th scope="col">User</th>
                                        <th scope="col">Previous Date</th>
                                        <th scope="col">New Date</th>
                                        <th scope="col">Reason</th>
                                    </tr>
                                </thead>
                                {{-- <tbody> --}}
                                    <tbody id="inhand_due_log_table_tbody">
                                        @forelse ($inHandDueDateLogs as $inHandDueDateLog)
                                            <tr style="color: #4E4C4C;height: 35px;border-bottom: 1px solid #b3b3b3;">
                                                <td style="padding-left: 10px;">{{ \Carbon\Carbon::parse($inHandDueDateLog->created_at)->format('m/d/Y') }}</td>
                                                <td>{{ $inHandDueDateLog->orderDetail->order_no ?? '' }}</td>
                                                <td>{{ $inHandDueDateLog->userDetail->name ?? '' }}</td>
                                                <td>{{ $inHandDueDateLog->pre_date }}</td>
                                                <td>{{ $inHandDueDateLog->new_date }}</td>
                                                <td>{{ $inHandDueDateLog->reason }}</td>
                                            </tr>
                                        @empty
                                            <tr style="color: #4E4C4C;height: 35px;border-bottom: 1px solid #b3b3b3;">
                                                <td colspan="5" style="padding-left: 10px;"><i>No Logs</i></td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                {{-- </tbody> --}}
                            </table>
                        </div>

                        <div class="mobile-log-cards">

                            @forelse($inHandDueDateLogs as $log)

                                <div class="log-card">

                                    <div class="log-card-header">
                                        <span class="order-no">
                                            {{ $log->orderDetail->order_no ?? '-' }}
                                        </span>

                                        <span class="log-date">
                                            {{ \Carbon\Carbon::parse($log->created_at)->format('m/d/Y') }}
                                        </span>
                                    </div>

                                    <div class="log-card-body">

                                        <div class="log-row">
                                            <span>User</span>
                                            <strong>{{ $log->userDetail->name ?? '-' }}</strong>
                                        </div>

                                        <div class="log-row">
                                            <span>Previous Date</span>
                                            <strong>{{ $log->pre_date }}</strong>
                                        </div>

                                        <div class="log-row">
                                            <span>New Date</span>
                                            <strong class="text-success">{{ $log->new_date }}</strong>
                                        </div>

                                        <div class="log-row reason">
                                            <span>Reason</span>

                                            <p>
                                                {{ $log->reason ?: '-' }}
                                            </p>
                                        </div>

                                    </div>

                                </div>

                                @empty

                                <div class="text-center p-4">
                                    <i>No Logs</i>
                                </div>

                            @endforelse

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
