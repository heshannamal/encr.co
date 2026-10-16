@extends('layouts.app', ['activePage' => 'sizes', 'titlePage' => __('Sizes')])

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
        width: 84px;
        position: relative;
        right: -29px;
    }
    .btn-text-position {
        position: relative;
        right: -7px;
        font-size: 15px;
    }
    .content-position {
        position: relative;
        top: -45px;
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
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>SIZES</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="row col-md-12" style="padding: 0rem;">
        <div class="col-md-4 ml-auto text-right mt-3">
            
        </div>
    </div>

    {{-- <div class="col-md-12 btn-top">
        <div class="row div_align">
            <div class="col-md-9"></div>
            <div class="col-md-3 btns-right-position btn_set">
                <div class="row">
                    <div class="col-md-6 btns-padding">
                        @if (Gate::check('add sizes'))
                            <button class="btns-text btns-style btns-card" style="outline: unset;" href="#" data-toggle="modal" data-target="#size_create_modal" title="Add New Size">
                                Add Size
                            </button>
                        @endif
                    </div>
                    <div class="col-md-6 btns-padding">
                            <button class="btns-text btns-style btns-card" style="outline: unset;" href="#" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout">
                                Table Layout
                            </button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}


    <div class="col-md-12">
        <div class="card">
            {{-- <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="float-left header-title">Sizes</h1>
                        </div>
                        <div class="col-md-6 header-icons justify-content-end">
                            @if (Gate::check('add sizes'))
                             <span>
                                 <a class="btn btn-round" href="#" data-toggle="modal" data-target="#size_create_modal">
                                     <i class="fas fa-plus"></i>
                                 </a>
                                 <p>Add Sizes</p>
                             </span>
                             @endif

                             <span>
                                 <a class="btn btn-round" href="#" data-toggle="modal" data-target="#layout_modal">
                                     <i class="fas fa-wrench"></i>
                                 </a>
                                 <p>Table Layout</p>
                             </span>
                         </div>
                    </div>
                </div>
            </div> --}}
                <div class="col-md-4 ml-auto mb-2 mt-2">
                    <table class="btn-inside-table" style="width: 100%">
                        <tr>
                            <td style="width: 25%"></td>
                            <td>
                                <button class="styled-button" style="outline: unset;" href="#" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout">
                                    Table Layout
                                </button>
                            </td>
                            <td>
                                @if (Gate::check('add sizes'))
                                    <button class="btn-green-filled" style="outline: unset;" href="#" data-toggle="modal" data-target="#size_create_modal" title="Add New Size">
                                        <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD SIZE
                                    </button>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-12 new-style-table">
                    <div class="table-responsive">
                        <table class="table align-items-center" id="size_table">
                            <thead>
                                <th class="size-name" scope="col">Size Name</th>
                                <th class="size-type" scope="col">Size Type</th>
                                <th class="created-at" scope="col">Created At</th>
                                <th class="updated-at" scope="col">Updated At</th>
                            </thead>

                            <tbody class="list">
                                @foreach ($sizes as $size)
                                <tr>
                                    <td class="size-name"><a href="#" class="edit" data-value="{{$size->id}}">{{$size->size_name}}</a></td>
                                    <td class="size-type">
                                        @foreach ($sizeTypes as $sizeType)
                                            @if ($size->size_type == $sizeType->id)
                                                {{ $sizeType->type_name }}
                                            @endif
                                        @endforeach

                                    </td>
                                    <td class="created-at">{{$size->created_at->format('m-d-Y')}}</td>
                                    <td class="updated-at">{{$size->updated_at->format('m-d-Y')}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>

    </div>
</div>

@include('pages.masters.sizes.create')
@include('pages.masters.sizes.edit')

{{-- Sizes Fields & Layouts --}}
<div class="modal fade" id="layout_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Sizes Fields &amp; Layouts</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">

                        <input type="hidden" id="layout_id" name="layout_id" value="{{$sizeLayout['id']  ?? ''}}" />
                        <input type="hidden" id="column_layout_id" name="column_layout_id" value="{{$columnLayout['id'] ?? 0}}" />

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="size_name" name="size_name" title="Size Name" @isset($sizeLayout) @if ($sizeLayout['size_name'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="size_name">Size Name</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="size_type" name="size_type" title="Size Type" @isset($sizeLayout) @if ($sizeLayout['size_type'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="size_type">Size Type</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="created_at" name="created_at" title="Created At" @isset($sizeLayout) @if ($sizeLayout['created'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="created_at">Created At</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="updated_at" name="updated_at" title="Updated At" @isset($sizeLayout) @if ($sizeLayout['updated'] == 1) checked @endif @endisset />
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

<script>
    var searchIdx = '';

    $(document).ready(function () {
        // Sizes Table Layout
        tableLayout();

        var sizeTable = $('#size_table').DataTable({
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

        alphabet.insertBefore( sizeTable.table().container() );

        alphabet.on('click', 'span', function () {
            alphabet.find( '.active' ).removeClass( 'active' );
            $(this).addClass( 'active' );

            _alphabetSearch = $(this).data('letter');
            sizeTable.draw(_alphabetSearch);
        });

        // save column order when move
        sizeTable.on('column-reorder', function (e, settings, details) {
            var columnStr = localStorage.getItem("DataTables_size_table_/sizes");
            var columnObj = JSON.parse(columnStr);
            var colReorder = new $.fn.dataTable.ColReorder( sizeTable );
            var curr = colReorder.fnOrder();
            var column_order = JSON.stringify(curr);
            var interface_name = 'Size';
            var interface_id = 7;
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
            var columnStr = localStorage.getItem("DataTables_size_table_/sizes");
            var columnObj = JSON.parse(columnStr);
            var column_order = JSON.stringify(columnObj.ColReorder);
            var interface_name = 'Size';
            var interface_id = 7;
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
            var interfaceId = 7;
            $.ajax({
                url: '{{ url("datatable/get_column_order") }}/'+interfaceId,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    console.log(data.column_order);
                    var columnStr = localStorage.getItem("DataTables_size_table_/sizes");
                    var columnObj = JSON.parse(columnStr);
                    columnObj.ColReorder = JSON.parse(data.column_order);

                    localStorage.setItem('DataTables_size_table_/sizes', JSON.stringify(columnObj));
                },
                complete: function() {
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        }

        // Size Edit
        $("body").on("click", ".edit", function(){
            var sizeId = $(this).data('value');
            $('#size_id').val(sizeId);
            $('#size_edit_modal').modal('show');
        });

        $('#size_name').on('change', function(){ tableLayout(); });
        $('#size_type').on('change', function(){ tableLayout(); });
        $('#created_at').on('change', function(){ tableLayout(); });
        $('#updated_at').on('change', function(){ tableLayout(); });
    });

    function tableLayout(){
        var layout_id = $('#layout_id').val();
        var size_name = $('#size_name').val();
        var size_type = $('#size_type').val();
        var created_at = $('#created_at').val();
        var updated_at = $('#updated_at').val();

        if($('#size_name').is(':checked')) {
            $('.size-name').css('display', 'table-cell');
            size_name = 1;
        } else {
            $('.size-name').css('display', 'none');
            size_name = 0;
        }

        if($('#size_type').is(':checked')) {
            $('.size-type').css('display', 'table-cell');
            size_type = 1;
        } else {
            $('.size-type').css('display', 'none');
            size_type = 0;
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
            url:'sizes/layout',
            type:'POST',
            data: {
                'layout_id':layout_id, 'size_name':size_name, 'size_type':size_type, 'created_at':created_at, 'updated_at':updated_at, '_token':'{{csrf_token()}}'
            },
            success: function (data, textStatus, jqXHR) {
                console.log(data);
                if(data == '"Saved"') {
                    window.location.reload(true);
                }
            }
        });
    }

    function searchIndex(){
        $('#size_table thead th').each(function(){
            if($(this).text() == 'Size Name') {
                searchIdx = $('#size_table thead th').index(this);
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
