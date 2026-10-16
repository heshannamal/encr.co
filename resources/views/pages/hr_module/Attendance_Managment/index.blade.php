@extends('layouts.app', ['activePage' => 'Attendance_Managment', 'titlePage' => __('Attendance Managment')])

@section('content')
<style>

</style>

@if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>ATTENDANCE MANAGMENT</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection


    <div class="col-md-12">
        <div class="card">

        </div>
    </div>
</div>


@endsection
