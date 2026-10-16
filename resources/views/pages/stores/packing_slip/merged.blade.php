@foreach($orders as $order)
    @include('pages.stores.packing_slip.single', ['order' => $order])
@endforeach
