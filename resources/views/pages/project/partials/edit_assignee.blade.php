<div class="modal fade" id="edit_assignee_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Project Assignees</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body" style="padding: 0 2rem !important;">
                <label for="assignees_tbody" id="assignees_count">No one has assigned yet.</label>
                <table class="table">
                    <tbody id="assignees_tbody">
                        {{-- @for ($i = 0; $i < 6; $i++)
                            <tr class="assignee-tr">
                                <td>
                                    <img src="{{ asset('assets') }}/img/user/299021756_118194164300710_3333245257052032691_n.jpg" alt="" style="width: 43px; height: 43px; border-radius: 50%; border: 2px solid white;"> Prasad Gnasekara
                                </td>
                                <td class="text-right">
                                    <a href="#" class="text-red remove-assignee" style="font-weight:100;" data-type="group" data-value="{{ $i }}"><i class="fa fas-user"></i> REMOVE</a>
                                </td>
                            </tr>
                        @endfor --}}

                    </tbody>
                </table>
                {{-- @for ($i = 0; $i < 6; $i++)
                    <div class="d-flex">
                        <div class="col-8">
                            <img src="{{ asset('assets') }}/img/user/299021756_118194164300710_3333245257052032691_n.jpg" alt="" style="width: 43px; height: 43px; border-radius: 50%; border: 2px solid white;"> Prasad Gnasekara
                        </div>
                        <div class="col-4 text-right">
                            <a href="#" class="text-red remove-assignee" data-type="group" value="{{ $i }}"><i class="fa fas-user"></i> REMOVE</a>
                        </div>
                    </div>
                @endfor --}}
            </div>
        </div>
    </div>
</div>

<script>
    $('body').on('click', '.remove-assignee', function(){
        console.log('working');
        var assigneeId = $(this).attr('data-value');
        var assigneeType = $(this).attr('data-type');

        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to remove this Assignee?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, remove it!"
        }).then(function(isConfirm) {
            console.log(isConfirm);
            if(isConfirm.value){
                $.ajax({
                    url:'{{ url("projects/delete_assignee") }}',
                    method:'POST',
                    dataType:'json',
                    data:{'project_id':mainProductId, 'assignee_id':assigneeId, 'assignee_type':assigneeType, '_token':'{{csrf_token()}}'},
                    beforeSend: function(){ $(".se-pre-con").fadeIn(); },
                    success: function(data)
                    {
                        displayAssignees();
                        $(".se-pre-con").fadeOut();
                        Swal.fire(
                            data[1],
                            data[2],
                            data[0],
                        );

                        $("#"+assigneeType+"_"+assigneeId).remove();
                        console.log(data);
                    }
                });
            }
        });

    });

    $('#edit_assignee_modal').on('shown.bs.modal', function (e) {
        $.ajax({
            url:'{{ url("projects/get_assignees") }}/'+mainProductId,
            method:'GET',
            dataType:'json',
            beforeSend: function(){ $(".se-pre-con").fadeIn(); },
            success: function(data)
            {
                $("#assignees_tbody").html('');
                var allAssignes = data[0];
                if(allAssignes.length > 0){

                    for (var i = 0; i < allAssignes.length; i++) {
                        var assigneesRows = '<tr class="assignee-tr" id="'+allAssignes[i].type+'_'+allAssignes[i].id+'">';
                            assigneesRows += '<td><img src="{{ asset('') }}/'+allAssignes[i].image+'" alt="" style="width: 43px; height: 43px; border-radius: 50%; border: 2px solid white;"><span class="pl-3 text-bold">'+allAssignes[i].name+'</span></td>';
                            assigneesRows += '<td class="text-right" style="padding-top: 1.8rem;"><a href="#" class="text-red remove-assignee" style="font-weight:100;" data-type="'+ allAssignes[i].type +'" data-value="'+ allAssignes[i].id +'"><i class="fa fas-user"></i> REMOVE</a></td></tr>';
                        $("#assignees_tbody").append(assigneesRows);
                    }
                } else {
                    $("#assignees_tbody").append('<td colspan="2"><i>No Assignees</i></td>');
                }

                assigneeCount(data[1], data[2]);

                $(".se-pre-con").fadeOut();
            },
        });
    });

    function assigneeCount(uCount, gCount)
    {
        var userCount = '';
        if(uCount == 1){
            userCount = uCount +' User';
        } else if(uCount > 1){
            userCount = uCount +' Users';
        }

        var groupCount = '';
        if(gCount == 1){
            groupCount = gCount +' Group';
        } else if(gCount > 1){
            groupCount = gCount +' Groups';
        }

        var countText = 'No one has assigned yet.'
        if(uCount > 0 && gCount > 0){
            countText = userCount+' & '+groupCount+' are assigned into this project';
        } else if (uCount > 0 && gCount == 0){
            countText = userCount+' are assigned into this project';
        } else if (uCount == 0 && gCount > 0){
            countText = groupCount+' are assigned into this project';
        }
        $("#assignees_count").html(countText);
    }
</script>
