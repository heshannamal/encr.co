<style>
    .table-font-size {
        font-size: 13px;
    }
    .table-border {
        border: unset !important;
    }
    .card-margin {
        margin: -0.5rem;
    }
    @media screen and (min-width: 600px) and (max-width: 800px) {
        .div_flexdir{
            flex-wrap: wrap;
            flex-direction: column;
        }
        .div_none{
            max-width: none;
        }
    }
    @media only screen and (min-device-width : 834px) and (max-device-width : 1024px) and (orientation : portrait) {
        .div_flexdir{
            flex-wrap: wrap;
            flex-direction: column;
        }
        .div_none{
            max-width: none;
        }
    }
</style>

<form action="{{ route('projects.update') }}" method="post">
    @csrf

    {{-- @foreach ($projects as $project) --}}
        <div class="card mb-3">
            <div class="card-body card-margin">
                <div class="row div_flexdir">
                    <div class="col-md-6 div_none">
                        <table class="table-font-size invoice_details table-border">
                            <tr>
                                <th  style="width: 130px;">Project Name </th>
                                <th  style="width: 20px;">:</th>
                                <td  style="width: 70%;"><input class="form-control" name="project_name" id="project_name" type='text' value="{{ $project->project_name }}"/></td>
                            </tr>
                            <tr>
                                <th>Project #  </th>
                                <th>:</th>
                                <td><input class="form-control" name="project_no" id="project_no" type='text' value='{{ $project->project_no }}' readonly /></td>
                            </tr>
                            <tr>
                                <th>Project Status </th>
                                <th>:</th>
                                <td>
                                    <select class="form-control" name="project_status_id" id="project_status_id">
                                        <option value="">Select a Status</option>
                                            @foreach ($projectStatus as $projectStat)
                                                <option value="{{ $projectStat->id }}" {{ $projectStat->id == $project->project_status_id ? 'selected' : '' }}>

                                                    {{ $projectStat->status_name }}
                                                </option>
                                            @endforeach
                                    </select>
                                </td>
                            </tr>

                        </table>
                    </div>

                    <div class="col-md-6 div_none">
                        <table class="table-font-size invoice_details table-border">
                            <tr>
                                <th>Project Type </th>
                                <th>:</th>
                                <td>
                                    <select class="form-control" name="type_id" id="type_id" required>
                                        <option value="">Select a Project Type</option>
                                            @foreach ($type as $projectType)
                                                <option value="{{ $projectType->id }}" @if ($projectType->id == $project->project_type_id ) selected @endif>
                                                    {{ $projectType->type_name }}
                                                </option>
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
                                <th style="width: 130px;">Project Color </th>
                                <th style="width: 20px;">:</th>
                                <td style="width: 70%;">
                                    <div class="color-picker-wrapper invoice-inputs" style="background-color: {{ $project->project_color }}">

                                        <input type="color" name="project_color" value="{{ $project->project_color }}" class="color-picker" list="presetColors" style="width: 100%;">
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

        {{-- description Details --}}
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">

                    <div class="col-md-6">
                        <table class="table-font-size invoice_details table-border">
                            <tr>
                                <th colspan="4">Project Description :</th>
                            </tr>
                            <tr>
                                <td class="text-center" style="width: 10px;"><i class="fas fa-file-signature" ></i></td>
                                <td style="width: 97.05%;;"><textarea class="form-control" id="project_description" name="project_description" type='text' rows="8" value="" style="margin-top: 5px; margin-bottom: 7px;">{{ $project->project_description }}</textarea></td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6" >
                        <table class="table-font-size invoice_details table-border" style="width: 99%;" >
                            <tr>
                                <th>Assignees :</th>
                            </tr>
                            <tr>
                                <td class="form-control">
                                    <select class=" select2-new-project" name="assignee" id="assignee" onchange="selectAssignee(this.options[this.selectedIndex].getAttribute('data-type'))">
                                        <option value="">Select the Project assignee</option>
                                            {{-- @foreach ($users as $user)
                                                <option value="{{ $user->id }}">
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach --}}
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}" data-type="group">{{ $group->name }}</option>
                                            @endforeach
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" data-type="user">{{ $user->name }}</option>
                                            @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><textarea class="form-control" id="project_assignee" name="project_assignee" type='text' rows="6" value='' style="margin-top: 4px; margin-bottom: 4px;">
                                    @foreach($users as $user)
                                        @foreach (explode(',', $project->project_assignee) as $assignee)
                                                @if(isset($user) && !empty($user) && $user->id ==  $assignee )
                                                    {{ $user->name }}
                                                @endif
                                        @endforeach
                                    @endforeach
                                </textarea></td>

                                <td><textarea class="form-control" id="project_assignee_id" name="project_assignee_id" type='text' rows="6" value='' style="margin-top: 4px; margin-bottom: 4px;" hidden>

                                        @foreach (explode(',', $project->project_assignee) as $assignee)

                                                {{ $assignee }}

                                        @endforeach

                                </textarea>
                                        <input type="hidden" id="project_assignee_users"  name="project_assignee_users" value="{{ $project->project_assignee_users }}">
                                        <input type="hidden" id="project_assignee_groups"  name="project_assignee_groups" value="{{ $project->project_assignee_groups }}">
                            </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <input class="invoice-inputs" name="project_id" type='hidden' value="{{ $project->id }}" />
    {{-- @endforeach --}}


    <div class="col-lg-12 control-btns no-print">
        <button type="submit" class="btn btn-success btn-custom">Update</button>
    </div>
</form>
