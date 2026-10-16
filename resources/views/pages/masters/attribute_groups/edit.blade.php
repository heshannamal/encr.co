@extends('layouts.app', ['activePage' => 'attribute_groups', 'titlePage' => __('Attribute Groups')])

@section('content')
<style>
    .form-field {
        display: flex;
        margin-bottom: 1rem;
        flex-direction: row;
        flex-wrap: nowrap;
        align-items: center;
    }
    .form-lable {
        width: 33%;
    }
    .form-input {
        width: 100%;
    }
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
    }
    div.alphabet {
        display: table;
        width: 100%;
        margin-bottom: 1em;
    }
    div.alphabet span {
        display: table-cell;
        color: #b3b3b3;
        cursor: pointer;
        text-align: center;
        width: 3.5%;
        border: 1px solid #e8e8e8;
    }
    div.alphabet span:hover {
        box-shadow: 2px 2px 5px #e8e8e8;
    }
    div.alphabet span.active {
        color: black;
    }
    .add-btn-position {
        width: 93px;
        position: relative;
        right: -25px;
    }
    .btn-text-position {
        position: relative;
        right: -6%;
        font-size: 15px;
    }
    .content-position {
        position: relative;
        top: -47px;
    }
    .add-btn-text {
        position: relative;
        right: -13px;
    }
    .btns-text {
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
    }
    .btns-text:hover {
        color: #909090 ;
    }
    .btns-style {
        width: 100%;
        height: 100%;
        background-color: #909090;
        border: unset;
        border-radius: 5px;
    }
    .btns-card:hover {
        background-color: #ffffff
    }
    .btns-padding {
        padding-left: 0.2rem;
        padding-right: 0.2rem;
    }
    .btns-right-position {
        position: relative;
        right: 14px;
    }
    .btn-top {
        position: relative;
        top: 11px;
    }
    @media only screen and (min-device-width : 768px) and (max-device-width : 1024px) {
   .btn_set{
    max-width: none;
    flex:none;
    right:0px;

   }
   .div_display{
    display:none;
   }
   .div_align{
    justify-content: center;
   }
   .search_orga{
    width:200% !important;
   }
   .pagina001{
        flex-wrap: wrap;
     }
  }
  .new-style-table table.dataTable thead .sorting:before,table.dataTable thead .sorting_asc:before,table.dataTable thead .sorting_desc:before,table.dataTable thead .sorting_asc_disabled:before,table.dataTable thead .sorting_desc_disabled:before {
        content: "\f0de";
        font-family: FontAwesome;
    }
    .new-style-table table.dataTable thead .sorting:after,table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting_desc:after,table.dataTable thead .sorting_asc_disabled:after,table.dataTable thead .sorting_desc_disabled:after {
        content: "\f0dd";
        font-family: FontAwesome;
        right: .65rem !important;
    }
    .new-style-table table thead tr{
        background-color: grey;
        color: white;
        height: 40px;
        font-size: .7rem;
    }
    .new-style-table table tr{
        background-color: white;
        color: grey;
        min-height: 40px;
        font-size: .7rem;
        border-bottom: 1px solid #b3b3b3;
        border-top: 1px solid #e9ecef !important;
    }
    .new-style-table table tbody tr:hover{
        background-color: #f6f6ff;
    }
    .new-style-table th, .new-style-table td {
        padding: 10px;
        vertical-align: middle !important;
    }
    .new-style-table .dataTables_info {
        color:#b3b3b3;
    }
    .card{
        background-color: white;
        border: none;
        border-radius: 0rem;
    }
    .styled-button{
        outline: unset;
        color: #d3d3d3;
        background-color: #fafafa;;
        border: 1px solid #d3d3d3;
        padding: .3rem;
        padding-left: .7rem;
        padding-right: .7rem;
        margin: 0rem;
        cursor: pointer;
    }
    .page-item .page-link, .page-item span {
        border-radius: 0 !important;
        font-size: 0.7rem;
    }
    .page-item.active .page-link {
        z-index: 1;
        color: grey;
        border-color: #cccccc;
        background-color: #e9e9e9;
        box-shadow:none;
    }
    .btn-green-filled{
        outline: unset !important;
        color: white;
        background-color: #47D6B6;
        border: 2px solid #47D6B6;
        font-weight: 700;
        font-size: .7rem;
        cursor: pointer;
        padding: .4rem;
        padding-left: 1rem;
        padding-right: 1rem;
    }
    .new-style-table table thead tr{
        background-color: rgba(50, 50, 50, 1) !important;
    }
    .new-style-table .table tbody td , .new-style-table .table tbody td a {
        padding: 0.4rem 1rem !important;
        font-size: .9rem !important;
        color: rgba(22, 22, 23, 1) !important;
    }
    .btn-inside-table button{
        width: 100% !important;
        font-size: .7rem !important;
        height: 2.1rem;
        font-size: .7rem !important;
    }
    body {
        font-family: 'Open Sans', 'sans-serif' !important;
    }
</style>

<div class="container-fluid mb-5 content-position">
    {{-- <div class="se-pre-con"></div> --}}

    @section('order-header')
        <span>Edit ATTRIBUTE GROUP</span>
    @endsection

    @section('back-btn')
    <a href="{{ route('attribute_groups') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12 mt-5">
        <form action="{{ route('attribute_groups.update', $attributeGroup->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Attribute Group <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-input" id="edit_attribute_group" name="edit_attribute_group" value="{{ $attributeGroup->name }}" required />
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="form-group">
                                        <label class="form-label">Product Style <span class="text-danger">*</span></label><br>
                                        <select class="form-control form-input multy-selection" id="edit_attribute_group_product_category" name="edit_attribute_group_product_category[]"  multiple="multiple" required>
                                            @foreach ($productCategories as $productCategory)
                                                <option value="{{$productCategory->id}}" @if(in_array($productCategory->id, $commenHelper->getProductCategoryIdInArray($attributeGroup->product_category_id))) selected @endif>
                                                    {{$productCategory->product_category_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label class="form-label">Attribute</label>
                                        <select class="form-control form-input" id="select_attribute">
                                            <option value="">Select Attribute</option>
                                            @foreach ($subAttributes as $subAttribute)
                                                <option value="{{$subAttribute->id}}">
                                                    {{$subAttribute->attribute_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn-green-filled mt-4" type="button" style="outline: unset;" title="Select Attribute" id="select_attribute_btn">
                                        <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table" style="width: 100%;" id="grouped_attributes_table">
                                        <thead>
                                            <tr>
                                                <th class="image_table_header">ATTRIBUTE NAME</th>
                                                <th class="text-center image_table_header">ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody id="grouped_attributes_tbody">
                                            @foreach ($groupedAttributes as $groupedAttribute)
                                                <tr id="grouped_attribute_{{ $groupedAttribute->attribute_id }}">
                                                    <input type="hidden" class="selected-attribute-id" name="attribute_ids[]" value="{{ $groupedAttribute->attribute_id }}">
                                                    <td>{{ $groupedAttribute->attribute->attribute_name ?? '' }}</td>
                                                    <td><button type="button" class="btn btn-sm btn-danger delete-grouped-attribute" value="{{ $groupedAttribute->attribute_id }}"><i class="fa fa-trash"></i></button></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-3 mb-3 text-right">
                    <button type="submit" class="btn btn-success custom_btn">UPDATE</button>
                    <button type="button" class="btn btn-danger custom_btn" onclick="deleteGroup({{$attributeGroup->id}})">DELETE</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#edit_attribute_group_product_category').select2({
                placeholder: "Select Product Style",
                allowClear: true,
                width: '100%',
            });

            $('#select_attribute').select2({
                placeholder: "Select Attribute",
                allowClear: true,
                width: '100%',
            });

            toggleSelectedAtrributes();

            $('#select_attribute_btn').click(function(){
                var selectedAttribute =  $('#select_attribute').val();
                if(selectedAttribute == ''){
                    Swal.fire({
                        type: 'error',
                        title: 'Cannot Add!',
                        text: 'Please Select An Attribute First!',
                    });
                    return false;
                }
                addNewAttribute();
            });
        });

        $('body').on('click', '.delete-grouped-attribute', function(){
            var attributeId = $(this).val();
            $('#grouped_attribute_'+attributeId).remove();
            toggleSelectedAtrributes();
        });

        function addNewAttribute(){
            var selectedAttributeField =  $('#select_attribute');
            var newRow = '<tr id="grouped_attribute_'+selectedAttributeField.val()+'">'+
                            '<input type="hidden" class="selected-attribute-id" name="attribute_ids[]" value="'+selectedAttributeField.val()+'">'+
                            '<td>'+selectedAttributeField.find('option:selected').text()+'</td>'+
                            '<td><button type="button" class="btn btn-sm btn-danger delete-grouped-attribute" value="'+selectedAttributeField.val()+'"><i class="fa fa-trash"></i></button></td>'+
                        '</tr>';
            $('#grouped_attributes_tbody').append(newRow);
            toggleSelectedAtrributes();
        }

        function toggleSelectedAtrributes(){
            var selectedAttributes = [];
            $('.selected-attribute-id').each(function() {
                selectedAttributes.push($(this).val());
            });

            $('#select_attribute').val('').trigger('change');

            $('#select_attribute option').each(function() {
                if(selectedAttributes.includes($(this).val())) {
                    $(this).prop('disabled', true);
                } else {
                    $(this).prop('disabled', false);
                }
            });
        }

        function deleteGroup(groupId) {

            Swal.fire({
                title: 'Are you sure to delete attribute group?',
                text: 'This action delete your attribute group.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {

                if (result.value) {

                    console.log('success');
                    window.location = "{{ url('attribute_groups/delete') }}/" + groupId;

                } else {
                    Swal.close();
                }
            });
        }
    </script>
@endsection
