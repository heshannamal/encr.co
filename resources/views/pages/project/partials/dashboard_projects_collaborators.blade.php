@foreach ($collaborators as $collaborator)
    <div class="col-md-3 d-flex align-items-center mb-2">
        <a href="{{ url('/view/employee/profile/' . $collaborator['id']) }}">
            <div class="rounded-circle d-flex align-items-center justify-content-center mr-2" style="width:45px;height:45px; overflow:hidden;">
                <img src="{{ asset($collaborator['image']) }}" alt="" style="width:100%; height:100%; object-fit:cover;">
                {{-- <i class="fa fa-user fa-2x text-white"></i> --}}
            </div>
        </a>
        <span class="ms-2">{{ $collaborator['name'] }}</span>
    </div>
    
@endforeach
