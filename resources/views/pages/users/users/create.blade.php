<style>
    #new_image_container {
        width: 100px;
        height: 100px;
        margin-left: 15px;
        margin-top: -30px;
        border-radius: 50%;
        overflow: hidden;
    }
    #new_image_preview {
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

<div class="modal fade" id="user_create_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Add New Users</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('users.create') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row flex_set">
                            <div class="col-md-6 form-field max_width01">
                                <label class="form-lable">Name <span class="text-danger">*</span></label>
                                <input type="text" class="required form-control form-input" id="new_name" name="new_name" required />
                            </div>

                            <div class="col-md-6 form-field max_width01">
                                <label class="form-lable">Email <span class="text-danger">*</span></label>
                                <input type="email" class="required form-control form-input" id="new_email" name="new_email" required />
                            </div>

                            <div class="col-md-6 form-field max_width01">
                                <label class="form-lable">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="required form-control" id="new_password" name="new_password" required />
                                    <span class="input-group-text" >
                                    <i class="fas fa-eye-slash" id="toggleNewPassword"></i>
                                </span>
                                </div>
                            </div>

                            <div class="col-md-6 form-field max_width01">
                                <label class="form-lable">Confirm Password <span class="text-danger">*</span></label>
                               <div class="input-group">
                                   <input type="password" class="required form-control" id="new_conform_password" name="new_confirm_password" required />
                                   <span class="input-group-text" >
                                    <i class="fas fa-eye-slash" id="toggleNewConfirmPassword"></i>
                                </span>
                               </div>

                            </div>
                            <div class="col-6"></div>
                            <div id="conform_password_message" class="text-danger col-6" style="display: none;">
                                <span>password conform not matched...!</span>
                            </div>
                            <div class="col-md-12 form-field max_width01">
                                <label for="new_user_role_id" class="d-inline-flex">User Group <span class="text-danger d-inline-flex">*</span></label>&nbsp;
                                <select type="text" class=" form-control form-input rounded-1" id="new_user_role_id" name="new_user_role_id[]" multiple="multiple" required>
                                    @foreach ($userRoles as $userRole)
                                        <option value="{{$userRole->id}}">{{$userRole->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- <div class="col-md-6 form-field">
                                <label class="form-lable">User Group <span class="text-danger">*</span></label>
                                <select type="text" class="form-control form-input" id="new_user_group_id" name="new_user_group_id" required>
                                    @foreach ($userGroups as $userGroup)
                                        <option value="{{$userGroup->id}}">{{$userGroup->user_group_name}}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            <div class="col-md-6 form-field mt-3 max_width01">
                                <label class="form-lable">Profile Picture</label>
                                <input type="file" class="form-control form-input" id="new_profile_pic" name="new_profile_pic" onchange="uploadFile()" style="overflow: hidden;" />
                            </div>

                            <div class="col-md-6 form-field mt-5">
                                <div id="new_image_container">
                                    <img src="{{ asset('argon') }}/img/icons/placeholder.png" id="new_image_preview" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 control-btns">
                        <button class="btn btn-secondary btn-custom"  type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        <button type="submit" class="btn btn-success btn-custom" id="save">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        // checkRequired();
        // $(".required").keyup(checkRequired);
        // $(".required").onchange(checkRequired);
        // // $('body').on('change', '.required', function() {
        // //     checkRequired();
        // // });
        //     function checkRequired(){
        //     var fields = document.getElementsByClassName('required');
        //     var password = $("#new_password").val();
        //     var confirmPassword = $("#new_conform_password").val();
        //     var matched = false;
        //         if (password != confirmPassword) {
        //             matched = false;
        //         }else {
        //             matched = true;
        //         }
        //     for (var i = 0; i < fields.length; i++){
        //         if(fields[i].value.length > 0){
        //             if(matched){
        //                 document.getElementById('save').disabled = false;
        //
        //             }else{
        //                 document.getElementById('save').disabled = true;
        //             }
        //         }else{
        //             // alert('enabled');
        //             document.getElementById('save').disabled = true;
        //         }
        //     }
        // }
        checkPasswordMatch();
        $("#new_password").keyup(checkPasswordMatch);
        $("#new_conform_password").keyup(checkPasswordMatch);

        function checkPasswordMatch() {
                var password = $("#new_password").val();
                var confirmPassword = $("#new_conform_password").val();
                var passwordField = document.getElementById('new_password');
                var confirmPasswordField = document.getElementById('new_conform_password');

                if(passwordField.value !== ''){
                    confirmPasswordField.setAttribute('required', 'true');
                }else{
                    confirmPasswordField.removeAttribute('required');
                }
                if (password != confirmPassword) {
                    $("#edit_conform_password").addClass("is-invalid");
                    document.getElementById('conform_password_message').style.display = 'block';
                    // checkRequired();
                    document.getElementById('save').disabled = true;
                }else {
                    $("#edit_conform_password").removeClass("is-invalid");
                    document.getElementById('conform_password_message').style.display = 'none';
                    // checkRequired();
                    document.getElementById('save').disabled = false;
                }
            }



    });


    $('body').on('click', '#toggleNewPassword', function() {
        var x = document.getElementById("new_password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
        $(this).toggleClass('fa-eye fa-eye-slash');
    });
    $('body').on('click', '#toggleNewConfirmPassword', function() {
        var x = document.getElementById("new_conform_password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
        $(this).toggleClass('fa-eye fa-eye-slash');
    });
    function uploadFile() {
        var image_preview = document.getElementById("new_image_preview");
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
