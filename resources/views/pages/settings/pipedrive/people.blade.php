@extends('layouts.app', ['activePage' => 'pipedrive_people', 'titlePage' => __('People')])

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
                    <h1 class="float-left header-title">Pipedrive Synchronization - People</h1>

                    <div class="float-right header-icons"></div>
                </div>

            </div>

            <div class="card-body">
                <div class="col-md-12">
                    <form action="{{ route('pipedrive.people_upload') }}" id="people_upload_form" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="input-group">
                            <input type="file" class="form-control" name="people_csv" accept=".xlsx, .xls, .csv" required />
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-info btn-sm"><i class="fas fa-upload"></i> Upload</button>
                            </div>
                        </div>
                    </form>
                </div>

                <form action="{{ route('pipedrive.people_sync') }}" id="people_sync" method="post">
                    @csrf
                    <div class="row mt-3" style="display: flex; align-items: center;">
                        <div class="col-md-6">
                            <span class="synced-count">Synced/Total: {{$syncedPDCCount}}/{{$pDCCount}}</span>
                            <button type="submit" class="btn btn-sm btn-success btn-secondary-custom"><i class="fas fa-sync-alt"></i> Sync</button>
                        </div>

                        <div class="col-md-6" style="display: flex; justify-content: flex-end;">
                            {{ $pDContacts->onEachSide(1)->links("pagination::bootstrap-4") }}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-theme">
                                    <th>Pipedrive<br>Contact Person</th>
                                    <th>Pipedrive<br>Email</th>
                                    <th>Encroms<br>Contact Person</th>
                                    <th>Encroms<br>Email</th>
                                    <th>Pipedrive<br>Organization</th>
                                    <th>Encroms<br>Organization</th>
                                    <th>Status</th>
                                </thead>

                                <tbody>
                                    @foreach ($pDContacts as $pDContact)
                                        <tr>
                                            <td>{{$pDContact->contact_name}}</td>
                                            <td>{{$pDContact->email}}</td>
                                            <td>
                                                <select class="form-control contact_id" name="contact[{{$pDContact->id}}][contact_id]" id="contact_{{$pDContact->id}}">
                                                    <option value="">Select a Conatct Person</option>
                                                    @foreach ($peoples as $people)
                                                        <option value="{{$people->id}}" @if ($people->id == $pDContact->contact_id || ($people->email == $pDContact->email && !empty($pDContact->email))) selected @endif>{{$people->first_name ?? ''}}{{' '}}{{$people->last_name ?? ''}}</option>
                                                    @endforeach
                                                </select>

                                                <button type="button" class="btn btn-sm btn-secondary btn-secondary-custom add-contact" onclick="contactDataset({{ json_encode($pDContact) }}, {{$pDContact->id}})" value="{{$pDContact->id}}"
                                                    @foreach ($peoples as $people)
                                                        @if ($people->id == $pDContact->contact_id || ($people->email == $pDContact->email && !empty($pDContact->email))) disabled @endif
                                                    @endforeach
                                                ><i class="fas fa-plus"></i></button>
                                            </td>
                                            <td>
                                                @foreach ($peoples as $people)
                                                @if ($people->id == $pDContact->contact_id || ($people->email == $pDContact->email && !empty($pDContact->email))) {{$people->email}} @break @endif
                                                @endforeach
                                            </td>
                                            <td>{{$pDContact->pd_organization}}</td>
                                            <td>
                                                <select class="form-control" name="contact[{{$pDContact->id}}][organization_id]" id="encore_org_{{$pDContact->id}}">
                                                    <option value="">Select an Organizations</option>
                                                    @foreach ($organizations as $organization)
                                                        <option value="{{$organization->id}}" @if ($organization->organization_name == $pDContact->pd_organization) selected @endif @if ($organization->id == $pDContact->organization_id) selected @endif>{{$organization->organization_name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                @if ($pDContact->is_synced == 1)
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
                            <span class="synced-count">Synced/Total: {{$syncedPDCCount}}/{{$pDCCount}}</span>
                            <button type="submit" class="btn btn-sm btn-success btn-secondary-custom"><i class="fas fa-sync-alt"></i> Sync</button>
                        </div>

                        <div class="col-md-6" style="display: flex; justify-content: flex-end;">
                            {{ $pDContacts->onEachSide(1)->links("pagination::bootstrap-4") }}
                        </div>
                    </div>
            </form>
            </div>

        </div>
    </div>
</div>

@include('pages.settings.pipedrive.contact_create_modal')

<script>
    function contactDataset(data, pdc_id){
        var full_name = data.contact_name.trim();

        var first_name = '';
        var last_name = '';

        var name_parts = full_name.split(' ');

        if (name_parts.length === 1) {
            first_name = name_parts[0];
        } else {
            first_name = name_parts.shift();
            last_name = name_parts.join(' ');
        }

        $('#people_first_name').val(first_name);
        $('#people_last_name').val(last_name);
        $('#people_phone_no').val(data.phone_no);
        $('#people_email').val(data.email);

        var org_id = $('#encore_org_'+pdc_id).val();
        $('#people_organization_id').val(org_id);

        $('#pdc_id').val(pdc_id);
    }
</script>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $(".se-pre-con").fadeOut('slow');

        $('select').select2();
        $('.select2-organization-modal').select2({
            dropdownParent: $('#contact_create_modal')
        });

        $('#people_upload_form').on('submit', function(e){
            e.preventDefault();
            $(".se-pre-con").fadeIn('slow');
            this.submit();
        });

        $('#people_sync').on('submit', function(e){
            e.preventDefault();
            $(".se-pre-con").fadeIn('slow');
            this.submit();
        });

        $('.add-contact').click(function(){
            var pdc_id = $(this).val();
            $('#pdc_id').val(pdc_id);
            $('#contact_create_modal').modal('show');
        });
    });
</script>
@endsection
