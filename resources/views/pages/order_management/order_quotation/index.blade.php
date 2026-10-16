@extends('layouts.app', ['activePage' => 'order_details', 'titlePage' => __('Quotation')])

@section('content')
    <div class="container-fluid mt-5">
        <div class="col-md-12 mt-5">
            <div class="float-left">
                <div class="btn-group">
                    <select class="form-control btn-secondary btn-secondary-custom" id="order_no" name="order_no" searchable="Search here..">
                        <option>Select an Order No</option>
                        @foreach ($newOrders as $order)
                            <option value="{{$order->id}}">{{$order->order_no}}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-success btn-sm form-control text-small" id="quatation" style="width: 180px"><i class="fas fa-search"></i> Generate Quotation</button>
                </div>
            </div>

            <div class="float-right">
                <div class="btn-group">
                    <button type="button" class="btn btn-secondary btn-secondary-custom dropdown-toggle" title="Customize" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-wrench"></i> Customize</button>
                    <div class="dropdown-menu organiztions-dropdown-menu">
                        <a class="dropdown-item" href="#">Organiztions Fields &amp; Layouts</a>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12 mt-6 alphabet">
            <a href="#"><button type="button" class="btn btn-secondary btn-secondary-custom no-space" >All</button></a>
            <button type="button" value="A" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> A </button>
            <button type="button" value="B" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> B </button>
            <button type="button" value="C" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> C </button>
            <button type="button" value="D" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> D </button>
            <button type="button" value="E" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> E </button>
            <button type="button" value="F" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> F </button>
            <button type="button" value="G" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> G </button>
            <button type="button" value="H" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> H </button>
            <button type="button" value="I" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> I </button>
            <button type="button" value="J" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> J </button>
            <button type="button" value="K" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> K </button>
            <button type="button" value="L" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> L </button>
            <button type="button" value="M" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> M </button>
            <button type="button" value="N" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> N </button>
            <button type="button" value="O" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> O </button>
            <button type="button" value="P" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> P </button>
            <button type="button" value="Q" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> Q </button>
            <button type="button" value="R" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> R </button>
            <button type="button" value="S" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> S </button>
            <button type="button" value="T" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> T </button>
            <button type="button" value="U" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> U </button>
            <button type="button" value="V" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> V </button>
            <button type="button" value="W" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> W </button>
            <button type="button" value="X" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> X </button>
            <button type="button" value="Y" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> Y </button>
            <button type="button" value="Z" class="btn btn-secondary btn-secondary-custom no-space sortByAlphabet"> Z </button>
        </div>

        <div class="col-md-12 mt-3">
            <div class="table-responsive">
                <table class="table align-items-center" id="orders_table">
                    <thead class="thead-light filters">
                        <th>Quotation #</th>
                        <th>Organization</th>
                        <th>Support Agent</th>
                        <th>Total ($)</th>
                        <th>Status</th>
                    </thead>

                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td><a href="#" class="edit-order" data-value="{{$order->id}}">{{$order->order_no}}</a></td>
                            <td>{{$order->organizationDetails['organization_name']}}</td>
                            <td>{{$order->userDetails['name']}}</td>
                            <td>{{number_format($order->order_total, 2)}}</td>
                            <td>{{$order->statusDetails['status_name']}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            // Edit Order
            $("body").on("click", ".edit-order", function(){
                var orderId = $(this).data('value');
                window.location.replace('order_details/search/'+orderId);
            });

            $("body").on("click", "#quatation", function(){
                var quoteId = $('#order_no').val();
                window.location.replace('orders/addQuation/'+quoteId);
            });

            // View Order
            $("body").on("click", ".view-order", function(){
                var orderId = $(this).val();
                window.location.replace('orders/info/'+orderId);
            });
        });
    </script>
@endsection
