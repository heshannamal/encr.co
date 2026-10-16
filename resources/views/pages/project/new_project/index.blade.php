@extends('layouts.app', ['activePage' => 'new_projects', 'titlePage' => __('New Projects')])

@section('content')
<style>
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
    .back-btn-div-position {
        padding: 0.5rem;
    }
    .btn-right {
        position: relative;
        right: 10px;
    }
    .back-btn-font {
        font-size: x-small;
        font-weight: 900;
    }
    .back-btn-div {
        padding: 0.5rem;
        background-color: #787878;
        border-radius: 0.125rem;
    }
    .td-border {
        border: 0.05rem solid #787878;
        border-radius: 3px;
    }
</style>

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<div class="container-fluid mb-5">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>NEW PROJECT</span>
    @endsection

    <div class="col-md-12 mt-4">
        <div class="card">
            {{-- <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <h1 class="float-left header-title">New Project</h1>

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

            <div class="card-header back-btn-div-position">
                <div class=" col-md-12">
                    <div class="float-right btn-right">
                            <a class="btn back-btn-div" href="{{route('projects')}}" title="Add New Orders">
                                <i class="fas fa-solid fa-reply-all back-btn-font" style="color: #ffffff;">   SWITCH TO PROJECT</i>
                            </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('new_projects.create') }}" method="post">
                    @csrf
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table invoice_details">
                                        <tr>
                                            <th>Project Name :</th>
                                            <td class="td-border"><input class="invoice-inputs" name="project_name" id="project_name" type='text'/></td>
                                        </tr>
                                        <tr>
                                            <th>Project # :</th>
                                            <td class="td-border"><input class="invoice-inputs" name="project_no" id="project_no" type='text' value='{{$projectNo}}' readonly /></td>
                                        </tr>
                                        <tr>
                                            <th>Project Status :</th>
                                            <td class="td-border">
                                                <select class="invoice-inputs select2-new-project" name="project_status_id" id="project_status_id" required>
                                                    <option value="">Select a Status</option>
                                                    @foreach($projectStatuses as $projectStatus)
                                                        <option value="{{$projectStatus->id}}">{{$projectStatus->status_name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>

                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <table class="table invoice_details">
                                        <tr>
                                            <th>Project Type :</th>
                                            <td class="td-border">
                                                <select class="invoice-inputs select2-new-project" name="type_id" id="type_id" required>
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
                                    </table>
                                    <table class="table invoice_details mt-3">

                                        <tr>
                                            <th style="width: 36%;">Project Color :</th>
                                            <td class="td-border">
                                                <div class="color-picker-wrapper invoice-inputs" style="background-color: #0064fb">

                                                    <input type="color" name="project_color" value="#0064fb" class="color-picker" list="presetColors" style="width: 100%;">
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
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <table class="table shipping_details">
                                        <tr>
                                            <th colspan="4">Project Description :</th>
                                        </tr>
                                        <tr>
                                            <td class="text-center" width="25px"><i class="fas fa-file-signature"></i></td>
                                            <td class="td-border"><textarea class="invoice-inputs" id="project_description" name="project_description" type='text' rows="10" value='' style="margin-top: 5px; margin-bottom: 7px;"></textarea></td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-6" >
                                    <table class="table shipping_details" >
                                        <tr>
                                            <th colspan="4">Assignees :</th>
                                        </tr>
                                        <tr colspan="4">
                                            <td>
                                                <select class="invoice-inputs select2-new-project" name="assignee" id="assignee" onchange="selectAssignee()">
                                                    <option value="">Select the Project assignee</option>
                                                    @foreach ($users as $users)
                                                        <option value="{{ $users->id }}">{{ $users->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr colspan="4">
                                            <td class="td-border"><textarea class="invoice-inputs" id="project_assignee" name="project_assignee" type='text' rows="8" value='' style="margin-top: 4px; margin-bottom: 4px;"></textarea></td>
                                            <td><textarea class="invoice-inputs" id="project_assignee_id" name="project_assignee_id" type='text' rows="8" value='' style="margin-top: 4px; margin-bottom: 4px; width: 178%;" hidden></textarea></td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 control-btns mt-3 no-print">
                        <button type="submit" class="btn btn-success btn-custom">Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<input type="hidden" id="from_project_create_page" value="1"/>
<input type="hidden" id="organization_id_from_contact" value="{{app('request')->input('organization_id')}}"/>

{{-- Comment by Sanjeewa --}}
{{-- @include('pages.project_management.new_project.add_item_modal') --}}
{{-- @include('pages.contacts.modals.people_create_modal') --}}
{{-- @include('pages.contacts.modals.organization_create_modal') --}}

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

var selectedOptions = [];
var selectedOptions1 = [];

    function selectAssignee() {
        var dropdown = document.getElementById("assignee");
        var textArea = document.getElementById("project_assignee");
        var textArea1 = document.getElementById("project_assignee_id");
        var selectedOption = dropdown.options[dropdown.selectedIndex].text;
        var selectedOption1 = dropdown.options[dropdown.selectedIndex].value;
        selectedOptions.push(selectedOption);
        selectedOptions1.push(selectedOption1);
        textArea.value = selectedOptions.join("\n");
        textArea1.value = selectedOptions1.join("\n");
    }

    $(document).ready(function(){

        $('.select2-new-project').select2();

        $('.color-picker').change(function(){
            $(this).parent().css('background-color', $(this).val());
        });
    });



</script>
