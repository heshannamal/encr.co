@extends('layouts.app', ['activePage' => 'my_devices', 'titlePage' => __('Shared with Me')])

@section('content')
<style>
    #no_sync_container {
        height: 500px;
        margin-left: auto;
        margin-right: auto;
    }
    #no_sync_container img {
        width: 200px;
    }
    #no_sync_container p {
        line-height: 1;
    }
</style>

<div class="container-fluid mb-5">
    <div class="se-pre-con"></div>

    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <h1 class="float-left header-title">Shared with Me</h1>

                    <div class="float-right header-icons"></div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 breadcrumbs"><a href="#"> Encore Drive </a><i class="fas fa-angle-right"></i><a href="#"> Shared with Me </a></div>

                    <div class="col-md-6 mb-3 text-right drive-controls">
                        <button type="button" class="btn btn-secondary btn-sm" title="Get Link"><i class="fas fa-link"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="Share Sample"><i class="fas fa-user-plus"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="Remove"><i class="fas fa-trash-alt"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="More Action"><i class="fas fa-ellipsis-v"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="List View"><i class="fas fa-list-alt"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="View Details"><i class="fas fa-info-circle"></i></button>
                    </div>
                </div>

                {{-- Folders card --}}
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 text-center mt-5" id="no_sync_container">
                                <img src="{{asset('argon')}}/img/icons/device_sync.png" />
                                <h4 class="mt-3">No Files Shared</h4>
                                <p><small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras placerat justo pulvinar elit efficitur rutrum. In hac habitasse platea dictumst. Proin pretium nisi nec odio dignissim auctor. <a href="#">learn more</a></small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
