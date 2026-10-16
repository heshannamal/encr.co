@extends('layouts.app', ['activePage' => 'home', 'titlePage' => __('Dashboard')])

@section('content')
    <style>
        .dropdown-content {
            display: none;
            position: absolute;
            top: 31px;
            left: 128px;
            background-color: #ffffff;
            min-width: 125px;
            overflow: auto;
            box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.1);
            z-index: 1;
            padding: 10px 10px;
        }
        .dropdown-content button {
            padding: 5px 5px;
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 1px solid #eeeeee;
            border-radius: 3px;
        }
        .dropdown-content button:focus {
            outline: none;
        }
        .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
        }
    </style>

    <div class="container-fluid mb-5">
        <div class="se-pre-con"></div>

        <div class="col-md-12 mt-4">
            <div class="card">
                {{-- <div class="card-header">
                    <div class="card-header-danger col-md-12">
                        <h1 class="float-left header-title">Home</h1>
                    </div>
                </div> --}}

                <div class="card-body">
                    <div class="accordion-header">
                        <button type="button" class="accordion"><i class="fas fa-caret-down"></i> Tasks Due Soon</button>
                        <button type="button" class="change-view"><i class="fas fa-list"></i></button>
                    </div>
                    <div class="panel">
                        <p style="color: #bbbaba;">No tasks due in the next five days</p>
                    </div>

                    <div class="accordion-header">
                        <button type="button" class="accordion"><i class="fas fa-caret-down"></i> Orders</button>
                        <button type="button" class="change-view"><i class="fas fa-list"></i></button>
                    </div>
                    <div class="panel">
                        <div class="row">
                            {{-- {{ dd($orders) }} --}}
                            @foreach ($orders as $order)
                                <div class="order-container">
                                    <button type="button" class="tile-menu order-color" value="{{$order->id}}"><i class="fas fa-ellipsis-h"></i></button>
                                    <div class="dropdown-content color-palette {{$order->id}}">
                                        <button type="button" class="color-pick" style="background-color: #f6f8f9" data-color="f6f8f9" value="{{$order->id}}"></button>
                                        <button type="button" class="color-pick" style="background-color: #fb5779" data-color="fb5779" value="{{$order->id}}"></button>
                                        <button type="button" class="color-pick" style="background-color: #ff7510" data-color="ff7510" value="{{$order->id}}"></button>
                                        <button type="button" class="color-pick" style="background-color: #ffa800" data-color="ffa800" value="{{$order->id}}"></button>
                                        <button type="button" class="color-pick" style="background-color: #ffd101" data-color="ffd101" value="{{$order->id}}"></button>
                                        <button type="button" class="color-pick" style="background-color: #ace610" data-color="ace610" value="{{$order->id}}"></button>
                                        <button type="button" class="color-pick" style="background-color: #19db7d" data-color="19db7d" value="{{$order->id}}"></button>
                                        <button type="button" class="color-pick" style="background-color: #00D4CB" data-color="00D4CB" value="{{$order->id}}"></button>
                                        <button type="button" class="color-pick" style="background-color: #48dafd" data-color="48dafd" value="{{$order->id}}"></button>
                                        <button type="button" class="color-pick" style="background-color: #0064fb" data-color="0064fb" value="{{$order->id}}"></button>
                                        <button type="button" class="color-pick" style="background-color: #6458f9" data-color="6458f9" value="{{$order->id}}"></button>
                                        <button type="button" class="color-pick" style="background-color: #A147E4" data-color="A147E4" value="{{$order->id}}"></button>
                                        <button type="button" class="color-pick" style="background-color: #ff78ff" data-color="ff78ff" value="{{$order->id}}"></button>
                                        <button type="button" class="color-pick" style="background-color: #ff4ba6" data-color="ff4ba6" value="{{$order->id}}"></button>
                                        <button type="button" class="color-pick" style="background-color: #ff93af" data-color="ff93af" value="{{$order->id}}"></button>
                                        <button type="button" class="color-pick" style="background-color: #5a7896" data-color="5a7896" value="{{$order->id}}"></button>
                                    </div>
{{-- {{ dd($order) }} --}}
                                    <a href="{{ url('order_details/edit') }}/{{$order->id}}/order?active_tab=order" class="order-link">
                                        <div class="project-container">
                                            <div class="tile-icon">

                                                <div class="tile-card {{$order->id}}" style="background-color: {{$order->flag}}">
                                                    @foreach ($organizations as $organization)
                                                        @if($order->organization_id == $organization->id)
                                                            @foreach ($sports as $sport)
                                                                @if($organization->sport == $sport->sport_name)
                                                                    <img class="tile-thumbnail" src="{{ asset('assets') }}/{{ $sport->sport_image }}" />
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                    {{-- <img src="{{asset('argon')}}/img/icons/lacrosse.png" class="tile-thumbnail"> --}}
                                                </div>
                                            </div>
                                            <div class="tile-title">#{{$order->order_no}}<br>{{$order->organizationDetails['organization_name']}}</div>
                                            <div class="tile-subtitle">{{$order->order_description}}</div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $(".se-pre-con").fadeOut('slow');
            $('.panel').css('display', 'block');
        });

        $('.accordion').on('click', function(){
            if($(this).parent().next('.panel').css('display') == 'block'){
                $(this).parent().next('.panel').css('display', 'none');
                $(this).children().removeClass('fa-caret-down');
                $(this).children().addClass('fa-caret-right');

            } else {
                $(this).parent().next('.panel').css('display', 'block');
                $(this).children().addClass('fa-caret-down');
                $(this).children().removeClass('fa-caret-right');
            }
        });

        // Toggle color palette
        $('.tile-menu').on('click', function(){
            $('.color-palette').hide();
            var orderId = $(this).val();
            $('.color-palette.'+orderId).show();
        });

        $(document).mouseup(function(e){
            if (!$('.color-palette').is(e.target) && $('.color-palette').has(e.target).length === 0) {
                $('.color-palette').hide();
                $('.color-palette').unbind('click');
            }
        });

        // Change order flag
        $('.color-pick').on('click', function(){
            var orderId = $(this).val();
            var color_code = $(this).data('color');

            $.ajax({
                url: "{{ url('change_flag') }}",
                type: "POST",
                data: {
                    'orderId':orderId, 'color_code':color_code, '_token':'{{csrf_token()}}'
                },
                success: function (data) {
                    console.log(data);
                    $('.tile-card.'+orderId).css('background-color', '#'+color_code)
                }
            });
        });

        let header = "HOME";
        document.getElementById("header").innerHTML = header;
    </script>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
