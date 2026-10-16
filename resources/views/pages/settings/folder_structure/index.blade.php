@extends('layouts.app', ['activePage' => 'folder_structure', 'titlePage' => __('Folder Structure')])

@section('content')
<style>
    .folder-toggle:hover {
        color: #007bff;
        text-decoration: underline;
    }
</style>
<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Folder Structure</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="row m-1">
                <ul>
                    @include('pages.settings.folder_structure.partials.folder_node', ['node' => $structure])
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.folder-toggle').forEach(function(toggle) {
            toggle.addEventListener('click', function() {
                const nested = this.nextElementSibling;
                if (!nested) return;
                if (nested.style.display === 'none') {
                    nested.style.display = 'block';
                    this.querySelector('.toggle-sign').textContent = '[-]';
                } else {
                    nested.style.display = 'none';
                    this.querySelector('.toggle-sign').textContent = '[+]';
                }
            });
        });
    });
</script>

@endsection



