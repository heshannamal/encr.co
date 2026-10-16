@extends('layouts.app', ['activePage' => 'my_drive', 'titlePage' => __('My Drive')])

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
    .select2-container--default .select2-results__group {
        background-color: #dddddd;
    }
    .drag-over {
        box-shadow: 0px 0px 5px 1px #0060ff8a;
    }
</style>

<div class="container-fluid mb-5">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>MY DRIVE</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12 mt-4">
        <div class="card" id="file_container">
            {{-- <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <h1 class="float-left header-title">My Drive</h1>

                    <div class="float-right header-icons"></div>
                </div>
            </div> --}}

            <div class="card-body">
                <div class="row">
                    <input type="hidden" id="user_id" data-user-path="{{$userPath}}" data-user-name="{{auth()->user()->name}}" />
                    <input type="hidden" id="current_folder_id" data-current_folder_id="{{$userPath}}" />
                    <div class="col-md-6 breadcrumbs" id="breadcrumb_id"></div>

                    <div class="col-md-6 text-right drive-controls">
                        <button type="button" class="btn btn-secondary btn-sm" title="Sort Elements" id="elements_sort_az">Name <i class="fas fa-sort-alpha-down"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="Sort Elements" id="elements_sort_za" style="display: none;">Name <i class="fas fa-sort-alpha-down-alt"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="List Layout" id="list_layout"><i class="fas fa-list"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="Grid Layout" id="grid_layout" style="display: none;"><i class="fas fa-th"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="Get Link"><i class="fas fa-link"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="Share"><i class="fas fa-user-plus"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="Remove"><i class="fas fa-trash-alt"></i></button>
                        {{-- <button type="button" class="btn btn-secondary btn-sm" title="More Action"><i class="fas fa-ellipsis-v"></i></button> --}}
                        {{-- <button type="button" class="btn btn-secondary btn-sm" title="View Details"><i class="fas fa-info-circle"></i></button> --}}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="col-md-3 form-field float-right mgmt-search-container">
                            <input type="text" class="form-control" id="elements_search" placeholder="&#x1F50E;&#xFE0E; search..." />
                        </div>
                    </div>
                </div>

                {{-- Folders card --}}
                <div class="card">
                    <div class="card-header custom-card-header storage-header">
                        <h4>Folders</h4>
                        <button type="button" class="btn btn-secondary btn-sm ml-3" title="Add Folder" data-toggle="modal" data-target="#add_folder_modal">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>

                    <div class="card-body" id="folder_card">
                        <div class="row" id="folder_content"></div>
                    </div>
                </div>

                {{-- Files card --}}
                <div class="card mt-3">
                    <div class="card-header custom-card-header storage-header">
                        <h4>Files</h4>
                        <button type="button" class="btn btn-secondary btn-sm ml-3" title="Add Files" data-toggle="modal" data-target="#add_files_modal">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>

                    <div class="card-body" id="file_card">
                        <div class="row selectable" id="file_content"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add_folder_modal" tabindex="-1" role="dialog" aria-labelledby="add_folder_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_folder_label">Create a New Folder</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12 form-field">
                    <label class="form-lable">Folder Name</label>
                    <input type="text" class="form-control" id="create_folder_name" name="create_folder_name" />
                </div>
            </div>

            <div class="modal-footer">
                <input type="hidden" id="create_directory_path" name="create_directory_path" />
                <button type="button" class="btn btn-secondary btn-sm btn-custom" data-dismiss="modal">Close</button>
                <button type="button" id="btn_create_folder" class="btn btn-success btn-sm btn-custom">Create</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add_files_modal" tabindex="-1" role="dialog" aria-labelledby="add_files_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_files_label">Upload Files</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12 form-field">
                    <input type="file" class="form-control" id="create_file" name="create_file[]" multiple data-browse-on-zone-click="true" />
                </div>
            </div>

            <div class="modal-footer">
                <input type="hidden" id="create_file_path" name="create_file_path" />
                <button type="button" class="btn btn-secondary btn-sm btn-custom" data-dismiss="modal">Close</button>
                <button type="button" id="btn_create_file" class="btn btn-success btn-sm btn-custom">Upload</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="share_modal" role="dialog" aria-labelledby="share_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="share_label"><img src="{{asset('argon')}}/img/icons/add_user.png" class="title-icons" /> Share with people and groups</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <input type="hidden" id="share_user_category" />

                    <select class="invoice-inputs share-user-id-select2" id="share_user_id" style="width: 100% !important;">
                        <option value="">Add people and groups</option>
                        <optgroup label="User Groups">
                            @foreach($userGroups as $userGroup)
                                <option value="{{$userGroup->id}}">{{$userGroup->name}}</option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Users">
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <input type="hidden" id="share_path" />
                <input type="hidden" id="share_type" />
                <button type="button" class="btn btn-secondary btn-sm btn-custom" data-dismiss="modal">Close</button>
                <button type="button" id="btn_share" class="btn btn-success btn-sm btn-custom">Share</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="link_modal" tabindex="-1" role="dialog" aria-labelledby="link_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="link_label"><img src="{{asset('argon')}}/img/icons/link.png" class="title-icons" /> Get link</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" id="link_path" class="form-control" />
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm btn-custom" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-sm btn-custom" onclick="copyLink()">Copy Link</button>
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
                <a href="#" target="_blank" id="file_download" class="btn btn-info btn-sm btn-custom"><i class="fas fa-download"></i> Download</a>
                <button type="button" class="btn btn-secondary btn-sm btn-custom" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="move_modal" tabindex="-1" role="dialog" aria-labelledby="move_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="move_label"><img src="{{asset('argon')}}/img/icons/drive.png" class="title-icons" /> Move to</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <div class="input-group">
                        <input type="text" class="form-control" id="location_path" value="My Drive" readonly />
                        <div class="input-group-append">
                            <button type="button" class="btn btn-secondary btn-sm" id="change_location">Change Location</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" id="location_container" style="display: none;">
                    <div id="tree"></div>
                 </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm btn-custom" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-sm btn-custom" id="move_to_file" data-selected_my_drive_path="{{$userPath}}" data-dismiss="modal">Move</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rename_folder_modal" tabindex="-1" role="dialog" aria-labelledby="rename_folder_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rename_folder_label">Rename Folder</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12 form-field">
                    <label class="form-lable">Folder Name</label>
                    <input type="text" class="form-control" id="rename_folder_name" name="rename_folder_name" />
                </div>
            </div>

            <div class="modal-footer">
                <input type="hidden" id="rename_directory_path" name="rename_directory_path" />
                <button type="button" class="btn btn-secondary btn-sm btn-custom" data-dismiss="modal">Close</button>
                <button type="button" id="btn_rename_folder" class="btn btn-success btn-sm btn-custom">Rename</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rename_file_modal" tabindex="-1" role="dialog" aria-labelledby="rename_file_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rename_file_label">Rename File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12 form-field">
                    <label class="form-lable">File Name</label>
                    <input type="text" class="form-control" id="rename_file" name="rename_file" />
                </div>
            </div>

            <div class="modal-footer">
                <input type="hidden" id="rename_file_extension" name="rename_file_extension" />
                <input type="hidden" id="rename_file_id" name="rename_file_id" />
                <input type="hidden" id="rename_file_path" name="rename_file_path" />
                <button type="button" class="btn btn-secondary btn-sm btn-custom" data-dismiss="modal">Close</button>
                <button type="button" id="btn_rename_file" class="btn btn-success btn-sm btn-custom">Rename</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var folderId = $('#user_id').data('user-path');
        folderContent(folderId);

        $('.share-user-id-select2').select2();
    });

    function folderContent(folderId) {
        $('#current_folder_id').attr('data-current_folder_id', folderId);
        $('#create_file_path').data('create-file-path', folderId);

        $.ajax({
            url: '{{ url("file_management/my_drive/folders") }}',
            type: "POST",
            dataType: 'json',
            data: {
                'folderId': folderId, '_token':'{{csrf_token()}}'
            },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(values) {
                var data = values['folders'];
                var breadcrumbs = values['breadcrumbs'];
                var files = values['files'];

                var breadcrumbRow = [];
                var breadcrumbPath = [];
                for (let j = 0; j < breadcrumbs.length; j++) {
                    breadcrumbPath += breadcrumbs[j].path+'/';

                    var breadcrumbNames = breadcrumbs[j].name;
                    if (~breadcrumbNames.indexOf('User_')) {
                        var breadcrumbName = 'My Drive';
                    } else {
                        var breadcrumbName = breadcrumbs[j].name;
                    }

                    if (breadcrumbName == 'My Drive') {
                        breadcrumbRow += '<a href="#" class="folder-id" data-folder-id="'+breadcrumbPath+'"> '+breadcrumbName+' </a>';
                    } else {
                        breadcrumbRow += '<i class="fas fa-angle-right"></i><a href="#" class="folder-id" data-folder-id="'+breadcrumbPath+'"> '+breadcrumbName+' </a>';
                    }
                }
                $('#breadcrumb_id').html(breadcrumbRow);

                if (data) {
                    var row = [];
                    for (let i = 0; i < data.length; i++) {
                        row += '<div class="col-md-3 mb-2 mgmt-element sort-folder">'+
                                    '<button type="button" class="btn btn-outline-default text-left custom-btn-outline-default btn-folder-menu w-100" value="'+(data[i].name).replace(/ /g,"")+'" data-folder-path="'+data[i].path+'">'+
                                        '<i class="fas fa-folder"></i> '+data[i].name+
                                    '</button>'+

                                    '<div class="folder-dropdown-content folder-menu '+(data[i].name).replace(/ /g,"")+'" >'+
                                        '<button type="button" class="btn-folder-open" value="'+data[i].path+'" data-folder-name="'+data[i].name+'"><i class="fas fa-arrows-alt"></i> Open</button>'+
                                        '<button type="button"><i class="fas fa-info-circle"></i> View Details</button>'+
                                        '<button type="button" class="btn-folder-share" value="'+data[i].path+'"><i class="fas fa-user-plus"></i> Share</button>'+
                                        // '<button type="button" class="btn-folder-link" value="'+data[i].path+'"><i class="fas fa-link"></i> Get Link</button>'+
                                        '<button type="button" class="btn-folder-move" value="'+data[i].id+'" data-file_path="'+data[i].path+'"><i class="far fa-folder-open"></i> Move to</button>'+
                                        '<button type="button" class="btn-folder-rename" value="'+data[i].path+'" data-folder-name="'+data[i].name+'"><i class="fas fa-edit"></i> Rename</button>'+
                                        '<button type="button" class="btn-folder-remove" value="'+data[i].id+'" data-folder_path="'+data[i].path+'"><i class="fas fa-trash-alt"></i> Remove</button>'+
                                    '</div>'+
                                '</div>';
                    }

                    $('#folder_card').show();
                    $('#folder_content').html(row);

                } else {
                    $('#folder_card').hide();
                }

                if (files) {
                    var row = [];
                    for (let i = 0; i < files.length; i++) {
                        if (files[i].extension == 'jpg' || files[i].extension == 'jpeg' || files[i].extension == 'png') {
                            var fileContent = '<div class="card-body file-bg-img" style="background-image: url('+files[i].url+')"></div>';
                            var fileListContent = '<img src="'+files[i].url+'" class="file-img list-file-thumb mb-2" style="display: none;" /><p class="file-name list-file-name" style="display: none;">'+files[i].name+'</p>';

                        } else if (files[i].extension == 'pdf') {
                            var fileContent = '<img src="{{asset("argon")}}/img/icons/pdf_icon.png" class="file-img mb-2" />';
                            var fileListContent = '<p class="file-name list-file-name" style="display: none;">'+files[i].name+'</p>';

                        } else if (files[i].extension == 'xlsx') {
                            var fileContent = '<img src="{{asset("argon")}}/img/icons/sheets.png" class="file-img mb-2" />';
                            var fileListContent = '<p class="file-name list-file-name" style="display: none;">'+files[i].name+'</p>';

                        } else {
                            var fileContent = '<img src="{{asset("argon")}}/img/icons/placeholder.png" class="file-img mb-2" />';
                            var fileListContent = '<p class="file-name list-file-name" style="display: none;">'+files[i].name+'</p>';
                        }

                        row += '<div class="col-md-3 file-conatiner mgmt-element sort-file">'+
                                    '<button type="button" class="open-file-details-modal btn-file-menu" value="'+files[i].id+'" data-url="'+files[i].url+'" data-file_name="'+files[i].name+'" data-mimetype="'+files[i].mimetype+'" data-size="'+files[i].size+'">'+
                                        '<div class="card">'+
                                            '<div class="card-body">'+fileContent+fileListContent+'</div>'+

                                            '<div class="card-footer">'+
                                                '<p class="file-name">'+files[i].name+'</p>'+
                                            '</div>'+
                                        '</div>'+
                                    '</button>'+

                                    '<div class="folder-dropdown-content file-menu '+files[i].id+'">'+
                                        '<button type="button" class="btn-file-open" data-url="'+files[i].url+'" data-file_name="'+files[i].name+'" data-mimetype="'+files[i].mimetype+'" data-size="'+files[i].size+'"><i class="fas fa-arrows-alt"></i> Preview</button>'+
                                        '<button type="button"><i class="fas fa-info-circle"></i> View Details</button>'+
                                        '<button type="button" class="btn-file-share" value="'+files[i].id+'" data-file_path="'+files[i].path+'"><i class="fas fa-user-plus"></i> Share</button>'+
                                        '<button type="button" class="btn-file-link" value="'+files[i].id+'" data-url="'+files[i].url+'"><i class="fas fa-link"></i> Get Link</button>'+
                                        '<button type="button" class="btn-file-move" value="'+files[i].id+'" data-file_path="'+files[i].path+'"><i class="far fa-folder-open"></i> Move to</button>'+
                                        '<button type="button" class="btn-file-rename" value="'+files[i].id+'" data-file_name="'+files[i].name+'" data-file_extension="'+files[i].extension+'" data-file_path="'+files[i].path+'"><i class="fas fa-edit"></i> Rename</button>'+
                                        '<button type="button" class="btn-file-remove" value="'+files[i].id+'" data-file_path="'+files[i].path+'"><i class="fas fa-trash-alt"></i> Remove</button>'+
                                    '</div>'+
                                '</div>';
                    }

                    $('#file_card').show();
                    $('#file_content').html(row);

                } else {
                    $('#file_card').hide();
                }
            },
            complete: function () {
                $('#create_directory_path').attr('data-create-directory-path', folderId);

                arrangeLayout();
                $(".se-pre-con").fadeOut('slow');
            }
        });
    }

    // Open Folder Menu On Right Click
    $('body').on('contextmenu', '.btn-folder-menu', function(e){
        e.preventDefault();
        $('.folder-menu').hide();
        var folderId = $(this).val();
        $('.folder-menu.'+folderId).show(300);
    });

    // Open Folder On Double Click
    $('body').on('dblclick touchend', '.btn-folder-menu', function(){
        var folderId = $(this).attr('data-folder-path');
        folderContent(folderId);
    });

    $(document).mouseup(function(e){
        if (!$('.folder-menu').is(e.target) && $('.folder-menu').has(e.target).length === 0) {
            $('.folder-menu').hide();
            $('.folder-menu').unbind('click');
        }
    });

    // Open File Menu On Right Click
    $('body').on('contextmenu', '.btn-file-menu', function(e){
        e.preventDefault();
        $('.file-menu').hide();
        var fileId = $(this).val();
        $('.file-menu.'+fileId).show(300);
    });

    // Open File On Double Click
    $('body').on('dblclick touchend', '.btn-file-menu', function(){
        var file = $(this);
        openFile(file);
    });

    $(document).mouseup(function(e){
        if (!$('.file-menu').is(e.target) && $('.file-menu').has(e.target).length === 0) {
            $('.file-menu').hide();
            $('.file-menu').unbind('click');
        }
    });

    $('body').on('click', '.btn-folder-open', function(){
        var folderId = $(this).val();
        folderContent(folderId);
    });

    $('body').on('click', '.folder-id', function() {
        var folderId = $(this).data('folder-id').slice(0, -1);
        folderContent(folderId);
    });

    $('body').on('click', '#btn_create_folder', function() {
        var folderName = $('#create_folder_name').val();
        var directoryPath = $('#create_directory_path').attr('data-create-directory-path');
        console.log(folderName);
        console.log(directoryPath);
        $.ajax({
            url: '{{ url("file_management/create_folder") }}',
            type: "POST",
            dataType: 'json',
            data: {
                'folderName': folderName, 'directoryPath': directoryPath, '_token':'{{csrf_token()}}'
            },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data) {
                console.log(data);
            },
            complete: function () {
                $('#create_folder_name').val('');
                $("#add_folder_modal").modal('hide');
                folderContent(directoryPath);
            }
        });
    });

    $('body').on('click', '.btn-folder-share', function() {
        var sharePath = $(this).val();
        $('#share_path').attr('data-share_path', sharePath);
        $('#share_path').attr('data-file_path', '');
        $('#share_type').val(1);
        $('#share_modal').modal('show');
    });

    $('body').on('click', '.btn-file-share', function() {
        var sharePath = $(this).val();
        var filePath = $(this).attr('data-file_path');
        $('#share_path').attr('data-share_path', sharePath);
        $('#share_path').attr('data-file_path', filePath);
        $('#share_type').val(2);
        $('#share_modal').modal('show');
    });

    // $('body').on('click', '.btn-folder-link', function() {
    //     var linkPath = $(this).val();
    //     $('#link_path').val(linkPath);
    //     $('#link_modal').modal('show');
    // });

    $('body').on('click', '.btn-file-link', function() {
        var linkPath = $(this).data('url');
        $('#link_path').val(linkPath);
        $('#link_modal').modal('show');
    });

    $('body').on('change', '#share_user_id', function() {
        var label = $(this.options[this.selectedIndex]).closest('optgroup').prop('label');
        if (label == 'User Groups') {
            var share_user_category = 'user_groups';
        } else {
            var share_user_category = 'users';
        }
        $('#share_user_category').val(share_user_category);
    });

    $('body').on('click', '#btn_share', function() {
        var share_path = $('#share_path').attr('data-share_path');
        var file_path = $('#share_path').attr('data-file_path');
        var user_id = $('#share_user_id').val();
        var share_user_category = $('#share_user_category').val();
        var share_type = $('#share_type').val();
        var interface_type = 'mydrive';

        $.ajax({
            url: '{{ url("file_management/share") }}',
            type: "POST",
            dataType: 'json',
            data: {
                'share_path': share_path,
                'file_path': file_path,
                'user_id': user_id,
                'share_type': share_type,
                'interface_type': interface_type,
                'share_user_category': share_user_category,
                '_token':'{{csrf_token()}}'
            },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data) {
                console.log(data);
            },
            complete: function () {
                $('#share_user_id').val('').change();
                $('#share_user_category').val('');
                $("#share_modal").modal('hide');
                $(".se-pre-con").fadeOut('slow');

                Swal.fire({
                    title: "Done!",
                    text: "The item was shared successfully!",
                    type: "success",
                    allowOutsideClick: false,
                    confirmButtonColor: '#2dce89'
                })
            }
        });
    });

    $('body').on('click', '.btn-file-open', function () {
        var file = $(this);
        openFile(file);
    });

    function openFile(file){
        var file_size = (parseFloat(file.data('size')) / 1024).toFixed(1);

        $('#file_download').attr('href', file.data('url'));
        $('#file_url').attr('src', file.data('url'));
        $('#file_name').html(file.data('file_name'));
        $('#file_type').html(file.data('mimetype'));
        $('.file_size').html(file_size+' KB');
        $('#view_file_details').modal('show');
    }

    function copyLink() {
        var copyText = document.getElementById("link_path");
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        navigator.clipboard.writeText(copyText.value);
    }

    $('body').on('click', '.btn-folder-rename', function () {
        $renameFolderPath = $(this).val();
        $folderName = $(this).data('folder-name');
        $('#rename_folder_name').val($folderName);
        $('#rename_directory_path').attr('data-rename-directory-path', $renameFolderPath);
        $('#rename_folder_modal').modal('show');
    });

    $('body').on('click', '#btn_rename_folder', function() {
        var folderName = $('#rename_folder_name').val();
        var renamedDirectory = $('#rename_directory_path').data('rename-directory-path');
        var directoryPath = $('#create_directory_path').data('create-directory-path');

        $.ajax({
            url: '{{ url("file_management/rename_folder") }}',
            type: "POST",
            dataType: 'json',
            data: {
                'folderName': folderName, 'directoryPath': directoryPath, 'renamedDirectory': renamedDirectory, '_token':'{{csrf_token()}}'
            },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data) {
                console.log(data);
            },
            complete: function () {
                $("#rename_folder_modal").modal('hide');
                folderContent(directoryPath);
            }
        });
    });

    $('body').on('click', '.btn-file-rename', function(){
        var fileId = $(this).val();
        var filePath = $(this).data('file_path');
        var fileName = $(this).data('file_name');
        var fileExtension = $(this).data('file_extension');
        var fileNameArray = fileName.split('.'+fileExtension);
        $('#rename_file').val(fileNameArray[0]);
        $('#rename_file_extension').val(fileExtension);
        $('#rename_file_id').val(fileId);
        $('#rename_file_path').val(filePath);
        $('#rename_file_modal').modal('show');
    });

    $('body').on('click', '#btn_rename_file', function() {
        var fileName = $('#rename_file').val();
        var fileExtension = $('#rename_file_extension').val();
        var renameFilePath = $('#rename_file_path').val();
        var createFilePath = $('#create_file_path').data('create-file-path');

        $.ajax({
            url: '{{ url("file_management/rename_file") }}',
            type: "POST",
            dataType: 'json',
            data: {
                'fileName': fileName, 'fileExtension': fileExtension, 'renameFilePath': renameFilePath, 'createFilePath': createFilePath, '_token':'{{csrf_token()}}'
            },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data) {
                console.log(data);
            },
            complete: function () {
                $("#rename_file_modal").modal('hide');
                folderContent(createFilePath);
            }
        });
    });

    $('body').on('keyup', '#elements_search', function(){
        var searchTxt = $(this).val().toLowerCase();
        var mgmtElement = $(".mgmt-element");

        for (i = 0; i < mgmtElement.length; i++) {
            if (mgmtElement[i].textContent.toLowerCase().includes(searchTxt)) {
                mgmtElement[i].style.display = "block";
            } else {
                mgmtElement[i].style.display = "none";
            }
        }
    });

    // file move to my drive
    $('body').on('click', '.btn-file-move', function () {
        var moving_file = $(this).val();
        var moving_file_path = $(this).attr('data-file_path');
        var tree = new Tree(document.getElementById('tree'));

        $.ajax({
            url: '{{ url("file_management/folder_hierarchy") }}',
            type: "POST",
            dataType: 'json',
            data: { '_token':'{{csrf_token()}}' },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data) {
                for (let i = 0; i < data.length; i++) {
                    var subFolderArray = '';
                    if (data[i].subFolders != null) {
                        var subFolders = data[i].subFolders;
                        var breadcrumbs = data[i].name;
                        subFolderArray = subFolderArrayFunction(subFolders, breadcrumbs);
                    }

                    tree.json([{
                        name: data[i].name,
                        path: data[i].path,
                        bread: data[i].name,
                        type: Tree.FOLDER,
                        selected: false,
                        children: subFolderArray,
                    }]);
                }
            },
            complete: function () {
                $('#move_to_file').attr('data-moving_file', moving_file);
                $('#move_to_file').attr('data-moving_file_path', moving_file_path);
                $('#move_to_file').attr('data-move_type', 1);

                $('#location_path').val('My Drive');
                $(".se-pre-con").fadeOut('slow');
            }
        });

        $('#move_modal').modal('show');
    });

    // folder move to my drive
    $('body').on('click', '.btn-folder-move', function () {
        var moving_file = $(this).val();
        var moving_file_path = $(this).attr('data-file_path');
        var tree = new Tree(document.getElementById('tree'));

        $.ajax({
            url: '{{ url("file_management/folder_hierarchy") }}',
            type: "POST",
            dataType: 'json',
            data: { '_token':'{{csrf_token()}}' },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data) {
                for (let i = 0; i < data.length; i++) {
                    var subFolderArray = '';
                    if (data[i].subFolders != null) {
                        var subFolders = data[i].subFolders;
                        var breadcrumbs = data[i].name;
                        subFolderArray = subFolderArrayFunction(subFolders, breadcrumbs);
                    }

                    tree.json([{
                        name: data[i].name,
                        path: data[i].path,
                        bread: data[i].name,
                        type: Tree.FOLDER,
                        selected: false,
                        children: subFolderArray,
                    }]);
                }
            },
            complete: function () {
                $('#move_to_file').attr('data-moving_file', moving_file);
                $('#move_to_file').attr('data-moving_file_path', moving_file_path);
                $('#move_to_file').attr('data-move_type', 2);

                $('#location_path').val('My Drive');
                $(".se-pre-con").fadeOut('slow');
            }
        });

        $('#move_modal').modal('show');
    });

    function subFolderArrayFunction(subFolders, breadcrumbs) {
        var subFoldersArr = [];
        var subBreadcrumbs = breadcrumbs;
        for (let j = 0; j < subFolders.length; j++) {
            var subFolderArray = '';
            if (subFolders[j].subFolders != null) {
                var subSubFolders = subFolders[j].subFolders;
                var breadcrumbs = subBreadcrumbs + ' > ' + subFolders[j].name;
                subFolderArray = subFolderArrayFunction(subSubFolders, breadcrumbs);
            }

            subFoldersArr.push({
                name: subFolders[j].name,
                path: subFolders[j].path,
                bread: subBreadcrumbs +' > '+ subFolders[j].name,
                type: Tree.FOLDER,
                children: subFolderArray
            });
        }

        return subFoldersArr;
    }

    $('body').on('click', '#change_location', function(){
        $('#location_container').show(700);
    });

    $('#move_modal').on('hidden.bs.modal', function () {
        $('#tree').html('');
        $('#location_container').hide(700);
    });

    $('body').on('click', '#tree summary', function () {
        var folderName = $(this).parent().attr('data-bread');
        var locationPath = 'My Drive > '+folderName;
        $('#location_path').val(locationPath);

        var selectedPath = $(this).parent().attr('data-path');
        $('#move_to_file').attr('data-selected_drive_path', selectedPath);
    });

    $('body').on('click', '#move_to_file', function () {
        var selected_drive_path = $(this).attr('data-selected_drive_path');
        var moving_file = $(this).attr('data-moving_file');
        var moving_file_path = $(this).attr('data-moving_file_path');
        var move_type = $(this).attr('data-move_type');
        var current_folder_id = $('#current_folder_id').attr('data-current_folder_id');

        if (move_type == 1) { // move file
            $.ajax({
                url: '{{ url("file_management/move_to_file") }}',
                type: "POST",
                dataType: 'json',
                data: {
                    'selected_drive_path': selected_drive_path, 'moving_file': moving_file, 'moving_file_path': moving_file_path, '_token':'{{csrf_token()}}'
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function(data) {
                    console.log(data);
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');

                    Swal.fire({
                        title: "Done!",
                        text: "File moved successfully!",
                        type: "success",
                        allowOutsideClick: false,
                        confirmButtonColor: '#2dce89'

                    }).then(function(isConfirm) {
                        if (isConfirm.value == true) {
                            $(".se-pre-con").fadeIn('slow');
                            folderContent(current_folder_id);
                        }
                    });
                }
            });

        } else { // move folder
            $.ajax({
                url: '{{ url("file_management/move_to_folder") }}',
                type: "POST",
                dataType: 'json',
                data: {
                    'selected_drive_path': selected_drive_path, 'moving_file': moving_file, 'moving_file_path': moving_file_path, '_token':'{{csrf_token()}}'
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function(data) {
                    console.log(data);
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');

                    Swal.fire({
                        title: "Done!",
                        text: "Folder moved successfully!",
                        type: "success",
                        allowOutsideClick: false,
                        confirmButtonColor: '#2dce89'

                    }).then(function(isConfirm) {
                        if (isConfirm.value == true) {
                            $(".se-pre-con").fadeIn('slow');
                            folderContent(current_folder_id);
                        }
                    });
                }
            });
        }
    });

    // Delete File
    $('body').on('click', '.btn-file-remove', function() {
        var file_id = $(this).val();
        var file_path = $(this).attr('data-file_path');
        var current_folder_id = $('#current_folder_id').attr('data-current_folder_id');

        $.ajax({
            url: '{{ url("file_management/remove_file") }}',
            type: "POST",
            dataType: 'json',
            data: {
                'file_id': file_id, 'file_path': file_path, 'current_folder_id':current_folder_id, '_token':'{{csrf_token()}}'
            },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data) {
                console.log(data);
            },
            complete: function () {
                $(".se-pre-con").fadeOut('slow');

                Swal.fire({
                    title: "Done!",
                    text: "File removed successfully!",
                    type: "success",
                    allowOutsideClick: false,
                    confirmButtonColor: '#2dce89'

                }).then(function(isConfirm) {
                    if (isConfirm.value == true) {
                        $(".se-pre-con").fadeIn('slow');
                        folderContent(current_folder_id);
                    }
                });
            }
        });
    });

    // Delete Folder
    $('body').on('click', '.btn-folder-remove', function() {
        var folder_id = $(this).val();
        var folder_path = $(this).attr('data-folder_path');
        var current_folder_id = $('#current_folder_id').attr('data-current_folder_id');

        $.ajax({
            url: '{{ url("file_management/remove_folder") }}',
            type: "POST",
            dataType: 'json',
            data: {
                'folder_id': folder_id, 'folder_path': folder_path, 'current_folder_id': current_folder_id, '_token':'{{csrf_token()}}'
            },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data) {
                console.log(data);
            },
            complete: function () {
                $(".se-pre-con").fadeOut('slow');

                Swal.fire({
                    title: "Done!",
                    text: "Folder removed successfully!",
                    type: "success",
                    allowOutsideClick: false,
                    confirmButtonColor: '#2dce89'

                }).then(function(isConfirm) {
                    if (isConfirm.value == true) {
                        $(".se-pre-con").fadeIn('slow');
                        folderContent(current_folder_id);
                    }
                });
            }
        });
    });

    $('body').on('click', '#elements_sort_az', function(){
        sortElementsAZ();
        $('#elements_sort_az').hide();
        $('#elements_sort_za').show();
    });

    $('body').on('click', '#elements_sort_za', function(){
        sortElementsZA();
        $('#elements_sort_az').show();
        $('#elements_sort_za').hide();
    });

    function sortElementsAZ() {
        $('.sort-folder').sort(function(a, b) {
            if (a.textContent < b.textContent) {
                return -1;
            } else {
                return 1;
            }
        }).appendTo('#folder_content');

        $('.sort-file').sort(function(a, b) {
            if (a.textContent < b.textContent) {
                return -1;
            } else {
                return 1;
            }
        }).appendTo('#file_content');
    }

    function sortElementsZA() {
        $('.sort-folder').sort(function(a, b) {
            if (a.textContent > b.textContent) {
                return -1;
            } else {
                return 1;
            }
        }).appendTo('#folder_content');

        $('.sort-file').sort(function(a, b) {
            if (a.textContent > b.textContent) {
                return -1;
            } else {
                return 1;
            }
        }).appendTo('#file_content');
    }

    $('body').on('click', '#list_layout', function() {
        localStorage.setItem('my_drive_layout_type', 'list');
        arrangeLayout();
    });

    $('body').on('click', '#grid_layout', function() {
        localStorage.setItem('my_drive_layout_type', 'grid');
        arrangeLayout();
    });

    function arrangeLayout() {
        var layout_type = localStorage.getItem('my_drive_layout_type');
        console.log(layout_type);

        if (layout_type == 'list') {
            $('#folder_content').addClass('list-raw');
            $('#folder_content .mgmt-element').addClass('list-folder');

            $('#file_content').addClass('list-raw');
            $('#file_content .mgmt-element').addClass('list-file');
            $('#file_content .mgmt-element .card-footer').addClass('list-file-footer');
            $('#file_content .mgmt-element .file-img').addClass('list-file-img');
            $('#file_content .mgmt-element .file-bg-img').addClass('list-file-bg-img');
            $('#file_content .file-conatiner .card-body').addClass('list-file-card-body');
            $('#file_content .list-file-thumb').show();
            $('#file_content .list-file-name').show();
            $('#grid_layout').show();
            $('#list_layout').hide();

        } else {
            $('#folder_content').removeClass('list-raw');
            $('#folder_content .mgmt-element').removeClass('list-folder');

            $('#file_content').removeClass('list-raw');
            $('#file_content .mgmt-element').removeClass('list-file');
            $('#file_content .mgmt-element .card-footer').removeClass('list-file-footer');
            $('#file_content .mgmt-element .file-img').removeClass('list-file-img');
            $('#file_content .mgmt-element .file-bg-img').removeClass('list-file-bg-img');
            $('#file_content .file-conatiner .card-body').removeClass('list-file-card-body');
            $('#file_content .list-file-thumb').hide();
            $('#file_content .list-file-name').hide();
            $('#grid_layout').hide();
            $('#list_layout').show();
        }
    }

    $(function() {
        $('.selectable').selectable();
    });

    $('html').on('dragover', function (e) {
        e.preventDefault();
        e.stopPropagation();
    });

    $('html').on('drop', function (e) {
        e.preventDefault();
        e.stopPropagation();
    });

    $('body').on('dragover', '#file_container', function () {
        $(this).addClass('drag-over');
        return false;
    });

    $('body').on('dragleave', '#file_container', function () {
        $(this).removeClass('drag-over');
        return false;
    });

    $('body').on('drop', '#file_container', function (e) {
        e.preventDefault();
        $(this).removeClass('drag-over');

        $('#progressbar_container').html('');

        var files = e.originalEvent.dataTransfer.files;

        var i = 0;
        var list = files;
        var max = files.length;

        dndNextIteration(i, list, max);
    });

    function dndNextIteration(i, list, max) {
        if (i >= max) {
            $('#create_file').val('');
            $('#create_file').fileinput('reset');
            $('#rename_file_label').html('Upload Completed');
            return;
        }

        var formData = new FormData();
        formData.append("create_file_path", $("#create_file_path").data('create-file-path'));

        formData.append("create_file", list[i]);

        var uploadingFile = '<div class="form-group progress_container progress_container_'+i+'">'+
                                '<img src="{{asset("argon")}}/img/icons/image_icon.png" />'+
                                '<div class="progress">'+
                                    '<div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>'+
                                '</div>'+
                            '</div>';
        $('#progressbar_container').append(uploadingFile);

        $('#upload_modal').css('display', 'block');
        $('#rename_file_label').html('Uploading..');

        $.ajax({
            xhr: function() {
                var percentComplete = 0;
                var xhr = new window.XMLHttpRequest();

                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        console.log(percentComplete);

                        $('.progress .progress-bar').css("width", percentComplete+'%', function() {
                            return $(this).attr("aria-valuenow", percentComplete) + "%";
                        });
                    }
                }, false);

                return xhr;
            },

            url: '{{ url("file_management/create_file") }}',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $("#add_files_modal").modal('hide');
                $('#create_folder_name').val('');
                $('#upload_status').val(1);
            },
            success: function(data) {
                console.log(data);
                $('#upload_status').val(0);
                dndOnEvent(i, list, max);
            }
        });
    }

    function dndOnEvent(i, list, max) {
        $('#upload_status').val(0);

        var filename = list[i].name;

        var completedFile = '<span style="width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><img src="{{asset("argon")}}/img/icons/image_icon.png" /> '+filename+'</span>'+
                            '<img src="{{asset("argon")}}/img/icons/check_green.png" />';

        $('.progress_container_'+i).html(completedFile);

        i++;
        dndNextIteration(i, list, max);
    }

    $(window).on('beforeunload', function(){
        var upload_status = $('#upload_status').val();
        console.log(upload_status);

        if (upload_status == 0) {
            var confirm = confirm();
        }

        if(confirm){
            return true;
        } else {
            return false;
        }
    });
</script>
@endsection
