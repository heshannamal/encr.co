@extends('layouts.app', ['activePage' => 'team_store', 'titlePage' => __('Team Store Order Reports')])

@section('content')
<style>
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
    }
    .form-field {
        align-items: center;
    }
    .form-field .form-lable {
        width: 30%;
    }
    .btn-team-store-download {
        border-radius: 1rem;
        padding: 0.1rem 0.5rem;
        font-size: 10px;
    }
    .select2.select2-container {
        width: 100% !important;
    }
</style>

<div class="container-fluid mb-5">
    <div class="se-pre-con"></div>

    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="float-left header-title">Team Store Order Reports</h1>
                        </div>
                        <div class="col-md-6 header-icons justify-content-end">
                            <span>
                                <a class="btn btn-round" href="#" data-toggle="modal" data-target="#import_modal" title="Import Team Store Orders Reports">
                                    <i class="fas fa-upload"></i>
                                </a>
                                <p>Import</p>
                            </span>

                            <span>
                                <a class="btn btn-round" href="#" data-toggle="modal" data-target="#layout_modal">
                                    <i class="fas fa-wrench"></i>
                                </a>
                                <p>Table Layout</p>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table align-items-center cell-border table-bordered" id="orders_table">
                            <thead class="bg-theme">
                                <th></th>
                                <th>Order No</th>
                                <th>Report Name</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                            </thead>

                            <tbody>
                                @foreach ($teamStores as $teamStore)
                                    <tr>
                                        <td><button type="button" class="btn btn-sm btn-info btn-team-store-download" value="{{$teamStore->id}}"><i class="fas fa-download"></i> download</button></td>
                                        <td>
                                            @if ($teamStore->order_id)
                                                <a href="#" class="edit-order" data-value="{{$teamStore->order_id}}">{{$teamStore->order_no}}</a>
                                            @else
                                                {{$teamStore->order_no}}
                                            @endif
                                        </td>
                                        <td>{{$teamStore->team_store_report_name}}</td>
                                        <td>{{$teamStore->created_at->format('m-d-Y')}}</td>
                                        <td>{{$teamStore->updated_at->format('m-d-Y')}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="import_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Import Team Store Order Report</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('team_store.create')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="col-md-12 form-field">
                            <label class="form-lable">Organization: <span class="text-danger">*</span></label>
                            <select class="invoice-inputs select2-add-item" name="organization_id" id="organization_id" required>
                                <option value="">Select an Organization</option>
                                @foreach($organizations as $organization)
                                    <option value="{{$organization->id}}">{{$organization->organization_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="col-md-12 form-field">
                            <label class="form-lable">Team Store Order Report (.xlsx): <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="team_store_report" name="team_store_report" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required />
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 control-btns">
                        <button type="reset" class="btn btn-secondary btn-custom">Cancel</button>
                        <button type="submit" class="btn btn-success btn-custom">Import</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $(".se-pre-con").fadeOut('slow');
        $('.select2-add-item').select2({
            dropdownParent: $("#import_modal")
        });

        var orderTable = $('#orders_table').DataTable({
            language: {
                search: '<i class="fas fa-search"></i>',
                searchPlaceholder: 'Search'
            },
            "pageLength": 50
        });
    });

    $('body').on('click', '.btn-team-store-download', function(e){
        var teamStoreId = $(this).val();

        $.ajax({
            url: '{{ url("team_store/get_team_store_report") }}/'+teamStoreId,
            type: "GET",
            dataType: 'json',
            beforeSend: function() {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data) {
                console.log(data);
                e.preventDefault();
                window.location.href = data.team_store_report;
            },
            complete: function() {
                $(".se-pre-con").fadeOut('slow');
            }
        });
    });

    // Edit Order
    $("body").on("click", ".edit-order", function(){
        var orderId = $(this).data('value');
        window.location.replace('order_details/edit/'+orderId+'/order?active_tab=order');
    });
</script>
@endsection
