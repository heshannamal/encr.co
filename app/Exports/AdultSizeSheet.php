<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemsDetail;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\OrderItemsDetailPlayerName;

class AdultSizeSheet implements FromView
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
                'embellishmentDetails', 'orderItemDetails.sizeDetails', 'orderItemDetails.playerDetails')
                ->where('id', $id)->first();


        $orderItemsDetails = OrderItem::with('orderItemDetails.sizeDetails', 'orderItemDetails.playerDetails')
        ->where('id', $id)->first();

        $adultItems = [];
        $youthItems = [];

        foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail) {
            $sizeName = $orderItemDetail->sizeDetails['size_name'];
            if (strpos($sizeName, 'Adult') === 0) {
                $adultItems[] = $orderItemDetail;
            } elseif (strpos($sizeName, 'Youth') === 0) {
                $youthItems[] = $orderItemDetail;
            }
        }

        $order = Order::with('organizationDetails', 'userDetails', 'contactDetails')->find($orderItem->order_id);

        $blackQty = OrderItemsDetail::where('order_item_id', $orderItem->id)->sum('blanks');

        $numQty = OrderItemsDetail::where('order_item_id', $orderItem->id)->sum('qty');

        return view('pages.order_management.order_quotation.adult_size_csv', [
            'order'=>$order, 'orderItem'=>$orderItem, 'blackQty'=>$blackQty, 'numQty'=>$numQty, 'adultItems'=>$adultItems, 'orderItemsDetails'=>$orderItemsDetails
        ]);

    }
}
