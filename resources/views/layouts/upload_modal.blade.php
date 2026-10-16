<style>
    .progress {
        margin-left: 10px;
        margin-bottom: 0rem;
        width: 100%;
    }
    .progress_container {
        padding: 0.5rem;
        display: flex;
        flex-direction: row;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    .upload-modal {
        position: fixed;
        right: 0.5rem;
        bottom: 2.5rem;
        width: 350px;
        border: 1px solid #d2d2d2;
        border-radius: 4px;
        z-index: 1;
    }
    .upload-modal-header {
        background-color: #202124;
        padding: 7px;
        color: white;
        font-weight: bold;
        border-top-right-radius: 4px;
        border-top-left-radius: 4px;
    }
    .upload-modal-header span{
        color: white;
        font-size: 12px;
    }
    .upload-modal-body {
        background-color: white;
        padding: 0 5px;
        font-size: 14px;
        max-height: 14rem;
        overflow-y: auto;
        border-bottom-right-radius: 4px;
        border-bottom-left-radius: 4px;
    }
    .upload-modal-row {
        display: flex;
        flex-wrap: wrap;
        padding: 7px;
        border-bottom: 1px solid #d2d2d266;
    }
    .upload-modal-body img {
        height: 20px;
    }
    .file-input {
        width: 100%;
    }
</style>
<head>
    <link type="text/css" rel="stylesheet" href="{{ asset('argon') }}/file_inputs/css/fileinput.css">
</head>

<div class="upload-modal" id="upload_modal" style="display: none;">
    <div class="upload-modal-header">
        <input type="hidden" id="upload_status" value="0" />
        <span id="rename_file_label">Uploading...</span>
        <button type="button" class="close" onclick="closeUploadModal();" aria-label="Close">
            <span aria-hidden="true" style="color: white; color: white; font-size: 25px; padding-top: 5px;">&times;</span>
        </button>
    </div>

    <div class="upload-modal-body">
        <div class="form-group" id="progressbar_container"></div>
    </div>
</div>

<script src="{{ asset('argon') }}/file_inputs/js/fileinput.js"></script>
<script src="{{ asset('argon') }}/file_inputs/themes/fas/theme.min.js"></script>
<script>
    function closeUploadModal(){
        $('#progressbar_container').html('');
        $('#upload_modal').css('display', 'none');
    }

    $('body').on('click', '#btn_create_file', function() {
        var folderName = $('#create_folder_name').val();
        var directoryPath = $('#create_directory_path').data('create-directory-path');

        if($('#create_file').val()) {
            var i = 0;
            var list = $('#create_file')[0].files;
            var max = $('#create_file')[0].files.length;

            nextIteration(i, list, max);
        }
    });

    function nextIteration(i, list, max) {
        if (i >= max) {
            $('#create_file').val('');
            $('#create_file').fileinput('reset');
            $('#rename_file_label').html('Upload Completed');
            return;
        }

        var formData = new FormData();
        formData.append("create_file_path", $("#create_file_path").data('create-file-path'));

        formData.append("create_file", $('#create_file')[0].files[i]);

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
                onEvent(i, list, max);
            }
        });
    }

    function onEvent(i, list, max) {
        $('#upload_status').val(0);

        var filename = $('#create_file')[0].files[i].name;

        var completedFile = '<span style="width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><img src="{{asset("argon")}}/img/icons/image_icon.png" /> '+filename+'</span>'+
                            '<img src="{{asset("argon")}}/img/icons/check_green.png" />';

        $('.progress_container_'+i).html(completedFile);

        i++;
        nextIteration(i, list, max);
    }

    $(document).ready(function(){
        $('#upload_status').val(0);

        $("#create_file").fileinput({
            uploadUrl: "#",
            enableResumableUpload: true,
            theme: 'fas',
            deleteUrl: "#",
            overwriteInitial: false,
            maxFileSize: 5120000,
            fileActionSettings: {
                showZoom: function(config) {
                    if (config.type === 'pdf' || config.type === 'image') {
                        return true;
                    }
                    return false;
                },
                showUpload: false,
            },
            previewFileIconSettings: {
                'doc': '<i class="fas fa-file-word text-primary"></i>',
                'xls': '<i class="fas fa-file-excel text-success"></i>',
                'ppt': '<i class="fas fa-file-powerpoint text-danger"></i>',
                'pdf': '<i class="fas fa-file-pdf text-danger"></i>',
                'zip': '<i class="fas fa-file-archive text-muted"></i>',
                'htm': '<i class="fas fa-file-code text-info"></i>',
                'txt': '<i class="fas fa-file-alt text-info"></i>',
                'mov': '<i class="fas fa-file-video text-warning"></i>',
                'mp3': '<i class="fas fa-file-audio text-warning"></i>',
                'jpg': '<i class="fas fa-file-image text-danger"></i>',
                'gif': '<i class="fas fa-file-image text-muted"></i>',
                'png': '<i class="fas fa-file-image text-primary"></i>',
            },
            previewFileExtSettings: {
                'doc': function(ext) {
                    return ext.match(/(doc|docx)$/i);
                },
                'xls': function(ext) {
                    return ext.match(/(xls|xlsx)$/i);
                },
                'ppt': function(ext) {
                    return ext.match(/(ppt|pptx)$/i);
                },
                'zip': function(ext) {
                    return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
                },
                'htm': function(ext) {
                    return ext.match(/(htm|html)$/i);
                },
                'txt': function(ext) {
                    return ext.match(/(txt|ini|csv|java|php|js|css)$/i);
                },
                'mov': function(ext) {
                    return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
                },
                'mp3': function(ext) {
                    return ext.match(/(mp3|wav)$/i);
                },
                'jpg': function(ext) {
                    return ext.match(/(jpg|jpeg)$/i);
                },
                'pdf': function(ext) {
                    return ext.match(/(pdf)$/i);
                },
            },
        }).on('filebeforedelete', function() {
            return new Promise(function(resolve, reject) {
                $.confirm({
                    title: 'Confirmation!',
                    content: 'Are you sure you want to delete this file?',
                    type: 'red',
                    buttons: {
                        ok: {
                            btnClass: 'btn-primary text-white',
                            keys: ['enter'],
                            action: function(){
                                resolve();
                            }
                        },
                        cancel: function(){
                            $.alert('File deletion was aborted! ');
                        }
                    }
                });
            });
        });
    });
</script>
