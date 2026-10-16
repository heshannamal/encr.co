<style>
    th, td {
        vertical-align: middle !important;
    }
    .modal-title{
        margin-left: 1rem;
        color: black;
        font-size: 1.3rem;
    }
</style>
<div class="modal fade" id="modal_ex_factory_date_log" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Ex-Factory Date Log</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body" style="margin-right: 3%;">
                <div class="row mobile_card_margin_unset" style="width: 100%;margin-left: 15px;">
                    <div class="col-md-12">
                        <div class="table-responsive desktop-log-table">
                            <table class="table" id="ex_factory_log_table">
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
                                    <tbody id="ex_factory_log_table_tbody">
                                        @forelse ($exfactoryLogs as $exfactoryLog)
                                            <tr style="color: #4E4C4C;height: 35px;border-bottom: 1px solid #b3b3b3;">
                                                <td style="padding-left: 10px;">{{ \Carbon\Carbon::parse($exfactoryLog->created_at)->format('m/d/Y') }}</td>
                                                <td>{{ $exfactoryLog->orderDetail->order_no ?? '' }}</td>
                                                <td>{{ $exfactoryLog->userDetail->name ?? '' }}</td>
                                                <td>{{ $exfactoryLog->pre_date }}</td>
                                                <td>{{ $exfactoryLog->new_date }}</td>
                                                <td>{{ $exfactoryLog->reason }}</td>
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

                            @forelse($exfactoryLogs as $log)

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

                                            <p>{{ $log->reason ?: '-' }}</p>
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
