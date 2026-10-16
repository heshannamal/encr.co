@extends('layouts.app', ['activePage' => 'projects', 'titlePage' => __('My Tasks Board')])

@section('content')
<style>
    .board-col-header {
        font-weight: 500;
        font-size: 0.95em;
        border-bottom: 1px solid #bbb;
        background: #fff;
        color: #222;
        letter-spacing: 0.01em;
        padding: 1rem 1rem 0.7rem 1rem;
    }
    .board-col-header.dark {
        background: #2b2b2b;
        color: #fff;
        border-bottom: none;
    }
    .board-task-card {
        position: relative;
        min-height: 70px;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        margin-bottom: 1.1rem;
    }
    .board-task-card .card-top-line {
        height: 3px;
        width: 40px;
        border-radius: 2px;
        background: #e91e63;
        position: absolute;
        top: 0.7rem;
        left: 1.1rem;
    }
    .board-task-card .card-top-line.purple { background: #e91e63; }
    .board-task-card .card-top-line.blue { background: #7c5fff; }
    .board-task-card .card-top-line.cyan { background: #2196f3; }
    .board-task-label {
        font-weight: 500;
        color: #222;
        margin-top: 0.7rem;
        margin-bottom: 0.2rem;
        font-size: 0.8rem;
    }
    .board-task-label .label-bold {
        font-weight: 700;
    }
    .board-task-label .label-blue { color: #7c5fff; }
    .board-task-label .label-cyan { color: #2196f3; }
    .board-task-desc {
        color: #222;
        font-size: 0.8rem;
        margin-bottom: 0.2rem;
    }
    .board-task-meta {
        color: #888;
        font-size: 0.75rem;
        margin-top: 0.1rem;
    }
    .board-add-section {
        color: #bbb;
        background: none;
        border: none;
        font-size: 1rem;
        margin-left: 1.2rem;
        margin-top: 1.5rem;
        cursor: pointer;
        text-align: left;
        font-weight: 500;
    }
</style>
<div class="container-fluid mb-5 content-position">
    <div class="row gy-4 gx-3 mt-4 flex-nowrap overflow-auto">
        <div class="col-12 col-sm-6 col-md-4 col-lg-3" style="min-width:320px;max-width:340px;">
            <div class="card mb-3">
                <div class="board-col-header rounded">Recently Assigned | 5</div>
            </div>
            <div class="card">
                <div class="card-body p-2">
                    <div class="board-task-card card mb-3 p-3">
                        <div class="card-top-line purple"></div>
                        <div class="board-task-label">Customer</div>
                        <div class="board-task-meta">UI</div>
                    </div>
                    <div class="board-task-card card mb-3 p-3">
                        <div class="card-top-line purple"></div>
                        <div class="board-task-label">Customer</div>
                    </div>
                    <div class="board-task-card card mb-3 p-3">
                        <div class="card-top-line blue"></div>
                        <div class="board-task-label"><span class="label-bold label-blue">First:</span> Get Started Using My Tasks</div>
                    </div>
                    <div class="board-task-card card mb-3 p-3">
                        <div class="card-top-line cyan"></div>
                        <div class="board-task-label"><span class="label-bold label-cyan">Second:</span> Find The Layout That's Right For You</div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0">
                    <button class="btn btn-outline-secondary w-100 board-add-task">+ Add Task</button>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3" style="min-width:320px;max-width:340px;">
            <div class="card mb-3">
                <div class="board-col-header rounded">Do Today | 0</div>
            </div>
            <div class="card">
                <div class="card-body p-2"></div>
                <div class="card-footer bg-white border-0">
                    <button class="btn btn-outline-secondary w-100 board-add-task">+ Add Task</button>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3" style="min-width:320px;max-width:340px;">
            <div class="card mb-3">
                <div class="board-col-header rounded">Do Next Week | 0</div>
            </div>
            <div class="card">
                <div class="card-body p-2"></div>
                <div class="card-footer bg-white border-0">
                    <button class="btn btn-outline-secondary w-100 board-add-task">+ Add Task</button>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3" style="min-width:320px;max-width:340px;">
            <div class="card mb-3">
                <div class="board-col-header rounded">Do Later | 0</div>
            </div>
            <div class="card">
                <div class="card-body p-2"></div>
                <div class="card-footer bg-white border-0">
                    <button class="btn btn-outline-secondary w-100 board-add-task">+ Add Task</button>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <button class="board-add-section ms-2">+ Add Section</button>
        </div>
    </div>
</div>
@endsection
