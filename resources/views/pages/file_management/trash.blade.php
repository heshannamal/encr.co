@extends('layouts.app', ['activePage' => 'deleted_files', 'titlePage' => __('Trash')])

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

    @section('order-header')
        <span>TRASH</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection
    
    <div class="col-md-12 mt-4">
        <div class="card">
            {{-- <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <h1 class="float-left header-title">Trash</h1>

                    <div class="float-right header-icons"></div>
                </div>
            </div> --}}

            <div class="card-body">
                <div class="row">
                    <input type="hidden" id="user_id" data-user-path="{{$userTrashFolderId}}" data-user-name="{{auth()->user()->name}}" />
                    <input type="hidden" id="current_folder_id" data-current_folder_id="{{$userTrashFolderId}}" />
                    <div class="col-md-6 breadcrumbs" id="breadcrumb_id"></div>

                    <div class="col-md-6 text-right drive-controls">
                        <button type="button" class="btn btn-secondary btn-sm" title="Sort Elements" id="elements_sort_az">Name <i class="fas fa-sort-alpha-down"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="Sort Elements" id="elements_sort_za" style="display: none;">Name <i class="fas fa-sort-alpha-down-alt"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="List Layout" id="list_layout"><i class="fas fa-list"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="Grid Layout" id="grid_layout" style="display: none;"><i class="fas fa-th"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="Get Link"><i class="fas fa-link"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="Share Sample"><i class="fas fa-user-plus"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="Remove"><i class="fas fa-trash-alt"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="More Action"><i class="fas fa-ellipsis-v"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="List View"><i class="fas fa-list-alt"></i></button>
                        <button type="button" class="btn btn-secondary btn-sm" title="View Details"><i class="fas fa-info-circle"></i></button>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="col-md-3 form-field float-right mgmt-search-container">
                            <input type="text" class="form-control" id="elements_search" placeholder="&#x1F50E;&#xFE0E; search..." />
                        </div>
                    </div>
                </div>

                {{-- Trash Message --}}
                <div class="row" id="trash_msg_container">
                    <div class="col-md-12" id="trash_msg">
                        <h4 class="float-left">Items in the trash are deleted forever after 30 days</h4>
                        <button type="button" class="btn btn-secondary btn-sm float-right" title="Empty Trash" id="empty_trash">
                            <i class="fas fa-trash-alt"></i> Empty Trash
                        </button>
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

<script>
    $(document).ready(function() {
        var folderId = $('#user_id').data('user-path');
        folderContent(folderId);

        $('.share-user-id-select2').select2();
    });

    function folderContent(folderId) {
        $.ajax({
            url: '{{ url("file_management/trash/folders") }}',
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
                        var breadcrumbName = 'Trash';
                    } else {
                        var breadcrumbName = breadcrumbs[j].name;
                    }

                    if (breadcrumbs[j].name == 'Trash') {
                        breadcrumbRow += '';

                    } else {
                        if (breadcrumbName == 'Trash') {
                            breadcrumbRow += '<a href="#" class="folder-id" data-folder-id="'+breadcrumbPath+'"> '+breadcrumbName+' </a>';
                        } else {
                            breadcrumbRow += '<i class="fas fa-angle-right"></i><a href="#" class="folder-id" data-folder-id="'+breadcrumbPath+'"> '+breadcrumbName+' </a>';
                        }
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
                                        '<button type="button" class="btn-folder-restore" value="'+data[i].id+'"><i class="far fa-folder-open"></i> Restore</button>'+
                                        '<button type="button" class="btn-folder-delete" value="'+data[i].path+'"><i class="fas fa-edit"></i> Delete Forever</button>'+
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
                                        '<button type="button" class="btn-file-restore" value="'+files[i].id+'"><i class="fas fa-edit"></i> Restore</button>'+
                                        '<button type="button" class="btn-file-delete" value="'+files[i].id+'"><i class="fas fa-trash-alt"></i> Delete Forever</button>'+
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
                $('#create_file_path').attr('data-create-file-path', folderId);
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

        Swal.fire({
            title: "This folder is in your trash",
            text: "To view this folder, you'll need to restore it from your trash",
            type: "info",
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: '#2dce89',
            confirmButtonText: "Restore",

        }).then(function(isConfirm) {
            if (isConfirm.value == true) {
                restoreFolder(folderId);
            }
        });
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

        Swal.fire({
            title: "This folder is in your trash",
            text: "To view this folder, you'll need to restore it from your trash",
            type: "info",
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: '#2dce89',
            confirmButtonText: "Restore",

        }).then(function(isConfirm) {
            if (isConfirm.value == true) {
                restoreFolder(folderId);
            }
        });
    });

    $('body').on('click', '.folder-id', function() {
        var folderId = $(this).data('folder-id').slice(0, -1);
        folderContent(folderId);
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

    $('body').on('click', '.btn-file-delete', function() {
        var file_id = $(this).val();
        var current_folder_id = $('#current_folder_id').attr('data-current_folder_id');

        Swal.fire({
            title: "Delete Forever?",
            text: "File will be deleted forever and you won't be able to restore it.",
            type: "info",
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: '#2dce89'

        }).then(function(isConfirm) {
            if (isConfirm.value == true) {
                $.ajax({
                    url: '{{ url("file_management/delete_file") }}',
                    type: "POST",
                    dataType: 'json',
                    data: {
                        'file_id': file_id, '_token':'{{csrf_token()}}'
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
                            text: "File deleted successfully!",
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
    });

    $('body').on('click', '.btn-folder-delete', function() {
        var file_path = $(this).val();
        var current_folder_id = $('#current_folder_id').attr('data-current_folder_id');

        Swal.fire({
            title: "Delete Forever?",
            text: "Folder will be deleted forever and you won't be able to restore it.",
            type: "info",
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: '#2dce89'

        }).then(function(isConfirm) {
            if (isConfirm.value == true) {
                $.ajax({
                    url: '{{ url("file_management/delete_folder") }}',
                    type: "POST",
                    dataType: 'json',
                    data: {
                        'file_path': file_path, '_token':'{{csrf_token()}}'
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
                            text: "Folder deleted successfully!",
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
    });

    $('body').on('click', '#empty_trash', function() {
        var current_folder_id = $('#current_folder_id').attr('data-current_folder_id');

        Swal.fire({
            title: "Delete Forever?",
            text: "All items in the trash will be deleted forever and you won't be able to restore them.",
            type: "info",
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: '#2dce89'

        }).then(function(isConfirm) {
            if (isConfirm.value == true) {
                $.ajax({
                    url: '{{ url("file_management/empty_trash") }}',
                    type: "POST",
                    dataType: 'json',
                    data: {
                        'current_folder_id': current_folder_id, '_token':'{{csrf_token()}}'
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
                            text: "Trash cleared successfully!",
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
    });

    $('body').on('click', '.btn-file-restore', function() {
        var file_id = $(this).val();
        var current_folder_id = $('#current_folder_id').attr('data-current_folder_id');

        $.ajax({
            url: '{{ url("file_management/restore_file") }}',
            type: "POST",
            dataType: 'json',
            data: {
                'file_id': file_id, '_token':'{{csrf_token()}}'
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
                    text: "File restored successfully!",
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

    $('body').on('click', '.btn-folder-restore', function() {
        var folder_path = $(this).val();
        restoreFolder(folder_path);
    });

    function restoreFolder(folder_path) {
        var folder_path = folder_path;
        var current_folder_id = $('#current_folder_id').attr('data-current_folder_id');

        $.ajax({
            url: '{{ url("file_management/restore_folder") }}',
            type: "POST",
            dataType: 'json',
            data: {
                'folder_path': folder_path, '_token':'{{csrf_token()}}'
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
                    text: "Folder restored successfully!",
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
        localStorage.setItem('trash_layout_type', 'list');
        arrangeLayout();
    });

    $('body').on('click', '#grid_layout', function() {
        localStorage.setItem('trash_layout_type', 'grid');
        arrangeLayout();
    });

    function arrangeLayout() {
        var layout_type = localStorage.getItem('trash_layout_type');

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
</script>
@endsection

