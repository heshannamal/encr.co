{{-- Orders Fields & Layouts --}}
<div class="modal fade" id="layout_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Projects Fields &amp; Layouts</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">

                        <input type="hidden" id="layout_id" name="layout_id" value="{{ $orderLayout['id'] ?? ''}}" />
                        <input type="hidden" id="column_reorder" name="column_reorder" value="{{$columnLayout['id'] ?? 0}}" />

                        {{-- <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="project_no"
                                    title="Order No"
                                    @isset($orderLayout)
                                        @if ($orderLayout['project_no'] == 1) checked @endif
                                    @endisset
                                    @empty($orderLayout) checked @endempty
                                />
                                <label class="custom-control-label" for="project_no">Project #</label>
                            </div>
                        </div> --}}

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input checkbox-style"
                                    id="project_name"
                                    title="Project Name"
                                    @isset($orderLayout)
                                        @if ($orderLayout['project_name'] == 1) checked @endif
                                    @endisset
                                    @empty($orderLayout) checked @endempty
                                />
                                <label class="custom-control-label" for="project_name">Project Name</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="status_name"
                                    title="Factories"
                                    @isset($orderLayout)
                                        @if ($orderLayout['status_name'] == 1) checked @endif
                                    @endisset
                                    @empty($orderLayout) checked @endempty
                                />
                                <label class="custom-control-label" for="status_name">Project Status</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="type_name"
                                    title="Project Type"
                                    @isset($orderLayout)
                                        @if ($orderLayout['type_name'] == 1) checked @endif
                                    @endisset
                                    @empty($orderLayout) checked @endempty
                                />
                                <label class="custom-control-label" for="type_name">Project Type</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input checkbox-style"
                                    id="project_description"
                                    title="Description"
                                    @isset($orderLayout)
                                        @if ($orderLayout['project_description'] == 1) checked @endif
                                    @endisset
                                    @empty($orderLayout) checked @endempty
                                />
                                <label class="custom-control-label" for="project_description">Description</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="assignee"
                                    title="Assignee"
                                    @isset($orderLayout)
                                        @if ($orderLayout['assignee'] == 1) checked @endif
                                    @endisset
                                    @empty($orderLayout) checked @endempty
                                />
                                <label class="custom-control-label" for="assignee">Assignee</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="created_by"
                                    title="Created By"
                                    @isset($orderLayout)
                                        @if ($orderLayout['created_by'] == 1) checked @endif
                                    @endisset
                                    @empty($orderLayout) checked @endempty
                                />
                                <label class="custom-control-label" for="created_by">Created By</label>
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input checkbox-style"
                                    id="created_at"
                                    title="Created At"
                                    @isset($orderLayout)
                                        @if ($orderLayout['created_at'] == 1) checked @endif
                                    @endisset
                                    @empty($orderLayout) checked @endempty
                                />
                                <label class="custom-control-label" for="created_at">Created At</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="updated_at"
                                    title="Updated At"
                                    @isset($orderLayout)
                                        @if ($orderLayout['updated_at'] == 1) checked @endif
                                    @endisset
                                    @empty($orderLayout) checked @endempty
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
