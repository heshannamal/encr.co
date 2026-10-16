{{-- Add Order --}}
<div class="modal fade select-container" id="add_project" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">NEW PROJECT</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row ">
                        <div class="card-body">
                            <form action="{{ route('new_projects.create') }}" method="post">
                                @csrf
                                <div class="card mb-3" style="border: 1px solid #e3e3e3 !important; border-radius: 4px;">
                                    <div class="card-body card-margin">
                                        <div class="row div_flexdir">
                                            <div class="col-md-6 div_none">
                                                <table class="table-font-size invoice_details table-border" >
                                                    <tr>
                                                        <th style="width: 105px;" class="th_width1 w-143">Project Name </th>
                                                        <th>:</th>
                                                        <td style="width: 212px;" class="th_width2 w-249"><input class="form-control" name="project_name" id="project_name" type='text'/></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Project # </th>
                                                        <th>:</th>
                                                        <td ><input class="form-control" name="project_no" id="project_no" type='text' value='{{$projectNo}}' readonly /></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Project Status </th>
                                                        <th>:</th>
                                                        <td>
                                                            <select class="form-control select2-new-project" name="project_status_id" id="project_status_id" required>
                                                                <option value="">Select a Status</option>
                                                                @foreach($projectStatuses as $projectStatus)
                                                                    <option value="{{$projectStatus->id}}">{{$projectStatus->status_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>

                                                </table>
                                            </div>

                                            <div class="col-md-6 div_none">
                                                <table class="table-font-size invoice_details table-border">
                                                    <tr>
                                                        <th style="width: 105px;" class="th_width1">Project Type </th>
                                                        <th>:</th>
                                                        <td style=" width: 2012px;" class="th_width2">
                                                            <select class="form-control select2-new-project" name="type_id" id="type_id" required>
                                                                <option value="">Select a Project Type</option>
                                                                @foreach($type as $type)
                                                                        <option value="{{$type->id}}">{{$type->type_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    {{-- <tr>
                                                        <th>Project Open Date :</th>
                                                        <td>
                                                            <input class="invoice-inputs datepicker" name="created_at" value="{{ $currentDate }}" readonly />
                                                        </td>
                                                    </tr> --}}

                                                    <tr>
                                                        <th style="width: 36%;" class="th_width1">Project Color </th>
                                                        <th>:</th>
                                                        <td class="th_width2">
                                                            <div class="color-picker-wrapper invoice-inputs" style="background-color: #0064fb">

                                                                <input type="color" name="project_color" value="#0064fb" class="color-picker" list="presetColors" style="width: 100%;" >
                                                                <datalist id="presetColors">
                                                                    <option>#f6f8f9</option>
                                                                    <option>#fb5779</option>
                                                                    <option>#ff7510</option>
                                                                    <option>#ffa800</option>
                                                                    <option>#ffd101</option>
                                                                    <option>#ace610</option>
                                                                    <option>#19db7d</option>
                                                                    <option>#00D4CB</option>
                                                                    <option>#48dafd</option>
                                                                    <option>#0064fb</option>
                                                                    <option>#6458f9</option>
                                                                    <option>#A147E4</option>
                                                                    <option>#ff78ff</option>
                                                                    <option>#ff4ba6</option>
                                                                    <option>#ff93af</option>
                                                                    <option>#5a7896</option>
                                                                </datalist>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Description Details --}}
                                <div class="card mb-3"  style="border: 1px solid #e3e3e3 !important; border-radius: 4px;">
                                    <div class="card-body">
                                        <div class="row div_flexdir">

                                            <div class="col-md-6">
                                                <table class="table-font-size invoice_details table-border">
                                                    <tr>
                                                        <th colspan="4">Project Description :</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center" width="25px"><i class="fas fa-file-signature"></i></td>
                                                        <td><textarea class=" form-control" id="project_description" name="project_description" type='text' rows="10" value='' style="margin-top: 5px; margin-bottom: 7px; width: 288px;"></textarea></td>
                                                    </tr>
                                                </table>
                                            </div>

                                            <div class="col-md-6" >
                                                <table class="table-font-size invoice_details table-border" >
                                                    <tr>
                                                        <th>Assignees :</th>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <select class="form-control select2-new-project" name="assignee" id="assignee" onchange="selectAssignee(this.options[this.selectedIndex].getAttribute('data-type'))" style="width: 331px;">
                                                                <option value="">Select the Project assignee</option>
                                                                @foreach ($groups as $group)
                                                                    <option value="{{ $group->id }}" data-type="group">{{ $group->name }}</option>
                                                                @endforeach
                                                                @foreach ($users as $users)
                                                                    <option value="{{ $users->id }}" data-type="user">{{ $users->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <textarea class="form-control" id="project_assignee" name="project_assignee" type="text" rows="8" style="margin-top: 4px; margin-bottom: 4px; width: 20.75rem;" oninput="handleRemovedText()"></textarea>
                                                        </td>

                                                        <td><textarea class="form-control" id="project_assignee_id" name="project_assignee_id" type='text' rows="8" value='' style="margin-top: 4px; margin-bottom: 4px; width: 20.75rem;" hidden></textarea></td>
                                                        <input type="hidden" id="project_assignee_users"  name="project_assignee_users" value="">
                                                        <input type="hidden" id="project_assignee_groups"  name="project_assignee_groups" value="">
                                                    </tr>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 control-btns mt-3 no-print" style="background-color: transparent;">
                                    <button type="submit" class="btn btn-success btn-custom save-btn">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
