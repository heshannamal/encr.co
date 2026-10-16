@php
$shareUsers = isset($users) ? $users : (isset($activeUsers) ? $activeUsers : []);
@endphp

<style>
    #shareProjectModal.modal.show {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        background: rgba(104, 104, 104, 0.3) !important;
        backdrop-filter: blur(1px);
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        z-index: 1050 !important;
    }

    #shareProjectModal .modal-dialog {
        max-width: 500px !important;
        width: 500px !important;
        margin: 0 !important;
        transform: none !important;
    }

    #shareProjectModal .modal-content {
        border-radius: 12px !important;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3) !important;
        width: 100% !important;
        max-width: none !important;
        padding: 0 !important;
        border: none !important;
        background: #fff !important;
    }

    #shareProjectModal .modal-title {
        color: #32325d !important;
        font-weight: 700 !important;
        font-family: inherit !important;
        margin: 0 !important;
    }

    #shareProjectModal .modal-body {
        padding: 1.5rem !important;
        background: #fff !important;
    }

    #shareProjectModal .form-group {
        margin-bottom: 1.5rem !important;
        display: block !important;
    }

    #shareProjectModal label {
        display: block !important;
        width: 100% !important;
        margin-bottom: 0.5rem !important;
        text-align: left !important;
        font-weight: 600 !important;
        color: #32325d !important;
        font-size: 0.9rem !important;
    }

    #shareProjectModal .select2-container {
        width: 100% !important;
        display: block !important;
    }

    #shareProjectModal .select2-selection--single {
        height: 40px !important;
        border: 1px solid #cad1d7 !important;
        border-radius: 4px !important;
        display: flex !important;
        align-items: center !important;
        background: #fff !important;
    }

    #shareProjectModal .select2-selection__rendered {
        line-height: 40px !important;
        padding-left: 12px !important;
        color: #525f7f !important;
        text-align: left !important;
    }

    #shareProjectModal .select2-selection__arrow {
        height: 38px !important;
    }

    #shareProjectModal .btn-custom-modal {
        padding: 10px 20px !important;
        background-color: #ffffff !important;
        color: #525f7f !important;
        border: 1px solid #cad1d7 !important;
        border-radius: 4px !important;
        font-weight: 600 !important;
        font-size: 0.875rem !important;
        transition: all 0.2s ease !important;
        box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08) !important;
        cursor: pointer !important;
        display: inline-block !important;
    }

    #shareProjectModal .btn-custom-modal:hover {
        background-color: #f7fafc !important;
        border-color: #adb5bd !important;
        transform: translateY(-1px) !important;
    }

    @media (max-width: 576px) {
        #shareProjectModal .modal-dialog {
            width: 90% !important;
            max-width: 90% !important;
        }
    }
</style>

<!-- Share Project Modal -->
<div class="modal" id="shareProjectModal" tabindex="-1" role="dialog" aria-labelledby="shareProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h3 class="modal-title" id="shareProjectModalLabel">Share Project</h3>
                <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <p style="color: #525f7f; margin-bottom: 1.5rem; text-align: left;">Search and add users to share this project with.</p>
                <div class="form-group">
                    <label for="share_user_select">Select User</label>
                    <select class="form-control w-100" id="share_user_select" name="share_user">
                        <option value="">Select a user...</option>
                        @foreach ($shareUsers as $user)
                            <option value="{{ isset($user->id) ? $user->id : $user['id'] }}" data-type="user">{{ isset($user->name) ? $user->name : $user['name'] }}</option>
                        @endforeach
                    </select>
                </div> -->
                <input type="hidden" id="share_project_id" value="">


                <div id="share_link_container" style="display: none; margin-top: 15px;">
                    <label id="share_link_label">Share Link</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="share_project_link" readonly style="background-color: #f7fafc;">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary copy-share-link" type="button" data-target="share_project_link" style="border: 1px solid #ced4da; background: #fff; color: #525f7f; height: 100%;"><i class="fa fa-copy"></i> Copy</button>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4 gap-2">
                    <button type="button" class="btn btn-custom-modal" data-dismiss="modal" data-bs-dismiss="modal">Cancel</button>
                    <!-- <button type="button" class="btn btn-custom-modal" id="btn_share_project">Share & Get Link</button> -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        let selectedShareTarget = {
            type: 'project',
            id: null
        };

        function getProjectShareBaseUrl(projectId) {
            return '{{ url("projects/view-temp") }}/' + projectId;
        }

        function getTargetShareUrl(projectId, targetType, targetId) {
            if (!targetType || targetType === 'project' || !targetId) {
                return getProjectShareBaseUrl(projectId);
            }

            if (targetType === 'section') {
                return getProjectShareBaseUrl(projectId) + '?open_target=true&type=section&section_id=' + encodeURIComponent(targetId);
            }

            return getProjectShareBaseUrl(projectId) + '?open_chat=true&type=' + encodeURIComponent(targetType) + '&discussion_id=' + encodeURIComponent(targetId);
        }


        function getShareLabel(type) {
            switch (type) {
                case 'section':
                    return 'Section Share Link';
                case 'discussion':
                    return 'Task Share Link';
                case 'sub_discussion':
                    return 'Sub Task Share Link';
                default:
                    return 'Project Share Link';
            }
        }

        function refreshShareLinks(projectId) {
            let link = '';
            if (selectedShareTarget.type === 'project' || !selectedShareTarget.id) {
                link = getProjectShareBaseUrl(projectId);
            } else {
                link = getTargetShareUrl(projectId, selectedShareTarget.type, selectedShareTarget.id);
            }
            $('#share_project_link').val(link);
            $('#share_link_label').text(getShareLabel(selectedShareTarget.type));
            $('#share_link_container').show();
        }

        // Share Project Logic
        $('#share_user_select').select2({
            dropdownParent: $('#shareProjectModal'),
            width: '100%'
        });

        $('body').on('click', '.share-project', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var projectId = $(this).data('id');
            var assignees = String($(this).data('assignees')).split(',');
            selectedShareTarget = {
                type: $(this).data('target-type') || 'project',
                id: $(this).data('target-id') || null
            };

            $('#share_project_id').val(projectId);
            $('#share_link_container').show();
            $('#share_project_link').val('');
            $('#share_user_select').val(null).trigger('change');
            refreshShareLinks(projectId);

            // Enable all options first, then disable the ones already assigned
            $('#share_user_select option').each(function() {
                if ($(this).val() !== "") {
                    if (assignees.includes($(this).val())) {
                        $(this).prop('disabled', true);
                    } else {
                        $(this).prop('disabled', false);
                    }
                }
            });

            $('#share_user_select').select2({
                dropdownParent: $('#shareProjectModal'),
                width: '100%'
            });

            $('#shareProjectModal').modal('show');
        });

        // Manual close fallback for both Bootstrap versions
        $('body').on('click', '[data-dismiss="modal"], [data-bs-dismiss="modal"]', function() {
            $('#shareProjectModal').modal('hide');
        });

        $('#btn_share_project').on('click', function() {
            var projectId = $('#share_project_id').val();
            var userId = $('#share_user_select').val();

            if (!userId) {
                Swal.fire('Error!', 'Please select a user to share with.', 'error');
                return;
            }

            // $.ajax({
            //     url: '{{ url("projects/add_assignee") }}',
            //     method: 'POST',
            //     dataType: 'json',
            //     data: {
            //         'project_id': projectId,
            //         'assignee_id': userId,
            //         'assignee_type': 'user',
            //         '_token': '{{ csrf_token() }}'
            //     },
            //     beforeSend: function() {
            //         $(".se-pre-con").fadeIn();
            //     },
            //     success: function(data) {
            //         $(".se-pre-con").fadeOut();
            //         if (data[3] && data[3][0] === 'success') {
            //             refreshShareLinks(projectId);
            //             $('#share_link_container').fadeIn();

            //             var btn = $('.share-project[data-id="' + projectId + '"]');
            //             btn.each(function() {
            //                 var currentAssignees = $(this).data('assignees');
            //                 if (currentAssignees) {
            //                     $(this).data('assignees', currentAssignees + ',' + userId);
            //                 } else {
            //                     $(this).data('assignees', userId);
            //                 }
            //             });
            //         } else {
            //             var errorMsg = data[3] ? data[3][1] : 'Could not add assignee';
            //             Swal.fire('Error', errorMsg, 'error');
            //         }
            //     },
            //     error: function() {
            //         $(".se-pre-con").fadeOut();
            //         Swal.fire('Error!', 'Something went wrong', 'error');
            //     }
            // });
        });

        $('body').on('click', '.copy-share-link', function() {
            var targetId = $(this).data('target');
            var copyText = document.getElementById(targetId);
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand('copy');

            var $btn = $(this);
            var originalText = $btn.html();
            $btn.html('<i class="fa fa-check"></i> Copied!');
            setTimeout(function() {
                $btn.html(originalText);
            }, 2000);
        });
    });
</script>