@extends('layouts.app', ['activePage' => 'oms', 'titlePage' => __('OMS')])

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
</style>

<div class="container-fluid mb-5">
    <div class="se-pre-con"></div>

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12 mt-4">
        <div class="card">
            {{-- <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <h1 class="float-left header-title">OMS</h1>

                    <div class="float-right header-icons"></div>
                </div>
            </div> --}}

            <div class="card-body">
                <div class="row">
                    <input type="hidden" id="oms_id" data-oms-id="{{$omsFolderId}}" />
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

                {{-- Folders card --}}
                <div class="card">
                    <div class="card-header custom-card-header">
                        <h4 class="float-left" id="content_title">Folders</h4>
                    </div>

                    <div class="card-body">
                        <div class="row" id="folder_content"></div>
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

<script>

    let header = "OMS";
        document.getElementById("header").innerHTML = header;

    var breadcrumbId = 0;

    $(document).ready(function() {
        var folderId = $('#oms_id').data('oms-id');
        folderContent(folderId);

        $('.share-user-id-select2').select2();
    });

    function folderContent(folderId) {
        $.ajax({
            url: '{{ url("file_management/oms/folders") }}',
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

                var breadcrumbRow = [];
                var breadcrumbPath = [];
                for (let j = 0; j < breadcrumbs.length; j++) {
                    breadcrumbPath += breadcrumbs[j].path+'/';

                    if (breadcrumbs[j].name == 'OMS') {
                        breadcrumbRow += '<a href="#" class="folder-id" data-folder-id="'+breadcrumbPath+'"> '+breadcrumbs[j].name+' </a>';
                    } else {
                        breadcrumbRow += '<i class="fas fa-angle-right"></i><a href="#" class="folder-id" data-folder-id="'+breadcrumbPath+'"> '+breadcrumbs[j].name+' </a>';
                    }
                }
                $('#breadcrumb_id').html(breadcrumbRow);

                if (data) {
                    var row = [];
                    for (let i = 0; i < data.length; i++) {
                        if (data[i].organization == '') {
                            var organization = '';
                        } else {
                            var organization = '<br><span class="oms-country-name">'+data[i].organization+'</span>';
                        }

                        row += '<div class="col-md-3 mb-2 mgmt-element sort-folder">'+
                                    '<button type="button" class="btn btn-outline-default text-left custom-btn-outline-default btn-folder-menu w-100" value="'+(data[i].name).replace(/ /g,"")+'" data-folder-path="'+data[i].path+'">'+
                                        '<i class="fas fa-folder"></i> '+ data[i].name +' '+ organization +
                                    '</button>'+

                                    '<div class="folder-dropdown-content folder-menu '+(data[i].name).replace(/ /g,"")+'">'+
                                        '<button type="button" class="btn-folder-open" value="'+data[i].path+'" data-folder-name="'+data[i].name+'"><i class="fas fa-arrows-alt"></i> Open</button>'+
                                        '<button type="button"><i class="fas fa-info-circle"></i> View Details</button>'+
                                        '<button type="button" class="btn-folder-share" value="'+data[i].path+'"><i class="fas fa-user-plus"></i> Share</button>'+
                                    '</div>'+
                                '</div>';
                    }

                    $('#content_title').html('Folder');
                    $('#folder_content').html(row);

                    $('#elements_search').val('');
                    $('#elements_sort_az').show();
                    $('#elements_sort_za').hide();

                } else {
                    allFiles(folderId);
                }
            },
            complete: function () {
                arrangeLayout();
                $(".se-pre-con").fadeOut('slow');
            }
        });
    }

    function allFiles(folderId) {
        $.ajax({
            url: '{{ url("file_management/oms/files") }}',
            type: "POST",
            dataType: 'json',
            data: {
                'folderId': folderId, '_token':'{{csrf_token()}}'
            },
            success: function(data) {
                if (data) {
                    var row = [];
                    for (let i = 0; i < data.length; i++) {
                        if (data[i].extension == 'jpg' || data[i].extension == 'jpeg' || data[i].extension == 'png') {
                            var fileContent = '<div class="card-body file-bg-img" style="background-image: url('+data[i].url+')"></div>';
                            var fileListContent = '<img src="'+data[i].url+'" class="file-img list-file-thumb mb-2" style="display: none;" /><p class="file-name list-file-name" style="display: none;">'+data[i].name+'</p>';

                        } else if (data[i].extension == 'pdf') {
                            var fileContent = '<img src="{{asset("argon")}}/img/icons/pdf_icon.png" class="file-img mb-2" />';
                            var fileListContent = '<p class="file-name list-file-name" style="display: none;">'+data[i].name+'</p>';

                        } else if (data[i].extension == 'xlsx') {
                            var fileContent = '<img src="{{asset("argon")}}/img/icons/sheets.png" class="file-img mb-2" />';
                            var fileListContent = '<p class="file-name list-file-name" style="display: none;">'+data[i].name+'</p>';

                        } else {
                            var fileContent = '<img src="{{asset("argon")}}/img/icons/placeholder.png" class="file-img mb-2" />';
                            var fileListContent = '<p class="file-name list-file-name" style="display: none;">'+data[i].name+'</p>';
                        }

                        row += '<div class="col-md-3 file-conatiner mgmt-element sort-file">'+
                                    '<button type="button" class="open-file-details-modal btn-file-menu" value="'+data[i].id+'" data-url="'+data[i].url+'" data-file_name="'+data[i].name+'" data-mimetype="'+data[i].mimetype+'" data-size="'+data[i].size+'">'+
                                        '<div class="card">'+
                                            '<div class="card-body">'+fileContent+fileListContent+'</div>'+

                                            '<div class="card-footer">'+
                                                '<p class="file-name">'+data[i].name+'</p>'+
                                            '</div>'+
                                        '</div>'+
                                    '</button>'+

                                    '<div class="folder-dropdown-content file-menu '+data[i].id+'">'+
                                        '<button type="button" class="btn-file-open" data-url="'+data[i].url+'" data-file_name="'+data[i].name+'" data-mimetype="'+data[i].mimetype+'" data-size="'+data[i].size+'"><i class="fas fa-arrows-alt"></i> Preview</button>'+
                                        '<button type="button"><i class="fas fa-info-circle"></i> View Details</button>'+
                                        '<button type="button" class="btn-file-share" value="'+data[i].id+'" data-file_path="'+data[i].path+'"><i class="fas fa-user-plus"></i> Share</button>'+
                                        '<button type="button" class="btn-file-link" value="'+data[i].id+'" data-url="'+data[i].url+'"><i class="fas fa-link"></i> Get Link</button>'+
                                    '</div>'+
                                '</div>';
                    }

                    $('#content_title').html('Files');
                    $('#folder_content').html(row);

                } else {
                    var row = '<div class="col-md-3 file-conatiner"></div>';
                    $('#content_title').html('Files');
                    $('#folder_content').html(row);
                }
            },
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

    $('body').on('click', '.folder-id', function() {
        var folderId = $(this).data('folder-id').slice(0, -1);
        console.log(folderId);
        folderContent(folderId);
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
        }).appendTo('#folder_content');
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
        }).appendTo('#folder_content');
    }

    $('body').on('click', '.btn-folder-share', function() {
        var sharePath = $(this).val();
        $('#share_path').attr('data-share_path', sharePath);
        $('#share_path').attr('data-file_path', '');
        $('#share_type').val(1);
        $('#share_modal').modal('show');
    });

    $('body').on('click', '.btn-file-share', function() {
        var sharePath = $(this).val();
        var filePath = $(this).data('file_path');
        $('#share_path').attr('data-share_path', sharePath);
        $('#share_path').attr('data-file_path', filePath);
        $('#share_type').val(2);
        $('#share_modal').modal('show');
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
        var interface_type = 'oms';

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

    $('body').on('click', '.btn-file-link', function() {
        var linkPath = $(this).data('url');
        $('#link_path').val(linkPath);
        $('#link_modal').modal('show');
    });

    function copyLink() {
        var copyText = document.getElementById("link_path");
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        navigator.clipboard.writeText(copyText.value);
    }

    $('body').on('click', '#list_layout', function() {
        localStorage.setItem('oms_layout_type', 'list');
        arrangeLayout();
    });

    $('body').on('click', '#grid_layout', function() {
        localStorage.setItem('oms_layout_type', 'grid');
        arrangeLayout();
    });

    function arrangeLayout() {
        var layout_type = localStorage.getItem('oms_layout_type');
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
</script>
@endsection
