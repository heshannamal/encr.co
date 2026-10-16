@extends('layouts.app', ['activePage' => 'user_groups', 'titlePage' => __('Creating User Groups')])

@section('content')
    <div class="container-fluid mt-5">
        <form action="{{ route('user_groups.create') }}" method="post">
            @csrf

            <div class="card mb-2">
                <div class="card-header">User Groups</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 form-field">
                            <label class="form-lable">User Group Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-input" id="user_group_name" name="user_group_name" required />
                        </div>

                        <div class="col-md-6 form-field">
                            <label class="form-lable">Narration</label>
                            <textarea type="text" class="form-control form-input" id="narration" name="narration" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer"></div>
            </div>

            <div class="col-lg-12 control-btns mb-5">
                <button type="submit" class="btn btn-success btn-custom">Save</button>
                <button type="reset" class="btn btn-secondary btn-custom">Cancel</button>
            </div>
        </form>
    </div>
@endsection