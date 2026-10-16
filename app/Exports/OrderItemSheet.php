<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemsDetail;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrderItemSheet implements FromView
{
    private $id;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }

    public function __construct(int $id)
    {
        $this->id = $id;
    }
    public function view(): View
    {
        $id = $this->id;
        $orderItem = OrderItem::with('productDetails', 'factoryDetails', 'exFactoryDetails', 'fabricDetails', 'secFabricDetails',
                'embellishmentDetails', 'orderItemDetails.sizeDetails')
                ->where('id', $id)->first();

        $order = Order::with('organizationDetails', 'userDetails', 'contactDetails')->find($orderItem->order_id);

        $blackQty = OrderItemsDetail::where('order_item_id', $orderItem->id)->sum('blanks');

        $numQty = OrderItemsDetail::where('order_item_id', $orderItem->id)->sum('qty');

        return view('pages.order_management.order_quotation.order_item_csv', [
            'order'=>$order, 'orderItem'=>$orderItem, 'blackQty'=>$blackQty, 'numQty'=>$numQty
        ]);

    }
}
