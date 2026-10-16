@extends('layouts.app', ['activePage' => 'file_share', 'titlePage' => __('Shared with Me')])

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
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
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
                    <div class="col-md-6 breadcrumbs" id="breadcrumb_id">
                        <a href="#"> Encore Drive </a><i class="fas fa-angle-right"></i><a href="#"> Shared with Me </a>
                    </div>

                    <div class="col-md-6 mb-3 text-right drive-controls">
                        <input type="hidden" id="current_folder_id" data-current_folder_id="shared_folder" />

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
                    </div>

                    <div class="card-body" id="folder_card">
                        <div class="row" id="folder_content"></div>
                    </div>
                </div>

                {{-- Files card --}}
                <div class="card mt-3">
                    <div class="card-header custom-card-header">
                        <h4 class="float-left">Files</h4>
                    </div>

                    <div class="card-body" id="file_card">
                        <div class="row" id="file_content"></div>
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
                    <select class="invoice-inputs share-user-id-select2" name="share_user_id" id="share_user_id" style="width: 100% !important;">
                        <option value="">Add people and groups</option>
                        @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <input type="hidden" id="share_path" name="share_path" />
                <input type="hidden" id="share_type" name="share_type" />
                <button type="button" class="btn btn-secondary btn-sm btn-custom" data-dismiss="modal">Close</button>
                <button type="button" id="btn_share" class="btn btn-success btn-sm btn-custom">Share</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="move_modal" tabindex="-1" role="dialog" aria-labelledby="move_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="move_label"><img src="{{asset('argon')}}/img/icons/drive.png" class="title-icons" /> Move to my drive</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <div class="input-group">
                        <input type="text" class="form-control" id="location_path" value="Encore Drive > File Storage > {{auth()->user()->name}}" data-user-name="{{auth()->user()->name}}" readonly />
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
                <button type="button" class="btn btn-success btn-sm btn-custom" id="move_to_my_drive_file" data-selected_my_drive_path="{{$userPath}}" data-dismiss="modal">Move</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        sharedContent();

        $('.share-user-id-select2').select2();
    });

    function sharedContent() {
        $('#current_folder_id').attr('data-current_folder_id', 'shared_folder');

        $.ajax({
            url: '{{ url("file_management/file_share/folders") }}',
            type: "POST",
            dataType: 'json',
            data: {
                '_token':'{{csrf_token()}}'
            },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(values) {
                var data = values['folders'];
                var files = values['files'];
                // console.log(values);

                if (data) {
                    var row = [];
                    for (let i = 0; i < data.length; i++) {
                        if (data[i].is_write == 1) {
                            var menuItems = '<button type="button" class="btn-folder-share" value="'+data[i].path+'"><i class="fas fa-user-plus"></i> Share</button>'+
                                            '<button type="button"><i class="fas fa-link"></i> Get Link</button>'+
                                            '<button type="button" class="btn-folder-move" value="'+data[i].id+'" data-file_path="'+data[i].path+'"><i class="fas fa-cloud-download-alt"></i> Move to My Drive</button>';
                        } else {
                            var menuItems = '';
                        }

                        row += '<div class="col-md-3 mb-2">'+
                                    '<button type="button" class="btn btn-outline-default text-left custom-btn-outline-default btn-folder-menu w-100" value="'+(data[i].name).replace(/ /g,"")+'" data-folder-path="'+data[i].path+'">'+
                                        '<i class="fas fa-folder"></i> '+data[i].name+
                                    '</button>'+

                                    '<div class="folder-dropdown-content folder-menu '+(data[i].name).replace(/ /g,"")+'">'+
                                        '<button type="button" class="btn-folder-open" value="'+data[i].path+'" data-folder-name="'+data[i].name+'"><i class="fas fa-arrows-alt"></i> Open</button>'+
                                        '<button type="button"><i class="fas fa-info-circle"></i> View Details</button>'+
                                        menuItems+
                                        '<button type="button" class="btn-item-remove" value="'+data[i].item_id+'"><i class="fas fa-trash-alt"></i> Remove</button>'+
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
                        } else if (files[i].extension == 'pdf') {
                            var fileContent = '<img src="{{asset("argon")}}/img/icons/pdf_icon.png" class="file-img mb-2" />';
                        } else {
                            var fileContent = '<img src="{{asset("argon")}}/img/icons/placeholder.png" class="file-img mb-2" />';
                        }

                        if (files[i].is_write == 1) {
                            var menuItems = '<button type="button" class="btn-file-share" value="'+files[i].id+'"><i class="fas fa-user-plus"></i> Share</button>'+
                                            '<button type="button"><i class="fas fa-link"></i> Get Link</button>'+
                                            '<button type="button" class="btn-file-move" value="'+files[i].id+'" data-file_path="'+files[i].path+'"><i class="fas fa-cloud-download-alt"></i> Move to My Drive</button>';
                        } else {
                            var menuItems = '';
                        }
                                        

                        row += '<div class="col-md-3 file-conatiner">'+
                                    '<button type="button" class="open-file-details-modal btn-file-menu" value="'+files[i].id+'" data-url="'+files[i].url+'" data-file_name="'+files[i].name+'" data-mimetype="'+files[i].mimetype+'" data-size="'+files[i].size+'">'+
                                        '<div class="card">'+
                                            '<div class="card-body">'+fileContent+'</div>'+

                                            '<div class="card-footer">'+
                                                '<p class="file-name">'+files[i].name+'</p>'+
                                            '</div>'+
                                        '</div>'+
                                    '</button>'+

                                    '<div class="folder-dropdown-content file-menu '+files[i].id+'">'+
                                        '<button type="button" class="btn-file-open" data-url="'+files[i].url+'" data-file_name="'+files[i].name+'" data-mimetype="'+files[i].mimetype+'" data-size="'+files[i].size+'"><i class="fas fa-arrows-alt"></i> Preview</button>'+
                                        '<button type="button"><i class="fas fa-info-circle"></i> View Details</button>'+
                                        menuItems+
                                        '<button type="button" class="btn-item-remove" value="'+files[i].item_id+'"><i class="fas fa-trash-alt"></i> Remove</button>'+
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
        console.log(file);
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

    $('body').on('click', '.btn-file-open', function () {
        var file = $(this);
        console.log(file);
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

    $('body').on('click', '.btn-file-share', function() {
        var sharePath = $(this).val();
        $('#share_path').attr('data-share-path', sharePath);
        $('#share_type').val(2);
        $('#share_modal').modal('show');
    });

    // file move to my drive
    $('body').on('click', '.btn-file-move', function () {
        var shared_file_id = $(this).val();
        var shared_file_path = $(this).attr('data-file_path');
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
                console.log(data);

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
                $('#move_to_my_drive_file').attr('data-shared_file_path', shared_file_path);
                $('#move_to_my_drive_file').attr('data-shared_file_id', shared_file_id);
                $('#move_to_my_drive_file').attr('data-shared_type', 1);

                var userName = $('#location_path').attr('data-user-name');
                $('#location_path').val('Encore Drive > File Storage > '+userName);
                $(".se-pre-con").fadeOut('slow');
            }
        });

        $('#move_modal').modal('show');
    });

    // folder move to my drive
    $('body').on('click', '.btn-folder-move', function () {
        var shared_file_id = $(this).val();
        var shared_file_path = $(this).attr('data-file_path');
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
                console.log(data);

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
                $('#move_to_my_drive_file').attr('data-shared_file_path', shared_file_path);
                $('#move_to_my_drive_file').attr('data-shared_file_id', shared_file_id);
                $('#move_to_my_drive_file').attr('data-shared_type', 2);

                var userName = $('#location_path').attr('data-user-name');
                $('#location_path').val('Encore Drive > File Storage > '+userName);
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

    $('body').on('click', '#btn_share', function() {
        var share_path = $('#share_path').attr('data-share-path');
        var user_id = $('#share_user_id').val();
        var share_type = $('#share_type').val();

        $.ajax({
            url: '{{ url("file_management/share") }}',
            type: "POST",
            dataType: 'json',
            data: {
                'share_path': share_path, 'user_id': user_id, 'share_type': share_type, '_token':'{{csrf_token()}}'
            },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data) {
                console.log(data);
            },
            complete: function () {
                $("#share_modal").modal('hide');
                $(".se-pre-con").fadeOut('slow');

                Swal.fire({
                    title: "Done!",
                    text: "The item was shared successfully!",
                    type: "success",
                    allowOutsideClick: false,
                })
            }
        });
    });

    function folderContent(folderId) {
        $('#current_folder_id').attr('data-current_folder_id', folderId);

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
                        var breadcrumbName = 'Shared with Me';
                    } else {
                        var breadcrumbName = breadcrumbs[j].name;
                    }

                    breadcrumbFirst = '<a href="#"> Encore Drive </a>';

                    if (breadcrumbName == 'Shared with Me') {
                        breadcrumbRow += '<i class="fas fa-angle-right"></i><a href="#" onClick="sharedContent();"> '+breadcrumbName+' </a>';
                    } else {
                        breadcrumbRow += '<i class="fas fa-angle-right"></i><a href="#" class="folder-id" data-folder-id="'+breadcrumbPath+'"> '+breadcrumbName+' </a>';
                    }
                }
                $('#breadcrumb_id').html(breadcrumbFirst + breadcrumbRow);

                if (data) {
                    var row = [];
                    for (let i = 0; i < data.length; i++) {
                        if (data[i].is_write == 1) {
                            var menuItems = '<button type="button" class="btn-folder-share" value="'+data[i].path+'"><i class="fas fa-user-plus"></i> Share</button>'+
                                            '<button type="button" class="btn-folder-link" value="'+data[i].path+'"><i class="fas fa-link"></i> Get Link</button>'+
                                            '<button type="button" class="btn-folder-move" value="'+data[i].id+'" data-file_path="'+data[i].path+'"><i class="fas fa-cloud-download-alt"></i> Move to My Drive</button>';
                        } else {
                            var menuItems = '';
                        }

                        row += '<div class="col-md-3 mb-2">'+
                                    '<button type="button" class="btn btn-outline-default text-left custom-btn-outline-default btn-folder-menu w-100" value="'+(data[i].name).replace(/ /g,"")+'" data-folder-path="'+data[i].path+'">'+
                                        '<i class="fas fa-folder"></i> '+data[i].name+
                                    '</button>'+

                                    '<div class="folder-dropdown-content folder-menu '+(data[i].name).replace(/ /g,"")+'">'+
                                        '<button type="button" class="btn-folder-open" value="'+data[i].path+'" data-folder-name="'+data[i].name+'"><i class="fas fa-arrows-alt"></i> Open</button>'+
                                        '<button type="button"><i class="fas fa-info-circle"></i> View Details</button>'+
                                        menuItems+
                                        '<button type="button" class="btn-item-remove" value="'+data[i].item_id+'"><i class="fas fa-trash-alt"></i> Remove</button>'+
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
                        } else if (files[i].extension == 'pdf') {
                            var fileContent = '<img src="{{asset("argon")}}/img/icons/pdf_icon.png" class="file-img mb-2" />';
                        } else {
                            var fileContent = '<img src="{{asset("argon")}}/img/icons/placeholder.png" class="file-img mb-2" />';
                        }

                        if (files[i].is_write == 1) {
                            var menuItems = '<button type="button" class="btn-file-share" value="'+files[i].id+'"><i class="fas fa-user-plus"></i> Share</button>'+
                                            '<button type="button" class="btn-file-link" value="'+files[i].id+'" data-url="'+files[i].url+'"><i class="fas fa-link"></i> Get Link</button>'+
                                            '<button type="button" class="btn-file-move" value="'+files[i].id+'" data-file_path="'+files[i].path+'"><i class="fas fa-cloud-download-alt"></i> Move to My Drive</button>';
                        } else {
                            var menuItems = '';
                        }

                        row += '<div class="col-md-3 file-conatiner">'+
                                    '<button type="button" class="open-file-details-modal btn-file-menu" value="'+files[i].id+'">'+
                                        '<div class="card">'+
                                            '<div class="card-body">'+fileContent+'</div>'+

                                            '<div class="card-footer">'+
                                                '<p class="file-name">'+files[i].name+'</p>'+
                                            '</div>'+
                                        '</div>'+
                                    '</button>'+

                                    '<div class="folder-dropdown-content file-menu '+files[i].id+'">'+
                                        '<button type="button" class="btn-file-open" data-url="'+files[i].url+'" data-file_name="'+files[i].name+'" data-mimetype="'+files[i].mimetype+'" data-size="'+files[i].size+'"><i class="fas fa-arrows-alt"></i> Preview</button>'+
                                        '<button type="button"><i class="fas fa-info-circle"></i> View Details</button>'+
                                        menuItems+
                                        '<button type="button" class="btn-item-remove" value="'+files[i].item_id+'"><i class="fas fa-trash-alt"></i> Remove</button>'+
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
                $(".se-pre-con").fadeOut('slow');
            }
        });
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
        var userName = $('#location_path').attr('data-user-name');
        var locationPath = 'Encore Drive > File Storage > '+userName+' > '+folderName;
        $('#location_path').val(locationPath);

        var selectedPath = $(this).parent().attr('data-path');
        $('#move_to_my_drive_file').attr('data-selected_my_drive_path', selectedPath);
    });

    $('body').on('click', '#move_to_my_drive_file', function () {
        var selected_my_drive_path = $(this).attr('data-selected_my_drive_path');
        var shared_file_path = $(this).attr('data-shared_file_path');
        var shared_file_id = $(this).attr('data-shared_file_id');
        var shared_type = $(this).attr('data-shared_type');

        if (shared_type == 1) { // move file
            $.ajax({
                url: '{{ url("file_management/move_to_my_drive_file") }}',
                type: "POST",
                dataType: 'json',
                data: {
                    'selected_my_drive_path': selected_my_drive_path, 'shared_file_id': shared_file_id, 'shared_file_path': shared_file_path, '_token':'{{csrf_token()}}'
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
                        text: "File moved to My Drive successfully!",
                        type: "success",
                        allowOutsideClick: false,
                    })
                }
            });

        } else { // move folder
            $.ajax({
                url: '{{ url("file_management/move_to_my_drive_folder") }}',
                type: "POST",
                dataType: 'json',
                data: {
                    'selected_my_drive_path': selected_my_drive_path, 'shared_file_id': shared_file_id, 'shared_file_path': shared_file_path, '_token':'{{csrf_token()}}'
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
                        text: "Folder moved to My Drive successfully!",
                        type: "success",
                        allowOutsideClick: false,
                    })
                }
            });
        }
    });

    // Remove item
    $('body').on('click', '.btn-item-remove', function() {
        var item_id = $(this).val();
        var current_folder_id = $('#current_folder_id').attr('data-current_folder_id');

        $.ajax({
            url: '{{ url("file_management/remove_shared_item") }}',
            type: "POST",
            dataType: 'json',
            data: {
                'item_id': item_id, 'current_folder_id':current_folder_id, '_token':'{{csrf_token()}}'
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
                    text: "Item removed successfully!",
                    type: "success",
                    allowOutsideClick: false,
                    confirmButtonColor: '#2dce89'

                }).then(function(isConfirm) {
                    if (isConfirm.value == true) {
                        $(".se-pre-con").fadeIn('slow');

                        if (current_folder_id == 'shared_folder') {
                            sharedContent();
                        } else {
                            folderContent(current_folder_id);
                        }
                    }
                });
            }
        });
    });
</script>
@endsection
