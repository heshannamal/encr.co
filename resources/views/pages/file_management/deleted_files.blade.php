@extends('layouts.app', ['activePage' => 'deleted_files', 'titlePage' => __('Trash')])

@section('content')
<style>
    #trash_msg_container {
        padding: 1rem;
    }
    #trash_msg {
        background-color: #eaeaea;
        padding: 0.4rem 1rem;
    }
</style>

<div class="container-fluid mb-5">
    <div class="se-pre-con"></div>

    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <h1 class="float-left header-title">Trash</h1>

                    <div class="float-right header-icons"></div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 breadcrumbs"><a href="#"> Encore Drive </a><i class="fas fa-angle-right"></i><a href="#"> Trash </a></div>

                    <div class="col-md-6 mb-3 text-right drive-controls">
                        <button type="button" class="btn btn-secondary btn-sm" title="Get Link"><i class="fas fa-link"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="Share Sample"><i class="fas fa-user-plus"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="Remove"><i class="fas fa-trash-alt"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="More Action"><i class="fas fa-ellipsis-v"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="List View"><i class="fas fa-list-alt"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="View Details"><i class="fas fa-info-circle"></i></button>
                    </div>
                </div>

                {{-- Trash Message --}}
                <div class="row" id="trash_msg_container">
                    <div class="col-md-12" id="trash_msg">
                        <h4 class="float-left">Items in the trash are deleted forever after 30 days</h4>
                        <button type="button" class="btn btn-secondary btn-sm float-right" title="Empty Trash">
                            <i class="fas fa-trash-alt"></i> Empty Trash
                        </button>
                    </div>
                </div>

                {{-- Files card --}}
                <div class="card mt-3">
                    <div class="card-header custom-card-header">
                        <h4 class="float-left">Last Week</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 file-conatiner">
                                <a class="open-file-details-modal" href="#" data-toggle="modal" data-target="#view_file_details">
                                    <div class="card">
                                        <div class="card-body">
                                            <img src="{{asset('assets')}}/img/brand/5cXThO.jpg" class="file-img mb-2" />
                                        </div>

                                    <div class="card-footer">
                                        <p class="file-name">preview.jpg</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header custom-card-header">
                        <h4 class="float-left">Last Month</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 file-conatiner">
                                <a class="open-file-details-modal" href="#" data-toggle="modal" data-target="#view_file_details">
                                    <div class="card">
                                        <div class="card-body">
                                            <img src="{{asset('assets')}}/img/brand/eXEkiw.jpg" class="file-img mb-2" />
                                        </div>

                                    <div class="card-footer">
                                        <p class="file-name">preview.jpg</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3 file-conatiner">
                                <a class="open-file-details-modal" href="#" data-toggle="modal" data-target="#view_file_details">
                                    <div class="card">
                                        <div class="card-body">
                                            <img src="{{asset('assets')}}/img/brand/photo-1472152083436-a6eede6efad9.jpg" class="file-img mb-2" />
                                        </div>

                                    <div class="card-footer">
                                        <p class="file-name">preview.jpg</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add_folder" tabindex="-1" role="dialog" aria-labelledby="add_folder_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_folder_label">Add a New Folder</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12 form-field">
                    <label class="form-lable">Folder Name</label>
                    <input type="text" class="form-control" id="folder_name" name="folder_name" />
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-sm">Add</button>
            </div>
        </div>
    </div>
</div>
@endsection
