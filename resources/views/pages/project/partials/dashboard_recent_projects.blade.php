{{-- <div class="col-6 d-flex align-items-center mb-2 pointer">
    <div class="project-icon create-project-icon me-3 mr-2">
        <div class="create-project-icon-square"></div>
    </div>
    <span class="fw-medium">Create project</span>
</div> --}}
@if (count($projects) > 0)

@foreach ($projects as $project)
    <div class="col-6 mb-2">
        <a class="d-flex align-items-center" href="{{ route('projects.view.temp', $project->id) }}">
            <div class="project-icon me-3 mr-2" style="background-color: {{ $project->project_color ?? '#b5b5b5' }}">
                @if ($project->project_icon_url)
                    <img src="{{ $project->project_icon_url }}" alt="Project Icon" style="width: 100%; height: 100%; object-fit: contain;">
                @else
                    <i class="fa fa-server" style="color:#fff; font-size: smaller;"></i>
                @endif
            </div>
            <span class="fw-medium">{{ $project->display_name }}</span>
        </a>
    </div>
@endforeach
@else
<div class="col-md-12 text-center text-muted">
    <i>No Projects</i>
</div>
@endif
