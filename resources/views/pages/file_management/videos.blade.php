@extends('layouts.app', ['activePage' => 'videos', 'titlePage' => __('Videos')])

@section('content')
<div class="container-fluid mb-5">
    <div class="se-pre-con"></div>

    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <h1 class="float-left header-title">Videos</h1>

                    <div class="float-right header-icons"></div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 breadcrumbs"><a href="#"> Encore Drive </a><i class="fas fa-angle-right"></i><a href="#"> Videos </a></div>

                    <div class="col-md-6 mb-3 text-right drive-controls">
                        <button type="button" class="btn btn-secondary btn-sm" title="Get Link"><i class="fas fa-link"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="Share Sample"><i class="fas fa-user-plus"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="Remove"><i class="fas fa-trash-alt"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="More Action"><i class="fas fa-ellipsis-v"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="List View"><i class="fas fa-list-alt"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="View Details"><i class="fas fa-info-circle"></i></button>
                    </div>
                </div>

                {{-- Files card --}}
                <div class="card mt-3">
                    <div class="card-header custom-card-header">
                        <h4 class="float-left">Files</h4>

                        <form action="{{ route('file_management.images.upload') }}" id="file_upload_form" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="file" id="upload_file" name="upload_file" hidden/>
                            <label class="btn btn-secondary btn-sm float-right" for="upload_file"><i class="fas fa-plus"></i></label>
                        </form>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            @isset($fileDatails)
                                @foreach ($fileDatails as $fileDatail)
                                    <div class="col-md-3 file-conatiner">

                                        <a class="open-file-details-modal" href="#" data-toggle="modal" data-target="#view_file_details" data-file="{{json_encode($fileDatail)}}">
                                            <div class="card">

                                                @if ($fileDatail->extension == 'mp4')
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
                        <iframe id="file_url" src="" width="100%" height="400px" allowfullscreen></iframe>
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
                                        <tr>
                                            <th>Created</th>
                                            <td id="file_timestamp"></td>
                                        </tr>
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
        $('#file_timestamp').html(file.timestamp);
    });

    $('#file_download').on('click', function(){
        var fileId = $(this).val();
        window.location.replace('../file_management/images/download/'+fileId);
    });

    $('#upload_file').on('change', function(){
        $('#file_upload_form').submit();
    });
</script>
@endsection
