@extends('layouts.app', ['activePage' => 'user_groups', 'titlePage' => __('User Groups')])

@section('content')
<div class="container-fluid">
    <div class="col-md-12 mt-5">
        <div class="float-right">
            <a class="btn btn-secondary btn-secondary-custom" href="#" onclick="exportReport()">
                <i class="fas fa-file-csv"></i> Export
            </a>

            <a href="{{ route('user_groups.add') }}" class="btn btn-secondary btn-secondary-custom" title="Add User Groups">
                <i class="fas fa-plus"></i> Add User Groups
            </a>

            <a class="btn btn-secondary btn-secondary-custom" href="#" data-toggle="modal" data-target="#layout_modal">
                <i class="fas fa-wrench"></i> Table Layout
            </a>
        </div>
    </div>

    <div class="col-md-12 mt-6 alphabet">
        <a href="{{ route('user_groups') }}"><button type="button" class="btn btn-secondary btn-secondary-custom no-space" >All</button></a>
        <button type="button" value="A" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> A </button>
        <button type="button" value="B" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> B </button>
        <button type="button" value="C" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> C </button>
        <button type="button" value="D" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> D </button>
        <button type="button" value="E" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> E </button>
        <button type="button" value="F" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> F </button>
        <button type="button" value="G" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> G </button>
        <button type="button" value="H" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> H </button>
        <button type="button" value="I" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> I </button>
        <button type="button" value="J" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> J </button>
        <button type="button" value="K" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> K </button>
        <button type="button" value="L" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> L </button>
        <button type="button" value="M" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> M </button>
        <button type="button" value="N" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> N </button>
        <button type="button" value="O" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> O </button>
        <button type="button" value="P" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> P </button>
        <button type="button" value="Q" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> Q </button>
        <button type="button" value="R" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> R </button>
        <button type="button" value="S" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> S </button>
        <button type="button" value="T" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> T </button>
        <button type="button" value="U" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> U </button>
        <button type="button" value="V" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> V </button>
        <button type="button" value="W" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> W </button>
        <button type="button" value="X" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> X </button>
        <button type="button" value="Y" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> Y </button>
        <button type="button" value="Z" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> Z </button>
    </div>

    <div class="col-md-12 mt-3">
        <div class="table-responsive">
            <table class="table align-items-center" id="user_groups_table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck1" title="Select all records in this page">
                                <label class="custom-control-label" for="customCheck1">&nbsp;</label>
                            </div>
                        </th>
                        <th class="user-group-name" scope="col">User Group</th>
                        <th class="narration" scope="col">Narration</th>
                        <th class="created-at" scope="col">Created At</th>
                        <th class="updated-at" scope="col">Updated At</th>
                    </tr>
                </thead>

                <tbody class="list">
                    @foreach ($userGroups as $userGroup)
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck.{{$userGroup->id}}" id-value="{{$userGroup->id}}" title="Select this user group">
                                    <label class="custom-control-label" for="customCheck.{{$userGroup->id}}">&nbsp;</label>
                                </div>
                            </td>
                            <td class="user-group-name"><a href="#" class="edit" data-value="{{$userGroup->id}}">{{$userGroup->user_group_name}}</a></td>
                            <td class="narration">{{$userGroup->narration}}</td>
                            <td class="created-at">{{$userGroup->created_at}}</td>
                            <td class="updated-at">{{$userGroup->updated_at}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- User Groups Fields & Layouts --}}
<div class="modal fade" id="layout_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">User Groups Fields &amp; Layouts</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">

                        <input type="hidden" id="layout_id" name="layout_id" value="{{$userGroupLayout['id']}}" />

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input 
                                    type="checkbox" class="custom-control-input" id="user_group_name" name="user_group_name" title="User Group Name" 
                                    @if ($userGroupLayout['user_group_name'] == 1) checked @endif 
                                />
                                <label class="custom-control-label" for="user_group_name">User Group Name</label>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input 
                                    type="checkbox" class="custom-control-input" id="narration" name="narration" title="Narration" 
                                    @if ($userGroupLayout['narration'] == 1) checked @endif 
                                />
                                <label class="custom-control-label" for="narration">Narration</label>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input 
                                    type="checkbox" class="custom-control-input" id="created_at" name="created_at" title="Created At" 
                                    @if ($userGroupLayout['created'] == 1) checked @endif 
                                />
                                <label class="custom-control-label" for="created_at">Created At</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input 
                                    type="checkbox" class="custom-control-input" id="updated_at" name="updated_at" title="Updated At" 
                                    @if ($userGroupLayout['updated'] == 1) checked @endif 
                                />
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
    $(document).ready(function() {
        $('#user_groups_table').DataTable();

        // User Group Edit
        $("body").on("click", ".edit", function(){
            var userGroupId = $(this).data('value');
            window.location.replace("user_groups/edit/"+userGroupId);
        });

        // User Groups Table Layout
        tableLayout();
        $('#user_group_name').on('change', function(){ tableLayout(); });
        $('#narration').on('change', function(){ tableLayout(); });
        $('#created_at').on('change', function(){ tableLayout(); });
        $('#updated_at').on('change', function(){ tableLayout(); });
    });

    function tableLayout(){
        var layout_id = $('#layout_id').val();
        var user_group_name = $('#user_group_name').val();
        var narration = $('#narration').val();
        var created_at = $('#created_at').val();
        var updated_at = $('#updated_at').val();

        if($('#user_group_name').is(':checked')) {
            $('.user-group-name').css('display', 'table-cell');
            user_group_name = 1;
        } else {
            $('.user-group-name').css('display', 'none');
            user_group_name = 0;
        }
        
        if($('#narration').is(':checked')) {
            $('.narration').css('display', 'table-cell');
            narration = 1;
        } else {
            $('.narration').css('display', 'none');
            narration = 0;
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
            url: "user_groups/layout",
            type: "POST",
            data: {
                'layout_id':layout_id, 'user_group_name':user_group_name, 'narration':narration, 'created_at':created_at, 'updated_at':updated_at, '_token':'{{csrf_token()}}'
            },
            success: function (data) {
                console.log(data);
                if(data == '"Saved"') {
                    window.location.reload(true);
                }
            }
        });
    }

    // Sort by Alphabet
    $('.sortByAlphabet').on('click', function(){
        var letterId = $(this).val();
        var userGroupsTable = $('#user_groups_table').DataTable();

        $.ajax({
            url:"{{ url('user_groups/sort_by_alphabet') }}/"+letterId,
            method:'GET',
            dataType:'json',
            success: function (data){
                console.log(data);
                userGroupsTable.clear().draw();
                for (var i = 0; i < data.length; i++) {
                    var row = userGroupsTable.row.add([
                        '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="customCheck'+data[i].id+'" id-value="'+data[i].id+'"><label class="custom-control-label" for="customCheck'+data[i].id+'">&nbsp;</label></div>',
                        '<a href="#" class="edit" data-value="'+data[i].id+'">'+data[i].user_group_name+'</a>',
                        data[i].narration,
                        data[i].created_at,
                        data[i].updated_at,
                    ]);
                    userGroupsTable.row(row).column(1).nodes().to$().addClass('user-group-name');
                    userGroupsTable.row(row).column(2).nodes().to$().addClass('narration');
                    userGroupsTable.row(row).column(3).nodes().to$().addClass('created-at');
                    userGroupsTable.row(row).column(4).nodes().to$().addClass('updated-at');
                    userGroupsTable.row(row).draw();
                }

                tableLayout();
            }
        });
    });

    function exportReport() {
        $("#user_groups_table").tableExport();
    }
</script>

@endsection
