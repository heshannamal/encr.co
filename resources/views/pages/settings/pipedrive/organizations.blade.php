@extends('layouts.app', ['activePage' => 'pipedrive_organizations', 'titlePage' => __('Organizations')])

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
    .select2-container {
        width: 90% !important;
    }
    .sync-text {
        font-weight: bold;
        font-size: 12px;
    }
    .synced-count {
        font-weight: bold;
        text-transform: uppercase;
        margin-left: 15px;
    }
    td {
        vertical-align: middle !important;
    }
</style>

<div class="container-fluid mb-5">
    <div class="se-pre-con"></div>

    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <h1 class="float-left header-title">Pipedrive Synchronization - Organizations</h1>

                    <div class="float-right header-icons"></div>
                </div>

            </div>

            <div class="card-body">
                <div class="col-md-12">
                    <form action="{{ route('pipedrive.organizations_upload') }}" id="organizations_upload_form" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="input-group">
                            <input type="file" class="form-control" name="organizations_csv" accept=".xlsx, .xls, .csv" required />
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-info btn-sm"><i class="fas fa-upload"></i> Upload</button>
                            </div>
                        </div>
                    </form>
                </div>

                <form action="{{ route('pipedrive.organizations_sync') }}" id="organizations_sync" method="post">
                    @csrf
                    <div class="row mt-3" style="display: flex; align-items: center;">
                        <div class="col-md-6">
                            <span class="synced-count">Synced/Total: {{$syncedPDOCount}}/{{$pDOCount}}</span>
                            <button type="submit" class="btn btn-sm btn-success btn-secondary-custom"><i class="fas fa-sync-alt"></i> Sync</button>
                        </div>

                        <div class="col-md-6" style="display: flex; justify-content: flex-end;">
                            {{ $pDOrganizations->onEachSide(1)->links("pagination::bootstrap-4") }}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-theme">
                                    <th>Pipedrive Organization</th>
                                    <th>Encroms Organization</th>
                                    <th>Status</th>
                                </thead>

                                <tbody>
                                    @foreach ($pDOrganizations as $pDOrganization)
                                        <tr>
                                            <td>{{$pDOrganization->organization_name}}</td>
                                            <td>
                                                <select class="form-control organization_id" name="organization[{{$pDOrganization->id}}]" id="organization_{{$pDOrganization->id}}">
                                                    <option value="">Select an Organizations</option>
                                                    @foreach ($organizations as $organization)
                                                        <option value="{{$organization->id}}" @if ($organization->id == $pDOrganization->organization_id) selected @endif>{{$organization->organization_name}}</option>
                                                    @endforeach
                                                </select>

                                                <button type="button" class="btn btn-sm btn-secondary btn-secondary-custom add-organization" value="{{$pDOrganization->id}}"><i class="fas fa-plus"></i></button>
                                            </td>
                                            <td>
                                                @if ($pDOrganization->is_synced == 1)
                                                    <span class="sync-text text-success">SYNCED</span>
                                                @else
                                                    <span class="sync-text text-danger">NOT SYNCED</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-3" style="display: flex; align-items: center;">
                        <div class="col-md-6">
                            <span class="synced-count">Synced/Total: {{$syncedPDOCount}}/{{$pDOCount}}</span>
                            <button type="submit" class="btn btn-sm btn-success btn-secondary-custom"><i class="fas fa-sync-alt"></i> Sync</button>
                        </div>

                        <div class="col-md-6" style="display: flex; justify-content: flex-end;">
                            {{ $pDOrganizations->onEachSide(1)->links("pagination::bootstrap-4") }}
                        </div>
                    </div>
            </form>
            </div>

        </div>
    </div>
</div>

@include('pages.settings.pipedrive.organization_create_modal')
@include('pages.settings.pipedrive.people_create_modal')

<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $(".se-pre-con").fadeOut('slow');

        $('select').select2();
        $('.select2-organization-modal').select2({
            dropdownParent: $('#organization_create_modal')
        });

        $('#organizations_upload_form').on('submit', function(e){
            e.preventDefault();
            $(".se-pre-con").fadeIn('slow');
            this.submit();
        });

        $('#organizations_sync').on('submit', function(e){
            e.preventDefault();
            $(".se-pre-con").fadeIn('slow');
            this.submit();
        });

        $('.add-organization').click(function(){
            var pdo_id = $(this).val();
            $('#pdo_id').val(pdo_id);
            $('#customer_id').val('');
            $('#organization_create_modal').modal('show');
        });
    });
</script>
@endsection
