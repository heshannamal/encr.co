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

    /* MOBILE RESPONSIVE STYLES (Max Width: 768px) */
    @media (max-width: 768px) {
        .content-position {
            position: relative !important;
            top: 0 !important;
            padding: 12px 14px 30px 14px !important;
        }

        .content-position .col-md-12.mt-5 {
            margin-top: 8px !important;
            padding: 0 !important;
        }

        .content-position .col-md-12.mt-5 > form {
            background: #ffffff !important;
            border-radius: 20px !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.06) !important;
            border: 1px solid #f1f5f9 !important;
            padding: 20px 18px 22px 18px !important;
            position: relative !important;
        }

        /* .content-position .col-md-12.mt-5 > form::before {
            content: "Edit Attribute Groups" !important;
            display: block !important;
            font-size: 20px !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            padding-bottom: 16px !important;
            margin-bottom: 18px !important;
            border-bottom: 1px solid #f1f5f9 !important;
            letter-spacing: -0.3px !important;
        } */

        .content-position .card {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            margin: 0 !important;
        }

        .content-position .card-body { padding: 0 !important; }

        .content-position .col-md-6 {
            padding: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
        }

        .content-position .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .content-position .col-md-12 { padding: 0 !important; }
        .content-position .col-md-12.mt-3 { margin-top: 0 !important; }

        .content-position .form-group { margin-bottom: 18px !important; }

        .content-position .form-label {
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            margin-bottom: 8px !important;
            display: block !important;
        }

        .content-position .form-label .text-danger {
            color: #ef4444 !important;
            margin-left: 2px !important;
        }

        .content-position input.form-control.form-input,
        .content-position #edit_attribute_group {
            width: 100% !important;
            height: 48px !important;
            border-radius: 12px !important;
            border: 1px solid #e2e8f0 !important;
            padding: 0 16px !important;
            font-size: 15px !important;
            font-weight: 600 !important;
            color: #0f172a !important;
            box-sizing: border-box !important;
            outline: none !important;
            box-shadow: none !important;
            background-color: #ffffff !important;
        }

        .content-position #edit_attribute_group:focus { border-color: #10b981 !important; }

        /* ── Select2 ── */
        .content-position .select2-container {
            width: 100% !important;
            border: none !important;
        }

        .content-position .select2-container--default .select2-selection--multiple {
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            min-height: 48px !important;
            padding: 6px 36px 6px 12px !important;
            /* display: flex !important; */
            align-items: center !important;
            flex-wrap: wrap !important;
            position: relative !important;
            background-color: #ffffff !important;
            box-sizing: border-box !important;
        }

        .content-position .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            padding: 0 !important;
            margin: 0 !important;
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 6px !important;
            flex: 0 1 auto !important;
            width: auto !important;
        }

        .content-position .select2-container--default .select2-search--inline {
            flex: 1 1 120px !important;
            min-width: 120px !important;
            margin: 0 !important;
        }

        .content-position .select2-container--default .select2-search--inline .select2-search__field {
            margin: 0 !important;
            width: 100% !important;
            height: 30px !important;
            font-size: 14px !important;
            color: #334155 !important;
        }

        .content-position .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #f1f5f9 !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            padding: 4px 10px 4px 6px !important;
            font-size: 13.5px !important;
            font-weight: 500 !important;
            color: #1e293b !important;
            display: inline-flex !important;
            align-items: center !important;
            margin: 0 !important;
        }

        .content-position .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #64748b !important;
            font-size: 14px !important;
            margin-right: 6px !important;
            border: none !important;
            background: transparent !important;
            cursor: pointer !important;
            padding: 0 !important;
            float: none !important;
        }

        .content-position .select2-container--default .select2-selection--multiple::after {
            content: "" !important;
            position: absolute !important;
            top: 50% !important;
            right: 18px !important;
            width: 8px !important;
            height: 8px !important;
            border-right: 2px solid #1e293b !important;
            border-bottom: 2px solid #1e293b !important;
            transform: translateY(-70%) rotate(45deg) !important;
            pointer-events: none !important;
        }

        /* Product Style multi-select: grow with tags, hide clear "×" */
        .content-position .select2-container--default .select2-selection--multiple { height: auto !important; overflow: visible !important; }
        /* .content-position .select2-container--default .select2-selection--multiple .select2-selection__clear { position: absolute !important; top: 12px !important; right: 40px !important; margin: 0 !important; font-size: 18px !important; line-height: 1 !important; color: #64748b !important; z-index: 1 !important; }        .content-position .select2-container--default .select2-selection--multiple .select2-selection__rendered { flex: 1 1 auto !important; } */
        .content-position .select2-container--default .select2-selection--multiple .select2-search--inline { flex: 1 1 auto !important; min-width: 0 !important; }
        .content-position .select2-container--default .select2-selection--multiple .select2-search__field { padding-left: 0 !important; }
        /* .content-position .select2-container--default .select2-selection--multiple .select2-selection__clear { position: absolute !important; width: 0 !important; margin: 0 !important; padding: 0 !important; } */
        .content-position .select2-container--default .select2-selection--multiple .select2-selection__rendered { gap: 0 6px !important; }

        /* ── Attribute select + Add button row (right card only) ── */
        .content-position .col-md-6:last-child .card-body > .row:first-child {
            display: flex !important;
            align-items: flex-end !important;
            gap: 10px !important;
            flex-wrap: nowrap !important;
            margin-bottom: 12px !important;
        }

        .content-position .col-md-6:last-child .col-md-9 {
            width: calc(100% - 94px) !important;
            max-width: calc(100% - 94px) !important;
            flex: 0 0 calc(100% - 94px) !important;
            padding: 0 !important;
        }

        .content-position .col-md-6:last-child .col-md-9 .form-group { margin-bottom: 0 !important; }

        .content-position .col-md-6:last-child .col-md-3 {
            width: 84px !important;
            max-width: 84px !important;
            flex: 0 0 84px !important;
            padding: 0 !important;
        }

        .content-position .select2-container--default .select2-selection--single {
            height: 48px !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            background-color: #ffffff !important;
            padding: 0 14px !important;
            display: flex !important;
            align-items: center !important;
            position: relative !important;
            box-sizing: border-box !important;
        }

        .content-position .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding-left: 0 !important;
            font-size: 14.5px !important;
            color: #94a3b8 !important;
            line-height: 46px !important;
        }

        .content-position .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px !important;
            right: 14px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .content-position .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border: none !important;
            width: 8px !important;
            height: 8px !important;
            border-right: 2px solid #1e293b !important;
            border-bottom: 2px solid #1e293b !important;
            transform: rotate(45deg) !important;
            margin: 0 !important;
            top: auto !important;
            left: auto !important;
            position: static !important;
        }

        .content-position #select_attribute_btn {
            width: 84px !important;
            height: 48px !important;
            margin: 0 !important;
            background-color: #14b8a6 !important;
            border: none !important;
            border-radius: 12px !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #ffffff !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
            box-shadow: none !important;
            text-transform: none !important;
            padding: 0 !important;
        }

        .content-position #select_attribute_btn i.fa.fa-plus {
            margin-right: 4px !important;
            font-size: 13px !important;
        }

        /* ── Grouped attributes list ── */
        #grouped_attributes_table {
            border: none !important;
            margin-bottom: 20px !important;
            width: 100% !important;
        }

        #grouped_attributes_table thead { display: none !important; }

        #grouped_attributes_tbody {
            display: flex !important;
            flex-direction: column !important;
            width: 100% !important;
        }

        #grouped_attributes_tbody tr {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            padding: 12px 0 !important;
            border-bottom: 1px solid #f1f5f9 !important;
            background: transparent !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        #grouped_attributes_tbody tr td:first-of-type {
            font-size: 14.5px !important;
            font-weight: 500 !important;
            color: #334155 !important;
            padding: 0 !important;
            border: none !important;
            text-align: left !important;
            flex: 1 1 auto !important;
        }

        #grouped_attributes_tbody tr td:last-of-type {
            padding: 0 !important;
            border: none !important;
            text-align: right !important;
            flex: 0 0 auto !important;
        }

        .btn.delete-grouped-attribute {
            width: 36px !important;
            height: 36px !important;
            border-radius: 8px !important;
            border: 1px solid #fecdd3 !important;
            background-color: #ffffff !important;
            color: #ef4444 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 0 !important;
            box-shadow: none !important;
            cursor: pointer !important;
        }

        .btn.delete-grouped-attribute:hover,
        .btn.delete-grouped-attribute:active {
            background-color: #fef2f2 !important;
            border-color: #fca5a5 !important;
        }

        .btn.delete-grouped-attribute i.fa.fa-trash {
            font-size: 14px !important;
            color: #ef4444 !important;
        }

        /* ── Bottom buttons ── */
        .content-position .col-md-12.mt-3.mb-3.text-right {
            display: flex !important;
            flex-direction: row-reverse !important;
            gap: 12px !important;
            padding: 0 !important;
            margin: 8px 0 0 0 !important;
            width: 100% !important;
        }

        .custom_btn {
            flex: 1 1 50% !important;
            height: 50px !important;
            border-radius: 14px !important;
            font-size: 16px !important;
            font-weight: 700 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin: 0 !important;
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            text-transform: capitalize !important;
            cursor: pointer !important;
        }

        .btn-success.custom_btn { background-color: #10b981 !important; color: #ffffff !important; }
        .btn-success.custom_btn:hover,
        .btn-success.custom_btn:active { background-color: #059669 !important; }

        .btn-danger.custom_btn { background-color: #dc2626 !important; color: #ffffff !important; }
        .btn-danger.custom_btn:hover,
        .btn-danger.custom_btn:active { background-color: #b91c1c !important; }
    }
</style>

<div class="container-fluid mb-5 content-position">
    {{-- <div class="se-pre-con"></div> --}}

    @section('order-header')
        <span>EDIT ATTRIBUTE GROUP</span>
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
