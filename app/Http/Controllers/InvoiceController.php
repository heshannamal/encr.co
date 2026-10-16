<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemsDetail;
use App\Models\EmbellishmentType;

class InvoiceController extends Controller
{
    public function index(){
        $orders = Order::with('organizationDetails', 'userDetails', 'statusDetails')->where('order_status_id', 3)->where('active', 1)->get();

        $newOrders = Order::select('id', 'order_no')->where('order_status_id', 2)->where('active', 1)->get();

        $embellishmentTypes = EmbellishmentType::where('active', 1)->get();

        $emptyInvoice = 0;

        return view('pages.order_management.invoice.index', [
                    'orders'=>$orders,'newOrders'=>$newOrders, 'emptyInvoice'=>$emptyInvoice, 'embellishmentTypes'=>$embellishmentTypes
        ]);
    }

    public function search($orderId){
        $emptyInvoice = $orderId;

        $orderDetails = Order::with('orderItems', 'orderItems.orderItemDetails', 'orderItems.productDetails',
                                    'orderItems.embellishmentDetails', 'orderItems.orderItemDetails.sizeDetails',
                                    'orderItems.factoryDetails', 'organizationDetails', 'contactDetails')
                             ->where('orders.id', $orderId)->get();

        $orders = Order::select('id', 'order_no')->where('active', 1)->get();

        $embellishmentTypes = EmbellishmentType::where('active', 1)->get();

        return view('pages.order_management.invoice.info', [
                    'orders'=>$orders, 'orderDetails'=>$orderDetails, 'emptyInvoice'=>$emptyInvoice,
                    'embellishmentTypes'=>$embellishmentTypes
        ]);
    }

    public function updateOrderSeqData(Request $request){
        foreach($request->product as $productDetails){
            $OrderItemsDetail = OrderItemsDetail:: find($productDetails['orderNo']);
            $OrderItemsDetail->qty = $productDetails['qty'];
            $OrderItemsDetail->numseq_one = $productDetails['numseq_one'];
            $OrderItemsDetail->numseq_two = $productDetails['numseq_two'];
            $OrderItemsDetail->numseq_three = $productDetails['numseq_three'];
            $OrderItemsDetail->numseq_four = $productDetails['numseq_four'];
            $OrderItemsDetail->numseq_five = $productDetails['numseq_five'];
            $OrderItemsDetail->numseq_six = $productDetails['numseq_six'];
            $OrderItemsDetail->numseq_seven = $productDetails['numseq_seven'];
            $OrderItemsDetail->numseq_eight = $productDetails['numseq_eight'];
            $OrderItemsDetail->numseq_nine = $productDetails['numseq_nine'];
            $OrderItemsDetail->numseq_ten = $productDetails['numseq_ten'];
            $OrderItemsDetail->numseq_eleven = $productDetails['numseq_eleven'];
            $OrderItemsDetail->numseq_twelve = $productDetails['numseq_twelve'];
            $OrderItemsDetail->numseq_thirteen = $productDetails['numseq_thirteen'];
            $OrderItemsDetail->numseq_fourteen = $productDetails['numseq_fourteen'];
            $OrderItemsDetail->numseq_fifteen = $productDetails['numseq_fifteen'];
            $OrderItemsDetail->numseq_sixteen = $productDetails['numseq_sixteen'];
            $OrderItemsDetail->numseq_seventeen = $productDetails['numseq_seventeen'];
            $OrderItemsDetail->numseq_eighteen = $productDetails['numseq_eighteen'];
            $OrderItemsDetail->numseq_nineteen = $productDetails['numseq_nineteen'];
            $OrderItemsDetail->numseq_twenty = $productDetails['numseq_twenty'];
            $OrderItemsDetail->numseq_twenty_one = $productDetails['numseq_twenty_one'];
            $OrderItemsDetail->numseq_twenty_two = $productDetails['numseq_twenty_two'];
            $OrderItemsDetail->numseq_twenty_three = $productDetails['numseq_twenty_three'];
            $OrderItemsDetail->numseq_twenty_four = $productDetails['numseq_twenty_four'];
            $OrderItemsDetail->numseq_twenty_five = $productDetails['numseq_twenty_five'];
            $OrderItemsDetail->numseq_twenty_six = $productDetails['numseq_twenty_six'];
            $OrderItemsDetail->numseq_twenty_seven = $productDetails['numseq_twenty_seven'];
            $OrderItemsDetail->numseq_twenty_eight = $productDetails['numseq_twenty_eight'];
            $OrderItemsDetail->numseq_twenty_nine = $productDetails['numseq_twenty_nine'];
            $OrderItemsDetail->numseq_thirty = $productDetails['numseq_thirty'];
            $OrderItemsDetail->numseq_thirty_one = $productDetails['numseq_thirty_one'];
            $OrderItemsDetail->numseq_thirty_two = $productDetails['numseq_thirty_two'];
            $OrderItemsDetail->numseq_thirty_three = $productDetails['numseq_thirty_three'];
            $OrderItemsDetail->numseq_thirty_four = $productDetails['numseq_thirty_four'];
            $OrderItemsDetail->numseq_thirty_five = $productDetails['numseq_thirty_five'];
            $OrderItemsDetail->numseq_thirty_six = $productDetails['numseq_thirty_six'];
            $OrderItemsDetail->numseq_thirty_seven = $productDetails['numseq_thirty_seven'];
            $OrderItemsDetail->numseq_thirty_eight = $productDetails['numseq_thirty_eight'];
            $OrderItemsDetail->numseq_thirty_nine = $productDetails['numseq_thirty_nine'];
            $OrderItemsDetail->numseq_forty = $productDetails['numseq_forty'];
            $OrderItemsDetail->numseq_forty_one = $productDetails['numseq_forty_one'];
            $OrderItemsDetail->numseq_forty_two = $productDetails['numseq_forty_two'];
            $OrderItemsDetail->numseq_forty_three = $productDetails['numseq_forty_three'];
            $OrderItemsDetail->numseq_forty_four = $productDetails['numseq_forty_four'];
            $OrderItemsDetail->numseq_forty_five = $productDetails['numseq_forty_five'];
            $OrderItemsDetail->numseq_forty_six = $productDetails['numseq_forty_six'];
            $OrderItemsDetail->numseq_forty_seven = $productDetails['numseq_forty_seven'];
            $OrderItemsDetail->numseq_forty_eight = $productDetails['numseq_forty_eight'];
            $OrderItemsDetail->numseq_forty_nine = $productDetails['numseq_forty_nine'];
            $OrderItemsDetail->numseq_fifty = $productDetails['numseq_fifty'];
            $OrderItemsDetail->save();
        }

        $orderId = $request->item_id;
        $emptyInvoice = $orderId;

        $orderDetails = Order::with('orderItems', 'orderItems.orderItemDetails', 'orderItems.productDetails', 'orderItems.fabricDetails', 'orderItems.orderItemDetails.sizeDetails', 'contactDetails')
                             ->where('orders.id', $orderId)->get();

        $orders = Order::select('id', 'order_no')->where('active', 0)->get();

        $embellishmentTypes = EmbellishmentType::where('active', 1)->get();

        return view('pages.order_management.order_details', ['orders'=>$orders, 'orderDetails'=>$orderDetails, 'emptyInvoice'=>$emptyInvoice, 'embellishmentTypes'=>$embellishmentTypes]);

    }

    public function addInvoice($id){
        $OrderItemsDetail = Order:: find($id);
        $OrderItemsDetail->order_status_id = 3;
        $OrderItemsDetail->update();
        return redirect()->route('invoice');
    }

    public function info($id){
        $orders = Order::with('organizationDetails', 'userDetails', 'statusDetails', 'contactDetails', 'orderItems',
                              'orderItems.productDetails', 'orderItems.statusDetails')
                       ->where('id', $id)
                       ->get();

        return view('pages.order_management.invoice.info', ['orders'=>$orders]);
    }

    public function delete($id){
        $order = Order::find($id);
        $order->active = 0;
        $order->update();

        return redirect()->route('invoice')->withSuccess('Invoice Delete Successfully!');
    }
}
