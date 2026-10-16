@extends('layouts.app', ['activePage' => 'project_overview', 'titlePage' => __('Project Overview')])

@section('content')
<style>
    .overview-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        padding: 2rem 1.5rem 1.5rem 1.5rem;
        font-size: 0.8rem;
        margin-top: 1.5rem;
    }
    .overview-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.2rem;
    }
    .overview-title {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        font-weight: 700;
        font-size: 1rem;
    }
    .overview-title-icon {
        background: #f7b6e6;
        border-radius: 50%;
        width: 2rem;
        height: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .overview-tabs {
        display: flex;
        gap: 1.2rem;
        border-bottom: 2px solid #222;
        margin-bottom: 1.5rem;
        font-size: 0.8rem;
        font-weight: 600;
    }
    .overview-tabs .tab {
        padding: 0 0.5rem 0.5rem 0.5rem;
        cursor: pointer;
        color: #222;
        border: none;
        background: none;
        border-bottom: 3px solid transparent;
        transition: border-color 0.2s;
    }
    .overview-tabs .tab.active {
        border-bottom: 3px solid #222;
        color: #222;
    }
    .overview-back-btn {
        border: 1px solid #222;
        border-radius: 20px;
        padding: 0.2rem 1.2rem;
        background: #fff;
        color: #222;
        font-weight: 600;
        font-size: 0.8rem;
        margin-left: 1rem;
        transition: background 0.2s;
    }
    .overview-back-btn:hover {
        background: #f5f5f5;
    }
    .overview-avatar-group {
        display: flex;
        align-items: center;
        gap: 0.2rem;
    }
    .overview-avatar {
        width: 1.5rem;
        height: 1.5rem;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #fff;
        margin-left: -0.5rem;
        box-shadow: 0 0 0 1px #bbb;
    }
    .overview-avatar:first-child {
        margin-left: 0;
    }
    .overview-form-label {
        font-weight: 600;
        margin-bottom: 0.2rem;
    }
    .overview-color-dot {
        width: 1.2rem;
        height: 1.2rem;
        border-radius: 50%;
        display: inline-block;
        margin-right: 0.5rem;
        border: 2px solid #fff;
        cursor: pointer;
        box-shadow: 0 0 0 1px #bbb;
    }
    .overview-color-dot.selected {
        border: 2px solid #e91e63;
        box-shadow: 0 0 0 2px #e91e6333;
    }
    .overview-color-custom {
        display: flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.8rem;
        margin-right: 0.7rem;
    }
    .overview-section-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 0.8rem;
    }
    .overview-assist-list {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .overview-assist-item {
        display: flex;
        align-items: center;
        background: #f4f4f4;
        border-radius: 8px;
        padding: 0.2rem 0.7rem 0.2rem 0.2rem;
        gap: 0.4rem;
        font-size: 0.8rem;
        margin-bottom: 0.2rem;
    }
    .overview-assist-avatar {
        width: 1.3rem;
        height: 1.3rem;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 0.3rem;
    }
    .overview-assist-role {
        font-size: 0.7rem;
        color: #888;
        margin-left: 0.2rem;
    }
    .overview-add-btn {
        background: #fff;
        border: 1.5px solid #bbb;
        border-radius: 50%;
        width: 1.5rem;
        height: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: #888;
        cursor: pointer;
        margin-right: 0.3rem;
    }
    .overview-form-control, .overview-form-select, .overview-form-textarea {
        font-size: 0.8rem;
        border-radius: 6px;
        border: 1px solid #ececec;
        background: transparent;
        padding: 0.4rem 0.7rem;
        width: 100%;
        margin-bottom: 0.7rem;
    }
    .overview-form-textarea {
        min-height: 3.2rem;
        resize: vertical;
    }
    .overview-btn-group {
        display: flex;
        gap: 0.7rem;
        margin-top: 1.2rem;
    }
    .overview-btn {
        font-size: 0.8rem;
        border-radius: 6px;
        padding: 0.3rem 1.2rem;
        border: 1px solid #bbb;
        background: #fff;
        color: #222;
        font-weight: 600;
        transition: background 0.2s;
    }
    .overview-btn-primary {
        background: #222;
        color: #fff;
        border: 1px solid #222;
    }
    .overview-btn-primary:hover {
        background: #444;
        color: #fff;
    }
    .overview-btn:hover {
        background: #f5f5f5;
    }
    @media (max-width: 900px) {
        .overview-header, .overview-tabs {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        .overview-card {
            padding: 1rem 0.5rem;
        }
    }
</style>
<div class="container-fluid mb-5 content-position">
    <div class="overview-header">
        <div class="overview-title">
            <span class="overview-title-icon">
                <i class="fa fa-paint-brush" style="color:#fff; font-size:1rem;"></i>
            </span>
            UI/UX
        </div>
        <div class="overview-avatar-group">
            <img src="{{ asset('assets/img/user/team-4-800x800.jpg') }}" class="overview-avatar" title="User 1">
            <img src="{{ asset('assets/img/user/team-3-800x800.jpg') }}" class="overview-avatar" title="User 2">
            <img src="{{ asset('assets/img/user/team-2-800x800.jpg') }}" class="overview-avatar" title="User 3">
            <img src="{{ asset('assets/img/user/team-1-800x800.jpg') }}" class="overview-avatar" title="User 4">
            <button class="overview-back-btn">BACK</button>
        </div>
    </div>
    <div class="overview-tabs">
        <button class="tab">List</button>
        <button class="tab">Board</button>
        <button class="tab active">Overview</button>
        <button class="tab">Timeline</button>
    </div>
    <div class="overview-card">
        <form>
            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <label class="overview-form-label">Project Name</label>
                    <input type="text" class="overview-form-control form-control" value="UI/UX" placeholder="Project Name" />
                </div>
                <div class="col-12 col-md-6">
                    <label class="overview-form-label">Assist</label>
                    <div class="overview-assist-list mb-2">
                        <span class="overview-add-btn" title="Add Assist"><i class="fa fa-plus"></i></span>
                        <span class="overview-assist-item"><img src="{{ asset('assets/img/user/team-4-800x800.jpg') }}" class="overview-assist-avatar"> Prasad Gunase... <span class="overview-assist-role">Project Admin</span></span>
                        <span class="overview-assist-item"><img src="{{ asset('assets/img/user/team-1-800x800.jpg') }}" class="overview-assist-avatar"> Haritha Wikram... <span class="overview-assist-role">Editor</span></span>
                        <span class="overview-assist-item"><img src="{{ asset('assets/img/user/team-2-800x800.jpg') }}" class="overview-assist-avatar"> Oshadhi <span class="overview-assist-role">Editor</span></span>
                    </div>
                    <textarea class="overview-form-textarea" placeholder="Add description"></textarea>
                </div>
                <div class="col-12 col-md-6">
                    <label class="overview-form-label">Code</label>
                    <input type="text" class="overview-form-control" value="#8765" placeholder="Code" />
                </div>
                <div class="col-12 col-md-6">
                    <label class="overview-form-label">Project description</label>
                    <textarea class="overview-form-textarea" placeholder="Add description"></textarea>
                </div>
                <div class="col-12 col-md-6">
                    <label class="overview-form-label">Color</label>
                    <div class="d-flex align-items-center mb-2">
                        <span class="overview-color-custom"><span class="overview-add-btn"><i class="fa fa-plus"></i></span>Custom<br>Add color</span>
                        <span class="overview-color-dot selected" style="background:#f7b6e6;"></span>
                        <span class="overview-color-dot" style="background:#ff7a7a;"></span>
                        <span class="overview-color-dot" style="background:#ffb74d;"></span>
                        <span class="overview-color-dot" style="background:#ffe066;"></span>
                        <span class="overview-color-dot" style="background:#6ee7b7;"></span>
                        <span class="overview-color-dot" style="background:#4fd1c5;"></span>
                        <span class="overview-color-dot" style="background:#7c5fff;"></span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <label class="overview-form-label">Status</label>
                    <select class="overview-form-select">
                        <option>New</option>
                        <option>In Progress</option>
                        <option>Completed</option>
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <label class="overview-form-label">Type</label>
                    <select class="overview-form-select">
                        <option>Design</option>
                        <option>Development</option>
                        <option>QA</option>
                    </select>
                </div>
            </div>
            <div class="overview-btn-group">
                <button type="reset" class="overview-btn">RESET</button>
                <button type="submit" class="overview-btn overview-btn-primary">UPDATE</button>
            </div>
        </form>
    </div>
</div>
@endsection
