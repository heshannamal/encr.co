@extends('layouts.app', ['activePage' => 'under_contruction', 'titlePage' => __('Under Contruction')])

@section('content')
<style>
    .container-fluid.mb-5 {
        display: flex;
        height: 60vh;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .contruction-text {
        color: #a5a5a5;
        text-transform: uppercase;
        font-family: sans-serif;
        margin: 0rem;
    }
</style>

<div class="container-fluid mb-5">
    <h1 class="contruction-text">Coming Soon</h1>
    <h6 class="contruction-text">This page is under contruction</h6>
</div>
@endsection
