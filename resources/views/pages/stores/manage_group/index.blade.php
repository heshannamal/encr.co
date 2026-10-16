@extends('layouts.app', ['activePage' => 'Team Stores', 'titlePage' => __('Team Stores')])

@section('sub-sidebar-content')

<style>
    .main_card {
        margin-top: 20px;
        border: unset;
        padding-bottom: 15px;
        border-radius: unset;
    }

    .add_user {
        width: 125px;
        height: 35px;
        background-color: #F8F8F8;
        border: 1px solid #DEDEDE;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
        color: #B3B3B3;
    }

    .add_user_div {
        margin-right: 15px;
        padding: 15px;
        padding-bottom: unset;
    }

    .manage_group_topic {
        font-size: 18px;
    }

    .card_div {
        padding: 15px;
        padding-bottom: 5px;
    }

    .manage_group_p {
        font-size: 11px;
        color: #717070;
        font-weight: 500;
        margin-bottom: unset;
    }

    .empty_user {
        text-align: center;
        padding-top: 100px;
    }

    .empty_user_text {
        color: #B3B3B3;
        font-size: 13px;
        padding: 15px;
    }

    .user-row {
        padding: 10px;
        background-color: #f9f9f9;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
        display: none;
    }

    @media (max-width: 767px) {
        .main_card {
            margin-top: 15px !important;
            background-color: transparent !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 10px !important;
        }

        .main_card > div > hr {
            display: none !important;
        }

        .card_div {
            width: 100% !important;
            padding: 20px !important;
            background-color: #ffffff !important;
            border-radius: 16px !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03) !important;
            margin-bottom: 12px !important;
        }

        .manage_group_topic {
            font-size: 18px !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            display: block !important;
            margin-bottom: 8px !important;
        }

        .manage_group_p {
            font-size: 12px !important;
            line-height: 1.5 !important;
            color: #64748b !important;
        }

        .add_user_div {
            width: 100% !important;
            margin-right: 0 !important;
            padding: 15px !important;
            background-color: #ffffff !important;
            border-radius: 16px !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03) !important;
            margin-bottom: 12px !important;
            text-align: center !important;
        }

        .add_user {
            width: 100% !important;
            height: auto !important;
            background-color: #f1f5f9 !important;
            border: none !important;
            border-radius: 10px !important;
            padding: 12px !important;
            font-size: 0 !important; /* Hide original text */
            cursor: pointer !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .add_user i {
            display: none !important;
        }

        .add_user::after {
            content: "+ Add User" !important;
            font-size: 15px !important;
            font-weight: 600 !important;
            color: #0f172a !important;
        }

        /* Hide table header row */
        .main_card > .user-row:nth-child(2) {
            display: none !important;
        }

        .user-row {
            background-color: #ffffff !important;
            border-radius: 16px !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03) !important;
            padding: 15px 20px !important;
            margin-bottom: 12px !important;
            border: none !important;
        }

        .user-row .row {
            margin: 0 !important;
            display: grid !important;
            grid-template-columns: 1fr auto !important;
            grid-template-areas:
                "name actions"
                "email actions" !important;
            align-items: center !important;
            gap: 2px 10px !important;
        }

        .user-row .col-lg-5,
        .user-row .col-lg-2 {
            width: auto !important;
            max-width: none !important;
            flex: none !important;
            padding: 0 !important;
            text-align: left !important;
            word-break: break-word !important;
        }

        .user-row .row > div:nth-child(1) {
            grid-area: name !important;
            font-weight: 700 !important;
            font-size: 15px !important;
            color: #0f172a !important;
        }

        .user-row .row > div:nth-child(2) {
            grid-area: email !important;
            color: #64748b !important;
            font-size: 13px !important;
            font-family: inherit !important;
        }

        .user-row .row > div:nth-child(3) {
            grid-area: actions !important;
            display: flex !important;
            gap: 8px !important;
            justify-content: flex-end !important;
        }

        .user-row .row > div:nth-child(3) button.copy_link_btn {
            width: 38px !important;
            height: 38px !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            background: #ffffff !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 0 !important;
            cursor: pointer !important;
            outline: none !important;
        }

        .user-row .row > div:nth-child(3) button.copy_link_btn:nth-child(2) {
            order: 1 !important;
            color: #334155 !important;
        }

        .user-row .row > div:nth-child(3) button.copy_link_btn:nth-child(1) {
            order: 2 !important;
            color: #ef4444 !important;
            border-color: #fee2e2 !important;
        }

        .empty_user {
            padding-top: 40px !important;
        }

        .bg-box.container-fluid.fix-nav.header-layout {
            margin-bottom: 0 !important;
        }

        .header-layout {
            margin-bottom: 0 !important;
            height: auto !important;
            min-height: 0 !important;
        }

        /* Prevent iOS Safari from auto-zooming on focus */
        input[type="text"],
        input[type="number"],
        input[type="search"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        input[type="url"],
        select,
        textarea,
        .form-control,
        .select2-selection,
        .select2-search__field,
        .select2-search input {
            font-size: 16px !important;
        }
    }
</style>

<div class="container-fluid mb-5" style="padding: 0 !important;">
    <div class="se-pre-con"></div>

    @include('pages.stores.layouts.top_header')

    @yield('stores_header')

    <div class="card col-lg-12 main_card" style="margin-top: 20px;">
        <div class="">
            <div class="row">
                <div class="card_div" style="width: 80%;">
                    <strong class="manage_group_topic">Manage Group Access</strong>
                    <p class="manage_group_p">Add the email addresses of coaches or group managers here to give access to marketing tools and store details like store open/close dates, fundraising totals and order summary.</p>
                </div>
                <div class="ml-auto add_user_div" style="width: 17%; text-align: right;">
                    <button class="add_user" data-toggle="modal" data-target="#addUserModal">
                        <i class="fa fa-user-plus" style="padding: 5px;"></i> ADD USER
                    </button>
                </div>
            </div>
            <hr style="margin: unset; margin-bottom: 10px;">

        </div>

        @if ($store->groupAccessDetails->count() > 0)

        <div class="user-row">
            <div class="row">
                <div class="col-lg-5" style="font-weight: 600;">USER NAME</div>
                <div class="col-lg-5" style="font-weight: 600;">EMAIL</div>
                <div class="col-lg-2 text-center" style="font-weight: 600;">ACTIONS</div>
            </div>
        </div>

        @foreach ($store->groupAccessDetails as $user)

        <div class="user-row">
            <div class="row">
                <div class="col-lg-5">{{$user->name}}</div>
                <div class="col-lg-5">{{$user->email}}</div>
                <div class="col-lg-2 text-center">
                    <button class="copy_link_btn" style="font-size: .9rem;" onclick="remove_access({{$user->id}})">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                    <button class="copy_link_btn" style="font-size: .9rem;"
                        onclick="edit_access({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', '{{ addslashes($user->active) }}')">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>

        @endforeach

        @else

        <div class="empty_user">
            <img src="{{asset('assets')}}/img/team_stores/empty_user_access_img.png" style="width: 120px;" />
            <p class="empty_user_text">Haven't add any user access yet.</p>
        </div>

        @endif
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Manage User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="addUserForm" action="{{ route('store.add_user_group_access') }}">
                    @csrf
                    <input type="hidden" name="group_access_id" id="store_group_access_id">
                    <input type="hidden" name="group_access_store_id" id="group_access_store_id" value="{{ $store->id }}">
                    <div class="form-row p-3">
                        <div class="col-md-6 mb-3">
                            <label for="storeUserName">Name</label>
                            <input type="text" class="form-control" id="storeUserName" name="name" placeholder="Enter name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="storeUserEmail">Email</label>
                            <input type="email" class="form-control" id="storeUserEmail" name="email" placeholder="Enter email" required>
                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="form-check d-flex align-items-center">
                                <input type="checkbox" class="form-check-input" id="denied_access" name="denied_access">
                                <label class="form-check-label mb-0 ms-2" for="denied_access">
                                    Denied Access
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="text-right p-3">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(document).on('click', '.add_user', function(e) {
            e.preventDefault();

            $('#addUserForm')[0].reset();

            $('#store_group_access_id').val('');

            $('#addUserModal').modal('show');
        });
    });

    function edit_access(id, name, email, active) {
        $('#store_group_access_id').val(id);
        $('#storeUserName').val(name);
        $('#storeUserEmail').val(email);
        $('#denied_access').prop('checked', active == 0);
        $('#addUserModal').modal('show');
    }

    function remove_access(id) {
        console.log('id is : ' + id);
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $('.se-pre-con').fadeIn('slow');

                $.ajax({
                    url: "{{ route('store.remove_user_group_access') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        group_access_id: id
                    },
                    success: function(response) {
                        $('.se-pre-con').fadeOut('slow');

                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message || 'User access deleted successfully!',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        location.reload();
                    },
                    error: function(xhr) {
                        $('.se-pre-con').fadeOut('slow');

                        let msg = 'Something went wrong. Please try again.';
                        if (xhr.responseJSON?.message) {
                            msg = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: msg
                        });
                    }
                });
            }
        });
    }
</script>

@endsection
@section('content')
@include('pages.stores.layouts.sidebar', ['sub_content' => 'overview'])
@endsection
