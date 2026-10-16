{{-- {{ dd($projects) }} --}}

@extends('layouts.app', ['activePage' => 'new_projects', 'titlePage' => __('New Projects')])

@section('content')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
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
    .select2.select2-container {
        width: 100% !important;
    }
    .table.invoice_details.arange th{
        width: 40%;
    }
    @media (min-width: 992px){
        .modal-lg {
            max-width: 900px !important;
        }
    }
    .select2-container .select2-selection--single .select2-selection__rendered {
        white-space: break-spaces;
    }
    .select2-container .select2-selection--single {
        overflow: hidden;
    }
    .product_table_body td:nth-child(3) {
        width: 20%;
    }

    #item_attribute+.select2 {
        width: 100% !important;
    }
    #item_attribute+a {
        display: flex;
    }

    #item_attribute{
        height: 110px !important;
    }

    #item_attribute + .select2.select2-container{
        min-height: 100px !important;
    }

    .item-table-inputs{
        width: auto !important;
    }
    .second-nav-place {
        background-color: #212529;
        width: 100%;
        height: 50px;
        margin-top: 10px;
        position: relative;
        top: -35px;
    }
    .back-btn-f0nt-place {
        position: relative;
        top: 3px;
        right: 11px;
    }
    .back-btn-icon-place {
        position: relative;
        top: 9px;
        right: -11px;
    }
    .back-btn {
        padding: 0%;
    }
    .back-btn-font {
        font-family: Helvetica, sans-serif;
        color: white;
        font-size: 58%;
        line-height: 14px;
    }
    .back-btn-bg {
        background-color: #787878;
        width: 100%;
        height: 35px;
        position: relative;
        right: -2px;
        border-radius: 4px;
        border: 1px solid;
        border-color: red;
    }
    .btn-place {
        position: relative;
        top: 14px;
    }
    .nav-btn-spec {
        height: 36px;
        width: 33%;
        position: relative;
        left: 2px;
        border-color: transparent;
        padding: 0;
        padding-top: 7px;
        color: black;
        font-size: 13px;
    }
    .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
        color: black;
        border-bottom: 4px solid black;
        border-color: none;
        background-color: white;
    }
    .btn-border {
        border-bottom: transparent;
    }
    .content-position {
        position: relative;
        top: -25px;
    }
    .manage-btns {
        position: relative;
        left: 38px;
    }
    /* .nav-item:hover {
        color: #ffffff
    } */
    @media screen and (min-width: 600px) and (max-width: 800px) {
        .div_flexdir{
            flex-wrap: wrap;
            flex-direction: column;
        }
        .div_none{
            max-width: none;
        }
        .div_btn_size{
            width:200%;
        }
        .div_nav_top{
            top:-13%;
        }
    }
    @media only screen and (min-device-width : 768px) and (max-device-width : 1024px){
        .div_format{
            max-width: 60%;
            flex:unset;
        }
    }
    @media only screen and (min-device-width: 834px) and (orientation: portrait) {
        .header1{
            display: inline !important;
        }
        .headder_size{
            font-size:15px;
        }
        .div_format{
            max-width: none;
            flex:unset;
        }
    }
    .card-position {
        width: 109%;
        position: relative;
        left: -6%;
    }
    .card-new{
    background-color: #fff;
    padding: 1rem;
    }
    .header-style{
        color: black;
        font-size: 1.2rem;
        font-weight: 600;
    }
    .form-label{
        margin-top: 0.5rem;
        color: black;
        font-size: 0.8rem;
        font-weight: 500;
        margin-bottom: .1rem;
    }
    .sub-header-style{
        color: black;
        font-size: 1rem;
        margin-top: 1rem;
        font-weight: 600;
    }
    .form-control {
        border-radius: 0rem;
    }
    .sub-product-style .pr{
        padding-right: .5rem;
    }
    .sub-product-style .pl{
        padding-left: .5rem;
    }
    .select2-selection__rendered{
        border: 1px solid #DEDEDE;
        border-radius: 0rem;
        color: #717070;
        padding-left: 7px;
        font-size: 0.8rem;
    }
    .select2 .selection .select2-selection--multiple{
        border: 1px solid #DEDEDE !important;
        border-radius: 0rem !important;
        color: #717070 !important;
        min-height: calc(1.5rem + 1px);
    }
    .select2-selection--multiple .select2-selection__rendered{
        border: none !important;
    }
    .fix-nav {
        margin-bottom: 1.5rem !important;
    }
    .subProductTable{
        width: 100%;
    }
    .subProductTable thead tr{
        background-color: grey;
        color: white;
        font-size: .7rem;
        height: 2.5rem;
    }
    .subProductTable tbody tr{
        height: 2.2rem;
        color: grey;
        border-bottom: 1px solid #e5e5e5
    }
    .subProductTable th, .subProductTable td{
        padding-left: 1rem;
        padding-right: 1rem;
        font-size: 12px;
    }
    .ql-toolbar{
        background-color: #fbfbfb;
    }
    .upload-area {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 95px;
        border: 2px dashed #ccc;
        text-align: center;
        padding: 10px;
        cursor: pointer;
    }

    .upload-area:hover {
        border-color: #007bff;
        cursor: pointer;
    }
    .navbarStylePaste.nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
        border-color: none;
    }
    .navbarStylePaste.nav-tabs{
        border-bottom: white;
    }
    .navbarStylePaste .nav-link{
        color: grey !important;
        background-color: white !important;
        border: none;
        border-bottom: 3px solid #dee2e6 !important;
    }
    .navbarStylePaste .nav-tabs .active, .navbarStylePaste .nav-link:hover{
        color: black !important;
        background-color: white !important;
        border: none;
        border-bottom: 3px solid black !important;
    }
    .close-button{
        position: absolute;
        top: 24%;
        right: 1%;
        background: none;
        border: none;
        outline: unset;
        cursor: pointer;
        color: #b3b3b3;
    }
    .functionalities_front_image, .functionalities_side_image, .functionalities_back_image, .functionalities_3d_images, .functionalities_lifestyle_images{
        background-color: transparent;
        color: #00af77;
        font-weight: 800;
        border: none;
        border-radius: .5rem;
        cursor: pointer;
    }
    .uploadStyles, .downloadStyles{
        border: none;
        background-color: transparent;
        outline: unset;
        cursor: pointer;
    }
    .uploadStyles{
        color: #00af77;
    }
    .downloadStyles{
        color:#44b4b4;
    }
    .uploadStyles:disabled, .downloadStyles:disabled {
        color: #dedede;
        border: none;
        background-color: transparent;
        outline: unset;
        cursor: not-allowed;
    }
    .fitsSizesRadioLayouts {
    display: none;
    }

    /* Style the custom square icons for radio buttons */
    .fitsSizesRadioLayouts + label::before {
    content: "\25A0"; /* Unicode character for a solid square */
    font-size: 16px; /* Adjust the icon size as needed */
    padding-right: 5px; /* Add spacing between the icon and label text */
    }

    /* Style the labels for radio buttons */
    .fitsSizesRadioLayouts + label {
    cursor: pointer;
    font-size: 0.9rem; /* Adjust the font size as needed */
    color: grey; /* Default text color */
    }

    /* Style the checked radio button */
    .fitsSizesRadioLayouts:checked + label::before {
    color: black; /* Color when checked */
    }
    .checkboxLable::after{
        display: none;
    }
    .fitsSizesRadioLayouts + label::before {
        content: "\25A0";
        font-size: 16px;
        padding-right: 0px;
        content: "\2014";
        display: inline-block;
        transform: scaleY(4);
        padding-bottom: .18rem;
    }
    .form-input, .select2 .form-input {
        width: 100%;
    }
    .custom_btn{
        border-radius: 0rem;
        padding: .4rem 1rem;
        font-size: .8rem;
    }

</style>

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif


@section('back-btn')
<a href="{{route('projects')}}" class="home-btn-color">BACK TO PROJECTS</a>
@endsection

<div class="d-flex mt-3">
    <div class="col-md-6 d-flex">
        <div class="project-color p-2" style="width: 50px; height: 50px;">
            <span style="background-color: #e79494; border-radius: 20px; width:100%; height: 100%;"></span>
        </div>
        <div class="project-id-no"><span style="font-size: 28px; font-family: fantasy;">Project # {{ $project->project_no }}</span></div>
        <div class="d-flex project-status" style="width: 40%;">
            <label class="px-2 pt-1" for="project_status" style="width: 60%; text-align: end;">Project Status</label>
            <select class="form-control" name="project_status_id" id="project_status_id" style="width: 5.3rem; height: 1.7rem;">
                <option value="">Select a Status</option>
                    @foreach ($projectStatus as $projectStat)
                        <option value="{{ $projectStat->id }}" {{ $projectStat->id == $project->project_status_id ? 'selected' : '' }}>
                            {{ $projectStat->status_name }}
                        </option>
                    @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6 d-flex justify-content-end">
        <div class="project-assignees">
            <a href="#" class="d-flex" data-toggle="modal" data-target="#edit_assignee_modal" id="display_assignees">
                <div style="display: table; height: 3rem; padding-right: 25px;">
                    <div style="display: table-cell; vertical-align: middle; text-align: center; color: rgb(78, 78, 78); font-size: 14px;"><i>No Assignee</i></div>
                </div>
            </a>
        </div>
        <div class="add-project-assignees pl-3">
            <button class="btn btn-secondary" data-toggle="modal" data-target="#add_assignee_modal"><i class="fa fa-user-plus"></i> ADD ASSIGNEE</button>
        </div>
    </div>
</div>

<div class="second-nav-place-pre" style="width: 100%; height: 50px;">
    <div class="col-md-12 ">
        <div class="row">
            <div class="row col-md-7 btn-place manage-btns div_format " id="nav-tab">
                {{-- <div class="col-md-2 back-btn-bg">
                    <span>
                        <a class="back-btn-font" href="{{route('projects')}}" title="Projects">
                            <div class="row">
                                <div class="col-md-6 back-btn back-btn-icon-place">
                                    <i class="fas fa-arrow-left mt-1"></i>
                                </div>
                                <div class="col-md-6 back-btn back-btn-f0nt-place">
                                    BACK TO PROJECTS
                                </div>
                            </div>
                        </a>
                    </span>
                </div> --}}

                <div class="col-md-12 ">
                    <section id="tabs">
                        <nav>
                            <div class="nav nav-tabs nav-fill btn-border div_btn_size" id="nav-tab" role="tablist">

                                <a class=" nav-btn-spec nav-item nav-link no-width" id="order-mangement-tab" data-toggle="tab" href="#project_mangement_tab" role="tab" aria-controls="project_mangement" aria-selected="true">PROJECT MANAGEMENT</a>

                                <a class="nav-btn-spec nav-item nav-link active" id="invoice-tab" data-toggle="tab" href="#project_tab" role="tab" aria-controls="project" aria-selected="true">PROJECT DETAILS</a>

                            </div>
                        </nav>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
        {{-- @foreach ($projects as $project) --}}
            <span>Project # {{ $project->project_no }}</span>
        {{-- @endforeach --}}
    @endsection

    <div class="col-md-12 mt-4">
        {{-- <div class="card"> --}}
            {{-- <div class="card-header">
                <div class="card-header-danger col-md-12">
                    @foreach ($projects as $project)
                        <h1 class="float-left header-title">Project # {{ $project->project_no }} - {{ $project->project_name }}</h1>
                    @endforeach
                    <div class="float-right header-icons">
                        <span>
                            <a class="btn btn-round" href="{{route('projects')}}" title="Add New Projects">
                                <i class="fas fa-arrow-left mt-1"></i>
                            </a>
                            <p>Back to Projects</p>
                        </span>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="card-body"> --}}

                <section id="tabs">
                    <div class=" col-md-12">
                        {{-- <div class="row mt-10"> --}}
                            {{-- <div class="col-md-12 "> --}}
                                {{-- <nav>
                                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">

                                            <a class="nav-item nav-link active" id="order-mangement-tab" data-toggle="tab" href="#project_mangement_tab" role="tab" aria-controls="project_mangement" aria-selected="true">Project Mangement</a>

                                            <a class="nav-item nav-link" id="invoice-tab" data-toggle="tab" href="#project_tab" role="tab" aria-controls="project" aria-selected="true">Project</a>

                                    </div>
                                </nav> --}}

                                <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                    {{-- Project Mangement Tab --}}
                                        <div class="tab-pane fade" id="project_mangement_tab" role="tabpanel" aria-labelledby="invoice-tab">
                                            @include('pages.project.project_details.inner_pages.project_management')
                                        </div>

                                    {{-- Project Detail Tab --}}
                                        <div class="tab-pane fade show active" id="project_tab" role="tabpanel" aria-labelledby="invoice-tab">
                                            @if ($project->project_type_id == 2)
                                                @include('pages.project.project_details.inner_pages.product_detail')
                                            @else
                                                @include('pages.project.project_details.inner_pages.project_detail')
                                            @endif
                                        </div>
                                </div>
                            {{-- </div> --}}
                        {{-- </div> --}}
                    </div>
                </section>
            {{-- </div> --}}

        {{-- </div> --}}
    </div>
</div>

<input type="hidden" id="from_project_create_page" value="1"/>
<input type="hidden" id="organization_id_from_contact" value="{{app('request')->input('organization_id')}}"/>

{{-- Comment by Sanjeewa --}}
@include('pages.project.partials.add_assignee')
@include('pages.project.partials.edit_assignee')
{{-- @include('pages.contacts.modals.people_create_modal') --}}
{{-- @include('pages.contacts.modals.organization_create_modal') --}}

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $('#image_view_modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var imgSrc = button.data('img-src');
        var modal = $(this);
        modal.find('#image_to_display').attr('src', imgSrc);
    });
</script>


<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>

    function selectAssignee(type) {
        var dropdown = document.getElementById("assignee");
        var textArea = document.getElementById("project_assignee");
        var textArea1 = document.getElementById("project_assignee_id");
        var selectedOption = dropdown.options[dropdown.selectedIndex].text;
        var selectedOption1 = dropdown.options[dropdown.selectedIndex].value;
        textArea.value += selectedOption + "\n";
        textArea1.value += selectedOption1 + "\n";

        if (type == 'group') {
            var groups = $('#project_assignee_groups').val();
            if(groups != ''){
                groups = JSON.parse(groups);
                groups.push(selectedOption1);
                $('#project_assignee_groups').val(JSON.stringify(groups));
            } else {
                var newArr = [];
                newArr.push(selectedOption1);
                $('#project_assignee_groups').val(JSON.stringify(newArr));
            }
        } else if(type == 'user') {
            var users = $('#project_assignee_users').val();
            if(users != ''){
                users = JSON.parse(users);
                users.push(selectedOption1);
                $('#project_assignee_users').val(JSON.stringify(users));
            } else {
                var newArr2 = [];
                newArr2.push(selectedOption1);
                $('#project_assignee_users').val(JSON.stringify(newArr2));
            }
        }
    }

    let mainProductId = '{{ $project->id }}';

    $(document).ready(function(){
        displayAssignees();

        $('.select2-new-project').select2();

        $('.color-picker').change(function(){
            $(this).parent().css('background-color', $(this).val());
        });

        $("#new_main_category_id").select2();
        $("#new_gender").select2();
        $("#new_size_id").select2();
        $("#new_product_category_id").select2();
        $("#new_sport").select2();
        $("#new_product_attribute_id").select2();
        $("#new_product_factory_id").select2();

        $(".se-pre-con").fadeOut('slow');

        $('#project_status_id').change(function() {
            var statusId = $(this).val();
            changeProjectStatus(mainProductId, statusId);
        });

        function changeProjectStatus(mainProductId, statusId){
            $.ajax({
                url:"{{ url('projects/change_status') }}/"+mainProductId+"/"+statusId,
                method:"GET",
                dataType:"json",
                beforeSend:function(){
                    $(".se-pre-con").fadeIn();
                },
                success:function(data){
                    $(".se-pre-con").fadeOut();
                    if(data == 'success'){
                        Swal.fire({
                            title: "Done!",
                            text: "Project Status Changed  Successfully!",
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: data.errorInfo[2],
                            type: "error",
                        });
                    }
                }
            });
        }
    });

    function displayAssignees()
    {
        $.ajax({
                url:'{{ url("projects/get_assignees") }}/'+mainProductId,
                method:'GET',
                dataType:'json',
                // beforeSend: function(){ $(".se-pre-con").fadeIn(); },
                success: function(data)
                {
                    $("#display_assignees").html('');
                    var allAssignes = data[0];
                    if(allAssignes.length > 0){
                        var extraAssignee = 0;
                        for (var i = 0; i < allAssignes.length; i++) {
                            if(i<4){
                                $("#display_assignees").append('<img src="{{ asset('') }}/'+allAssignes[i].image+'" alt="" style="width: 43px; height: 43px; border-radius: 50%; margin-left: -13px; border: 2px solid white;">');
                            } else {
                                extraAssignee++;
                            }
                        }

                        if(extraAssignee > 0){
                            var extraAssigneeDisply = '<div style="width: 50px; height: 50px; border-radius: 50%; background-color:aliceblue; font-weight:bold; display: table; margin-left: -13px;">'+
                                                        '<div style="display: table-cell; vertical-align: middle; text-align: center; color: black; font-size: 20px;">'+extraAssignee+'+</div>'+
                                                '</div>';
                            $("#display_assignees").append(extraAssigneeDisply);
                        }
                    } else {
                        $("#display_assignees").append('<div style="display: table; height: 3rem; padding-right: 25px;">'+
                            '<div style="display: table-cell; vertical-align: middle; text-align: center; color: rgb(78, 78, 78); font-size: 14px;"><i>No Assignee</i></div>'+
                        '</div>');
                    }

                    assigneeCount(data[1], data[2]);
                },
            });
    }

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
            document.getElementById('new_description').value = htmlContent;
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

    function imageDisplay(fileInput , displayArea){
        const imagePreview = document.getElementById(displayArea + '_uploaded');
        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.src = e.target.result;
            };

            reader.readAsDataURL(fileInput.files[0]);

            $('#'+displayArea+'_upload_area').hide();
            $('#'+displayArea+'_display_area').show();
            $('.functionalities_'+displayArea).show();
        }
    }
    function removeImagePreview(img){
        $('#'+img+'_display_area').hide();
        $('.functionalities_'+img).hide();
        $('#'+img+'_upload_area').show();
    }

    function previewImg(imageToDisplay){

        const imagePreview = document.getElementById(imageToDisplay+'_uploaded');
        const imagePreviewArea = document.getElementById('imagePreviewArea');

        const src = imagePreview.getAttribute('src');

        imagePreviewArea.setAttribute('src', src);
    }

    document.addEventListener("change", function (event) {
        if (event.target && event.target.type === "file") {

            var existence = $('#existence');
            console.log('clicked');
        }
    });

    function uploadMultipleImages(imageID, ID){

        $('#uploaded_'+imageID+'_table').show();

        var fileID = document.getElementById(imageID);
        var files = fileID.files;
        var constantVal = 0;

        if(ID == null){

            for (var i = 0; i < files.length; i++) {

                var newRowHTML = `
                    <tr>
                        <td>${files[i].name}</td>
                        <td class="text-center">
                            <button class="uploadStyles" data-toggle="modal" data-target="#image_view_modal" id="imagePreview${i}" data-img-src="" type="button" title="View">
                                <i class="fa fa-eye" style="color: grey;"></i>
                            </button>
                            <button onclick="uploadMultipleImages('${imageID}', '${i}')" class="uploadStyles" type="button" title="Upload">
                                <i class="fa fa-cloud-upload" id="${imageID}_upload_${i}"></i><i class="fas fa-spinner fa-spin" id="${imageID}_loading_${i}" style="display: none"></i>
                            </button>
                        </td>
                    </tr>
                `;

                document.getElementById(imageID+"_tbody").innerHTML += newRowHTML;
                constantVal = i;
            }
        }else{


            if(imageID == 'lifestyle_images'){

                uploadImagesMultiple(files[ID], 'Life_Style_Image' , 'lifeStyle Images File' , 'image_link' , ID, 'lifestyle_images');

            }else{

                uploadImagesMultiple(files[ID], '3D_Image' , '3D Images File' , 'image_link' , ID, '3D_images');

            }
        }
        for (var i = constantVal; i > -1; i--) {
            var file = files[i];

            console.log(file);

            var reader = new FileReader();

            reader.onload = (function (fileIndex) {
                return function (e) {
                    var imageContainer = document.getElementById('imagePreview' + fileIndex);
                    imageContainer.setAttribute('data-img-src', e.target.result);
                };
            })(i);

            reader.readAsDataURL(file);
        }


    }

    function uploadImages(uploaded_image_id, folder_name, fileCategory, db_coloumn_name) {

        var fileCat =fileCategory;
        var folder =folder_name;
        var dbField =db_coloumn_name;
        var productNo =$('#new_product_no').val();
        var product_id =$('#product_id').val();

        var formData = new FormData();
        formData.append('file_category', fileCat);
        formData.append('folder', folder);
        formData.append('product_no', productNo);

        if(folder_name == 'Life_Style_Image' || folder_name == '3D_Image'){
            var files = uploaded_image_id;

            formData.append('image_uploaded', files);
            formData.append('product_id', product_id);
            formData.append('db_image_field', dbField);
            formData.append('_token', '{{ csrf_token() }}');


        }else{
            var files = $('#'+uploaded_image_id)[0].files[0];

            formData.append('image_uploaded',files);
            formData.append('db_field',dbField);
            formData.append('_token','{{ csrf_token() }}');
        }


        $.ajax({
            url:"{{ route('products.upload_image') }}",
            method:'POST',
            dataType:'json',
            data:formData,
            contentType: false,
            processData: false,
            beforeSend:function(){
                $('#'+uploaded_image_id+'_upload').hide();
                $('#'+uploaded_image_id+'_loading').show();
                },
            success:function(data){

                $('#'+uploaded_image_id+'_upload').show();
                $('#'+uploaded_image_id+'_loading').hide();

                Swal.fire({
                    type: data.responce,
                    title: data.meessage,
                });

            },
        });

    }
    function uploadImagesMultiple(uploaded_image_id, folder_name, fileCategory, db_coloumn_name, num , idName) {

        var fileCat =fileCategory;
        var folder =folder_name;
        var dbField =db_coloumn_name;
        var productNo =$('#new_product_no').val();
        var product_id =$('#product_id').val();

        var formData = new FormData();
        formData.append('file_category', fileCat);
        formData.append('folder', folder);
        formData.append('product_no', productNo);

        var files = uploaded_image_id;

        formData.append('image_uploaded', files);
        formData.append('product_id', product_id);
        formData.append('db_image_field', dbField);
        formData.append('_token', '{{ csrf_token() }}');


        $.ajax({
            url:"{{ route('products.upload_image') }}",
            method:'POST',
            dataType:'json',
            data:formData,
            contentType: false,
            processData: false,
            beforeSend:function(){
                $('#'+idName+'_upload_'+num).hide();
                $('#'+idName+'_loading_'+num).show();
                },
            success:function(data){

                $('#'+idName+'_upload_'+num).show();
                $('#'+idName+'_loading_'+num).hide();

                Swal.fire({
                    type: data.responce,
                    title: data.meessage,
                });

            },
        });

        }

    function removeImg(imgID){
        Swal.fire({
            title: 'Are you sure to delete?',
            text: 'This action delete your image.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {

            if (result.value) {
            $.ajax({
                url:"{{ route('products.removeImages') }}",
                method:'POST',
                dataType:'json',
                data:{
                    '_token': '{{ csrf_token() }}',
                    imgID: imgID },
                beforeSend:function(){
                    $('.se-pre-con').fadeIn();
                },
                success:function(data){

                    $('.se-pre-con').fadeOut();

                    Swal.fire({
                        type: data.responce,
                        title: data.meessage,
                    });
                    location.reload();
                },
            });

            } else {
                Swal.close();
            }
        });




    }

    function buttonEnableFunc(buttonID){
        $("#"+buttonID+"_uploading").prop("disabled", false);
    }
</script>
