
<style>
    #edit_image_container {
        width: 100px;
        height: 100px;
        margin-left: 15px;
        margin-top: -30px;
        border-radius: 50%;
        overflow: hidden;
    }
    #edit_image_preview {
        width: 100%;
        height: 100%;
    }
    #toggleNewPassword {
        cursor: pointer;
    }
    #toggleNewConfirmPassword {
        cursor: pointer;
    }
</style>

<div class="modal fade" id="user_edit_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Edit Users</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('users.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row">
                            <input type="hidden" id="user_id" name="user_id" />

                            <div class="col-md-6 form-field">
                                <label class="form-lable" for="edit_name">Name <span class="text-danger">*</span></label>&nbsp;
                                <input type="text" class="form-control form-input" id="edit_name" name="edit_name" required />
                            </div>

{{--                            <div class="col-md-6 form-field">--}}
{{--                                <label class="form-lable">Email <span class="text-danger">*</span></label>--}}
{{--                                <input type="email" class="form-control form-input" id="edit_email" disabled required />--}}
{{--                            </div>--}}

                            <div class="col-md-6 form-field">
                                <label class="form-lable" for="edit_user_role_id">User Group<span class="text-danger">*</span></label>
                                <select type="text" class="form-control form-input" id="edit_user_role_id" name="edit_user_role_id[]" multiple="multiple" required>
                                    @foreach ($userRoles as $userRole)
                                        {{-- <option value="{{$userRole->id}}" @if ($user->user_role_id == $userRole->id) selected @endif>{{$userRole->user_role_name}}</option> --}}
                                        <option value="{{$userRole->id}}" @if ($user->role_id == $userRole->id) selected @endif>{{$userRole->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- <div class="col-md-6 form-field">
                                <label class="form-lable">User Group <span class="text-danger">*</span></label>
                                <select type="text" class="form-control form-input" id="edit_user_group_id" name="edit_user_group_id" required>
                                    @foreach ($userGroups as $userGroup)
                                        <option value="{{$userGroup->id}}" @if ($user->user_group_id == $userGroup->id) selected @endif>{{$userGroup->user_group_name}}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            <div class="col-md-6 form-field">
                                <label class="form-lable">Profile Picture</label>
                                <input type="file" class="form-control form-input" id="edit_profile_pic" name="edit_profile_pic" onchange="updateFile()" style="overflow: hidden;" />
                            </div>



                            <div class="col-md-6 form-field mt-5">
                                <div id="edit_image_container">
                                    <img id="edit_image_preview" />
                                    <input type="hidden" id="edit_old_profile_pic" name="edit_old_profile_pic" />
                                </div>
                            </div>

                            <div class="col-12 form-field mt-1">
                                <input type="checkbox" id="changeLoginDetails" name="change_login_details">
                                <label for="changeLoginDetails" class="m-1"> &nbsp;Change Login Details</label>
                            </div>
                            <div id="loginDetailsHolder" class="col-md-12 mt-1" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6 form-field">
                                        <label class="form-lable">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control form-input" id="edit_email" name="edit_email" />
                                    </div>

                                    <div class="col-md-6 form-field">
                                        <label class="form-lable">Password  <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="edit_password" name="edit_password" />
                                            <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-eye-slash" id="toggleNewPassword"></i>

                                </span>
                                    </div>
                                    </div>
                                    <div class="col-md-6 form-field">
                                        <label class="form-lable">Confirm Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                        <input type="password" class="form-control" id="edit_conform_password" name="edit_conform_password" />
                                        <span class="input-group-text" id="basic-addon2">
                                    <i class="fas fa-eye-slash" id="toggleNewConfirmPassword"></i>
                                </span>
                                        </div>

                                    </div>
                                    <div id="conform_password_message" class="col-12 text-danger" style="display: none;">
                                        <span>password conform not matched...!</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 control-btns">
                        <button class="btn btn-secondary btn-custom"  type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        @can('delete users')
                        <button type="button" class="btn btn-danger btn-custom delete">Delete</button>
                        @endcan
                        @can('edit users')
                        <button type="submit" class="btn btn-success btn-custom" id="update">Update</button>
                        @endcan
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    //manage  username password
    $(document).ready(function () {
        checkPasswordMatch();
        $("#edit_password").keyup(checkPasswordMatch);
        $("#edit_conform_password").keyup(checkPasswordMatch);

        function checkPasswordMatch() {
            var changeLoginDetails = document.getElementById('changeLoginDetails').checked;
            if (changeLoginDetails){
                var password = $("#edit_password").val();
                var confirmPassword = $("#edit_conform_password").val();
                var passwordField = document.getElementById('edit_password');
                var confirmPasswordField = document.getElementById('edit_conform_password');

                if(passwordField.value !== ''){
                    confirmPasswordField.setAttribute('required', 'true');
                }else{
                    confirmPasswordField.removeAttribute('required');
                }
                if (password != confirmPassword) {
                    $("#edit_conform_password").addClass("is-invalid");
                    document.getElementById('conform_password_message').style.display = 'block';
                    document.getElementById('update').disabled = true;
                }else {
                    $("#edit_conform_password").removeClass("is-invalid");
                    document.getElementById('conform_password_message').style.display = 'none';
                    document.getElementById('update').disabled = false;

                }
            }

        }
        $('body').on('change', '#changeLoginDetails', function() {
            checkPasswordMatch();
            var changeLoginDetails = document.getElementById('changeLoginDetails').checked;
            var loginDetailsHolder = document.getElementById('loginDetailsHolder');
            var password = document.getElementById('edit_password');
            var conform_password = document.getElementById('edit_conform_password');
            if(changeLoginDetails){
                loginDetailsHolder.style.display = 'block';
                document.getElementById('edit_email').setAttribute('required', 'true');

            }else{
                loginDetailsHolder.style.display = 'none';
                document.getElementById('edit_email').removeAttribute('required');
                conform_password.removeAttribute('required');
            }
        });



    });



    $('body').on('click', '#toggleNewPassword', function() {
        var x = document.getElementById("edit_password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
        $(this).toggleClass('fa-eye fa-eye-slash');
    });
    $('body').on('click', '#toggleNewConfirmPassword', function() {
        var x = document.getElementById("edit_conform_password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
        $(this).toggleClass('fa-eye fa-eye-slash');
    });

    $('#user_edit_modal').on('shown.bs.modal', function (e) {
        var userId = $('#user_id').val();

        $.ajax({
            url: '{{url("users/edit")}}/'+userId,
            type: 'GET',
            dataType: 'json',
            success: function(data){
                console.log(data);
                $('#edit_name').val(data.name);
                $('#edit_email').val(data.email);
                $('#edit_user_role_id').val(JSON.parse(data.role_id)).change();
                // $('#edit_user_group_id').val(data.user_group_id).change();
                $('#edit_old_profile_pic').val(data.profile_pic);

                if (data.profile_pic) {
                    $('#edit_image_preview').attr('src', data.profile_pic);
                } else {
                    $('#edit_image_preview').attr('src', '{{asset("assets")}}/img/organization/default.png');
                }
            }
        });
    })

    $(".delete").on("click", function(){
        var userId = $('#user_id').val();
        Swal.fire({
            title: "Confirm Delete?",
            text: "Do You Want to Delete This User?",
            type: "warning",
            buttons: true,
            dangerMode: true,
            showCancelButton: true,
            confirmButtonColor: '#2dce89',
            closeOnConfirm: false,
            closeOnCancel: true

        }).then(function(isConfirm) {
            if (isConfirm.value == true) {
                window.location.replace("../../users/delete/"+userId);
            }
        });
    });

    function updateFile() {
        var image_preview = document.getElementById("edit_image_preview");
        var file = document.querySelector("input[type=file]").files[0];

        var reader = new FileReader();
        reader.onloadend = function () {
            image_preview.src = reader.result;
            document.getElementById("base64").value = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            image_preview.src = "";

        }
    }

</script>
