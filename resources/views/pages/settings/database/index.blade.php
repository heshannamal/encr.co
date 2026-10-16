@extends('layouts.app', ['activePage' => 'Database_Settings', 'titlePage' => __('Database Settings')])

@section('content')
<style>
    .card{
        border: none;
        border-radius: 0rem;
    }
    .font-color{
        color: #979797;
    }
    .border-buttom{
        border-bottom: 1px solid rgba(0, 0, 0, .1);
    }
    .mini-card{
        border: 1px solid rgba(43, 43, 43, 0.548);
        margin: 5px;
        padding: 15px;
        cursor: pointer;
    }
    .activecard{
        border-color:#418d47;
        background-color: #28b63456;
        border: 2px solid;
    }
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
        display: none;
    }
</style>
<div class="container-fluid mb-5 content-position" >
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Database Settings</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="row m-1">
                <div class="col-12">

                    <p class="font-color border-buttom">Select enviroment</p>

                </div>
            </div>

            <div class="row m-1">
                {{-- <div class="col-12"> --}}

                    <div class=" col-3.5 mini-card cardchange {{ $databasename === 'testing' ? 'activecard' : '' }}" data-name="testing">
                        <h2>Testing Database</h2>
                        <p>Database name : {{$test_databasename}}</p>
                    </div>
                    <div class=" col-3.5 mini-card cardchange {{ $databasename === 'live' ? 'activecard' : '' }}" data-name="live">
                        <h2>Live Database</h2>
                        <p>Database name : {{$live_databasename}}</p>
                    </div>
                    <div class=" col-3.5 mini-card cardchange {{ $databasename === 'development' ? 'activecard' : '' }}" data-name="development">
                        <h2>Development Database</h2>
                        <p>Database name : {{$dev_databasename}}</p>
                    </div>

                {{-- </div> --}}
            </div>
        </div>
    </div>
</div>
<script>
$('.cardchange').on('click', function () {
    var database_name = $(this).data('name');
    var current_database = "{{ $databasename }}"; // coming from blade
    var user_id = "{{ auth()->id() }}";

    var isLiveChange =
        (current_database === 'live' || database_name === 'live') ;

    if (isLiveChange) {
        Swal.fire({
            title: 'Confirm Password',
            input: 'password',
            inputLabel: 'Enter your password to switch database',
            inputAttributes: {
                autocapitalize: 'off',
                autocomplete: 'current-password'
            },
            showCancelButton: true,
            confirmButtonText: 'Confirm',
            showLoaderOnConfirm: true,
            preConfirm: (password) => {
                return $.ajax({
                    url: "{{ route('configuration.database.password.change') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        database_name: database_name,
                        password: password
                    }
                }).then(response => {

                        return response.message;

                })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then(result => {
            console.log(result);

            if (result.value == "Database changed successfully.") {
                Swal.fire('Success', result.value, 'success').then(() => {
                    location.reload();
                });
            }else if(result.dismiss){
 location.reload();
            }else{
                Swal.fire(
                        'password Wrong!',
                        'Fail to change Database!',
                        'error'
                    ).then(() => {
                        location.reload();
                    });
            }
        });
    }
    else {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to switch to the '" + database_name + "' database?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{ url('configuration/database/change') }}/" + database_name,
                    method: 'GET',
                    dataType: 'json',
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (data) {
                        Swal.fire('Success', data, 'success').then(() => {
                            location.reload();
                        });
                    },
                    complete: function () {
                        $(".se-pre-con").fadeOut('slow');
                    }
                });
            }
        });
    }
});


</script>
@endsection
