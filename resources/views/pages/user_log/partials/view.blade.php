@foreach ($audits as $field=>$audit)
    @if ($type == 'view')
        @if ($field == 'order_status_id')
            <div class="row">
                <div class="col">
                    <h5 class="text-capitalize">{{ str_replace('_', ' ', $field) }}</h5>
                    <hr style="margin-top: inherit; margin-bottom: 0.5rem;">
                    <div class="row">
                        <div class="col-md-2 text-right" style="padding-right: 2rem; font-weight: bold;"> New : </div>
                        <div class="col-md-10" style="font-weight: bold;"> {{ \App\Helpers\AuditViewHelper::getOrderStatusName($audit['new']) }}</div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-2 text-right" style="padding-right: 2rem;"> Previous : </div>
                        <div class="col-md-10"> {{ \App\Helpers\AuditViewHelper::getOrderStatusName($audit['old']) }}</div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col">
                    <h5 class="text-capitalize">{{ str_replace('_', ' ', $field) }}</h5>
                    <hr style="margin-top: inherit; margin-bottom: 0.5rem;">
                    <div class="row">
                        <div class="col-md-2 text-right" style="padding-right: 2rem; font-weight: bold;"> New : </div>
                        <div class="col-md-10" style="font-weight: bold;"> {!! $audit['new'] !!}</div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-2 text-right" style="padding-right: 2rem;"> Previous : </div>
                        <div class="col-md-10"> {!! $audit['old'] !!}</div>
                    </div>
                </div>
            </div>
        @endif
    @else
        @if ($field != 'id')
            @if ($field == 'order_status_id')
                <div class="row mb-1">
                    <div class="col-md-2 d-flex justify-content-end text-right" style="font-weight: bold;"><h5 class="text-capitalize">{{ str_replace('_', ' ', $field) }}</h5></div>
                    <div class="" style="font-weight: bold;">:</div>
                    <div class="col-md-9" style="font-weight: bold;"> {{ \App\Helpers\AuditViewHelper::getOrderStatusName($audit['new']) }} </div>
                </div>
            @else
                <div class="row mb-1">
                    <div class="col-md-2 d-flex justify-content-end text-right" style="font-weight: bold;"><h5 class="text-capitalize">{{ str_replace('_', ' ', $field) }}</h5></div>
                    <div class="" style="font-weight: bold;">:</div>
                    <div class="col-md-9" style="font-weight: bold;"> {!! $audit['new'] !!} </div>
                </div>
            @endif
        @endif
    @endif
@endforeach
