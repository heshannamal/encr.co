<style>
    .order-tile {
        border-radius: 12px;
        width: 50px;
        height: 50px;
        align-items: center;
        display: flex;
        fill: #fff;
        flex-direction: column;
        justify-content: center;
        flex-flow: column;
        position: relative;
    }
    .order-tile img {
        width: 35px;
        height: 35px;
        vertical-align: middle;
    }
    .management_title {
        padding-left: 15px;
        margin-bottom: 0;
    }

</style>

<div class="card">
    <div class="card-body">
        <div class="col-md-12">
            <div class="row pb-1" style="border-bottom: 1px solid #d2d2d2;">
                <div>
                    <div class="order-tile" style="background-color: {{$project->project_color}}">
                        <img src="{{asset('argon')}}/img/icons/lacrosse.png">
                    </div>
                </div>

                <div>
                    @if ($project->project_type_id == 2)
                        <h4 class="management_title">#{{$project->project_no}} - {{$product->product_name}}<br><small class="text-muted">{{$project->project_description}}</small></h4>
                    @else
                        <h4 class="management_title">#{{$project->project_no}} {{$project->project_name}}<br><small class="text-muted">{{$project->project_description}}</small></h4>
                    @endif
                </div>
            </div>
        </div>

        @include('pages.project.project_details.management.list')
    </div>
</div>
