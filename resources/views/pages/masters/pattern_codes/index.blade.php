@extends('layouts.app', ['activePage' => 'pattern_codes', 'titlePage' => __('Pattern Codes')])

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
        <span>PATTERN CODES</span>
    @endsection

    @section('back-btn')
    <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="row col-md-12" style="padding: 0rem;">
        <div class="col-md-4 ml-auto text-right mt-3">

        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="col-md-4 ml-auto mb-2 mt-3">
                <table class="btn-inside-table" style="width: 100%">
                    <tr>
                        <td style="width: 25%"></td>
                        <td>
                            <button class="styled-button" style="outline: unset;" href="#" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout">
                                Table Layout
                            </button>
                        </td>
                        <td>
                            @if (Gate::check('add pattern code'))
                                <button class="btn-green-filled" style="outline: unset;" href="#" data-toggle="modal" data-target="#pattern_code_create_modal" title="Add New Pattern Code">
                                    <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD PATTERN CODE
                                </button>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
                <div class="col-md-12 new-style-table">
                    <div class="table-responsive">
                        <table class="table align-items-center" id="pattern_codes_table">
                            <thead>
                                <th class="pattern-code" scope="col">Pattern Code</th>
                                <th class="product-name" scope="col">Product Name</th>
                                <th class="attribute-name" scope="col">Attributes</th>
                                <th class="created-at" scope="col">Created At</th>
                                <th class="updated-at" scope="col">Updated At</th>
                            </thead>

                            <tbody class="list">
                                @foreach ($patternCodes as $patternCode)
                                <tr>
                                    <td class="pattern-code"><a href="#" style="color: grey !important" class="edit edit_pattern_codes" data-value="{{$patternCode->id}}">{{$patternCode->pattern_code}}</a></td>
                                    <td class="product-name">{{ $patternCode->subProduct->product_name ?? '' }}</td>
                                    <td class="attribute-name">
                                        @php
                                            $patternAttributeArr = [];
                                            $patternAttributeArr = json_decode($patternCode->pattern_attribute);
                                        @endphp
                                        <ul>
                                            @foreach ($patternAttributeArr as $patternAttribute)
                                                <li>{{ $helper->getAttributeNameById($patternAttribute) }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="created-at">{{$patternCode->created_at->format('m-d-Y')}}</td>
                                    <td class="updated-at">{{$patternCode->updated_at->format('m-d-Y')}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>

{{-- Attributes Fields & Layouts --}}
<div class="modal fade" id="layout_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Patter Codes Fields &amp; Layouts</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">
                        <input type="hidden" id="layout_id" name="layout_id" value="{{$patternCodeLayout['id'] ?? ''}}" />
                        <input type="hidden" id="column_layout_id" name="column_layout_id" value="{{$columnLayout['id'] ?? 0}}" />

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="pattern_code" name="pattern_code" title="Attribute Group" @isset($patternCodeLayout) @if ($patternCodeLayout['pattern_code'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="pattern_code">Patter Code</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="product_name" name="product_name" title="Product Style" @isset($patternCodeLayout) @if ($patternCodeLayout['product_name'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="product_name">Product Name</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="attribute_name" name="attribute_name" title="Attribute" @isset($patternCodeLayout) @if ($patternCodeLayout['attribute_name'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="attribute_name">Attribute</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="created_at" name="created_at" title="Created At" @isset($patternCodeLayout) @if ($patternCodeLayout['created'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="created_at">Created At</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="updated_at" name="updated_at" title="Updated At" @isset($patternCodeLayout) @if ($patternCodeLayout['updated'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="updated_at">Updated At</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer"></div>
        </div>
    </div>
</div>

@include('pages.masters.pattern_codes.create')
@include('pages.masters.pattern_codes.edit')

<script>
    var searchIdx = '';

    $(document).ready( function () {
        // Attributes Table Layout
        tableLayout();

        var attributeTable = $('#pattern_codes_table').DataTable({
            colReorder: true,
            stateSave: true,
            "autoWidth": false,
            "pageLength": 50,
            language: {
                search: '<i class="fas fa-search"></i>',
                searchPlaceholder: 'Search'
            }
        });

        searchIndex();

        // Alphabet Search
        var _alphabetSearch = '';

        $.fn.dataTable.ext.search.push( function (settings, searchData) {

            if ( ! _alphabetSearch ) {
                return true;
            }

            if ( searchData[searchIdx].charAt(0) === _alphabetSearch ) {
                return true;
            }

            return false;
        });

        var alphabet = $('<div class="alphabet"/>').append( '' );

        $('<span class="clear active"/>').data( 'letter', '' ).html( 'All' ).appendTo( alphabet );

        for ( var i=0 ; i<26 ; i++ ) {
            var letter = String.fromCharCode( 65 + i );

            $('<span/>').data( 'letter', letter ).html( letter ).appendTo( alphabet );
        }

        alphabet.insertBefore( attributeTable.table().container() );

        alphabet.on('click', 'span', function () {
            alphabet.find( '.active' ).removeClass( 'active' );
            $(this).addClass( 'active' );

            _alphabetSearch = $(this).data('letter');
            attributeTable.draw(_alphabetSearch);
        });

        // save column order when move
        attributeTable.on('column-reorder', function (e, settings, details) {
            var columnStr = localStorage.getItem("DataTables_pattern_codes_table_/pattern_codes");
            var columnObj = JSON.parse(columnStr);
            var colReorder = new $.fn.dataTable.ColReorder( attributeTable );
            var curr = colReorder.fnOrder();
            var column_order = JSON.stringify(curr);
            var interface_name = 'Patter Codes';
            var interface_id = 16;
            console.log(column_order);

            $.ajax({
                url: '{{ route("datatable.column_order") }}',
                type: "POST",
                data: {
                    'interface_name': interface_name, 'interface_id': interface_id, 'column_order':column_order, '_token':'{{csrf_token()}}'
                },
                success: function(data) {
                    console.log(data);
                    searchIndex();
                }
            });
        });

        var columnId = $('#column_layout_id').val();
        if(columnId == 0){
            // save column order
            var columnStr = localStorage.getItem("DataTables_pattern_codes_table_/pattern_codes");
            var columnObj = JSON.parse(columnStr);
            var column_order = JSON.stringify(columnObj.ColReorder);
            var interface_name = 'Patter Codes';
            var interface_id = 16;
            console.log(column_order);

            $.ajax({
                url: '{{ route("datatable.column_order") }}',
                type: "POST",
                data: {
                    'interface_name': interface_name, 'interface_id': interface_id, 'column_order':column_order, '_token':'{{csrf_token()}}'
                },
                success: function(data) {
                    console.log(data);
                    if (window.location.href.indexOf('reload')==-1) {
                        window.location.replace(window.location.href+'?reload');
                    }
                },
                complete: function() {
                    $(".se-pre-con").fadeOut('slow');
                }
            });

        } else {
            // refresh column order according to user
            var interfaceId = 16;
            $.ajax({
                url: '{{ url("datatable/get_column_order") }}/'+interfaceId,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    console.log(data.column_order);
                    var columnStr = localStorage.getItem("DataTables_pattern_codes_table_/pattern_codes");
                    var columnObj = JSON.parse(columnStr);
                    columnObj.ColReorder = JSON.parse(data.column_order);

                    localStorage.setItem('DataTables_pattern_codes_table_/pattern_codes', JSON.stringify(columnObj));
                },
                complete: function() {
                    $(".se-pre-con").fadeOut('slow');
                }
            });

        }

        // Embellishment Type Edit
        // $(document).on("click", ".edit_pattern_codes", function(){
        //     var attributeId = $(this).data('value');
        //     $('#attribute_id').val(attributeId);
        //     $('#attribute_edit_modal').modal('show');
        //     console.log('error');
        // });


        $('#pattern_code').on('change', function(){ tableLayout(); });
        $('#product_name').on('change', function(){ tableLayout(); });
        $('#attribute_name').on('change', function(){ tableLayout(); });
        $('#created_at').on('change', function(){ tableLayout(); });
        $('#updated_at').on('change', function(){ tableLayout(); });
    });


    $(document).ready( function () {
        $(document).on("click", ".edit_pattern_codes", function(){
            var patternCodeIdId = $(this).data('value');
            $('#pattern_code_id').val(patternCodeIdId);
            $('#pattern_code_edit_modal_body').html('');
            $('#new_attributes').html('');
            $('#pattern_code_edit_modal').modal('show');
        });
    });
    function tableLayout(){
        var layout_id = $('#layout_id').val();
        var pattern_code = $('#pattern_code').val();
        var product_name = $('#product_name').val();
        var attribute_name = $('#attribute_name').val();
        var created_at = $('#created_at').val();
        var updated_at = $('#updated_at').val();

        if($('#pattern_code').is(':checked')) {
            $('.pattern-code').css('display', 'table-cell');
            pattern_code = 1;
        } else {
            $('.pattern-code').css('display', 'none');
            pattern_code = 0;
        }

        if($('#product_name').is(':checked')) {
            $('.product-name').css('display', 'table-cell');
            product_name = 1;
        } else {
            $('.product-name').css('display', 'none');
            product_name = 0;
        }

        if($('#attribute_name').is(':checked')) {
            $('.attribute-name').css('display', 'table-cell');
            attribute_name = 1;
        } else {
            $('.attribute-name').css('display', 'none');
            attribute_name = 0;
        }

        if($('#created_at').is(':checked')) {
            $('.created-at').css('display', 'table-cell');
            created_at = 1;
        } else {
            $('.created-at').css('display', 'none');
            created_at = 0;
        }

        if($('#updated_at').is(':checked')) {
            $('.updated-at').css('display', 'table-cell');
            updated_at = 1;
        } else {
            $('.updated-at').css('display', 'none');
            updated_at = 0;
        }

        $.ajax({
            url: "pattern_codes/layout",
            type: "POST",
            data: {
                'layout_id':layout_id, 'pattern_code':pattern_code, 'product_name':product_name, 'attribute_name':attribute_name, 'created_at':created_at, 'updated_at':updated_at, '_token':'{{csrf_token()}}'
            },
            success: function (data) {
                console.log(data);
                if(data == '"Saved"') {
                    window.location.reload(true);
                }
            }
        });
    }

    function searchIndex(){
        $('#pattern_codes_table thead th').each(function(){
            if($(this).text() == 'Attribute Group') {
                searchIdx = $('#pattern_codes_table thead th').index(this);
                console.log(searchIdx);
            }
        });
    }

    $('#layout_modal').on('hidden.bs.modal', function () {
        $(".se-pre-con").fadeIn('slow');
        window.location.reload(true);
    });
</script>
@endsection
