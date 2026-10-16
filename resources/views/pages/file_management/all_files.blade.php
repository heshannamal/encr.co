@extends('layouts.app', ['activePage' => 'all_files', 'titlePage' => __('My Drive')])

@section('content')
<div class="container-fluid mb-5">
    <div class="se-pre-con"></div>

    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <h1 class="float-left header-title">My Drive</h1>

                    <div class="float-right header-icons"></div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 breadcrumbs"><a href="#"> Encore Drive </a><i class="fas fa-angle-right"></i><a href="#"> My Drive </a></div>

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
                    <div class="card-header custom-card-header">
                        <h4 class="float-left">Folders</h4>
                        <button type="button" class="btn btn-secondary btn-sm float-right" title="Add Folder" data-toggle="modal" data-target="#add_folder">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            @isset($folders)
                                @foreach ($folders as $folder)
                                    <div class="col-md-3 mb-2">
                                        <button type="button" class="btn btn-outline-default text-left custom-btn-outline-default w-100" title="Encroms">
                                            <i class="fas fa-folder"></i> {{$folder->name}}
                                        </button>
                                    </div>
                                @endforeach
                            @endisset
                        </div>
                    </div>
                </div>

                {{-- Files card --}}
                <div class="card mt-3">
                    <div class="card-header custom-card-header">
                        <h4 class="float-left">Files</h4>
                        {{-- <button type="button" class="btn btn-secondary btn-sm float-right" title="Add Files" data-toggle="modal" data-target="#add_folder">
                            <i class="fas fa-plus"></i>
                        </button> --}}
                    </div>

                    <div class="card-body">
                        <div class="row">
                            @isset($fileDatails)
                                @foreach ($fileDatails as $fileDatail)
                                    <div class="col-md-3 file-conatiner">
                                        <a class="open-file-details-modal" href="#" data-toggle="modal" data-target="#view_file_details" data-file="{{json_encode($fileDatail)}}">
                                            <div class="card">

                                                @if ($fileDatail->extension == 'jpg' || $fileDatail->extension == 'jpeg' || $fileDatail->extension == 'png')
                                                    <div class="card-body file-bg-img" style="background-image: url('{{$fileDatail->url}}')"></div>
                                                @elseif ($fileDatail->extension == 'doc' || $fileDatail->extension == 'docx' || $fileDatail->extension == 'ttf')
                                                    <div class="card-body">
                                                        <img src="{{asset('argon')}}/img/icons/docs.png" class="file-img mb-2" />
                                                    </div>
                                                @elseif ($fileDatail->extension == 'xls' || $fileDatail->extension == 'xlsx'|| $fileDatail->extension == 'xlsm' || $fileDatail->extension == 'csv')
                                                    <div class="card-body">
                                                        <img src="{{asset('argon')}}/img/icons/sheets.png" class="file-img mb-2" />
                                                    </div>
                                                @elseif ($fileDatail->extension == 'mp3')
                                                    <div class="card-body">
                                                        <img src="{{asset('argon')}}/img/icons/mp3.png" class="file-img mb-2" />
                                                    </div>
                                                @elseif ($fileDatail->extension == 'mp4')
                                                    <div class="card-body">
                                                        <img src="{{asset('argon')}}/img/icons/mp4.png" class="file-img mb-2" />
                                                    </div>
                                                @elseif ($fileDatail->extension == 'mkv')
                                                    <div class="card-body">
                                                        <img src="{{asset('argon')}}/img/icons/mkv.png" class="file-img mb-2" />
                                                    </div>
                                                @elseif ($fileDatail->extension == 'avi')
                                                    <div class="card-body">
                                                        <img src="{{asset('argon')}}/img/icons/avi.png" class="file-img mb-2" />
                                                    </div>
                                                @elseif ($fileDatail->extension == 'zip')
                                                    <div class="card-body">
                                                        <img src="{{asset('argon')}}/img/icons/zip.png" class="file-img mb-2" />
                                                    </div>
                                                @else
                                                    <div class="card-body">
                                                        <img src="{{asset('argon')}}/img/icons/placeholder.png" class="file-img mb-2" />
                                                    </div>
                                                @endif

                                                <div class="card-footer">
                                                    <p class="file-name">{{$fileDatail->name}}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @endisset
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

            <form action="{{ route('file_management.all_files.create_folder') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12 form-field">
                        <label class="form-lable">Folder Name</label>
                        <input type="text" class="form-control" id="folder_name" name="folder_name" />
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" id="create_directory_path" name="create_directory_path">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn-sm">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="view_file_details" tabindex="-1" role="dialog" aria-labelledby="view_file_label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-9">
                        <img id="file_url" src="" width="100%" />
                        {{-- <img src="{{asset('assets')}}/img/brand/black-panther-4k-minimalism-2020-gd.jpg" width="100%" /> --}}
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <img src="{{asset('argon')}}/img/icons/image.png" height="35px" />&nbsp;
                            <h4 id="file_name" style="display: block; width: 190px; word-wrap: break-word;"></h4>
                        </div>

                        <div class="row">
                            <div class="com-md-12">
                                <table>
                                    <tbody>
                                        <tr>
                                            <th>Type</th>
                                            <td id="file_type"></td>
                                        </tr>
                                        <tr>
                                            <th>Size</th>
                                            <td class="file_size"></td>
                                        </tr>
                                        <tr>
                                            <th>Storage used</th>
                                            <td class="file_size"></td>
                                        </tr>
                                        {{-- <tr>
                                            <th>Created</th>
                                            <td id="file_timestamp"></td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" id="file_download" class="btn btn-info btn-sm"><i class="fas fa-download"></i> Download</a>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('.open-file-details-modal').on('click', function () {
        var file = $(this).data('file');

        var file_size = (parseFloat(file.size) / 1024).toFixed(1);

        $('#file_download').val(file.file_no);
        $('#file_url').attr('src', file.url);
        $('#file_name').html(file.name);
        $('#file_type').html(file.mimetype);
        $('.file_size').html(file_size+' KB');
        // $('#file_timestamp').html(file.timestamp);
    });

    $('#file_download').on('click', function(){
        var fileId = $(this).val();
        window.location.replace('../file_management/images/download/'+fileId);
    });
</script>
@endsection
