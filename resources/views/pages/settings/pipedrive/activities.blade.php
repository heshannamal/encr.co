@extends('layouts.app', ['activePage' => 'pipedrive_activities', 'titlePage' => __('Activities')])

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
    .select2-container {
        width: 90% !important;
    }
    .sync-text {
        font-weight: bold;
        font-size: 12px;
    }
    .synced-count {
        font-weight: bold;
        text-transform: uppercase;
    }
    td {
        vertical-align: middle !important;
    }
</style>


<div class="container-fluid mb-5">
    <div class="se-pre-con"></div>

    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <h1 class="float-left header-title">Pipedrive Synchronization - Activities</h1>

                    <div class="float-right header-icons"></div>
                </div>

            </div>

            <div class="card-body">
                <form action="{{ route('pipedrive.activities_upload') }}" id="activities_upload_form" method="post" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" id="pDOCount" value="{{$pDOCount}}" />
                    <input type="hidden" id="syncedPDOCount" value="{{$syncedPDOCount}}" />
                    <input type="hidden" id="pDCCount" value="{{$pDCCount}}" />
                    <input type="hidden" id="syncedPDCCount" value="{{$syncedPDCCount}}" />

                    <div class="row" style="margin: 0px;">
                        <div class="col-md-6">
                            <select class="form-control" name="user_id" id="user_id" required>
                                <option value="">Select an User</option>
                                @foreach ($users as $user)
                                    <option value="{{$user->id}}" @if ($user->id == request()->get('userId')) selected @endif>{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="file" class="form-control" name="activities_csv" accept=".xlsx, .xls, .csv" required />
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-info btn-sm"><i class="fas fa-upload"></i> Upload</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row mt-3" style="display: flex; align-items: center;">
                    <div class="col-md-6 ml-3">
                        <a href="#" class="btn btn-sm btn-secondary-custom btn-info mb-2" id="load_activities">
                            <i class="fas fa-angle-double-down"></i> Load User Activites
                        </a>
                        <br>

                        @if (request()->get('userId') > 0)
                            <span class="synced-count mt-1">Organization Synced/Total: {{$syncedPDOCount}}/{{$pDOCount}}</span><br>
                            <span class="synced-count mt-1">People Synced/Total: {{$syncedPDCCount}}/{{$pDCCount}}</span><br>
                            <span class="synced-count mt-1">Activity Synced/Total: {{$syncedCount}}/{{$ACTCount}}</span><br>
                        @endif
                        <button type="button" onclick="submitDATA()" class="btn btn-sm btn-success btn-secondary-custom mt-1 mb-2"><i class="fas fa-sync-alt"></i> Sync</button>

                    </div>

                    <div class="col-md-6" style="display: flex; justify-content: flex-end;">
                        @if (request()->get('userId') > 0)
                        {{ $pDActivities->appends(['userId' => request()->get('userId')])->onEachSide(1)->links("pagination::bootstrap-4") }}
                        @endif
                    </div>
                </div>

                <form action="{{ route('pipedrive.activities_sync') }}" id="activities_sync" method="post">
                    @csrf
                    @if (request()->get('userId') > 0)
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-theme">
                                        <th>Is Done</th>
                                        <th>Contact Person</th>
                                        <th>Organization</th>
                                        <th>search/link Org</th>
                                        <th>Subject</th>
                                        <th>Deal</th>
                                        <th>Note</th>
                                        <th>Email</th>
                                        <th>Phone No</th>
                                        <th>Due Date</th>
                                        <th>Duration</th>
                                        <th>is synced</th>
                                    </thead>

                                    <tbody>
                                        @foreach ($pDActivities as $pDActivity)

                                            <input type="hidden" name="PD_records[{{$pDActivity->id}}][user]" value="{{ optional($pDActivity->pDCDetails)->contact_id}}">
                                            <input type="hidden" name="PD_records[{{$pDActivity->id}}][organization]" value="{{ optional($pDActivity->pDODetails)->organization_id}}">
                                            <input type="hidden" name="PD_records[{{$pDActivity->id}}][user_sync]" value="{{ optional($pDActivity->pDCDetails)->is_synced}}">
                                            <input type="hidden" name="PD_records[{{$pDActivity->id}}][organization_sync]" value="{{ optional($pDActivity->pDODetails)->is_synced}}">
                                            <input type="hidden" name="PD_records[{{$pDActivity->id}}][user_id]" value="{{ request()->get('userId')}}">

                                            <tr>
                                                <td>{{$pDActivity->done}}</td>
                                                <td>
                                                    @if (optional($pDActivity->pDCDetails)->is_synced == 1)
                                                        <i class="fas fa-circle text-success"></i> {{$pDActivity->contact_name}}
                                                    @else
                                                        <i class="fas fa-circle text-danger"></i> {{$pDActivity->contact_name}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (optional($pDActivity->pDODetails)->is_synced == 1)
                                                        <i class="fas fa-circle text-success"></i> {{$pDActivity->organization_name}}
                                                    @else
                                                        <i class="fas fa-circle text-danger"></i> {{$pDActivity->organization_name}}
                                                    @endif
                                                </td>
                                                <td>
                                                    <select id="organizationSelect{{$pDActivity->id}}" class="organization-select" data-activity-id="{{$pDActivity->id}}" style="width: 500px;">
                                                        <option value="">Search organizations...</option>
                                                    </select>
                                                </td>
                                                <td>{{$pDActivity->subject}}</td>
                                                <td>{{$pDActivity->deal}}</td>
                                                <td>{{$pDActivity->note}}</td>
                                                <td>{{$pDActivity->email}}</td>
                                                <td>{{$pDActivity->phone_no}}</td>
                                                <td>{{$pDActivity->due_date}}</td>
                                                <td>{{$pDActivity->duration}}</td>
                                                <td>
                                                    @if ($pDActivity->is_synced == 1)
                                                        <i class="text-success">&nbsp;Synced</i>
                                                    @elseif($pDActivity->is_synced == 2)
                                                        <i class="text-success">&nbsp;Already Exist</i>
                                                    @else
                                                        <i class="text-danger">&nbsp;Not Synced</i>
                                                    @endif
                                                </td>
                                            </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <div class="row mt-3" style="display: flex; align-items: center;">
                        <div class="col-md-6">
                            @if (request()->get('userId') > 0)
                                <span class="synced-count mt-1">Organization Synced/Total: {{$syncedPDOCount}}/{{$pDOCount}}</span><br>
                                <span class="synced-count mt-1">People Synced/Total: {{$syncedPDCCount}}/{{$pDCCount}}</span><br>
                                <span class="synced-count mt-1">Activity Synced/Total: {{$syncedCount}}/{{$ACTCount}}</span><br>
                            @endif
                            <button type="submit" class="btn btn-sm btn-success btn-secondary-custom mt-1 1st_submit_btn"><i class="fas fa-sync-alt"></i> Sync</button>
                        </div>

                        <div class="col-md-6" style="display: flex; justify-content: flex-end;">
                            @if (request()->get('userId') > 0)
                            {{ $pDActivities->appends(['userId' => request()->get('userId')])->onEachSide(1)->links("pagination::bootstrap-4") }}
                            @endif
                        </div>
                    </div>
            </form>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $(".se-pre-con").fadeOut('slow');

        $('select').select2();
        $('.select2-organization-modal').select2({
            dropdownParent: $('#organization_create_modal')
        });

        $('#user_id').on('change', function(){
            var user_id = $(this).val();
            var url = '{{ route("pipedrive.activities", ["userId"=>"user_id"]) }}';
            url = url.replace('user_id', user_id);
            $('#load_activities').attr('href', url);
        });

        $('#load_activities').on('click', function(e){
            e.preventDefault();
            var href = $(this).attr('href');

            var user_id = $('#user_id').val();

            if (user_id == '') {
                Swal.fire({
                    title: "Error!",
                    text: "Please select a user",
                    type: "warning",
                    allowOutsideClick: false,
                });
            } else {
                window.location = href;
            }
        });

        $('#activities_upload_form').on('submit', function(e){
            e.preventDefault();
            $(".se-pre-con").fadeIn('slow');
            this.submit();
        });

        // $('#activities_upload_form').on('submit', function(e){
        //     e.preventDefault();
        //     var pDOCount = $('#pDOCount').val();
        //     var syncedPDOCount = $('#syncedPDOCount').val();
        //     var pDCCount = $('#pDCCount').val();
        //     var syncedPDCCount = $('#syncedPDCCount').val();

        //     if (pDOCount == syncedPDOCount) {
        //         if (pDCCount == syncedPDCCount) {
        //             $(".se-pre-con").fadeIn('slow');
        //             this.submit();
        //         } else {
        //             Swal.fire({
        //                 title: "Contact persons are not synced!",
        //                 text: "Please sync all contact persons",
        //                 type: "warning",
        //                 allowOutsideClick: false,
        //             });
        //         }

        //     } else {
        //         Swal.fire({
        //             title: "Organizations are not synced!",
        //             text: "Please sync all organizations",
        //             type: "warning",
        //             allowOutsideClick: false,
        //         });
        //     }
        // });
    });

    function submitDATA(){
        $('.1st_submit_btn').click();
    }
</script>
<script>
   $(document).ready(function() {
    // Loop through each select element with class 'organization-select'
    $('.organization-select').each(function() {
        // Initialize Select2 for the current select element
        initializeOrganizationSelect2(this);
    });
});

// Function to initialize Select2 for organization search
function initializeOrganizationSelect2(input) {
    $(input).select2({
        placeholder: 'Search organizations...',
        ajax: {
            url: "{{ url('/pipedrive/searchorganizations') }}",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term
                };
            },
            processResults: function(data) {
                var options = $.map(data, function(item) {
                    return {
                        id: item.id,
                        text: item.organization_name,
                        isNew: false // Assume all options are existing by default
                    };
                });

                return { results: options };
            },
            cache: true
        },
        minimumInputLength: 2,
        tags: true, // Allow creating new options by typing
        createTag: function(params) {
            return {
                id: params.term,
                text: params.term,
                isNew: true // Set isNew to true for new options
            };
        }
    }).on('select2:select', function (e) {
        var data = e.params.data;
        var selectedText = data.text;

        if (data.isNew) {
            // If the selected option is new, prompt to create a new organization
            swal({
                title: "New Option Selected",
                text: "Do you want to create a new organization for '" + selectedText + "'?",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((createNew) => {
                if (createNew.value) {
                    // Get the activity ID
                    var activityId = $(this).data('activity-id');
                    // Get the text of the newly created organization
                    var newOrganizationName = selectedText;
console.log(activityId);
console.log(newOrganizationName);
                    // AJAX request to create a new organization
                    $.ajax({
                        url: "{{ url('/pipedrive/createorganization') }}",
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token in headers
                        },
                        data: {
                            activity_id: activityId,
                            organization_name: newOrganizationName
                        },
                        success: function(response) {
                            // Handle success response
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            swal("Error creating organization", {
                                icon: "error",
                            });
                        }
                    });

                }
            });
        } else {
            // If the selected option already exists, prompt to link with the existing organization
            swal({
                title: "Existing Option Selected",
                text: "Do you want to link with the existing organization '" + selectedText + "'?",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((linkExisting) => {
                if (linkExisting.value) {
                    // Get the activity ID
                    var activityId = $(this).data('activity-id');
                    // Get the text of the newly created organization
                    var organizationId = data.id;
console.log(activityId);
console.log(organizationId);
                    // AJAX request to create a new organization
                    $.ajax({
                        url: "{{ url('/pipedrive/linkorganization') }}",
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token in headers
                        },
                        data: {
                            activity_id: activityId,
                            organizationId: organizationId
                        },
                        success: function(response) {
                            // Handle success response
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            swal("Error creating organization", {
                                icon: "error",
                            });
                        }
                    });
                }
            });
        }
    });
}



</script>
@endsection
