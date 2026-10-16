<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link rel="stylesheet" type="text/css"
href="{{ asset('email-assets') }}/app-assets/vendors/css/forms/select/select2.min.css">
<style>
    .compose-main-section{
        width: 50%;
        background-color: rgb(255, 255, 255);
        position: fixed;
        bottom: 0;
        right: 0;
        z-index: 10000;
        margin: 70px 20px;
        min-height: 550px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        border: solid 0.1px rgb(135, 135, 135);
        padding: 10px;
        display: none;
    }
    .compose-header{
        background-color: rgb(255, 255, 255);
        padding: 5px;
        display: inline-flex;
        width: 100%;
        flex-wrap: nowrap;
        justify-content: space-between;
        border-bottom: solid 0.1px rgb(224, 224, 224);

    }
    .compose-close{
        border: none;
        background-color: transparent;
    }
    .compose-body{
        display: flex;
        flex-direction: column;
    }
    .compose-input-feld{
        width: 100%;
        margin-top: 10px;

    }
    .copmose-input{
        width: 70%;
        margin-left: 10px;
        border: none;
    }
    .copmose-input:focus-visible{
        border: none;
    }
    .compose-item-text{
        width: 8%;
    }
    .compose-body{
        border-bottom: solid 0.1px rgb(224, 224, 224);
    }
    .ck-content{
        min-height: 150px;
        max-height: 150px;


    }
    .input-file-show{
        overflow-y: scroll;
        max-height: 77px;

    }

    .select2-selection__choice {
        color: #121212 !important;
        height: 1.5rem !important;
        border-radius: 25px !important;
        background-color: #f9f9f9 !important;
        border-color: #b8b8b8 !important;
    }
    .avatar-compose {
        font-size: .875rem;
        width: 22px !important;
        height: 22px !important;
    }
    .select2-container--classic .select2-selection--multiple .select2-selection__choice, .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #e1e1e1 !important;
        border-color: #e1e1e1 !important;
        color: #fff;
        padding: 2px 5px;
    }
    .avatar-sm {
        font-size: .875rem;
        width: 18px !important;
        height: 18px !important;
    }
    .select2-selection__rendered{
        overflow-x: scroll;
    }
    ..select2-container .select2-selection--multiple .select2-selection__rendered {
        display: -webkit-inline-box !important;
    }
    .ql-editor{
        min-height: 150px;
        max-height: 150px;
    }


</style>
<div class="compose-main-section">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <div class="email-content">
    <form name="frmCompose" id="composeForm" enctype="multipart/form-data" method="post">
    {{ csrf_field() }}
    <input type="text" value="" name = "txtMessgNo" id="txtMessgNo" hidden/>
    <input type="text" value="" name = "txtMailBoxType" id="txtMailBoxType" hidden/>
        <div class="compose-header">
            <h2 class="compose-header-text float-left">Compose email</h2>
            <button class="compose-close float-right" onclick="toggleCompose(event)"><i data-feather="x" class="font-medium-2 float-right mt-1"></i></button>
        </div>
        <div class="compose-body">
            <div class="compose-input-feld"  style="display: inline-flex;">
                <p class="compose-item-text float-left">To</p>
                {{-- <input type="test" class="copmose-input"  name="emialTo[]" multiple id="tomail" > --}}
                <div class="flex-grow-1 copmose-input divBorder" style="    background-color: #d6d6d6;margin-right: 10px;">

                    <select class="select2 form-control w-100" name="emialTo[]" id="email-to"placeholder="enter To address" multiple>

                    </select>
                </div>

                @if(isset($attachmentCount) && $attachmentCount > 0)

                <select id="txtAttachmentPaths" name="txtAttachmentPaths[]" multiple hidden>
                    @foreach ($downloadAttachments as $file)
                        @php
                            $fileCurrentName = 'public/attachment/' . $file['filename'];
                        @endphp
                        <option value="{{ asset($fileCurrentName) }}" data-originalName="{{ $file['OriginalName'] }}" selected>{{ asset($fileCurrentName) }}</option>
                    @endforeach
                </select>

            @endif
            <!--<div class="flex-grow-1">
                <select name="attahcemnts[]" class="select2 form-control w-100" id="attahcemnts" multiple>

                </select>
            </div>-->
            <div>
                <a class="toggle-cc text-body mr-1" href="javascript:void(0);">Cc</a>
                <a class="toggle-bcc text-body" href="javascript:void(0);">Bcc</a>
            </div>
            </div>
            <div class="compose-input-feld"  style="display: inline-flex;">
                <p class="compose-item-text float-left">cc :</p>
                <div class="flex-grow-1 copmose-input divBorder" style="    background-color: #d6d6d6;margin-right: 38px;">

                    <select class="select2 form-control w-100" name="emailCC[]" id="emailCC" multiple>

                    </select>
                </div>
                <a class="text-body toggle-bcc" href="javascript:void(0);"><i data-feather="x"></i></a>
            </div>
            <div class="compose-input-feld " style="display: inline-flex;">
                <p class="compose-item-text float-left">Bcc :</p>
                {{-- <input type="email" class="copmose-input"  name="emailBCC[]"  multiple> --}}
                <div class="flex-grow-1 copmose-input divBorder" style="    background-color: #d6d6d6;margin-right: 38px;">

                    <select class="select2 form-control w-100" name="emailBCC[]" id="emailBCC" multiple>

                    </select>
                </div>
                <a class="text-body toggle-bcc" href="javascript:void(0);"><i data-feather="x"></i></a>
            </div>
        </div>
        <div class="compose-body">
            <div class="compose-input-feld">
                <p class="compose-item-text float-left">subject</p>
                <input type="text" class="copmose-input mx-3 mt-1"  placeholder="Subject" name="emailSubject" id="emailSubject">
            </div>
        </div>
        <div class="compose-body compose-textarea">
            <div class="compose-input-feld">
                <div id="editor-container" ></div>
                <input type="text" id="copied_message_body" name="copied_message_body" hidden>
            </div>
        </div>
        <div class="compose-body input-file-show">
            <div class="compose-input-feld" style="display:inline" id="showAttachmentArea">
            </div>
        </div>
        <!-- Example split danger button -->
        <div class="btn-group">
            <button type="button" onclick="getEditorContents();" class="btn btn-primary">send</button>
            <button type="button" id="btnSaveDraft" class="btn btn-primary mx-2">save draft</button>
            <input type="file" name="file[]" id="file" class="inputfile float-" onchange="getSelectedFiles(this)"
                data-multiple-caption="{count} files selected" multiple hidden/>

        </div>
    </form>
  </div>
</div>
<script>

    function forwardMessage() {
        document.getElementById('emailSubject').value = '';
        var composeSection = document.querySelector(".compose-main-section");
        composeSection.style.display = "block";
        var forwardSubject = "Fwd: " + document.getElementById("txtMailSubject").value;
        document.getElementById("emailSubject").value = forwardSubject;
        var originalEmailBody = document.getElementById("txtBodyMessage").value;
        originalEmailBody = originalEmailBody.replace(/<br *\/?>/gi, '\n');
        console.log(forwardSubject);
        console.log(originalEmailBody);
        quill.clipboard.dangerouslyPasteHTML(originalEmailBody);
        document.getElementById("showAttachmentArea").innerHTML = "";

    }


</script>

    <script>
        let input = document.getElementById("file");
        let imageName = document.getElementById("imageName")
            var quill = new Quill('#editor-container', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'], // Text styles
                        [{ 'color': [] }], // Font color
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }], // Lists
                        [{ 'size': ['small', false, 'large', 'huge'] }], // Font size
                        [{ 'align': [] }], // Alignment options
                        ['clean'] // Remove formatting
                    ]
                }
            });

            // Handle changes in the Quill editor and update the hidden input
            quill.on('text-change', function() {
                // Manually insert line breaks within the same <p> tag
                var htmlContent = document.querySelector('.ql-editor').innerHTML.replace(/<div>/g, '').replace(/<\/div>/g, '<br>');
                document.getElementById('copied_message_body').value = htmlContent;
            });

        // Clear formatting button functionality
        document.getElementById('clear-formatting').addEventListener('click', function() {
            quill.format('bold', false);
            quill.format('italic', false);
            quill.format('underline', false);
            quill.format('strike', false);
            quill.format('color', false);
            quill.format('size', false);
        });
    </script>
    <script>
        function getSelectedFiles(filesSelected){
            var files = $(filesSelected).prop("files");
            var names = $.map(files, function(val) { return val.name; });
            var attachArea = "";
            $( "#txtAttachmentPaths option:selected").each(function() {
                //alert($(this).val());
                attachArea = attachArea + "<div style='width:100%;font-size: 16px;padding: 8px;' class='alert alert-primary' role='alert'><a href='"+$(this).val()+"' download>"+ $(this).attr('data-originalName') +"</a><button onclick=\"myFunction(this)\" style='font-size: 10px; padding: 5px; float: right;' type='button' data-removeFile='"+ $(this).val() +"' class='btn btn-primary btn-sm'>X</button></div>";
            });

            for(i=0;i<names.length;i++)
            {
                attachArea = attachArea + "<div style='width: 100%;font-size: 16px;padding: 8px;' class='alert alert-primary' role='alert'><a >"+ names[i] +"</a><button onclick=\"myFunctionRemoveInput(this)\" style='font-size: 10px; padding: 5px; float: right;' type='button' class='btn btn-primary btn-sm'>X</button></div>";
            }
            document.getElementById("showAttachmentArea").innerHTML = attachArea;


        }
        function myFunctionRemoveInput(filesInputs){
            $(filesInputs).parent().remove();

        }
        function toggleCompose(event) {
            event.preventDefault();

            var composeSection = document.querySelector(".compose-main-section");
            if (composeSection.style.display === "none" || composeSection.style.display === "") {
                composeSection.style.display = "block";
            } else {
                composeSection.style.display = "none";
            }
            var darfTview = "<?php if (isset($draftMessageNo)) {
                unset($draftMessageNo);
                echo 'UnSet';
            } else {
                echo 'UnSet';
            } ?>";


            $('#email-to').find('option').remove();
            $('#emailCC').find('option').remove();
            $('#emailBCC').find('option').remove();
            $('#txtAttachmentPaths').find('option').remove();

            document.getElementById("emailSubject").value = "";
            document.getElementById("editorTextArea").value = "";
        }


        $(".replyBtn").click(function() {
            var composeSection = document.querySelector(".compose-main-section");
            composeSection.style.display = "block";
            var replySubject = "Re: " + document.getElementById("txtMailSubject").value;
            document.getElementById("emailSubject").value = replySubject;
            var repyMial = document.getElementById("txtMailRepyTo").value;


            var initialContent = document.getElementById("txtMailBodyHead").value;
            quill.setContents(initialContent);
            var message_string = document.getElementById("txtBodyMessage").value;

            message_string = message_string.replace(/<br *\/?>/gi, '\n');
            console.log(document.getElementById("txtBodyMessage").value);
            console.log($('#txtBodyMessage').val());
            console.log($('#txtBodyMessage').html());
            console.log(message_string);

            // document.getElementById("editorTextArea").value = document.getElementById("editorTextArea").value +
            //     "\n" + message_string + "\n\n";

            $('#editorTextArea + .Editor-container .Editor-editor').html($('#txtBodyMessage').val());


            if (!$("#email-to option[value='" + repyMial + "']").length > 0) {
                $("#email-to").append("<option value=" + repyMial + ">" + repyMial + "</option>");
                $("#email-to").val(repyMial);
            } else {

                $("#email-to option[value='" + repyMial + "']").remove();
                $("#email-to").append("<option value=" + repyMial + ">" + repyMial + "</option>");
                $("#email-to").val(repyMial);
            }


        });
        function replyMessage(){
            var composeSection = document.querySelector(".compose-main-section");
            composeSection.style.display = "block";
            var replySubject = "Re: " + document.getElementById("txtMailSubject").value;
            document.getElementById("emailSubject").value = replySubject;
            var repyMial = document.getElementById("txtMailRepyTo").value;



            var message_string = document.getElementById("txtBodyMessage").value;

            message_string = message_string.replace(/<br *\/?>/gi, '\n');
            console.log(document.getElementById("txtBodyMessage").value);
            console.log($('#txtBodyMessage').val());
            console.log($('#txtBodyMessage').html());
            console.log(message_string);

            // document.getElementById("editorTextArea").value = document.getElementById("editorTextArea").value +
            //     "\n" + message_string + "\n\n";

            $('#editorTextArea + .Editor-container .Editor-editor').html($('#txtBodyMessage').val());


            if (!$("#email-to option[value='" + repyMial + "']").length > 0) {
                $("#email-to").append("<option value=" + repyMial + ">" + repyMial + "</option>");
                $("#email-to").val(repyMial);
            } else {

                $("#email-to option[value='" + repyMial + "']").remove();
                $("#email-to").append("<option value=" + repyMial + ">" + repyMial + "</option>");
                $("#email-to").val(repyMial);
            }

        }
        $(document).ready(function() {
            $("#btnSaveDraft").click(function() {
            document.getElementById('composeForm').action = "savedraft";

            document.getElementById("composeForm").submit();
            });
        });

        $(document).ready(function() {
            $(".se-pre-con").fadeOut('slow');
            var composeSection = document.querySelector(".compose-main-section");
            composeSection.style.display = "block";
            var quill = new Quill('#editor-container', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'], // Text styles
                        [{ 'color': [] }], // Font color
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }], // Lists
                        [{ 'size': ['small', false, 'large', 'huge'] }], // Font size
                        [{ 'align': [] }], // Alignment options
                        ['clean'] // Remove formatting
                    ]
                }
            });

            if (localStorage.getItem("sentMail") == "Done") {
                alert("Email Sent ");
                localStorage.setItem("sentMail", "Not Done");
                document.getElementById("formGetEmails").submit();
            } else if (localStorage.getItem("draftMail") == "Done") {
                alert("Draft Saved");
                localStorage.setItem("draftMail", "Not Done");
                document.getElementById("formGetEmails").submit();
            }
            // remove this later
            if (localStorage.getItem("draftShowNot") == "Show") {
                alert("draft set 1");
            }
            //not this
            if (localStorage.getItem("savedDraftShow") == "show") {



                //subject
                var darftSubject = "<?php if (isset($draftEmailSubject)) {
    echo $draftEmailSubject;
} else {
    echo null;
} ?>";
                document.getElementById("emailSubject").value = darftSubject;

                //toaddress
                var draftAllToAddresses = <?php if (isset($draftAllToAddresses)) {
    echo json_encode($draftAllToAddresses);
} else {
    echo 'null';
} ?>;
                if (draftAllToAddresses.length > 0) {
                    for (var toI = 0; toI < draftAllToAddresses.length; toI++) {
                        if (!$("#email-to option[value='" + draftAllToAddresses[toI]['mail'] + "']").length > 0) {
                            $("#email-to").append("<option value=" + draftAllToAddresses[toI]['mail'] + ">" +
                                draftAllToAddresses[toI]['mail'] + "</option>");

                            $("#email-to option[value='" + draftAllToAddresses[toI]['mail'] + "']").prop('selected',
                                true).attr('selected', true);
                        }
                    }
                }

                //ccaddresses
                var draftAllCCAddresses = <?php if (isset($draftAllCCAddresses)) {
    echo json_encode($draftAllCCAddresses);
} else {
    echo 'null';
} ?>;
                if (draftAllCCAddresses.length > 0) {
                    $(".cc-wrapper").css("display", "show");
                    for (var ccI = 0; ccI < draftAllCCAddresses.length; ccI++) {
                        if (!$("#emailCC option[value='" + draftAllCCAddresses[ccI]['mail'] + "']").length > 0) {
                            $("#emailCC").append("<option value=" + draftAllCCAddresses[ccI]['mail'] + ">" +
                                draftAllCCAddresses[ccI]['mail'] + "</option>");
                            $("#emailCC option[value='" + draftAllCCAddresses[ccI]['mail'] + "']").prop('selected',
                                true).attr('selected', true);
                        }
                    }
                }

                //bccaddresses
                var draftAllBCCAddresses = <?php if (isset($draftAllBCCAddresses)) {
    echo json_encode($draftAllBCCAddresses);
} else {
    echo 'null';
} ?>;
                if (draftAllBCCAddresses.length > 0) {
                    $(".bcc-wrapper").css("display", "show");
                    for (var bccI = 0; bccI < draftAllBCCAddresses.length; bccI++) {
                        if (!$("#emailBCC option[value='" + draftAllBCCAddresses[bccI]['mail'] + "']").length > 0) {
                            $("#emailBCC").append("<option value=" + draftAllBCCAddresses[bccI]['mail'] + ">" +
                                draftAllBCCAddresses[bccI]['mail'] + "</option>");
                            $("#emailBCC option[value='" + draftAllBCCAddresses[bccI]['mail'] + "']").prop(
                                'selected',
                                true).attr('selected', true);
                        }
                    }
                }


                //mailBody



                var message_string = document.getElementById("txtBodyMessage").value;
                message_string = message_string.replace(/<br *\/?>/gi, '\n');
                document.getElementById("editor-container").value = message_string;
                console.log(document.getElementById("editor-container").value);
                $('#editor-container + .Editor-container .Editor-editor').html(message_string);

                var attachArea = "";
                $("#txtAttachmentPaths option").each(function() {
                    //alert($(this).val());
                    $(this).prop("selected", true);
                    attachArea = attachArea + "<div style='width: 100%;font-size: 16px;padding: 8px;' class='alert alert-primary' role='alert'><a href='"+$(this).val()+"' download>"+ $(this).attr('data-originalName') +"</a><button onclick=\"myFunction(this)\" style='font-size: 10px; padding: 5px; float: right;' type='button' data-removeFile='"+ $(this).val() +"' class='btn btn-primary btn-sm'>X</button></div>";
                });

                document.getElementById("showAttachmentArea").innerHTML = attachArea;


                // ./public/attachment
                //var downloadAttachments = <?php if (isset($downloadAttachments)) { echo json_encode($downloadAttachments); } else { echo 'null'; } ?>;
               /* if (downloadAttachments.length > 0) {
                    for (var attI = 0; attI < downloadAttachments.length; attI++) {

                        if (!$("#attahcemnts option[value='" + downloadAttachments[attI]['filename'] + "']")
                            .length > 0) {
                            $("#attahcemnts").append("<option value='" + downloadAttachments[attI]['filename'] +
                                "'>" +
                                downloadAttachments[attI]['OriginalName'] + "</option>");
                            $("#attahcemnts option[value='" + downloadAttachments[attI]['filename'] + "']").prop(
                                'selected',
                                true).attr('selected', true);
                        }

                    }
                }*/

                // getAttachmentArea();





                localStorage.setItem("savedDraftShow", "notShow");
            }

            document.querySelector(".compose-main-section").style.display = "block";
        });

        /*function getAttachmentArea()
        {
            //alert("test");
            var inputArea = "";
            $("#attahcemnts option").each(function() {
                //alert($(this).val());
                inputArea = inputArea + "<div style='width: 100%;font-size: 16px;padding: 8px;' class='alert alert-primary' role='alert'><a href='../public/attachment/"+$(this).val()+"' download>"+ $(this).text() +"</a></a><button style='font-size: 10px; padding: 5px; float: right;' type='button' class='btn btn-primary btn-sm'>X</button></div>";
            });

            document.getElementById("attahArea").innerHTML = inputArea;
        }
*/



    </script>



