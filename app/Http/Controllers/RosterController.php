<?php

namespace App\Http\Controllers;

use App\Models\CheckPayment;
use Illuminate\Http\Request;
use App\Models\EmbellishmentType;
use App\Models\Fabric;
use App\Models\Factory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemsDetail;
use App\Models\Organization;
use App\Models\PaymentLog;
use App\Models\Product;
use App\Models\SubProduct;
use App\Models\VenmoPayment;
use App\Models\PaypalPayment;
use App\Models\ShippedOrders;
use App\Models\OrderItemsDetailPlayerName;

class RosterController extends Controller
{
    public function index($orderId){
        $emptyInvoice = $orderId;

        $orderDetails = Order::with('orderItems', 'orderItems.orderItemDetails', 'orderItems.productDetails', 'orderItems.orderItemFiles',
                                    'orderItems.embellishmentDetails', 'orderItems.orderItemDetails.sizeDetails',
                                    'orderItems.factoryDetails', 'orderItems.fabricDetails', 'organizationDetails',
                                    'contactDetails', 'orderItems.statusDetails')
                             ->where('orders.id', $orderId)->get();

        $orders = Order::select('id', 'order_no')->where('active', 1)->get();

        $products = Product::where('active', 1)->orderBy('product_name')->get();

        $fabrics = Fabric::where('active', 1)->orderBy('fabric_name')->get();

        $factories = Factory::where('active', 1)->orderBy('factory_name')->get();

        $sub_products = SubProduct::get();

        $embellishmentTypes = EmbellishmentType::where('active', 1)->orderBy('embellishment_name')->get();

        $cardPayment = PaymentLog::where('order_id', $orderId)->sum('amount');
        $checkPayment = CheckPayment::where('order_id', $orderId)->sum('amount');
        $paypalPayement = PaypalPayment::where('order_id', $orderId)->sum('amount');
        $venmoPayment = VenmoPayment::where('order_id', $orderId)->sum('amount');

        $payment = 0;
        if($cardPayment > 0 && $paypalPayement > 0){
            $payment = round($cardPayment - (($orderDetails[0]->order_total * 3)/100),2) + $checkPayment + round($paypalPayement - (($orderDetails[0]->order_total * 3)/100),2) + $venmoPayment;

        } else if ($cardPayment > 0 && $paypalPayement == 0) {
            $payment = round($cardPayment - (($orderDetails[0]->order_total * 3)/100),2) + $checkPayment + $paypalPayement + $venmoPayment;

        } else if ($cardPayment == 0 && $paypalPayement > 0) {
            $payment = $cardPayment + $checkPayment + round($paypalPayement - (($orderDetails[0]->order_total * 3)/100),2) + $venmoPayment;

        } else {
            $payment = $cardPayment + $checkPayment + $paypalPayement + $venmoPayment;
        }

        $balnceToBePaid = 0;
        if ($payment == 0) {
            $paymentStatus = 0; // Pending

        } else if ($payment < $orderDetails[0]->order_total && $payment > 0) {
            $paymentStatus = 1; // Partial
            $balnceToBePaid = $orderDetails[0]->order_total - $payment;

        } else {
            $paymentStatus = 2; // Paid
        }

        $shippedArray = [];
        $ShippedOrders = ShippedOrders::select('id', 'order_id','order_item_id', 'order_item_qty','order_item_shipped_qty', 'order_item_backordered_qty','est_delivery_date', 'order_item_tracking_no')->where('order_id', $orderId)->get();
        foreach($ShippedOrders as $shippedOrder)
        {
            $productID = OrderItem::select('product_id')->where('id', $shippedOrder->order_item_id)->get();
            $productname = Product::select('product_name')->where('id', $productID[0]->product_id)->get();
            $shippedArray[] = array('id' => $shippedOrder->id, 'order_id' => $shippedOrder->order_id, 'order_item_id' => $shippedOrder->order_item_id, 'orderItemName' => $productname[0]->product_name, 'order_item_qty' => $shippedOrder->order_item_qty, 'order_item_shipped_qty' => $shippedOrder->order_item_shipped_qty, 'order_item_backordered_qty' => $shippedOrder->order_item_backordered_qty, 'est_delivery_date' => $shippedOrder->est_delivery_date, 'order_item_tracking_no' => $shippedOrder->order_item_tracking_no);

        }

        $arrayPlayerNames = [];
        $arrayPlayerNamesPattern = array();
        //$mainArrayString = "";
        $orderItemsDetailIds = OrderItemsDetailPlayerName::select('order_items_detail_id')->where('order_id',$orderId)->where('active',1)->distinct()->get();
        foreach($orderItemsDetailIds as $orderItemsDetailId)
        {
            $subArrayString = "";
            $orderItemsDetailIdAllDetails = OrderItemsDetailPlayerName::where('order_items_detail_id',$orderItemsDetailId->order_items_detail_id)->where('active',1)->get();
            foreach($orderItemsDetailIdAllDetails as $orderItemsDetailIdAllDetail)
            {
                if($subArrayString == "")
                {
                    $subArrayString = "\"num$orderItemsDetailIdAllDetail->number_sequence\":\"$orderItemsDetailIdAllDetail->name\"";
                }
                else
                {
                    $subArrayString = $subArrayString . ", \"num$orderItemsDetailIdAllDetail->number_sequence\":\"$orderItemsDetailIdAllDetail->name\"";
                }
            }


            $arrayElemnts = "{".$subArrayString."}";
            array_push($arrayPlayerNames,json_decode($arrayElemnts));
            array_push($arrayPlayerNamesPattern,$orderItemsDetailId->order_items_detail_id);
            //$arrayPlayerNamesPattern
        }




        return view('pages.order_management.roster.index', [
            'emptyInvoice'=>$emptyInvoice, 'orderDetails'=>$orderDetails, 'orders'=>$orders, 'products'=>$products, 'sub_products'=>$sub_products,
            'fabrics'=>$fabrics, 'factories'=>$factories, 'embellishmentTypes'=>$embellishmentTypes, 'paymentStatus'=>$paymentStatus, 'ShippedOrdersDetails'=>$shippedArray, 'balnceToBePaid'=>$balnceToBePaid,'arrayPlayerNames'=>$arrayPlayerNames, 'arrayPlayerNamesPattern'=>$arrayPlayerNamesPattern
        ]);
    }

    public function update(Request $request){
        foreach($request->orderItem as $orderItems){
            $orderItem = OrderItem::find($request->order_item_id);
            $totQty = $orderItems['TOTALqty'];
            $unitPrice = $orderItems['unitprice'];
            $totPrice = $totQty * $unitPrice;

            $orderItem->qty = $totQty;
            $orderItem->total = $totPrice;
            //$orderItem->extra_size = $orderItems['extra_size'];
            //$orderItem->extra_size_two = $orderItems['extra_size_two'];
            //$orderItem->extra_size_three = $orderItems['extra_size_three'];
            if(isset($orderItems['extra_size'])){ $orderItem->extra_size = $orderItems['extra_size']; }
            if(isset($orderItems['extra_size_two'])){ $orderItem->extra_size_two = $orderItems['extra_size_two']; }
            if(isset($orderItems['extra_size_three'])){ $orderItem->extra_size_three = $orderItems['extra_size_three']; }
            $orderItem->update();
        }

        $order = Order::find($request->order_id);
        $organization = Organization::find($order->organization_id);
        $orderSubTotal = OrderItem::where('order_id', $request->order_id)->sum('total');
        if ($organization->sales_tax_active == 1) {
            $salesTax = $organization->sales_tax;
        } else {
            $salesTax = 0;
        }
        $orderSalesTax = ($orderSubTotal / 100) * $salesTax;
        $orderShipping = $order->shipping ?? '';
        $orderArtwork = $order->artwork ?? '';
        $orderProcessingFee = $order->processing_fee ?? '';
        $orderFeesTotal = $orderSalesTax + $orderShipping + $orderArtwork + $orderProcessingFee;

        $order->sub_total = $orderSubTotal;
        $order->order_total = $orderSubTotal + $orderFeesTotal;
        $order->sales_tax = $orderSalesTax;
        $order->update();

        $blankProductArray = [];
        foreach($request->product as $productDetails){
            $OrderItemsDetail = OrderItemsDetail::find($productDetails['orderNo']);
            $OrderItemsDetail->blanks = $productDetails['blanks'];
            $OrderItemsDetail->qty = $productDetails['qty'];

            if($productDetails['blanks'] > 0){
                $blankProductArray[$productDetails['orderNo']] = $productDetails['blanks'];
            }

            if ($productDetails['numseq_one'] != ""){ $OrderItemsDetail->numseq_one = $productDetails['numseq_one']; } else { $OrderItemsDetail->numseq_one = "";}
            if ($productDetails['numseq_two'] != ""){ $OrderItemsDetail->numseq_two = $productDetails['numseq_two']; } else { $OrderItemsDetail->numseq_two = "";}
            if ($productDetails['numseq_three'] != ""){ $OrderItemsDetail->numseq_three = $productDetails['numseq_three']; } else { $OrderItemsDetail->numseq_three = "";}
            if ($productDetails['numseq_four'] != ""){ $OrderItemsDetail->numseq_four = $productDetails['numseq_four']; } else { $OrderItemsDetail->numseq_four = "";}
            if ($productDetails['numseq_five'] != ""){ $OrderItemsDetail->numseq_five = $productDetails['numseq_five']; } else { $OrderItemsDetail->numseq_five = "";}
            if ($productDetails['numseq_six'] != ""){ $OrderItemsDetail->numseq_six = $productDetails['numseq_six']; } else { $OrderItemsDetail->numseq_six = "";}
            if ($productDetails['numseq_seven'] != ""){ $OrderItemsDetail->numseq_seven = $productDetails['numseq_seven']; } else { $OrderItemsDetail->numseq_seven = "";}
            if ($productDetails['numseq_eight'] != ""){ $OrderItemsDetail->numseq_eight = $productDetails['numseq_eight']; } else { $OrderItemsDetail->numseq_eight = "";}
            if ($productDetails['numseq_nine'] != ""){ $OrderItemsDetail->numseq_nine = $productDetails['numseq_nine']; } else { $OrderItemsDetail->numseq_nine = "";}
            if ($productDetails['numseq_ten'] != ""){ $OrderItemsDetail->numseq_ten = $productDetails['numseq_ten']; } else { $OrderItemsDetail->numseq_ten = "";}

            if ($productDetails['numseq_eleven'] != ""){ $OrderItemsDetail->numseq_eleven = $productDetails['numseq_eleven']; } else { $OrderItemsDetail->numseq_eleven = "";}
            if ($productDetails['numseq_twelve'] != ""){ $OrderItemsDetail->numseq_twelve = $productDetails['numseq_twelve']; } else { $OrderItemsDetail->numseq_twelve = "";}
            if ($productDetails['numseq_thirteen'] != ""){ $OrderItemsDetail->numseq_thirteen = $productDetails['numseq_thirteen']; } else { $OrderItemsDetail->numseq_thirteen = "";}
            if ($productDetails['numseq_fourteen'] != ""){ $OrderItemsDetail->numseq_fourteen = $productDetails['numseq_fourteen']; } else { $OrderItemsDetail->numseq_fourteen = "";}
            if ($productDetails['numseq_fifteen'] != ""){ $OrderItemsDetail->numseq_fifteen = $productDetails['numseq_fifteen']; } else { $OrderItemsDetail->numseq_fifteen = "";}
            if ($productDetails['numseq_sixteen'] != ""){ $OrderItemsDetail->numseq_sixteen = $productDetails['numseq_sixteen']; } else { $OrderItemsDetail->numseq_sixteen = "";}
            if ($productDetails['numseq_seventeen'] != ""){ $OrderItemsDetail->numseq_seventeen = $productDetails['numseq_seventeen']; } else { $OrderItemsDetail->numseq_seventeen = "";}
            if ($productDetails['numseq_eighteen'] != ""){ $OrderItemsDetail->numseq_eighteen = $productDetails['numseq_eighteen']; } else { $OrderItemsDetail->numseq_eighteen = "";}
            if ($productDetails['numseq_nineteen'] != ""){ $OrderItemsDetail->numseq_nineteen = $productDetails['numseq_nineteen']; } else { $OrderItemsDetail->numseq_nineteen = "";}
            if ($productDetails['numseq_twenty'] != ""){ $OrderItemsDetail->numseq_twenty = $productDetails['numseq_twenty']; } else { $OrderItemsDetail->numseq_twenty = "";}

            if ($productDetails['numseq_twenty_one'] != ""){ $OrderItemsDetail->numseq_twenty_one = $productDetails['numseq_twenty_one']; } else { $OrderItemsDetail->numseq_twenty_one = "";}
            if ($productDetails['numseq_twenty_two'] != ""){ $OrderItemsDetail->numseq_twenty_two = $productDetails['numseq_twenty_two']; } else { $OrderItemsDetail->numseq_twenty_two = "";}
            if ($productDetails['numseq_twenty_three'] != ""){ $OrderItemsDetail->numseq_twenty_three = $productDetails['numseq_twenty_three']; } else { $OrderItemsDetail->numseq_twenty_three = "";}
            if ($productDetails['numseq_twenty_four'] != ""){ $OrderItemsDetail->numseq_twenty_four = $productDetails['numseq_twenty_four']; } else { $OrderItemsDetail->numseq_twenty_four = "";}
            if ($productDetails['numseq_twenty_five'] != ""){ $OrderItemsDetail->numseq_twenty_five = $productDetails['numseq_twenty_five']; } else { $OrderItemsDetail->numseq_twenty_five = "";}
            if ($productDetails['numseq_twenty_six'] != ""){ $OrderItemsDetail->numseq_twenty_six = $productDetails['numseq_twenty_six']; } else { $OrderItemsDetail->numseq_twenty_six = "";}
            if ($productDetails['numseq_twenty_seven'] != ""){ $OrderItemsDetail->numseq_twenty_seven = $productDetails['numseq_twenty_seven']; } else { $OrderItemsDetail->numseq_twenty_seven = "";}
            if ($productDetails['numseq_twenty_eight'] != ""){ $OrderItemsDetail->numseq_twenty_eight = $productDetails['numseq_twenty_eight']; } else { $OrderItemsDetail->numseq_twenty_eight = "";}
            if ($productDetails['numseq_twenty_nine'] != ""){ $OrderItemsDetail->numseq_twenty_nine = $productDetails['numseq_twenty_nine']; } else { $OrderItemsDetail->numseq_twenty_nine = "";}
            if ($productDetails['numseq_thirty'] != ""){ $OrderItemsDetail->numseq_thirty = $productDetails['numseq_thirty']; } else { $OrderItemsDetail->numseq_thirty = "";}

            if ($productDetails['numseq_thirty_one'] != ""){ $OrderItemsDetail->numseq_thirty_one = $productDetails['numseq_thirty_one']; } else { $OrderItemsDetail->numseq_thirty_one = "";}
            if ($productDetails['numseq_thirty_two'] != ""){ $OrderItemsDetail->numseq_thirty_two = $productDetails['numseq_thirty_two']; } else { $OrderItemsDetail->numseq_thirty_two = "";}
            if ($productDetails['numseq_thirty_three'] != ""){ $OrderItemsDetail->numseq_thirty_three = $productDetails['numseq_thirty_three']; } else { $OrderItemsDetail->numseq_thirty_three = "";}
            if ($productDetails['numseq_thirty_four'] != ""){ $OrderItemsDetail->numseq_thirty_four = $productDetails['numseq_thirty_four']; } else { $OrderItemsDetail->numseq_thirty_four = "";}
            if ($productDetails['numseq_thirty_five'] != ""){ $OrderItemsDetail->numseq_thirty_five = $productDetails['numseq_thirty_five']; } else { $OrderItemsDetail->numseq_thirty_five = "";}
            if ($productDetails['numseq_thirty_six'] != ""){ $OrderItemsDetail->numseq_thirty_six = $productDetails['numseq_thirty_six']; } else { $OrderItemsDetail->numseq_thirty_six = "";}
            if ($productDetails['numseq_thirty_seven'] != ""){ $OrderItemsDetail->numseq_thirty_seven = $productDetails['numseq_thirty_seven']; } else { $OrderItemsDetail->numseq_thirty_seven = "";}
            if ($productDetails['numseq_thirty_eight'] != ""){ $OrderItemsDetail->numseq_thirty_eight = $productDetails['numseq_thirty_eight']; } else { $OrderItemsDetail->numseq_thirty_eight = "";}
            if ($productDetails['numseq_thirty_nine'] != ""){ $OrderItemsDetail->numseq_thirty_nine = $productDetails['numseq_thirty_nine']; } else { $OrderItemsDetail->numseq_thirty_nine = "";}
            if ($productDetails['numseq_forty'] != ""){ $OrderItemsDetail->numseq_forty = $productDetails['numseq_forty']; } else { $OrderItemsDetail->numseq_forty = "";}

            if ($productDetails['numseq_forty_one'] != ""){ $OrderItemsDetail->numseq_forty_one = $productDetails['numseq_forty_one']; } else { $OrderItemsDetail->numseq_forty_one = "";}
            if ($productDetails['numseq_forty_two'] != ""){ $OrderItemsDetail->numseq_forty_two = $productDetails['numseq_forty_two']; } else { $OrderItemsDetail->numseq_forty_two = "";}
            if ($productDetails['numseq_forty_three'] != ""){ $OrderItemsDetail->numseq_forty_three = $productDetails['numseq_forty_three']; } else { $OrderItemsDetail->numseq_forty_three = "";}
            if ($productDetails['numseq_forty_four'] != ""){ $OrderItemsDetail->numseq_forty_four = $productDetails['numseq_forty_four']; } else { $OrderItemsDetail->numseq_forty_four = "";}
            if ($productDetails['numseq_forty_five'] != ""){ $OrderItemsDetail->numseq_forty_five = $productDetails['numseq_forty_five']; } else { $OrderItemsDetail->numseq_forty_five = "";}
            if ($productDetails['numseq_forty_six'] != ""){ $OrderItemsDetail->numseq_forty_six = $productDetails['numseq_forty_six']; } else { $OrderItemsDetail->numseq_forty_six = "";}
            if ($productDetails['numseq_forty_seven'] != ""){ $OrderItemsDetail->numseq_forty_seven = $productDetails['numseq_forty_seven']; } else { $OrderItemsDetail->numseq_forty_seven = "";}
            if ($productDetails['numseq_forty_eight'] != ""){ $OrderItemsDetail->numseq_forty_eight = $productDetails['numseq_forty_eight']; } else { $OrderItemsDetail->numseq_forty_eight = "";}
            if ($productDetails['numseq_forty_nine'] != ""){ $OrderItemsDetail->numseq_forty_nine = $productDetails['numseq_forty_nine']; } else { $OrderItemsDetail->numseq_forty_nine = "";}
            if ($productDetails['numseq_fifty'] != ""){ $OrderItemsDetail->numseq_fifty = $productDetails['numseq_fifty']; } else { $OrderItemsDetail->numseq_fifty = "";}

            if($productDetails['numseq_fifty_one'] != ""){$OrderItemsDetail->numseq_fifty_one = $productDetails['numseq_fifty_one'];}else{ $OrderItemsDetail->numseq_fifty_one =""; }
            if($productDetails['numseq_fifty_two'] != ""){$OrderItemsDetail->numseq_fifty_two = $productDetails['numseq_fifty_two'];}else{ $OrderItemsDetail->numseq_fifty_two =""; }
            if($productDetails['numseq_fifty_three'] != ""){$OrderItemsDetail->numseq_fifty_three = $productDetails['numseq_fifty_three'];}else{ $OrderItemsDetail->numseq_fifty_three =""; }
            if($productDetails['numseq_fifty_four'] != ""){$OrderItemsDetail->numseq_fifty_four = $productDetails['numseq_fifty_four'];}else{ $OrderItemsDetail->numseq_fifty_four =""; }
            if($productDetails['numseq_fifty_five'] != ""){$OrderItemsDetail->numseq_fifty_five = $productDetails['numseq_fifty_five'];}else{ $OrderItemsDetail->numseq_fifty_five =""; }
            if($productDetails['numseq_fifty_six'] != ""){$OrderItemsDetail->numseq_fifty_six = $productDetails['numseq_fifty_six'];}else{ $OrderItemsDetail->numseq_fifty_six =""; }
            if($productDetails['numseq_fifty_seven'] != ""){$OrderItemsDetail->numseq_fifty_seven = $productDetails['numseq_fifty_seven'];}else{ $OrderItemsDetail->numseq_fifty_seven =""; }
            if($productDetails['numseq_fifty_eight'] != ""){$OrderItemsDetail->numseq_fifty_eight = $productDetails['numseq_fifty_eight'];}else{ $OrderItemsDetail->numseq_fifty_eight =""; }
            if($productDetails['numseq_fifty_nine'] != ""){$OrderItemsDetail->numseq_fifty_nine = $productDetails['numseq_fifty_nine'];}else{ $OrderItemsDetail->numseq_fifty_nine =""; }
            if($productDetails['numseq_sixty'] != ""){$OrderItemsDetail->numseq_sixty = $productDetails['numseq_sixty'];}else{ $OrderItemsDetail->numseq_sixty =""; }

            if($productDetails['numseq_sixty_one'] != ""){$OrderItemsDetail->numseq_sixty_one = $productDetails['numseq_sixty_one'];}else{ $OrderItemsDetail->numseq_sixty_one =""; }
            if($productDetails['numseq_sixty_two'] != ""){$OrderItemsDetail->numseq_sixty_two = $productDetails['numseq_sixty_two'];}else{ $OrderItemsDetail->numseq_sixty_two =""; }
            if($productDetails['numseq_sixty_three'] != ""){$OrderItemsDetail->numseq_sixty_three = $productDetails['numseq_sixty_three'];}else{ $OrderItemsDetail->numseq_sixty_three =""; }
            if($productDetails['numseq_sixty_four'] != ""){$OrderItemsDetail->numseq_sixty_four = $productDetails['numseq_sixty_four'];}else{ $OrderItemsDetail->numseq_sixty_four =""; }
            if($productDetails['numseq_sixty_five'] != ""){$OrderItemsDetail->numseq_sixty_five = $productDetails['numseq_sixty_five'];}else{ $OrderItemsDetail->numseq_sixty_five =""; }
            if($productDetails['numseq_sixty_six'] != ""){$OrderItemsDetail->numseq_sixty_six = $productDetails['numseq_sixty_six'];}else{ $OrderItemsDetail->numseq_sixty_six =""; }
            if($productDetails['numseq_sixty_seven'] != ""){$OrderItemsDetail->numseq_sixty_seven = $productDetails['numseq_sixty_seven'];}else{ $OrderItemsDetail->numseq_sixty_seven =""; }
            if($productDetails['numseq_sixty_eight'] != ""){$OrderItemsDetail->numseq_sixty_eight = $productDetails['numseq_sixty_eight'];}else{ $OrderItemsDetail->numseq_sixty_eight =""; }
            if($productDetails['numseq_sixty_nine'] != ""){$OrderItemsDetail->numseq_sixty_nine = $productDetails['numseq_sixty_nine'];}else{ $OrderItemsDetail->numseq_sixty_nine =""; }
            if($productDetails['numseq_seventy'] != ""){$OrderItemsDetail->numseq_seventy = $productDetails['numseq_seventy'];}else{ $OrderItemsDetail->numseq_seventy =""; }

            if($productDetails['numseq_seventy_one'] != ""){$OrderItemsDetail->numseq_seventy_one = $productDetails['numseq_seventy_one'];}else{ $OrderItemsDetail->numseq_seventy_one =""; }
            if($productDetails['numseq_seventy_two'] != ""){$OrderItemsDetail->numseq_seventy_two = $productDetails['numseq_seventy_two'];}else{ $OrderItemsDetail->numseq_seventy_two =""; }
            if($productDetails['numseq_seventy_three'] != ""){$OrderItemsDetail->numseq_seventy_three = $productDetails['numseq_seventy_three'];}else{ $OrderItemsDetail->numseq_seventy_three =""; }
            if($productDetails['numseq_seventy_four'] != ""){$OrderItemsDetail->numseq_seventy_four = $productDetails['numseq_seventy_four'];}else{ $OrderItemsDetail->numseq_seventy_four =""; }
            if($productDetails['numseq_seventy_five'] != ""){$OrderItemsDetail->numseq_seventy_five = $productDetails['numseq_seventy_five'];}else{ $OrderItemsDetail->numseq_seventy_five =""; }
            if($productDetails['numseq_seventy_six'] != ""){$OrderItemsDetail->numseq_seventy_six = $productDetails['numseq_seventy_six'];}else{ $OrderItemsDetail->numseq_seventy_six =""; }
            if($productDetails['numseq_seventy_seven'] != ""){$OrderItemsDetail->numseq_seventy_seven = $productDetails['numseq_seventy_seven'];}else{ $OrderItemsDetail->numseq_seventy_seven =""; }
            if($productDetails['numseq_seventy_eight'] != ""){$OrderItemsDetail->numseq_seventy_eight = $productDetails['numseq_seventy_eight'];}else{ $OrderItemsDetail->numseq_seventy_eight =""; }
            if($productDetails['numseq_seventy_nine'] != ""){$OrderItemsDetail->numseq_seventy_nine = $productDetails['numseq_seventy_nine'];}else{ $OrderItemsDetail->numseq_seventy_nine =""; }
            if($productDetails['numseq_eighty'] != ""){$OrderItemsDetail->numseq_eighty = $productDetails['numseq_eighty'];}else{ $OrderItemsDetail->numseq_eighty =""; }

            if($productDetails['numseq_eighty_one'] != ""){$OrderItemsDetail->numseq_eighty_one = $productDetails['numseq_eighty_one'];}else{ $OrderItemsDetail->numseq_eighty_one =""; }
            if($productDetails['numseq_eighty_two'] != ""){$OrderItemsDetail->numseq_eighty_two = $productDetails['numseq_eighty_two'];}else{ $OrderItemsDetail->numseq_eighty_two =""; }
            if($productDetails['umseq_eighty_three'] != ""){$OrderItemsDetail->numseq_eighty_three = $productDetails['umseq_eighty_three'];}else{ $OrderItemsDetail->numseq_eighty_three =""; }
            if($productDetails['numseq_eighty_four'] != ""){$OrderItemsDetail->numseq_eighty_four = $productDetails['numseq_eighty_four'];}else{ $OrderItemsDetail->numseq_eighty_four =""; }
            if($productDetails['numseq_eighty_five'] != ""){$OrderItemsDetail->numseq_eighty_five = $productDetails['numseq_eighty_five'];}else{ $OrderItemsDetail->numseq_eighty_five =""; }
            if($productDetails['numseq_eighty_six'] != ""){$OrderItemsDetail->numseq_eighty_six = $productDetails['numseq_eighty_six'];}else{ $OrderItemsDetail->numseq_eighty_six =""; }
            if($productDetails['numseq_eighty_seven'] != ""){$OrderItemsDetail->numseq_eighty_seven = $productDetails['numseq_eighty_seven'];}else{ $OrderItemsDetail->numseq_eighty_seven =""; }
            if($productDetails['numseq_eighty_eight'] != ""){$OrderItemsDetail->numseq_eighty_eight = $productDetails['numseq_eighty_eight'];}else{ $OrderItemsDetail->numseq_eighty_eight =""; }
            if($productDetails['numseq_eighty_nine'] != ""){$OrderItemsDetail->numseq_eighty_nine = $productDetails['numseq_eighty_nine'];}else{ $OrderItemsDetail->numseq_eighty_nine =""; }
            if($productDetails['numseq_ninety'] != ""){$OrderItemsDetail->numseq_ninety = $productDetails['numseq_ninety'];}else{ $OrderItemsDetail->numseq_ninety =""; }

            if($productDetails['numseq_ninety_one'] != ""){$OrderItemsDetail->numseq_ninety_one = $productDetails['numseq_ninety_one'];}else{ $OrderItemsDetail->numseq_ninety_one =""; }
            if($productDetails['numseq_ninety_two'] != ""){$OrderItemsDetail->numseq_ninety_two = $productDetails['numseq_ninety_two'];}else{ $OrderItemsDetail->numseq_ninety_two =""; }
            if($productDetails['numseq_ninety_three'] != ""){$OrderItemsDetail->numseq_ninety_three = $productDetails['numseq_ninety_three'];}else{ $OrderItemsDetail->numseq_ninety_three =""; }
            if($productDetails['numseq_ninety_four'] != ""){$OrderItemsDetail->numseq_ninety_four = $productDetails['numseq_ninety_four'];}else{ $OrderItemsDetail->numseq_ninety_four =""; }
            if($productDetails['numseq_ninety_five'] != ""){$OrderItemsDetail->numseq_ninety_five = $productDetails['numseq_ninety_five'];}else{ $OrderItemsDetail->numseq_ninety_five =""; }
            if($productDetails['numseq_ninety_six'] != ""){$OrderItemsDetail->numseq_ninety_six = $productDetails['numseq_ninety_six'];}else{ $OrderItemsDetail->numseq_ninety_six =""; }
            if($productDetails['numseq_ninety_seven'] != ""){$OrderItemsDetail->numseq_ninety_seven = $productDetails['numseq_ninety_seven'];}else{ $OrderItemsDetail->numseq_ninety_seven =""; }
            if($productDetails['numseq_ninety_eight'] != ""){$OrderItemsDetail->numseq_ninety_eight = $productDetails['numseq_ninety_eight'];}else{ $OrderItemsDetail->numseq_ninety_eight =""; }
            if($productDetails['numseq_ninety_nine'] != ""){$OrderItemsDetail->numseq_ninety_nine = $productDetails['numseq_ninety_nine'];}else{ $OrderItemsDetail->numseq_ninety_nine =""; }
            if($productDetails['numseq_hundred'] != ""){$OrderItemsDetail->numseq_hundred = $productDetails['numseq_hundred'];}else{ $OrderItemsDetail->numseq_hundred =""; }
            $OrderItemsDetail->update();
        }

        if (isset($request->playerName)) {
            foreach($request->playerName as $playerDetails){
                $playerNameDetails = OrderItemsDetailPlayerName::where('order_items_detail_id', $playerDetails['itemId'])->first();

                if ($playerNameDetails) {
                    if(isset($playerDetails['player_one']) && $playerDetails['player_one'] != ""){$playerNameDetails->player_one = $playerDetails['player_one'];}else{$playerNameDetails->player_one = "";}
                    if(isset($playerDetails['player_two']) && $playerDetails['player_two'] != ""){$playerNameDetails->player_two = $playerDetails['player_two'];}else{$playerNameDetails->player_two = "";}
                    if(isset($playerDetails['player_three']) && $playerDetails['player_three'] != ""){$playerNameDetails->player_three = $playerDetails['player_three'];}else{$playerNameDetails->player_three = "";}
                    if(isset($playerDetails['player_four']) && $playerDetails['player_four'] != ""){$playerNameDetails->player_four = $playerDetails['player_four'];}else{$playerNameDetails->player_four = "";}
                    if(isset($playerDetails['player_five']) && $playerDetails['player_five'] != ""){$playerNameDetails->player_five = $playerDetails['player_five'];}else{$playerNameDetails->player_five = "";}
                    if(isset($playerDetails['player_six']) && $playerDetails['player_six'] != ""){$playerNameDetails->player_six = $playerDetails['player_six'];}else{$playerNameDetails->player_six = "";}
                    if(isset($playerDetails['player_seven']) && $playerDetails['player_seven'] != ""){$playerNameDetails->player_seven = $playerDetails['player_seven'];}else{$playerNameDetails->player_seven = "";}
                    if(isset($playerDetails['player_eight']) && $playerDetails['player_eight'] != ""){$playerNameDetails->player_eight = $playerDetails['player_eight'];}else{$playerNameDetails->player_eight = "";}
                    if(isset($playerDetails['player_nine']) && $playerDetails['player_nine'] != ""){$playerNameDetails->player_nine = $playerDetails['player_nine'];}else{$playerNameDetails->player_nine = "";}
                    if(isset($playerDetails['player_ten']) && $playerDetails['player_ten'] != ""){$playerNameDetails->player_ten = $playerDetails['player_ten'];}else{$playerNameDetails->player_ten = "";}

                    if(isset($playerDetails['player_eleven']) && $playerDetails['player_eleven'] != ""){$playerNameDetails->player_eleven = $playerDetails['player_eleven'];}else{$playerNameDetails->player_eleven = "";}
                    if(isset($playerDetails['player_twelve']) && $playerDetails['player_twelve'] != ""){$playerNameDetails->player_twelve = $playerDetails['player_twelve'];}else{$playerNameDetails->player_twelve = "";}
                    if(isset($playerDetails['player_thirteen']) && $playerDetails['player_thirteen'] != ""){$playerNameDetails->player_thirteen = $playerDetails['player_thirteen'];}else{$playerNameDetails->player_thirteen = "";}
                    if(isset($playerDetails['player_fourteen']) && $playerDetails['player_fourteen'] != ""){$playerNameDetails->player_fourteen = $playerDetails['player_fourteen'];}else{$playerNameDetails->player_fourteen = "";}
                    if(isset($playerDetails['player_fifteen']) && $playerDetails['player_fifteen'] != ""){$playerNameDetails->player_fifteen = $playerDetails['player_fifteen'];}else{$playerNameDetails->player_fifteen = "";}
                    if(isset($playerDetails['player_sixteen']) && $playerDetails['player_sixteen'] != ""){$playerNameDetails->player_sixteen = $playerDetails['player_sixteen'];}else{$playerNameDetails->player_sixteen = "";}
                    if(isset($playerDetails['player_seventeen']) && $playerDetails['player_seventeen'] != ""){$playerNameDetails->player_seventeen = $playerDetails['player_seventeen'];}else{$playerNameDetails->player_seventeen = "";}
                    if(isset($playerDetails['player_eighteen']) && $playerDetails['player_eighteen'] != ""){$playerNameDetails->player_eighteen = $playerDetails['player_eighteen'];}else{$playerNameDetails->player_eighteen = "";}
                    if(isset($playerDetails['player_nineteen']) && $playerDetails['player_nineteen'] != ""){$playerNameDetails->player_nineteen = $playerDetails['player_nineteen'];}else{$playerNameDetails->player_nineteen = "";}
                    if(isset($playerDetails['player_twenty']) && $playerDetails['player_twenty'] != ""){$playerNameDetails->player_twenty = $playerDetails['player_twenty'];}else{$playerNameDetails->player_twenty = "";}

                    if(isset($playerDetails['player_twenty_one']) && $playerDetails['player_twenty_one'] != ""){$playerNameDetails->player_twenty_one = $playerDetails['player_twenty_one'];}else{$playerNameDetails->player_twenty_one = "";}
                    if(isset($playerDetails['player_twenty_two']) && $playerDetails['player_twenty_two'] != ""){$playerNameDetails->player_twenty_two = $playerDetails['player_twenty_two'];}else{$playerNameDetails->player_twenty_two = "";}
                    if(isset($playerDetails['player_twenty_three']) && $playerDetails['player_twenty_three'] != ""){$playerNameDetails->player_twenty_three = $playerDetails['player_twenty_three'];}else{$playerNameDetails->player_twenty_three = "";}
                    if(isset($playerDetails['player_twenty_four']) && $playerDetails['player_twenty_four'] != ""){$playerNameDetails->player_twenty_four = $playerDetails['player_twenty_four'];}else{$playerNameDetails->player_twenty_four = "";}
                    if(isset($playerDetails['player_twenty_five']) && $playerDetails['player_twenty_five'] != ""){$playerNameDetails->player_twenty_five = $playerDetails['player_twenty_five'];}else{$playerNameDetails->player_twenty_five = "";}
                    if(isset($playerDetails['player_twenty_six']) && $playerDetails['player_twenty_six'] != ""){$playerNameDetails->player_twenty_six = $playerDetails['player_twenty_six'];}else{$playerNameDetails->player_twenty_six = "";}
                    if(isset($playerDetails['player_twenty_seven']) && $playerDetails['player_twenty_seven'] != ""){$playerNameDetails->player_twenty_seven = $playerDetails['player_twenty_seven'];}else{$playerNameDetails->player_twenty_seven = "";}
                    if(isset($playerDetails['player_twenty_eight']) && $playerDetails['player_twenty_eight'] != ""){$playerNameDetails->player_twenty_eight = $playerDetails['player_twenty_eight'];}else{$playerNameDetails->player_twenty_eight = "";}
                    if(isset($playerDetails['player_twenty_nine']) && $playerDetails['player_twenty_nine'] != ""){$playerNameDetails->player_twenty_nine = $playerDetails['player_twenty_nine'];}else{$playerNameDetails->player_twenty_nine = "";}
                    if(isset($playerDetails['player_thirty']) && $playerDetails['player_thirty'] != ""){$playerNameDetails->player_thirty = $playerDetails['player_thirty'];}else{$playerNameDetails->player_thirty = "";}

                    if(isset($playerDetails['player_thirty_one']) && $playerDetails['player_thirty_one'] != ""){$playerNameDetails->player_thirty_one = $playerDetails['player_thirty_one'];}else{$playerNameDetails->player_thirty_one = "";}
                    if(isset($playerDetails['player_thirty_two']) && $playerDetails['player_thirty_two'] != ""){$playerNameDetails->player_thirty_two = $playerDetails['player_thirty_two'];}else{$playerNameDetails->player_thirty_two = "";}
                    if(isset($playerDetails['player_thirty_three']) && $playerDetails['player_thirty_three'] != ""){$playerNameDetails->player_thirty_three = $playerDetails['player_thirty_three'];}else{$playerNameDetails->player_thirty_three = "";}
                    if(isset($playerDetails['player_thirty_four']) && $playerDetails['player_thirty_four'] != ""){$playerNameDetails->player_thirty_four = $playerDetails['player_thirty_four'];}else{$playerNameDetails->player_thirty_four = "";}
                    if(isset($playerDetails['player_thirty_five']) && $playerDetails['player_thirty_five'] != ""){$playerNameDetails->player_thirty_five = $playerDetails['player_thirty_five'];}else{$playerNameDetails->player_thirty_five = "";}
                    if(isset($playerDetails['player_thirty_six']) && $playerDetails['player_thirty_six'] != ""){$playerNameDetails->player_thirty_six = $playerDetails['player_thirty_six'];}else{$playerNameDetails->player_thirty_six = "";}
                    if(isset($playerDetails['player_thirty_seven']) && $playerDetails['player_thirty_seven'] != ""){$playerNameDetails->player_thirty_seven = $playerDetails['player_thirty_seven'];}else{$playerNameDetails->player_thirty_seven = "";}
                    if(isset($playerDetails['player_thirty_eight']) && $playerDetails['player_thirty_eight'] != ""){$playerNameDetails->player_thirty_eight = $playerDetails['player_thirty_eight'];}else{$playerNameDetails->player_thirty_eight = "";}
                    if(isset($playerDetails['player_thirty_nine']) && $playerDetails['player_thirty_nine'] != ""){$playerNameDetails->player_thirty_nine = $playerDetails['player_thirty_nine'];}else{$playerNameDetails->player_thirty_nine = "";}
                    if(isset($playerDetails['player_forty']) && $playerDetails['player_forty'] != ""){$playerNameDetails->player_forty = $playerDetails['player_forty'];}else{$playerNameDetails->player_forty = "";}

                    if(isset($playerDetails['player_forty_one']) && $playerDetails['player_forty_one'] != ""){$playerNameDetails->player_forty_one = $playerDetails['player_forty_one'];}else{$playerNameDetails->player_forty_one = "";}
                    if(isset($playerDetails['player_forty_two']) && $playerDetails['player_forty_two'] != ""){$playerNameDetails->player_forty_two = $playerDetails['player_forty_two'];}else{$playerNameDetails->player_forty_two = "";}
                    if(isset($playerDetails['player_forty_three']) && $playerDetails['player_forty_three'] != ""){$playerNameDetails->player_forty_three = $playerDetails['player_forty_three'];}else{$playerNameDetails->player_forty_three = "";}
                    if(isset($playerDetails['player_forty_four']) && $playerDetails['player_forty_four'] != ""){$playerNameDetails->player_forty_four = $playerDetails['player_forty_four'];}else{$playerNameDetails->player_forty_four = "";}
                    if(isset($playerDetails['player_forty_five']) && $playerDetails['player_forty_five'] != ""){$playerNameDetails->player_forty_five = $playerDetails['player_forty_five'];}else{$playerNameDetails->player_forty_five = "";}
                    if(isset($playerDetails['player_forty_six']) && $playerDetails['player_forty_six'] != ""){$playerNameDetails->player_forty_six = $playerDetails['player_forty_six'];}else{$playerNameDetails->player_forty_six = "";}
                    if(isset($playerDetails['player_forty_seven']) && $playerDetails['player_forty_seven'] != ""){$playerNameDetails->player_forty_seven = $playerDetails['player_forty_seven'];}else{$playerNameDetails->player_forty_seven = "";}
                    if(isset($playerDetails['player_forty_eight']) && $playerDetails['player_forty_eight'] != ""){$playerNameDetails->player_forty_eight = $playerDetails['player_forty_eight'];}else{$playerNameDetails->player_forty_eight = "";}
                    if(isset($playerDetails['player_forty_nine']) && $playerDetails['player_forty_nine'] != ""){$playerNameDetails->player_forty_nine = $playerDetails['player_forty_nine'];}else{$playerNameDetails->player_forty_nine = "";}
                    if(isset($playerDetails['player_fifty']) && $playerDetails['player_fifty'] != ""){$playerNameDetails->player_fifty = $playerDetails['player_fifty'];}else{$playerNameDetails->player_fifty = "";}

                    if(isset($playerDetails['player_fifty_one']) && $playerDetails['player_fifty_one'] != ""){$playerNameDetails->player_fifty_one = $playerDetails['player_fifty_one'];}else{$playerNameDetails->player_fifty_one = "";}
                    if(isset($playerDetails['player_fifty_two']) && $playerDetails['player_fifty_two'] != ""){$playerNameDetails->player_fifty_two = $playerDetails['player_fifty_two'];}else{$playerNameDetails->player_fifty_two = "";}
                    if(isset($playerDetails['player_fifty_three']) && $playerDetails['player_fifty_three'] != ""){$playerNameDetails->player_fifty_three = $playerDetails['player_fifty_three'];}else{$playerNameDetails->player_fifty_three = "";}
                    if(isset($playerDetails['player_fifty_four']) && $playerDetails['player_fifty_four'] != ""){$playerNameDetails->player_fifty_four = $playerDetails['player_fifty_four'];}else{$playerNameDetails->player_fifty_four = "";}
                    if(isset($playerDetails['player_fifty_five']) && $playerDetails['player_fifty_five'] != ""){$playerNameDetails->player_fifty_five = $playerDetails['player_fifty_five'];}else{$playerNameDetails->player_fifty_five = "";}
                    if(isset($playerDetails['player_fifty_six']) && $playerDetails['player_fifty_six'] != ""){$playerNameDetails->player_fifty_six = $playerDetails['player_fifty_six'];}else{$playerNameDetails->player_fifty_six = "";}
                    if(isset($playerDetails['player_fifty_seven']) && $playerDetails['player_fifty_seven'] != ""){$playerNameDetails->player_fifty_seven = $playerDetails['player_fifty_seven'];}else{$playerNameDetails->player_fifty_seven = "";}
                    if(isset($playerDetails['player_fifty_eight']) && $playerDetails['player_fifty_eight'] != ""){$playerNameDetails->player_fifty_eight = $playerDetails['player_fifty_eight'];}else{$playerNameDetails->player_fifty_eight = "";}
                    if(isset($playerDetails['player_fifty_nine']) && $playerDetails['player_fifty_nine'] != ""){$playerNameDetails->player_fifty_nine = $playerDetails['player_fifty_nine'];}else{$playerNameDetails->player_fifty_nine = "";}
                    if(isset($playerDetails['player_sixty']) && $playerDetails['player_sixty'] != ""){$playerNameDetails->player_sixty = $playerDetails['player_sixty'];}else{$playerNameDetails->player_sixty = "";}

                    if(isset($playerDetails['player_sixty_one']) && $playerDetails['player_sixty_one'] != ""){$playerNameDetails->player_sixty_one = $playerDetails['player_sixty_one'];}else{$playerNameDetails->player_sixty_one = "";}
                    if(isset($playerDetails['player_sixty_two']) && $playerDetails['player_sixty_two'] != ""){$playerNameDetails->player_sixty_two = $playerDetails['player_sixty_two'];}else{$playerNameDetails->player_sixty_two = "";}
                    if(isset($playerDetails['player_sixty_three']) && $playerDetails['player_sixty_three'] != ""){$playerNameDetails->player_sixty_three = $playerDetails['player_sixty_three'];}else{$playerNameDetails->player_sixty_three = "";}
                    if(isset($playerDetails['player_sixty_four']) && $playerDetails['player_sixty_four'] != ""){$playerNameDetails->player_sixty_four = $playerDetails['player_sixty_four'];}else{$playerNameDetails->player_sixty_four = "";}
                    if(isset($playerDetails['player_sixty_five']) && $playerDetails['player_sixty_five'] != ""){$playerNameDetails->player_sixty_five = $playerDetails['player_sixty_five'];}else{$playerNameDetails->player_sixty_five = "";}
                    if(isset($playerDetails['player_sixty_six']) && $playerDetails['player_sixty_six'] != ""){$playerNameDetails->player_sixty_six = $playerDetails['player_sixty_six'];}else{$playerNameDetails->player_sixty_six = "";}
                    if(isset($playerDetails['player_sixty_seven']) && $playerDetails['player_sixty_seven'] != ""){$playerNameDetails->player_sixty_seven = $playerDetails['player_sixty_seven'];}else{$playerNameDetails->player_sixty_seven = "";}
                    if(isset($playerDetails['player_sixty_eight']) && $playerDetails['player_sixty_eight'] != ""){$playerNameDetails->player_sixty_eight = $playerDetails['player_sixty_eight'];}else{$playerNameDetails->player_sixty_eight = "";}
                    if(isset($playerDetails['player_sixty_nine']) && $playerDetails['player_sixty_nine'] != ""){$playerNameDetails->player_sixty_nine = $playerDetails['player_sixty_nine'];}else{$playerNameDetails->player_sixty_nine = "";}
                    if(isset($playerDetails['player_seventy']) && $playerDetails['player_seventy'] != ""){$playerNameDetails->player_seventy = $playerDetails['player_seventy'];}else{$playerNameDetails->player_seventy = "";}

                    if(isset($playerDetails['player_seventy_one']) && $playerDetails['player_seventy_one'] != ""){$playerNameDetails->player_seventy_one = $playerDetails['player_seventy_one'];}else{$playerNameDetails->player_seventy_one = "";}
                    if(isset($playerDetails['player_seventy_two']) && $playerDetails['player_seventy_two'] != ""){$playerNameDetails->player_seventy_two = $playerDetails['player_seventy_two'];}else{$playerNameDetails->player_seventy_two = "";}
                    if(isset($playerDetails['player_seventy_three']) && $playerDetails['player_seventy_three'] != ""){$playerNameDetails->player_seventy_three = $playerDetails['player_seventy_three'];}else{$playerNameDetails->player_seventy_three = "";}
                    if(isset($playerDetails['player_seventy_four']) && $playerDetails['player_seventy_four'] != ""){$playerNameDetails->player_seventy_four = $playerDetails['player_seventy_four'];}else{$playerNameDetails->player_seventy_four = "";}
                    if(isset($playerDetails['player_seventy_five']) && $playerDetails['player_seventy_five'] != ""){$playerNameDetails->player_seventy_five = $playerDetails['player_seventy_five'];}else{$playerNameDetails->player_seventy_five = "";}
                    if(isset($playerDetails['player_seventy_six']) && $playerDetails['player_seventy_six'] != ""){$playerNameDetails->player_seventy_six = $playerDetails['player_seventy_six'];}else{$playerNameDetails->player_seventy_six = "";}
                    if(isset($playerDetails['player_seventy_seven']) && $playerDetails['player_seventy_seven'] != ""){$playerNameDetails->player_seventy_seven = $playerDetails['player_seventy_seven'];}else{$playerNameDetails->player_seventy_seven = "";}
                    if(isset($playerDetails['player_seventy_eight']) && $playerDetails['player_seventy_eight'] != ""){$playerNameDetails->player_seventy_eight = $playerDetails['player_seventy_eight'];}else{$playerNameDetails->player_seventy_eight = "";}
                    if(isset($playerDetails['player_seventy_nine']) && $playerDetails['player_seventy_nine'] != ""){$playerNameDetails->player_seventy_nine = $playerDetails['player_seventy_nine'];}else{$playerNameDetails->player_seventy_nine = "";}
                    if(isset($playerDetails['player_eighty']) && $playerDetails['player_eighty'] != ""){$playerNameDetails->player_eighty = $playerDetails['player_eighty'];}else{$playerNameDetails->player_eighty = "";}

                    if(isset($playerDetails['player_eighty_one']) && $playerDetails['player_eighty_one'] != ""){$playerNameDetails->player_eighty_one = $playerDetails['player_eighty_one'];}else{$playerNameDetails->player_eighty_one = "";}
                    if(isset($playerDetails['player_eighty_two']) && $playerDetails['player_eighty_two'] != ""){$playerNameDetails->player_eighty_two = $playerDetails['player_eighty_two'];}else{$playerNameDetails->player_eighty_two = "";}
                    if(isset($playerDetails['player_eighty_three']) && $playerDetails['player_eighty_three'] != ""){$playerNameDetails->player_eighty_three = $playerDetails['player_eighty_three'];}else{$playerNameDetails->player_eighty_three = "";}
                    if(isset($playerDetails['player_eighty_four']) && $playerDetails['player_eighty_four'] != ""){$playerNameDetails->player_eighty_four = $playerDetails['player_eighty_four'];}else{$playerNameDetails->player_eighty_four = "";}
                    if(isset($playerDetails['player_eighty_five']) && $playerDetails['player_eighty_five'] != ""){$playerNameDetails->player_eighty_five = $playerDetails['player_eighty_five'];}else{$playerNameDetails->player_eighty_five = "";}
                    if(isset($playerDetails['player_eighty_six']) && $playerDetails['player_eighty_six'] != ""){$playerNameDetails->player_eighty_six = $playerDetails['player_eighty_six'];}else{$playerNameDetails->player_eighty_six = "";}
                    if(isset($playerDetails['player_eighty_seven']) && $playerDetails['player_eighty_seven'] != ""){$playerNameDetails->player_eighty_seven = $playerDetails['player_eighty_seven'];}else{$playerNameDetails->player_eighty_seven = "";}
                    if(isset($playerDetails['player_eighty_eight']) && $playerDetails['player_eighty_eight'] != ""){$playerNameDetails->player_eighty_eight = $playerDetails['player_eighty_eight'];}else{$playerNameDetails->player_eighty_eight = "";}
                    if(isset($playerDetails['player_eighty_nine']) && $playerDetails['player_eighty_nine'] != ""){$playerNameDetails->player_eighty_nine = $playerDetails['player_eighty_nine'];}else{$playerNameDetails->player_eighty_nine = "";}
                    if(isset($playerDetails['player_ninety']) && $playerDetails['player_ninety'] != ""){$playerNameDetails->player_ninety = $playerDetails['player_ninety'];}else{$playerNameDetails->player_ninety = "";}

                    if(isset($playerDetails['player_ninety_one']) && $playerDetails['player_ninety_one'] != ""){$playerNameDetails->player_ninety_one = $playerDetails['player_ninety_one'];}else{$playerNameDetails->player_ninety_one = "";}
                    if(isset($playerDetails['player_ninety_two']) && $playerDetails['player_ninety_two'] != ""){$playerNameDetails->player_ninety_two = $playerDetails['player_ninety_two'];}else{$playerNameDetails->player_ninety_two = "";}
                    if(isset($playerDetails['player_ninety_three']) && $playerDetails['player_ninety_three'] != ""){$playerNameDetails->player_ninety_three = $playerDetails['player_ninety_three'];}else{$playerNameDetails->player_ninety_three = "";}
                    if(isset($playerDetails['player_ninety_four']) && $playerDetails['player_ninety_four'] != ""){$playerNameDetails->player_ninety_four = $playerDetails['player_ninety_four'];}else{$playerNameDetails->player_ninety_four = "";}
                    if(isset($playerDetails['player_ninety_five']) && $playerDetails['player_ninety_five'] != ""){$playerNameDetails->player_ninety_five = $playerDetails['player_ninety_five'];}else{$playerNameDetails->player_ninety_five = "";}
                    if(isset($playerDetails['player_ninety_six']) && $playerDetails['player_ninety_six'] != ""){$playerNameDetails->player_ninety_six = $playerDetails['player_ninety_six'];}else{$playerNameDetails->player_ninety_six = "";}
                    if(isset($playerDetails['player_ninety_seven']) && $playerDetails['player_ninety_seven'] != ""){$playerNameDetails->player_ninety_seven = $playerDetails['player_ninety_seven'];}else{$playerNameDetails->player_ninety_seven = "";}
                    if(isset($playerDetails['player_ninety_eight']) && $playerDetails['player_ninety_eight'] != ""){$playerNameDetails->player_ninety_eight = $playerDetails['player_ninety_eight'];}else{$playerNameDetails->player_ninety_eight = "";}
                    if(isset($playerDetails['player_ninety_nine']) && $playerDetails['player_ninety_nine'] != ""){$playerNameDetails->player_ninety_nine = $playerDetails['player_ninety_nine'];}else{$playerNameDetails->player_ninety_nine = "";}
                    if(isset($playerDetails['player_hundred']) && $playerDetails['player_hundred'] != ""){$playerNameDetails->player_hundred = $playerDetails['player_hundred'];}else{$playerNameDetails->player_hundred = "";}

                    if (isset($blankProductArray[$playerDetails['itemId']])) {
                        $nameCount = (int) $blankProductArray[$playerDetails['itemId']];

                        if ($nameCount == 0) {
                            $playerNameDetails->blank_qty = 0;
                            $playerNameDetails->blank_player_names = "";

                        } else {
                            if (isset($playerDetails['blank_players'])) {
                                $arrayCount = count($playerDetails['blank_players']);

                                if ($nameCount > $arrayCount) {
                                    for ($i = $arrayCount; $i < $nameCount; $i++){
                                        $playerDetails['blank_players'][$i] = null;
                                    }
                                    $playerNameDetails->blank_qty = $nameCount;
                                    $playerNameDetails->blank_player_names = json_encode($playerDetails['blank_players']);

                                } else if ($nameCount == $arrayCount) {
                                    $playerNameDetails->blank_qty = $nameCount;
                                    $playerNameDetails->blank_player_names = json_encode($playerDetails['blank_players']);

                                } else if ($nameCount < $arrayCount) {
                                    $newArray = [];
                                    for($i = 0; $i < $nameCount; $i++){
                                        $newArray[$i] = $playerDetails['blank_players'][$i];
                                    }
                                    $playerNameDetails->blank_qty = $nameCount;
                                    $playerNameDetails->blank_player_names = json_encode($newArray);
                                }

                            } else {
                                $newArray = [];
                                for($i = 0; $i < $nameCount; $i++){
                                    $newArray[$i] = null;
                                }
                                $playerNameDetails->blank_qty = $nameCount;
                                $playerNameDetails->blank_player_names = json_encode($newArray);
                            }
                        }

                    } else {
                        $playerNameDetails->blank_qty = 0;
                        $playerNameDetails->blank_player_names = "";
                    }

                    // if($playerNameDetails->blank_qty > 0 && isset($playerDetails['blank_players']) && isset($blankProductArray[$playerDetails['itemId']])){
                    //     if($playerNameDetails->blank_qty < $blankProductArray[$playerDetails['itemId']]){
                    //         for( $i = $playerNameDetails->blank_qty; $i < $blankProductArray[$playerDetails['itemId']]; $i++){
                    //             $playerDetails['blank_players'][$i] = null;
                    //         }
                    //         $playerNameDetails->blank_qty = $blankProductArray[$playerDetails['itemId']];
                    //         $playerNameDetails->blank_player_names = json_encode($playerDetails['blank_players']);

                    //     } else if($playerNameDetails->blank_qty == $blankProductArray[$playerDetails['itemId']]){
                    //         $playerNameDetails->blank_player_names = json_encode($playerDetails['blank_players']);

                    //     } else if($playerNameDetails->blank_qty > $blankProductArray[$playerDetails['itemId']]){
                    //         $newArray = [];
                    //         for($i = 0; $i < $blankProductArray[$playerDetails['itemId']]; $i++){
                    //             $newArray[$i] = $playerDetails['blank_players'][$i];
                    //         }
                    //         $playerNameDetails->blank_qty = $blankProductArray[$playerDetails['itemId']];
                    //         $playerNameDetails->blank_player_names = json_encode($newArray);
                    //     }
                    // } else if($playerNameDetails->blank_qty == 0 && isset($playerDetails['blank_players']) && isset($blankProductArray[$playerDetails['itemId']])){
                    //     if(isset($blankProductArray[$playerDetails['itemId']]) && $blankProductArray[$playerDetails['itemId']] > 0){ $playerNameDetails->blank_qty = $blankProductArray[$playerDetails['itemId']];}else{$playerNameDetails->blank_qty = 0;}
                    //     $playerNameDetails->blank_player_names = json_encode($playerDetails['blank_players']);
                    // } else {
                    //     $playerNameDetails->blank_qty = 0;
                    //     $playerNameDetails->blank_player_names = "";
                    // }

                    $playerNameDetails->update();

                } else {
                    $playerNameDetails = new OrderItemsDetailPlayerName();
                    $playerNameDetails->order_items_detail_id = $playerDetails['itemId'];
                    if(isset($playerDetails['player_one']) && $playerDetails['player_one'] != ""){$playerNameDetails->player_one = $playerDetails['player_one'];}else{$playerNameDetails->player_one = "";}
                    if(isset($playerDetails['player_two']) && $playerDetails['player_two'] != ""){$playerNameDetails->player_two = $playerDetails['player_two'];}else{$playerNameDetails->player_two = "";}
                    if(isset($playerDetails['player_three']) && $playerDetails['player_three'] != ""){$playerNameDetails->player_three = $playerDetails['player_three'];}else{$playerNameDetails->player_three = "";}
                    if(isset($playerDetails['player_four']) && $playerDetails['player_four'] != ""){$playerNameDetails->player_four = $playerDetails['player_four'];}else{$playerNameDetails->player_four = "";}
                    if(isset($playerDetails['player_five']) && $playerDetails['player_five'] != ""){$playerNameDetails->player_five = $playerDetails['player_five'];}else{$playerNameDetails->player_five = "";}
                    if(isset($playerDetails['player_six']) && $playerDetails['player_six'] != ""){$playerNameDetails->player_six = $playerDetails['player_six'];}else{$playerNameDetails->player_six = "";}
                    if(isset($playerDetails['player_seven']) && $playerDetails['player_seven'] != ""){$playerNameDetails->player_seven = $playerDetails['player_seven'];}else{$playerNameDetails->player_seven = "";}
                    if(isset($playerDetails['player_eight']) && $playerDetails['player_eight'] != ""){$playerNameDetails->player_eight = $playerDetails['player_eight'];}else{$playerNameDetails->player_eight = "";}
                    if(isset($playerDetails['player_nine']) && $playerDetails['player_nine'] != ""){$playerNameDetails->player_nine = $playerDetails['player_nine'];}else{$playerNameDetails->player_nine = "";}
                    if(isset($playerDetails['player_ten']) && $playerDetails['player_ten'] != ""){$playerNameDetails->player_ten = $playerDetails['player_ten'];}else{$playerNameDetails->player_ten = "";}

                    if(isset($playerDetails['player_eleven']) && $playerDetails['player_eleven'] != ""){$playerNameDetails->player_eleven = $playerDetails['player_eleven'];}else{$playerNameDetails->player_eleven = "";}
                    if(isset($playerDetails['player_twelve']) && $playerDetails['player_twelve'] != ""){$playerNameDetails->player_twelve = $playerDetails['player_twelve'];}else{$playerNameDetails->player_twelve = "";}
                    if(isset($playerDetails['player_thirteen']) && $playerDetails['player_thirteen'] != ""){$playerNameDetails->player_thirteen = $playerDetails['player_thirteen'];}else{$playerNameDetails->player_thirteen = "";}
                    if(isset($playerDetails['player_fourteen']) && $playerDetails['player_fourteen'] != ""){$playerNameDetails->player_fourteen = $playerDetails['player_fourteen'];}else{$playerNameDetails->player_fourteen = "";}
                    if(isset($playerDetails['player_fifteen']) && $playerDetails['player_fifteen'] != ""){$playerNameDetails->player_fifteen = $playerDetails['player_fifteen'];}else{$playerNameDetails->player_fifteen = "";}
                    if(isset($playerDetails['player_sixteen']) && $playerDetails['player_sixteen'] != ""){$playerNameDetails->player_sixteen = $playerDetails['player_sixteen'];}else{$playerNameDetails->player_sixteen = "";}
                    if(isset($playerDetails['player_seventeen']) && $playerDetails['player_seventeen'] != ""){$playerNameDetails->player_seventeen = $playerDetails['player_seventeen'];}else{$playerNameDetails->player_seventeen = "";}
                    if(isset($playerDetails['player_eighteen']) && $playerDetails['player_eighteen'] != ""){$playerNameDetails->player_eighteen = $playerDetails['player_eighteen'];}else{$playerNameDetails->player_eighteen = "";}
                    if(isset($playerDetails['player_nineteen']) && $playerDetails['player_nineteen'] != ""){$playerNameDetails->player_nineteen = $playerDetails['player_nineteen'];}else{$playerNameDetails->player_nineteen = "";}
                    if(isset($playerDetails['player_twenty']) && $playerDetails['player_twenty'] != ""){$playerNameDetails->player_twenty = $playerDetails['player_twenty'];}else{$playerNameDetails->player_twenty = "";}

                    if(isset($playerDetails['player_twenty_one']) && $playerDetails['player_twenty_one'] != ""){$playerNameDetails->player_twenty_one = $playerDetails['player_twenty_one'];}else{$playerNameDetails->player_twenty_one = "";}
                    if(isset($playerDetails['player_twenty_two']) && $playerDetails['player_twenty_two'] != ""){$playerNameDetails->player_twenty_two = $playerDetails['player_twenty_two'];}else{$playerNameDetails->player_twenty_two = "";}
                    if(isset($playerDetails['player_twenty_three']) && $playerDetails['player_twenty_three'] != ""){$playerNameDetails->player_twenty_three = $playerDetails['player_twenty_three'];}else{$playerNameDetails->player_twenty_three = "";}
                    if(isset($playerDetails['player_twenty_four']) && $playerDetails['player_twenty_four'] != ""){$playerNameDetails->player_twenty_four = $playerDetails['player_twenty_four'];}else{$playerNameDetails->player_twenty_four = "";}
                    if(isset($playerDetails['player_twenty_five']) && $playerDetails['player_twenty_five'] != ""){$playerNameDetails->player_twenty_five = $playerDetails['player_twenty_five'];}else{$playerNameDetails->player_twenty_five = "";}
                    if(isset($playerDetails['player_twenty_six']) && $playerDetails['player_twenty_six'] != ""){$playerNameDetails->player_twenty_six = $playerDetails['player_twenty_six'];}else{$playerNameDetails->player_twenty_six = "";}
                    if(isset($playerDetails['player_twenty_seven']) && $playerDetails['player_twenty_seven'] != ""){$playerNameDetails->player_twenty_seven = $playerDetails['player_twenty_seven'];}else{$playerNameDetails->player_twenty_seven = "";}
                    if(isset($playerDetails['player_twenty_eight']) && $playerDetails['player_twenty_eight'] != ""){$playerNameDetails->player_twenty_eight = $playerDetails['player_twenty_eight'];}else{$playerNameDetails->player_twenty_eight = "";}
                    if(isset($playerDetails['player_twenty_nine']) && $playerDetails['player_twenty_nine'] != ""){$playerNameDetails->player_twenty_nine = $playerDetails['player_twenty_nine'];}else{$playerNameDetails->player_twenty_nine = "";}
                    if(isset($playerDetails['player_thirty']) && $playerDetails['player_thirty'] != ""){$playerNameDetails->player_thirty = $playerDetails['player_thirty'];}else{$playerNameDetails->player_thirty = "";}

                    if(isset($playerDetails['player_thirty_one']) && $playerDetails['player_thirty_one'] != ""){$playerNameDetails->player_thirty_one = $playerDetails['player_thirty_one'];}else{$playerNameDetails->player_thirty_one = "";}
                    if(isset($playerDetails['player_thirty_two']) && $playerDetails['player_thirty_two'] != ""){$playerNameDetails->player_thirty_two = $playerDetails['player_thirty_two'];}else{$playerNameDetails->player_thirty_two = "";}
                    if(isset($playerDetails['player_thirty_three']) && $playerDetails['player_thirty_three'] != ""){$playerNameDetails->player_thirty_three = $playerDetails['player_thirty_three'];}else{$playerNameDetails->player_thirty_three = "";}
                    if(isset($playerDetails['player_thirty_four']) && $playerDetails['player_thirty_four'] != ""){$playerNameDetails->player_thirty_four = $playerDetails['player_thirty_four'];}else{$playerNameDetails->player_thirty_four = "";}
                    if(isset($playerDetails['player_thirty_five']) && $playerDetails['player_thirty_five'] != ""){$playerNameDetails->player_thirty_five = $playerDetails['player_thirty_five'];}else{$playerNameDetails->player_thirty_five = "";}
                    if(isset($playerDetails['player_thirty_six']) && $playerDetails['player_thirty_six'] != ""){$playerNameDetails->player_thirty_six = $playerDetails['player_thirty_six'];}else{$playerNameDetails->player_thirty_six = "";}
                    if(isset($playerDetails['player_thirty_seven']) && $playerDetails['player_thirty_seven'] != ""){$playerNameDetails->player_thirty_seven = $playerDetails['player_thirty_seven'];}else{$playerNameDetails->player_thirty_seven = "";}
                    if(isset($playerDetails['player_thirty_eight']) && $playerDetails['player_thirty_eight'] != ""){$playerNameDetails->player_thirty_eight = $playerDetails['player_thirty_eight'];}else{$playerNameDetails->player_thirty_eight = "";}
                    if(isset($playerDetails['player_thirty_nine']) && $playerDetails['player_thirty_nine'] != ""){$playerNameDetails->player_thirty_nine = $playerDetails['player_thirty_nine'];}else{$playerNameDetails->player_thirty_nine = "";}
                    if(isset($playerDetails['player_forty']) && $playerDetails['player_forty'] != ""){$playerNameDetails->player_forty = $playerDetails['player_forty'];}else{$playerNameDetails->player_forty = "";}

                    if(isset($playerDetails['player_forty_one']) && $playerDetails['player_forty_one'] != ""){$playerNameDetails->player_forty_one = $playerDetails['player_forty_one'];}else{$playerNameDetails->player_forty_one = "";}
                    if(isset($playerDetails['player_forty_two']) && $playerDetails['player_forty_two'] != ""){$playerNameDetails->player_forty_two = $playerDetails['player_forty_two'];}else{$playerNameDetails->player_forty_two = "";}
                    if(isset($playerDetails['player_forty_three']) && $playerDetails['player_forty_three'] != ""){$playerNameDetails->player_forty_three = $playerDetails['player_forty_three'];}else{$playerNameDetails->player_forty_three = "";}
                    if(isset($playerDetails['player_forty_four']) && $playerDetails['player_forty_four'] != ""){$playerNameDetails->player_forty_four = $playerDetails['player_forty_four'];}else{$playerNameDetails->player_forty_four = "";}
                    if(isset($playerDetails['player_forty_five']) && $playerDetails['player_forty_five'] != ""){$playerNameDetails->player_forty_five = $playerDetails['player_forty_five'];}else{$playerNameDetails->player_forty_five = "";}
                    if(isset($playerDetails['player_forty_six']) && $playerDetails['player_forty_six'] != ""){$playerNameDetails->player_forty_six = $playerDetails['player_forty_six'];}else{$playerNameDetails->player_forty_six = "";}
                    if(isset($playerDetails['player_forty_seven']) && $playerDetails['player_forty_seven'] != ""){$playerNameDetails->player_forty_seven = $playerDetails['player_forty_seven'];}else{$playerNameDetails->player_forty_seven = "";}
                    if(isset($playerDetails['player_forty_eight']) && $playerDetails['player_forty_eight'] != ""){$playerNameDetails->player_forty_eight = $playerDetails['player_forty_eight'];}else{$playerNameDetails->player_forty_eight = "";}
                    if(isset($playerDetails['player_forty_nine']) && $playerDetails['player_forty_nine'] != ""){$playerNameDetails->player_forty_nine = $playerDetails['player_forty_nine'];}else{$playerNameDetails->player_forty_nine = "";}
                    if(isset($playerDetails['player_fifty']) && $playerDetails['player_fifty'] != ""){$playerNameDetails->player_fifty = $playerDetails['player_fifty'];}else{$playerNameDetails->player_fifty = "";}

                    if(isset($playerDetails['player_fifty_one']) && $playerDetails['player_fifty_one'] != ""){$playerNameDetails->player_fifty_one = $playerDetails['player_fifty_one'];}else{$playerNameDetails->player_fifty_one = "";}
                    if(isset($playerDetails['player_fifty_two']) && $playerDetails['player_fifty_two'] != ""){$playerNameDetails->player_fifty_two = $playerDetails['player_fifty_two'];}else{$playerNameDetails->player_fifty_two = "";}
                    if(isset($playerDetails['player_fifty_three']) && $playerDetails['player_fifty_three'] != ""){$playerNameDetails->player_fifty_three = $playerDetails['player_fifty_three'];}else{$playerNameDetails->player_fifty_three = "";}
                    if(isset($playerDetails['player_fifty_four']) && $playerDetails['player_fifty_four'] != ""){$playerNameDetails->player_fifty_four = $playerDetails['player_fifty_four'];}else{$playerNameDetails->player_fifty_four = "";}
                    if(isset($playerDetails['player_fifty_five']) && $playerDetails['player_fifty_five'] != ""){$playerNameDetails->player_fifty_five = $playerDetails['player_fifty_five'];}else{$playerNameDetails->player_fifty_five = "";}
                    if(isset($playerDetails['player_fifty_six']) && $playerDetails['player_fifty_six'] != ""){$playerNameDetails->player_fifty_six = $playerDetails['player_fifty_six'];}else{$playerNameDetails->player_fifty_six = "";}
                    if(isset($playerDetails['player_fifty_seven']) && $playerDetails['player_fifty_seven'] != ""){$playerNameDetails->player_fifty_seven = $playerDetails['player_fifty_seven'];}else{$playerNameDetails->player_fifty_seven = "";}
                    if(isset($playerDetails['player_fifty_eight']) && $playerDetails['player_fifty_eight'] != ""){$playerNameDetails->player_fifty_eight = $playerDetails['player_fifty_eight'];}else{$playerNameDetails->player_fifty_eight = "";}
                    if(isset($playerDetails['player_fifty_nine']) && $playerDetails['player_fifty_nine'] != ""){$playerNameDetails->player_fifty_nine = $playerDetails['player_fifty_nine'];}else{$playerNameDetails->player_fifty_nine = "";}
                    if(isset($playerDetails['player_sixty']) && $playerDetails['player_sixty'] != ""){$playerNameDetails->player_sixty = $playerDetails['player_sixty'];}else{$playerNameDetails->player_sixty = "";}

                    if(isset($playerDetails['player_sixty_one']) && $playerDetails['player_sixty_one'] != ""){$playerNameDetails->player_sixty_one = $playerDetails['player_sixty_one'];}else{$playerNameDetails->player_sixty_one = "";}
                    if(isset($playerDetails['player_sixty_two']) && $playerDetails['player_sixty_two'] != ""){$playerNameDetails->player_sixty_two = $playerDetails['player_sixty_two'];}else{$playerNameDetails->player_sixty_two = "";}
                    if(isset($playerDetails['player_sixty_three']) && $playerDetails['player_sixty_three'] != ""){$playerNameDetails->player_sixty_three = $playerDetails['player_sixty_three'];}else{$playerNameDetails->player_sixty_three = "";}
                    if(isset($playerDetails['player_sixty_four']) && $playerDetails['player_sixty_four'] != ""){$playerNameDetails->player_sixty_four = $playerDetails['player_sixty_four'];}else{$playerNameDetails->player_sixty_four = "";}
                    if(isset($playerDetails['player_sixty_five']) && $playerDetails['player_sixty_five'] != ""){$playerNameDetails->player_sixty_five = $playerDetails['player_sixty_five'];}else{$playerNameDetails->player_sixty_five = "";}
                    if(isset($playerDetails['player_sixty_six']) && $playerDetails['player_sixty_six'] != ""){$playerNameDetails->player_sixty_six = $playerDetails['player_sixty_six'];}else{$playerNameDetails->player_sixty_six = "";}
                    if(isset($playerDetails['player_sixty_seven']) && $playerDetails['player_sixty_seven'] != ""){$playerNameDetails->player_sixty_seven = $playerDetails['player_sixty_seven'];}else{$playerNameDetails->player_sixty_seven = "";}
                    if(isset($playerDetails['player_sixty_eight']) && $playerDetails['player_sixty_eight'] != ""){$playerNameDetails->player_sixty_eight = $playerDetails['player_sixty_eight'];}else{$playerNameDetails->player_sixty_eight = "";}
                    if(isset($playerDetails['player_sixty_nine']) && $playerDetails['player_sixty_nine'] != ""){$playerNameDetails->player_sixty_nine = $playerDetails['player_sixty_nine'];}else{$playerNameDetails->player_sixty_nine = "";}
                    if(isset($playerDetails['player_seventy']) && $playerDetails['player_seventy'] != ""){$playerNameDetails->player_seventy = $playerDetails['player_seventy'];}else{$playerNameDetails->player_seventy = "";}

                    if(isset($playerDetails['player_seventy_one']) && $playerDetails['player_seventy_one'] != ""){$playerNameDetails->player_seventy_one = $playerDetails['player_seventy_one'];}else{$playerNameDetails->player_seventy_one = "";}
                    if(isset($playerDetails['player_seventy_two']) && $playerDetails['player_seventy_two'] != ""){$playerNameDetails->player_seventy_two = $playerDetails['player_seventy_two'];}else{$playerNameDetails->player_seventy_two = "";}
                    if(isset($playerDetails['player_seventy_three']) && $playerDetails['player_seventy_three'] != ""){$playerNameDetails->player_seventy_three = $playerDetails['player_seventy_three'];}else{$playerNameDetails->player_seventy_three = "";}
                    if(isset($playerDetails['player_seventy_four']) && $playerDetails['player_seventy_four'] != ""){$playerNameDetails->player_seventy_four = $playerDetails['player_seventy_four'];}else{$playerNameDetails->player_seventy_four = "";}
                    if(isset($playerDetails['player_seventy_five']) && $playerDetails['player_seventy_five'] != ""){$playerNameDetails->player_seventy_five = $playerDetails['player_seventy_five'];}else{$playerNameDetails->player_seventy_five = "";}
                    if(isset($playerDetails['player_seventy_six']) && $playerDetails['player_seventy_six'] != ""){$playerNameDetails->player_seventy_six = $playerDetails['player_seventy_six'];}else{$playerNameDetails->player_seventy_six = "";}
                    if(isset($playerDetails['player_seventy_seven']) && $playerDetails['player_seventy_seven'] != ""){$playerNameDetails->player_seventy_seven = $playerDetails['player_seventy_seven'];}else{$playerNameDetails->player_seventy_seven = "";}
                    if(isset($playerDetails['player_seventy_eight']) && $playerDetails['player_seventy_eight'] != ""){$playerNameDetails->player_seventy_eight = $playerDetails['player_seventy_eight'];}else{$playerNameDetails->player_seventy_eight = "";}
                    if(isset($playerDetails['player_seventy_nine']) && $playerDetails['player_seventy_nine'] != ""){$playerNameDetails->player_seventy_nine = $playerDetails['player_seventy_nine'];}else{$playerNameDetails->player_seventy_nine = "";}
                    if(isset($playerDetails['player_eighty']) && $playerDetails['player_eighty'] != ""){$playerNameDetails->player_eighty = $playerDetails['player_eighty'];}else{$playerNameDetails->player_eighty = "";}

                    if(isset($playerDetails['player_eighty_one']) && $playerDetails['player_eighty_one'] != ""){$playerNameDetails->player_eighty_one = $playerDetails['player_eighty_one'];}else{$playerNameDetails->player_eighty_one = "";}
                    if(isset($playerDetails['player_eighty_two']) && $playerDetails['player_eighty_two'] != ""){$playerNameDetails->player_eighty_two = $playerDetails['player_eighty_two'];}else{$playerNameDetails->player_eighty_two = "";}
                    if(isset($playerDetails['player_eighty_three']) && $playerDetails['player_eighty_three'] != ""){$playerNameDetails->player_eighty_three = $playerDetails['player_eighty_three'];}else{$playerNameDetails->player_eighty_three = "";}
                    if(isset($playerDetails['player_eighty_four']) && $playerDetails['player_eighty_four'] != ""){$playerNameDetails->player_eighty_four = $playerDetails['player_eighty_four'];}else{$playerNameDetails->player_eighty_four = "";}
                    if(isset($playerDetails['player_eighty_five']) && $playerDetails['player_eighty_five'] != ""){$playerNameDetails->player_eighty_five = $playerDetails['player_eighty_five'];}else{$playerNameDetails->player_eighty_five = "";}
                    if(isset($playerDetails['player_eighty_six']) && $playerDetails['player_eighty_six'] != ""){$playerNameDetails->player_eighty_six = $playerDetails['player_eighty_six'];}else{$playerNameDetails->player_eighty_six = "";}
                    if(isset($playerDetails['player_eighty_seven']) && $playerDetails['player_eighty_seven'] != ""){$playerNameDetails->player_eighty_seven = $playerDetails['player_eighty_seven'];}else{$playerNameDetails->player_eighty_seven = "";}
                    if(isset($playerDetails['player_eighty_eight']) && $playerDetails['player_eighty_eight'] != ""){$playerNameDetails->player_eighty_eight = $playerDetails['player_eighty_eight'];}else{$playerNameDetails->player_eighty_eight = "";}
                    if(isset($playerDetails['player_eighty_nine']) && $playerDetails['player_eighty_nine'] != ""){$playerNameDetails->player_eighty_nine = $playerDetails['player_eighty_nine'];}else{$playerNameDetails->player_eighty_nine = "";}
                    if(isset($playerDetails['player_ninety']) && $playerDetails['player_ninety'] != ""){$playerNameDetails->player_ninety = $playerDetails['player_ninety'];}else{$playerNameDetails->player_ninety = "";}

                    if(isset($playerDetails['player_ninety_one']) && $playerDetails['player_ninety_one'] != ""){$playerNameDetails->player_ninety_one = $playerDetails['player_ninety_one'];}else{$playerNameDetails->player_ninety_one = "";}
                    if(isset($playerDetails['player_ninety_two']) && $playerDetails['player_ninety_two'] != ""){$playerNameDetails->player_ninety_two = $playerDetails['player_ninety_two'];}else{$playerNameDetails->player_ninety_two = "";}
                    if(isset($playerDetails['player_ninety_three']) && $playerDetails['player_ninety_three'] != ""){$playerNameDetails->player_ninety_three = $playerDetails['player_ninety_three'];}else{$playerNameDetails->player_ninety_three = "";}
                    if(isset($playerDetails['player_ninety_four']) && $playerDetails['player_ninety_four'] != ""){$playerNameDetails->player_ninety_four = $playerDetails['player_ninety_four'];}else{$playerNameDetails->player_ninety_four = "";}
                    if(isset($playerDetails['player_ninety_five']) && $playerDetails['player_ninety_five'] != ""){$playerNameDetails->player_ninety_five = $playerDetails['player_ninety_five'];}else{$playerNameDetails->player_ninety_five = "";}
                    if(isset($playerDetails['player_ninety_six']) && $playerDetails['player_ninety_six'] != ""){$playerNameDetails->player_ninety_six = $playerDetails['player_ninety_six'];}else{$playerNameDetails->player_ninety_six = "";}
                    if(isset($playerDetails['player_ninety_seven']) && $playerDetails['player_ninety_seven'] != ""){$playerNameDetails->player_ninety_seven = $playerDetails['player_ninety_seven'];}else{$playerNameDetails->player_ninety_seven = "";}
                    if(isset($playerDetails['player_ninety_eight']) && $playerDetails['player_ninety_eight'] != ""){$playerNameDetails->player_ninety_eight = $playerDetails['player_ninety_eight'];}else{$playerNameDetails->player_ninety_eight = "";}
                    if(isset($playerDetails['player_ninety_nine']) && $playerDetails['player_ninety_nine'] != ""){$playerNameDetails->player_ninety_nine = $playerDetails['player_ninety_nine'];}else{$playerNameDetails->player_ninety_nine = "";}
                    if(isset($playerDetails['player_hundred']) && $playerDetails['player_hundred'] != ""){$playerNameDetails->player_hundred = $playerDetails['player_hundred'];}else{$playerNameDetails->player_hundred = "";}

                    if(isset($blankProductArray[$playerDetails['itemId']]) && $blankProductArray[$playerDetails['itemId']] > 0){ $playerNameDetails->blank_qty = $blankProductArray[$playerDetails['itemId']];}else{$playerNameDetails->blank_qty = 0;}
                    if(isset($playerDetails['blank_players'])){ $playerNameDetails->blank_player_names = json_encode($playerDetails['blank_players']);}else{$playerNameDetails->blank_player_names = "";}

                    $playerNameDetails->save();
                }
            }
        }

        if(isset($request->saveLeave))
        {
            if($request->saveLeave == "yes")
            {
                return "DoneAjaxPost";
            }
        }

        $this->setShippingFee($request->order_id);

        return redirect()->to('roster/'.$request->order_id.'?active_tab='.$request->order_item_id)->withSuccess('Order Updated Successfully!');
    }

    public function complete($id){
        $order = Order::find($id);
        $order->is_editable = 0;
        $order->update();

        return redirect()->route('roster', $id);
    }

    public function request(Request $request){
        $order = Order::find($request->order_id);
        $order->is_requested = 1;
        $order->request_reasons = $request->request_reasons;
        $order->update();

        return redirect()->route('roster', $request->order_id);
    }

    public function printOrderItem($id){
        $orderItem = OrderItem::with('productDetails', 'factoryDetails', 'exFactoryDetails', 'fabricDetails', 'secFabricDetails',
                                     'embellishmentDetails', 'orderItemDetails.sizeDetails')
                              ->find($id);

        $order = Order::with('organizationDetails', 'userDetails', 'contactDetails')->find($orderItem->order_id);

        $blackQty = orderItemsDetail::where('order_item_id', $orderItem->id)->sum('blanks');

        $numQty = orderItemsDetail::where('order_item_id', $orderItem->id)->sum('qty');

        return view('pages.order_management.roster.order_item_print', [
            'order'=>$order, 'orderItem'=>$orderItem, 'blackQty'=>$blackQty, 'numQty'=>$numQty
        ]);
    }

    public function newAddress(Request $request){
        $order = Order::find($request->new_address_order_id);
        $order->is_new_shipping_address = 1;
        $order->street = $request->new_street;
        $order->city = $request->new_city;
        $order->state = $request->new_state;
        $order->postal_code = $request->new_postal_code;
        $order->country = $request->new_country;
        $order->phone_no = $request->new_phone_no;
        $order->email = $request->new_email;
        $order->update();

        return redirect()->to('roster/'.$request->new_address_order_id.'?active_tab=order')->withSuccess('Customer Address Updated Successfully!');
    }

    public function setShippingFee($orderId){
        $order = Order::find($orderId);
        $orderTotal = $order->order_total;
        $orderTotal = $orderTotal - $order->shipping;
        $orderQty = OrderItem::where('order_id', $orderId)->get()->sum('qty');
        if($orderQty > 70){
            $shippingFee = 0.5 * $orderQty;
        } else if($orderQty == 0){
            $shippingFee = 0;
        } else {
            $shippingFee = 35;
        }
        $order->shipping = $shippingFee;
        $order->order_total = $orderTotal + $shippingFee;
        $order->update();
    }

    public function pasteRoster(Request $request) {
        $copiedItemDetails = OrderItemsDetail::where('order_item_id', $request->copied_item_id)->get();

        $isSizeExist = '';
        $totalQty = 0;
        $blankProductArray = [];
        foreach ($copiedItemDetails as $copiedItemDetail) {
            $orderItemsDetail = OrderItemsDetail::where('order_item_id', $request->item_id)->where('size_id', $copiedItemDetail->size_id)->first();

            if ($orderItemsDetail) {
                $isSizeExist = 'size_exist';
                $orderItemsDetail->blanks = $copiedItemDetail->blanks;
                $orderItemsDetail->qty = $copiedItemDetail->qty;

                $totalQty = $totalQty + $copiedItemDetail->blanks + $copiedItemDetail->qty;

                if($copiedItemDetail->blanks > 0){
                    $blankProductArray[$copiedItemDetail->id] = $copiedItemDetail->blanks;
                }

                if ($copiedItemDetail->numseq_one != ""){ $orderItemsDetail->numseq_one = $copiedItemDetail->numseq_one; } else { $orderItemsDetail->numseq_one = "";}
                if ($copiedItemDetail->numseq_two != ""){ $orderItemsDetail->numseq_two = $copiedItemDetail->numseq_two; } else { $orderItemsDetail->numseq_two = "";}
                if ($copiedItemDetail->numseq_three != ""){ $orderItemsDetail->numseq_three = $copiedItemDetail->numseq_three; } else { $orderItemsDetail->numseq_three = "";}
                if ($copiedItemDetail->numseq_four != ""){ $orderItemsDetail->numseq_four = $copiedItemDetail->numseq_four; } else { $orderItemsDetail->numseq_four = "";}
                if ($copiedItemDetail->numseq_five != ""){ $orderItemsDetail->numseq_five = $copiedItemDetail->numseq_five; } else { $orderItemsDetail->numseq_five = "";}
                if ($copiedItemDetail->numseq_six != ""){ $orderItemsDetail->numseq_six = $copiedItemDetail->numseq_six; } else { $orderItemsDetail->numseq_six = "";}
                if ($copiedItemDetail->numseq_seven != ""){ $orderItemsDetail->numseq_seven = $copiedItemDetail->numseq_seven; } else { $orderItemsDetail->numseq_seven = "";}
                if ($copiedItemDetail->numseq_eight != ""){ $orderItemsDetail->numseq_eight = $copiedItemDetail->numseq_eight; } else { $orderItemsDetail->numseq_eight = "";}
                if ($copiedItemDetail->numseq_nine != ""){ $orderItemsDetail->numseq_nine = $copiedItemDetail->numseq_nine; } else { $orderItemsDetail->numseq_nine = "";}
                if ($copiedItemDetail->numseq_ten != ""){ $orderItemsDetail->numseq_ten = $copiedItemDetail->numseq_ten; } else { $orderItemsDetail->numseq_ten = "";}

                if ($copiedItemDetail->numseq_eleven != ""){ $orderItemsDetail->numseq_eleven = $copiedItemDetail->numseq_eleven; } else { $orderItemsDetail->numseq_eleven = "";}
                if ($copiedItemDetail->numseq_twelve != ""){ $orderItemsDetail->numseq_twelve = $copiedItemDetail->numseq_twelve; } else { $orderItemsDetail->numseq_twelve = "";}
                if ($copiedItemDetail->numseq_thirteen != ""){ $orderItemsDetail->numseq_thirteen = $copiedItemDetail->numseq_thirteen; } else { $orderItemsDetail->numseq_thirteen = "";}
                if ($copiedItemDetail->numseq_fourteen != ""){ $orderItemsDetail->numseq_fourteen = $copiedItemDetail->numseq_fourteen; } else { $orderItemsDetail->numseq_fourteen = "";}
                if ($copiedItemDetail->numseq_fifteen != ""){ $orderItemsDetail->numseq_fifteen = $copiedItemDetail->numseq_fifteen; } else { $orderItemsDetail->numseq_fifteen = "";}
                if ($copiedItemDetail->numseq_sixteen != ""){ $orderItemsDetail->numseq_sixteen = $copiedItemDetail->numseq_sixteen; } else { $orderItemsDetail->numseq_sixteen = "";}
                if ($copiedItemDetail->numseq_seventeen != ""){ $orderItemsDetail->numseq_seventeen = $copiedItemDetail->numseq_seventeen; } else { $orderItemsDetail->numseq_seventeen = "";}
                if ($copiedItemDetail->numseq_eighteen != ""){ $orderItemsDetail->numseq_eighteen = $copiedItemDetail->numseq_eighteen; } else { $orderItemsDetail->numseq_eighteen = "";}
                if ($copiedItemDetail->numseq_nineteen != ""){ $orderItemsDetail->numseq_nineteen = $copiedItemDetail->numseq_nineteen; } else { $orderItemsDetail->numseq_nineteen = "";}
                if ($copiedItemDetail->numseq_twenty != ""){ $orderItemsDetail->numseq_twenty = $copiedItemDetail->numseq_twenty; } else { $orderItemsDetail->numseq_twenty = "";}

                if ($copiedItemDetail->numseq_twenty_one != ""){ $orderItemsDetail->numseq_twenty_one = $copiedItemDetail->numseq_twenty_one; } else { $orderItemsDetail->numseq_twenty_one = "";}
                if ($copiedItemDetail->numseq_twenty_two != ""){ $orderItemsDetail->numseq_twenty_two = $copiedItemDetail->numseq_twenty_two; } else { $orderItemsDetail->numseq_twenty_two = "";}
                if ($copiedItemDetail->numseq_twenty_three != ""){ $orderItemsDetail->numseq_twenty_three = $copiedItemDetail->numseq_twenty_three; } else { $orderItemsDetail->numseq_twenty_three = "";}
                if ($copiedItemDetail->numseq_twenty_four != ""){ $orderItemsDetail->numseq_twenty_four = $copiedItemDetail->numseq_twenty_four; } else { $orderItemsDetail->numseq_twenty_four = "";}
                if ($copiedItemDetail->numseq_twenty_five != ""){ $orderItemsDetail->numseq_twenty_five = $copiedItemDetail->numseq_twenty_five; } else { $orderItemsDetail->numseq_twenty_five = "";}
                if ($copiedItemDetail->numseq_twenty_six != ""){ $orderItemsDetail->numseq_twenty_six = $copiedItemDetail->numseq_twenty_six; } else { $orderItemsDetail->numseq_twenty_six = "";}
                if ($copiedItemDetail->numseq_twenty_seven != ""){ $orderItemsDetail->numseq_twenty_seven = $copiedItemDetail->numseq_twenty_seven; } else { $orderItemsDetail->numseq_twenty_seven = "";}
                if ($copiedItemDetail->numseq_twenty_eight != ""){ $orderItemsDetail->numseq_twenty_eight = $copiedItemDetail->numseq_twenty_eight; } else { $orderItemsDetail->numseq_twenty_eight = "";}
                if ($copiedItemDetail->numseq_twenty_nine != ""){ $orderItemsDetail->numseq_twenty_nine = $copiedItemDetail->numseq_twenty_nine; } else { $orderItemsDetail->numseq_twenty_nine = "";}
                if ($copiedItemDetail->numseq_thirty != ""){ $orderItemsDetail->numseq_thirty = $copiedItemDetail->numseq_thirty; } else { $orderItemsDetail->numseq_thirty = "";}

                if ($copiedItemDetail->numseq_thirty_one != ""){ $orderItemsDetail->numseq_thirty_one = $copiedItemDetail->numseq_thirty_one; } else { $orderItemsDetail->numseq_thirty_one = "";}
                if ($copiedItemDetail->numseq_thirty_two != ""){ $orderItemsDetail->numseq_thirty_two = $copiedItemDetail->numseq_thirty_two; } else { $orderItemsDetail->numseq_thirty_two = "";}
                if ($copiedItemDetail->numseq_thirty_three != ""){ $orderItemsDetail->numseq_thirty_three = $copiedItemDetail->numseq_thirty_three; } else { $orderItemsDetail->numseq_thirty_three = "";}
                if ($copiedItemDetail->numseq_thirty_four != ""){ $orderItemsDetail->numseq_thirty_four = $copiedItemDetail->numseq_thirty_four; } else { $orderItemsDetail->numseq_thirty_four = "";}
                if ($copiedItemDetail->numseq_thirty_five != ""){ $orderItemsDetail->numseq_thirty_five = $copiedItemDetail->numseq_thirty_five; } else { $orderItemsDetail->numseq_thirty_five = "";}
                if ($copiedItemDetail->numseq_thirty_six != ""){ $orderItemsDetail->numseq_thirty_six = $copiedItemDetail->numseq_thirty_six; } else { $orderItemsDetail->numseq_thirty_six = "";}
                if ($copiedItemDetail->numseq_thirty_seven != ""){ $orderItemsDetail->numseq_thirty_seven = $copiedItemDetail->numseq_thirty_seven; } else { $orderItemsDetail->numseq_thirty_seven = "";}
                if ($copiedItemDetail->numseq_thirty_eight != ""){ $orderItemsDetail->numseq_thirty_eight = $copiedItemDetail->numseq_thirty_eight; } else { $orderItemsDetail->numseq_thirty_eight = "";}
                if ($copiedItemDetail->numseq_thirty_nine != ""){ $orderItemsDetail->numseq_thirty_nine = $copiedItemDetail->numseq_thirty_nine; } else { $orderItemsDetail->numseq_thirty_nine = "";}
                if ($copiedItemDetail->numseq_forty != ""){ $orderItemsDetail->numseq_forty = $copiedItemDetail->numseq_forty; } else { $orderItemsDetail->numseq_forty = "";}

                if ($copiedItemDetail->numseq_forty_one != ""){ $orderItemsDetail->numseq_forty_one = $copiedItemDetail->numseq_forty_one; } else { $orderItemsDetail->numseq_forty_one = "";}
                if ($copiedItemDetail->numseq_forty_two != ""){ $orderItemsDetail->numseq_forty_two = $copiedItemDetail->numseq_forty_two; } else { $orderItemsDetail->numseq_forty_two = "";}
                if ($copiedItemDetail->numseq_forty_three != ""){ $orderItemsDetail->numseq_forty_three = $copiedItemDetail->numseq_forty_three; } else { $orderItemsDetail->numseq_forty_three = "";}
                if ($copiedItemDetail->numseq_forty_four != ""){ $orderItemsDetail->numseq_forty_four = $copiedItemDetail->numseq_forty_four; } else { $orderItemsDetail->numseq_forty_four = "";}
                if ($copiedItemDetail->numseq_forty_five != ""){ $orderItemsDetail->numseq_forty_five = $copiedItemDetail->numseq_forty_five; } else { $orderItemsDetail->numseq_forty_five = "";}
                if ($copiedItemDetail->numseq_forty_six != ""){ $orderItemsDetail->numseq_forty_six = $copiedItemDetail->numseq_forty_six; } else { $orderItemsDetail->numseq_forty_six = "";}
                if ($copiedItemDetail->numseq_forty_seven != ""){ $orderItemsDetail->numseq_forty_seven = $copiedItemDetail->numseq_forty_seven; } else { $orderItemsDetail->numseq_forty_seven = "";}
                if ($copiedItemDetail->numseq_forty_eight != ""){ $orderItemsDetail->numseq_forty_eight = $copiedItemDetail->numseq_forty_eight; } else { $orderItemsDetail->numseq_forty_eight = "";}
                if ($copiedItemDetail->numseq_forty_nine != ""){ $orderItemsDetail->numseq_forty_nine = $copiedItemDetail->numseq_forty_nine; } else { $orderItemsDetail->numseq_forty_nine = "";}
                if ($copiedItemDetail->numseq_fifty != ""){ $orderItemsDetail->numseq_fifty = $copiedItemDetail->numseq_fifty; } else { $orderItemsDetail->numseq_fifty = "";}

                if($copiedItemDetail->numseq_fifty_one != ""){$orderItemsDetail->numseq_fifty_one = $copiedItemDetail->numseq_fifty_one;}else{$orderItemsDetail->numseq_fifty_one = "";}
                if($copiedItemDetail->numseq_fifty_two != ""){$orderItemsDetail->numseq_fifty_two = $copiedItemDetail->numseq_fifty_two;}else{$orderItemsDetail->numseq_fifty_two = "";}
                if($copiedItemDetail->numseq_fifty_three != ""){$orderItemsDetail->numseq_fifty_three = $copiedItemDetail->numseq_fifty_three;}else{$orderItemsDetail->numseq_fifty_three = "";}
                if($copiedItemDetail->numseq_fifty_four != ""){$orderItemsDetail->numseq_fifty_four = $copiedItemDetail->numseq_fifty_four;}else{$orderItemsDetail->numseq_fifty_four = "";}
                if($copiedItemDetail->numseq_fifty_five != ""){$orderItemsDetail->numseq_fifty_five = $copiedItemDetail->numseq_fifty_five;}else{$orderItemsDetail->numseq_fifty_five = "";}
                if($copiedItemDetail->numseq_fifty_six != ""){$orderItemsDetail->numseq_fifty_six = $copiedItemDetail->numseq_fifty_six;}else{$orderItemsDetail->numseq_fifty_six = "";}
                if($copiedItemDetail->numseq_fifty_seven != ""){$orderItemsDetail->numseq_fifty_seven = $copiedItemDetail->numseq_fifty_seven;}else{$orderItemsDetail->numseq_fifty_seven = "";}
                if($copiedItemDetail->numseq_fifty_eight != ""){$orderItemsDetail->numseq_fifty_eight = $copiedItemDetail->numseq_fifty_eight;}else{$orderItemsDetail->numseq_fifty_eight = "";}
                if($copiedItemDetail->numseq_fifty_nine != ""){$orderItemsDetail->numseq_fifty_nine = $copiedItemDetail->numseq_fifty_nine;}else{$orderItemsDetail->numseq_fifty_nine = "";}
                if($copiedItemDetail->numseq_sixty != ""){$orderItemsDetail->numseq_sixty = $copiedItemDetail->numseq_sixty;}else{$orderItemsDetail->numseq_sixty = "";}

                if($copiedItemDetail->numseq_sixty_one != ""){$orderItemsDetail->numseq_sixty_one = $copiedItemDetail->numseq_sixty_one;}else{$orderItemsDetail->numseq_sixty_one = "";}
                if($copiedItemDetail->numseq_sixty_two != ""){$orderItemsDetail->numseq_sixty_two = $copiedItemDetail->numseq_sixty_two;}else{$orderItemsDetail->numseq_sixty_two = "";}
                if($copiedItemDetail->numseq_sixty_three != ""){$orderItemsDetail->numseq_sixty_three = $copiedItemDetail->numseq_sixty_three;}else{$orderItemsDetail->numseq_sixty_three = "";}
                if($copiedItemDetail->numseq_sixty_four != ""){$orderItemsDetail->numseq_sixty_four = $copiedItemDetail->numseq_sixty_four;}else{$orderItemsDetail->numseq_sixty_four = "";}
                if($copiedItemDetail->numseq_sixty_five != ""){$orderItemsDetail->numseq_sixty_five = $copiedItemDetail->numseq_sixty_five;}else{$orderItemsDetail->numseq_sixty_five = "";}
                if($copiedItemDetail->numseq_sixty_six != ""){$orderItemsDetail->numseq_sixty_six = $copiedItemDetail->numseq_sixty_six;}else{$orderItemsDetail->numseq_sixty_six = "";}
                if($copiedItemDetail->numseq_sixty_seven != ""){$orderItemsDetail->numseq_sixty_seven = $copiedItemDetail->numseq_sixty_seven;}else{$orderItemsDetail->numseq_sixty_seven = "";}
                if($copiedItemDetail->numseq_sixty_eight != ""){$orderItemsDetail->numseq_sixty_eight = $copiedItemDetail->numseq_sixty_eight;}else{$orderItemsDetail->numseq_sixty_eight = "";}
                if($copiedItemDetail->numseq_sixty_nine != ""){$orderItemsDetail->numseq_sixty_nine = $copiedItemDetail->numseq_sixty_nine;}else{$orderItemsDetail->numseq_sixty_nine = "";}
                if($copiedItemDetail->numseq_seventy != ""){$orderItemsDetail->numseq_seventy = $copiedItemDetail->numseq_seventy;}else{$orderItemsDetail->numseq_seventy = "";}

                if($copiedItemDetail->numseq_seventy_one != ""){$orderItemsDetail->numseq_seventy_one = $copiedItemDetail->numseq_seventy_one;}else{$orderItemsDetail->numseq_seventy_one = "";}
                if($copiedItemDetail->numseq_seventy_two != ""){$orderItemsDetail->numseq_seventy_two = $copiedItemDetail->numseq_seventy_two;}else{$orderItemsDetail->numseq_seventy_two = "";}
                if($copiedItemDetail->numseq_seventy_three != ""){$orderItemsDetail->numseq_seventy_three = $copiedItemDetail->numseq_seventy_three;}else{$orderItemsDetail->numseq_seventy_three = "";}
                if($copiedItemDetail->numseq_seventy_four != ""){$orderItemsDetail->numseq_seventy_four = $copiedItemDetail->numseq_seventy_four;}else{$orderItemsDetail->numseq_seventy_four = "";}
                if($copiedItemDetail->numseq_seventy_five != ""){$orderItemsDetail->numseq_seventy_five = $copiedItemDetail->numseq_seventy_five;}else{$orderItemsDetail->numseq_seventy_five = "";}
                if($copiedItemDetail->numseq_seventy_six != ""){$orderItemsDetail->numseq_seventy_six = $copiedItemDetail->numseq_seventy_six;}else{$orderItemsDetail->numseq_seventy_six = "";}
                if($copiedItemDetail->numseq_seventy_seven != ""){$orderItemsDetail->numseq_seventy_seven = $copiedItemDetail->numseq_seventy_seven;}else{$orderItemsDetail->numseq_seventy_seven = "";}
                if($copiedItemDetail->numseq_seventy_eight != ""){$orderItemsDetail->numseq_seventy_eight = $copiedItemDetail->numseq_seventy_eight;}else{$orderItemsDetail->numseq_seventy_eight = "";}
                if($copiedItemDetail->numseq_seventy_nine != ""){$orderItemsDetail->numseq_seventy_nine = $copiedItemDetail->numseq_seventy_nine;}else{$orderItemsDetail->numseq_seventy_nine = "";}
                if($copiedItemDetail->numseq_eighty != ""){$orderItemsDetail->numseq_eighty = $copiedItemDetail->numseq_eighty;}else{$orderItemsDetail->numseq_eighty = "";}

                if($copiedItemDetail->numseq_eighty_one != ""){$orderItemsDetail->numseq_eighty_one = $copiedItemDetail->numseq_eighty_one;}else{$orderItemsDetail->numseq_eighty_one = "";}
                if($copiedItemDetail->numseq_eighty_two != ""){$orderItemsDetail->numseq_eighty_two = $copiedItemDetail->numseq_eighty_two;}else{$orderItemsDetail->numseq_eighty_two = "";}
                if($copiedItemDetail->umseq_eighty_three != ""){$orderItemsDetail->numseq_eighty_three = $copiedItemDetail->umseq_eighty_three;}else{$orderItemsDetail->numseq_eighty_three = "";}
                if($copiedItemDetail->numseq_eighty_four != ""){$orderItemsDetail->numseq_eighty_four = $copiedItemDetail->numseq_eighty_four;}else{$orderItemsDetail->numseq_eighty_four = "";}
                if($copiedItemDetail->numseq_eighty_five != ""){$orderItemsDetail->numseq_eighty_five = $copiedItemDetail->numseq_eighty_five;}else{$orderItemsDetail->numseq_eighty_five = "";}
                if($copiedItemDetail->numseq_eighty_six != ""){$orderItemsDetail->numseq_eighty_six = $copiedItemDetail->numseq_eighty_six;}else{$orderItemsDetail->numseq_eighty_six = "";}
                if($copiedItemDetail->numseq_eighty_seven != ""){$orderItemsDetail->numseq_eighty_seven = $copiedItemDetail->numseq_eighty_seven;}else{$orderItemsDetail->numseq_eighty_seven = "";}
                if($copiedItemDetail->numseq_eighty_eight != ""){$orderItemsDetail->numseq_eighty_eight = $copiedItemDetail->numseq_eighty_eight;}else{$orderItemsDetail->numseq_eighty_eight = "";}
                if($copiedItemDetail->numseq_eighty_nine != ""){$orderItemsDetail->numseq_eighty_nine = $copiedItemDetail->numseq_eighty_nine;}else{$orderItemsDetail->numseq_eighty_nine = "";}
                if($copiedItemDetail->numseq_ninety != ""){$orderItemsDetail->numseq_ninety = $copiedItemDetail->numseq_ninety;}else{$orderItemsDetail->numseq_ninety = "";}

                if($copiedItemDetail->numseq_ninety_one != ""){$orderItemsDetail->numseq_ninety_one = $copiedItemDetail->numseq_ninety_one;}else{$orderItemsDetail->numseq_ninety_one = "";}
                if($copiedItemDetail->numseq_ninety_two != ""){$orderItemsDetail->numseq_ninety_two = $copiedItemDetail->numseq_ninety_two;}else{$orderItemsDetail->numseq_ninety_two = "";}
                if($copiedItemDetail->numseq_ninety_three != ""){$orderItemsDetail->numseq_ninety_three = $copiedItemDetail->numseq_ninety_three;}else{$orderItemsDetail->numseq_ninety_three = "";}
                if($copiedItemDetail->numseq_ninety_four != ""){$orderItemsDetail->numseq_ninety_four = $copiedItemDetail->numseq_ninety_four;}else{$orderItemsDetail->numseq_ninety_four = "";}
                if($copiedItemDetail->numseq_ninety_five != ""){$orderItemsDetail->numseq_ninety_five = $copiedItemDetail->numseq_ninety_five;}else{$orderItemsDetail->numseq_ninety_five = "";}
                if($copiedItemDetail->numseq_ninety_six != ""){$orderItemsDetail->numseq_ninety_six = $copiedItemDetail->numseq_ninety_six;}else{$orderItemsDetail->numseq_ninety_six = "";}
                if($copiedItemDetail->numseq_ninety_seven != ""){$orderItemsDetail->numseq_ninety_seven = $copiedItemDetail->numseq_ninety_seven;}else{$orderItemsDetail->numseq_ninety_seven = "";}
                if($copiedItemDetail->numseq_ninety_eight != ""){$orderItemsDetail->numseq_ninety_eight = $copiedItemDetail->numseq_ninety_eight;}else{$orderItemsDetail->numseq_ninety_eight = "";}
                if($copiedItemDetail->numseq_ninety_nine != ""){$orderItemsDetail->numseq_ninety_nine = $copiedItemDetail->numseq_ninety_nine;}else{$orderItemsDetail->numseq_ninety_nine = "";}
                if($copiedItemDetail->numseq_hundred != ""){$orderItemsDetail->numseq_hundred = $copiedItemDetail->numseq_hundred;}else{$orderItemsDetail->numseq_hundred = "";}
                $orderItemsDetail->update();

                // Paste player names
                $copiedItemPlayers = OrderItemsDetailPlayerName::where('order_items_detail_id', $copiedItemDetail->id)->first();

                if ($copiedItemPlayers) {
                    $orderItemPlayers = OrderItemsDetailPlayerName::where('order_items_detail_id', $orderItemsDetail->id)->first();

                    if ($orderItemPlayers) {
                        if(isset($copiedItemPlayers->player_one) && $copiedItemPlayers->player_one != ""){$orderItemPlayers->player_one = $copiedItemPlayers->player_one;}else{$orderItemPlayers->player_one = "";}
                        if(isset($copiedItemPlayers->player_two) && $copiedItemPlayers->player_two != ""){$orderItemPlayers->player_two = $copiedItemPlayers->player_two;}else{$orderItemPlayers->player_two = "";}
                        if(isset($copiedItemPlayers->player_three) && $copiedItemPlayers->player_three != ""){$orderItemPlayers->player_three = $copiedItemPlayers->player_three;}else{$orderItemPlayers->player_three = "";}
                        if(isset($copiedItemPlayers->player_four) && $copiedItemPlayers->player_four != ""){$orderItemPlayers->player_four = $copiedItemPlayers->player_four;}else{$orderItemPlayers->player_four = "";}
                        if(isset($copiedItemPlayers->player_five) && $copiedItemPlayers->player_five != ""){$orderItemPlayers->player_five = $copiedItemPlayers->player_five;}else{$orderItemPlayers->player_five = "";}
                        if(isset($copiedItemPlayers->player_six) && $copiedItemPlayers->player_six != ""){$orderItemPlayers->player_six = $copiedItemPlayers->player_six;}else{$orderItemPlayers->player_six = "";}
                        if(isset($copiedItemPlayers->player_seven) && $copiedItemPlayers->player_seven != ""){$orderItemPlayers->player_seven = $copiedItemPlayers->player_seven;}else{$orderItemPlayers->player_seven = "";}
                        if(isset($copiedItemPlayers->player_eight) && $copiedItemPlayers->player_eight != ""){$orderItemPlayers->player_eight = $copiedItemPlayers->player_eight;}else{$orderItemPlayers->player_eight = "";}
                        if(isset($copiedItemPlayers->player_nine) && $copiedItemPlayers->player_nine != ""){$orderItemPlayers->player_nine = $copiedItemPlayers->player_nine;}else{$orderItemPlayers->player_nine = "";}
                        if(isset($copiedItemPlayers->player_ten) && $copiedItemPlayers->player_ten != ""){$orderItemPlayers->player_ten = $copiedItemPlayers->player_ten;}else{$orderItemPlayers->player_ten = "";}

                        if(isset($copiedItemPlayers->player_eleven) && $copiedItemPlayers->player_eleven != ""){$orderItemPlayers->player_eleven = $copiedItemPlayers->player_eleven;}else{$orderItemPlayers->player_eleven = "";}
                        if(isset($copiedItemPlayers->player_twelve) && $copiedItemPlayers->player_twelve != ""){$orderItemPlayers->player_twelve = $copiedItemPlayers->player_twelve;}else{$orderItemPlayers->player_twelve = "";}
                        if(isset($copiedItemPlayers->player_thirteen) && $copiedItemPlayers->player_thirteen != ""){$orderItemPlayers->player_thirteen = $copiedItemPlayers->player_thirteen;}else{$orderItemPlayers->player_thirteen = "";}
                        if(isset($copiedItemPlayers->player_fourteen) && $copiedItemPlayers->player_fourteen != ""){$orderItemPlayers->player_fourteen = $copiedItemPlayers->player_fourteen;}else{$orderItemPlayers->player_fourteen = "";}
                        if(isset($copiedItemPlayers->player_fifteen) && $copiedItemPlayers->player_fifteen != ""){$orderItemPlayers->player_fifteen = $copiedItemPlayers->player_fifteen;}else{$orderItemPlayers->player_fifteen = "";}
                        if(isset($copiedItemPlayers->player_sixteen) && $copiedItemPlayers->player_sixteen != ""){$orderItemPlayers->player_sixteen = $copiedItemPlayers->player_sixteen;}else{$orderItemPlayers->player_sixteen = "";}
                        if(isset($copiedItemPlayers->player_seventeen) && $copiedItemPlayers->player_seventeen != ""){$orderItemPlayers->player_seventeen = $copiedItemPlayers->player_seventeen;}else{$orderItemPlayers->player_seventeen = "";}
                        if(isset($copiedItemPlayers->player_eighteen) && $copiedItemPlayers->player_eighteen != ""){$orderItemPlayers->player_eighteen = $copiedItemPlayers->player_eighteen;}else{$orderItemPlayers->player_eighteen = "";}
                        if(isset($copiedItemPlayers->player_nineteen) && $copiedItemPlayers->player_nineteen != ""){$orderItemPlayers->player_nineteen = $copiedItemPlayers->player_nineteen;}else{$orderItemPlayers->player_nineteen = "";}
                        if(isset($copiedItemPlayers->player_twenty) && $copiedItemPlayers->player_twenty != ""){$orderItemPlayers->player_twenty = $copiedItemPlayers->player_twenty;}else{$orderItemPlayers->player_twenty = "";}

                        if(isset($copiedItemPlayers->player_twenty_one) && $copiedItemPlayers->player_twenty_one != ""){$orderItemPlayers->player_twenty_one = $copiedItemPlayers->player_twenty_one;}else{$orderItemPlayers->player_twenty_one = "";}
                        if(isset($copiedItemPlayers->player_twenty_two) && $copiedItemPlayers->player_twenty_two != ""){$orderItemPlayers->player_twenty_two = $copiedItemPlayers->player_twenty_two;}else{$orderItemPlayers->player_twenty_two = "";}
                        if(isset($copiedItemPlayers->player_twenty_three) && $copiedItemPlayers->player_twenty_three != ""){$orderItemPlayers->player_twenty_three = $copiedItemPlayers->player_twenty_three;}else{$orderItemPlayers->player_twenty_three = "";}
                        if(isset($copiedItemPlayers->player_twenty_four) && $copiedItemPlayers->player_twenty_four != ""){$orderItemPlayers->player_twenty_four = $copiedItemPlayers->player_twenty_four;}else{$orderItemPlayers->player_twenty_four = "";}
                        if(isset($copiedItemPlayers->player_twenty_five) && $copiedItemPlayers->player_twenty_five != ""){$orderItemPlayers->player_twenty_five = $copiedItemPlayers->player_twenty_five;}else{$orderItemPlayers->player_twenty_five = "";}
                        if(isset($copiedItemPlayers->player_twenty_six) && $copiedItemPlayers->player_twenty_six != ""){$orderItemPlayers->player_twenty_six = $copiedItemPlayers->player_twenty_six;}else{$orderItemPlayers->player_twenty_six = "";}
                        if(isset($copiedItemPlayers->player_twenty_seven) && $copiedItemPlayers->player_twenty_seven != ""){$orderItemPlayers->player_twenty_seven = $copiedItemPlayers->player_twenty_seven;}else{$orderItemPlayers->player_twenty_seven = "";}
                        if(isset($copiedItemPlayers->player_twenty_eight) && $copiedItemPlayers->player_twenty_eight != ""){$orderItemPlayers->player_twenty_eight = $copiedItemPlayers->player_twenty_eight;}else{$orderItemPlayers->player_twenty_eight = "";}
                        if(isset($copiedItemPlayers->player_twenty_nine) && $copiedItemPlayers->player_twenty_nine != ""){$orderItemPlayers->player_twenty_nine = $copiedItemPlayers->player_twenty_nine;}else{$orderItemPlayers->player_twenty_nine = "";}
                        if(isset($copiedItemPlayers->player_thirty) && $copiedItemPlayers->player_thirty != ""){$orderItemPlayers->player_thirty = $copiedItemPlayers->player_thirty;}else{$orderItemPlayers->player_thirty = "";}

                        if(isset($copiedItemPlayers->player_thirty_one) && $copiedItemPlayers->player_thirty_one != ""){$orderItemPlayers->player_thirty_one = $copiedItemPlayers->player_thirty_one;}else{$orderItemPlayers->player_thirty_one = "";}
                        if(isset($copiedItemPlayers->player_thirty_two) && $copiedItemPlayers->player_thirty_two != ""){$orderItemPlayers->player_thirty_two = $copiedItemPlayers->player_thirty_two;}else{$orderItemPlayers->player_thirty_two = "";}
                        if(isset($copiedItemPlayers->player_thirty_three) && $copiedItemPlayers->player_thirty_three != ""){$orderItemPlayers->player_thirty_three = $copiedItemPlayers->player_thirty_three;}else{$orderItemPlayers->player_thirty_three = "";}
                        if(isset($copiedItemPlayers->player_thirty_four) && $copiedItemPlayers->player_thirty_four != ""){$orderItemPlayers->player_thirty_four = $copiedItemPlayers->player_thirty_four;}else{$orderItemPlayers->player_thirty_four = "";}
                        if(isset($copiedItemPlayers->player_thirty_five) && $copiedItemPlayers->player_thirty_five != ""){$orderItemPlayers->player_thirty_five = $copiedItemPlayers->player_thirty_five;}else{$orderItemPlayers->player_thirty_five = "";}
                        if(isset($copiedItemPlayers->player_thirty_six) && $copiedItemPlayers->player_thirty_six != ""){$orderItemPlayers->player_thirty_six = $copiedItemPlayers->player_thirty_six;}else{$orderItemPlayers->player_thirty_six = "";}
                        if(isset($copiedItemPlayers->player_thirty_seven) && $copiedItemPlayers->player_thirty_seven != ""){$orderItemPlayers->player_thirty_seven = $copiedItemPlayers->player_thirty_seven;}else{$orderItemPlayers->player_thirty_seven = "";}
                        if(isset($copiedItemPlayers->player_thirty_eight) && $copiedItemPlayers->player_thirty_eight != ""){$orderItemPlayers->player_thirty_eight = $copiedItemPlayers->player_thirty_eight;}else{$orderItemPlayers->player_thirty_eight = "";}
                        if(isset($copiedItemPlayers->player_thirty_nine) && $copiedItemPlayers->player_thirty_nine != ""){$orderItemPlayers->player_thirty_nine = $copiedItemPlayers->player_thirty_nine;}else{$orderItemPlayers->player_thirty_nine = "";}
                        if(isset($copiedItemPlayers->player_forty) && $copiedItemPlayers->player_forty != ""){$orderItemPlayers->player_forty = $copiedItemPlayers->player_forty;}else{$orderItemPlayers->player_forty = "";}

                        if(isset($copiedItemPlayers->player_forty_one) && $copiedItemPlayers->player_forty_one != ""){$orderItemPlayers->player_forty_one = $copiedItemPlayers->player_forty_one;}else{$orderItemPlayers->player_forty_one = "";}
                        if(isset($copiedItemPlayers->player_forty_two) && $copiedItemPlayers->player_forty_two != ""){$orderItemPlayers->player_forty_two = $copiedItemPlayers->player_forty_two;}else{$orderItemPlayers->player_forty_two = "";}
                        if(isset($copiedItemPlayers->player_forty_three) && $copiedItemPlayers->player_forty_three != ""){$orderItemPlayers->player_forty_three = $copiedItemPlayers->player_forty_three;}else{$orderItemPlayers->player_forty_three = "";}
                        if(isset($copiedItemPlayers->player_forty_four) && $copiedItemPlayers->player_forty_four != ""){$orderItemPlayers->player_forty_four = $copiedItemPlayers->player_forty_four;}else{$orderItemPlayers->player_forty_four = "";}
                        if(isset($copiedItemPlayers->player_forty_five) && $copiedItemPlayers->player_forty_five != ""){$orderItemPlayers->player_forty_five = $copiedItemPlayers->player_forty_five;}else{$orderItemPlayers->player_forty_five = "";}
                        if(isset($copiedItemPlayers->player_forty_six) && $copiedItemPlayers->player_forty_six != ""){$orderItemPlayers->player_forty_six = $copiedItemPlayers->player_forty_six;}else{$orderItemPlayers->player_forty_six = "";}
                        if(isset($copiedItemPlayers->player_forty_seven) && $copiedItemPlayers->player_forty_seven != ""){$orderItemPlayers->player_forty_seven = $copiedItemPlayers->player_forty_seven;}else{$orderItemPlayers->player_forty_seven = "";}
                        if(isset($copiedItemPlayers->player_forty_eight) && $copiedItemPlayers->player_forty_eight != ""){$orderItemPlayers->player_forty_eight = $copiedItemPlayers->player_forty_eight;}else{$orderItemPlayers->player_forty_eight = "";}
                        if(isset($copiedItemPlayers->player_forty_nine) && $copiedItemPlayers->player_forty_nine != ""){$orderItemPlayers->player_forty_nine = $copiedItemPlayers->player_forty_nine;}else{$orderItemPlayers->player_forty_nine = "";}
                        if(isset($copiedItemPlayers->player_fifty) && $copiedItemPlayers->player_fifty != ""){$orderItemPlayers->player_fifty = $copiedItemPlayers->player_fifty;}else{$orderItemPlayers->player_fifty = "";}

                        if(isset($copiedItemPlayers->player_fifty_one) && $copiedItemPlayers->player_fifty_one != ""){$orderItemPlayers->player_fifty_one = $copiedItemPlayers->player_fifty_one;}else{$orderItemPlayers->player_fifty_one = "";}
                        if(isset($copiedItemPlayers->player_fifty_two) && $copiedItemPlayers->player_fifty_two != ""){$orderItemPlayers->player_fifty_two = $copiedItemPlayers->player_fifty_two;}else{$orderItemPlayers->player_fifty_two = "";}
                        if(isset($copiedItemPlayers->player_fifty_three) && $copiedItemPlayers->player_fifty_three != ""){$orderItemPlayers->player_fifty_three = $copiedItemPlayers->player_fifty_three;}else{$orderItemPlayers->player_fifty_three = "";}
                        if(isset($copiedItemPlayers->player_fifty_four) && $copiedItemPlayers->player_fifty_four != ""){$orderItemPlayers->player_fifty_four = $copiedItemPlayers->player_fifty_four;}else{$orderItemPlayers->player_fifty_four = "";}
                        if(isset($copiedItemPlayers->player_fifty_five) && $copiedItemPlayers->player_fifty_five != ""){$orderItemPlayers->player_fifty_five = $copiedItemPlayers->player_fifty_five;}else{$orderItemPlayers->player_fifty_five = "";}
                        if(isset($copiedItemPlayers->player_fifty_six) && $copiedItemPlayers->player_fifty_six != ""){$orderItemPlayers->player_fifty_six = $copiedItemPlayers->player_fifty_six;}else{$orderItemPlayers->player_fifty_six = "";}
                        if(isset($copiedItemPlayers->player_fifty_seven) && $copiedItemPlayers->player_fifty_seven != ""){$orderItemPlayers->player_fifty_seven = $copiedItemPlayers->player_fifty_seven;}else{$orderItemPlayers->player_fifty_seven = "";}
                        if(isset($copiedItemPlayers->player_fifty_eight) && $copiedItemPlayers->player_fifty_eight != ""){$orderItemPlayers->player_fifty_eight = $copiedItemPlayers->player_fifty_eight;}else{$orderItemPlayers->player_fifty_eight = "";}
                        if(isset($copiedItemPlayers->player_fifty_nine) && $copiedItemPlayers->player_fifty_nine != ""){$orderItemPlayers->player_fifty_nine = $copiedItemPlayers->player_fifty_nine;}else{$orderItemPlayers->player_fifty_nine = "";}
                        if(isset($copiedItemPlayers->player_sixty) && $copiedItemPlayers->player_sixty != ""){$orderItemPlayers->player_sixty = $copiedItemPlayers->player_sixty;}else{$orderItemPlayers->player_sixty = "";}

                        if(isset($copiedItemPlayers->player_sixty_one) && $copiedItemPlayers->player_sixty_one != ""){$orderItemPlayers->player_sixty_one = $copiedItemPlayers->player_sixty_one;}else{$orderItemPlayers->player_sixty_one = "";}
                        if(isset($copiedItemPlayers->player_sixty_two) && $copiedItemPlayers->player_sixty_two != ""){$orderItemPlayers->player_sixty_two = $copiedItemPlayers->player_sixty_two;}else{$orderItemPlayers->player_sixty_two = "";}
                        if(isset($copiedItemPlayers->player_sixty_three) && $copiedItemPlayers->player_sixty_three != ""){$orderItemPlayers->player_sixty_three = $copiedItemPlayers->player_sixty_three;}else{$orderItemPlayers->player_sixty_three = "";}
                        if(isset($copiedItemPlayers->player_sixty_four) && $copiedItemPlayers->player_sixty_four != ""){$orderItemPlayers->player_sixty_four = $copiedItemPlayers->player_sixty_four;}else{$orderItemPlayers->player_sixty_four = "";}
                        if(isset($copiedItemPlayers->player_sixty_five) && $copiedItemPlayers->player_sixty_five != ""){$orderItemPlayers->player_sixty_five = $copiedItemPlayers->player_sixty_five;}else{$orderItemPlayers->player_sixty_five = "";}
                        if(isset($copiedItemPlayers->player_sixty_six) && $copiedItemPlayers->player_sixty_six != ""){$orderItemPlayers->player_sixty_six = $copiedItemPlayers->player_sixty_six;}else{$orderItemPlayers->player_sixty_six = "";}
                        if(isset($copiedItemPlayers->player_sixty_seven) && $copiedItemPlayers->player_sixty_seven != ""){$orderItemPlayers->player_sixty_seven = $copiedItemPlayers->player_sixty_seven;}else{$orderItemPlayers->player_sixty_seven = "";}
                        if(isset($copiedItemPlayers->player_sixty_eight) && $copiedItemPlayers->player_sixty_eight != ""){$orderItemPlayers->player_sixty_eight = $copiedItemPlayers->player_sixty_eight;}else{$orderItemPlayers->player_sixty_eight = "";}
                        if(isset($copiedItemPlayers->player_sixty_nine) && $copiedItemPlayers->player_sixty_nine != ""){$orderItemPlayers->player_sixty_nine = $copiedItemPlayers->player_sixty_nine;}else{$orderItemPlayers->player_sixty_nine = "";}
                        if(isset($copiedItemPlayers->player_seventy) && $copiedItemPlayers->player_seventy != ""){$orderItemPlayers->player_seventy = $copiedItemPlayers->player_seventy;}else{$orderItemPlayers->player_seventy = "";}

                        if(isset($copiedItemPlayers->player_seventy_one) && $copiedItemPlayers->player_seventy_one != ""){$orderItemPlayers->player_seventy_one = $copiedItemPlayers->player_seventy_one;}else{$orderItemPlayers->player_seventy_one = "";}
                        if(isset($copiedItemPlayers->player_seventy_two) && $copiedItemPlayers->player_seventy_two != ""){$orderItemPlayers->player_seventy_two = $copiedItemPlayers->player_seventy_two;}else{$orderItemPlayers->player_seventy_two = "";}
                        if(isset($copiedItemPlayers->player_seventy_three) && $copiedItemPlayers->player_seventy_three != ""){$orderItemPlayers->player_seventy_three = $copiedItemPlayers->player_seventy_three;}else{$orderItemPlayers->player_seventy_three = "";}
                        if(isset($copiedItemPlayers->player_seventy_four) && $copiedItemPlayers->player_seventy_four != ""){$orderItemPlayers->player_seventy_four = $copiedItemPlayers->player_seventy_four;}else{$orderItemPlayers->player_seventy_four = "";}
                        if(isset($copiedItemPlayers->player_seventy_five) && $copiedItemPlayers->player_seventy_five != ""){$orderItemPlayers->player_seventy_five = $copiedItemPlayers->player_seventy_five;}else{$orderItemPlayers->player_seventy_five = "";}
                        if(isset($copiedItemPlayers->player_seventy_six) && $copiedItemPlayers->player_seventy_six != ""){$orderItemPlayers->player_seventy_six = $copiedItemPlayers->player_seventy_six;}else{$orderItemPlayers->player_seventy_six = "";}
                        if(isset($copiedItemPlayers->player_seventy_seven) && $copiedItemPlayers->player_seventy_seven != ""){$orderItemPlayers->player_seventy_seven = $copiedItemPlayers->player_seventy_seven;}else{$orderItemPlayers->player_seventy_seven = "";}
                        if(isset($copiedItemPlayers->player_seventy_eight) && $copiedItemPlayers->player_seventy_eight != ""){$orderItemPlayers->player_seventy_eight = $copiedItemPlayers->player_seventy_eight;}else{$orderItemPlayers->player_seventy_eight = "";}
                        if(isset($copiedItemPlayers->player_seventy_nine) && $copiedItemPlayers->player_seventy_nine != ""){$orderItemPlayers->player_seventy_nine = $copiedItemPlayers->player_seventy_nine;}else{$orderItemPlayers->player_seventy_nine = "";}
                        if(isset($copiedItemPlayers->player_eighty) && $copiedItemPlayers->player_eighty != ""){$orderItemPlayers->player_eighty = $copiedItemPlayers->player_eighty;}else{$orderItemPlayers->player_eighty = "";}

                        if(isset($copiedItemPlayers->player_eighty_one) && $copiedItemPlayers->player_eighty_one != ""){$orderItemPlayers->player_eighty_one = $copiedItemPlayers->player_eighty_one;}else{$orderItemPlayers->player_eighty_one = "";}
                        if(isset($copiedItemPlayers->player_eighty_two) && $copiedItemPlayers->player_eighty_two != ""){$orderItemPlayers->player_eighty_two = $copiedItemPlayers->player_eighty_two;}else{$orderItemPlayers->player_eighty_two = "";}
                        if(isset($copiedItemPlayers->player_eighty_three) && $copiedItemPlayers->player_eighty_three != ""){$orderItemPlayers->player_eighty_three = $copiedItemPlayers->player_eighty_three;}else{$orderItemPlayers->player_eighty_three = "";}
                        if(isset($copiedItemPlayers->player_eighty_four) && $copiedItemPlayers->player_eighty_four != ""){$orderItemPlayers->player_eighty_four = $copiedItemPlayers->player_eighty_four;}else{$orderItemPlayers->player_eighty_four = "";}
                        if(isset($copiedItemPlayers->player_eighty_five) && $copiedItemPlayers->player_eighty_five != ""){$orderItemPlayers->player_eighty_five = $copiedItemPlayers->player_eighty_five;}else{$orderItemPlayers->player_eighty_five = "";}
                        if(isset($copiedItemPlayers->player_eighty_six) && $copiedItemPlayers->player_eighty_six != ""){$orderItemPlayers->player_eighty_six = $copiedItemPlayers->player_eighty_six;}else{$orderItemPlayers->player_eighty_six = "";}
                        if(isset($copiedItemPlayers->player_eighty_seven) && $copiedItemPlayers->player_eighty_seven != ""){$orderItemPlayers->player_eighty_seven = $copiedItemPlayers->player_eighty_seven;}else{$orderItemPlayers->player_eighty_seven = "";}
                        if(isset($copiedItemPlayers->player_eighty_eight) && $copiedItemPlayers->player_eighty_eight != ""){$orderItemPlayers->player_eighty_eight = $copiedItemPlayers->player_eighty_eight;}else{$orderItemPlayers->player_eighty_eight = "";}
                        if(isset($copiedItemPlayers->player_eighty_nine) && $copiedItemPlayers->player_eighty_nine != ""){$orderItemPlayers->player_eighty_nine = $copiedItemPlayers->player_eighty_nine;}else{$orderItemPlayers->player_eighty_nine = "";}
                        if(isset($copiedItemPlayers->player_ninety) && $copiedItemPlayers->player_ninety != ""){$orderItemPlayers->player_ninety = $copiedItemPlayers->player_ninety;}else{$orderItemPlayers->player_ninety = "";}

                        if(isset($copiedItemPlayers->player_ninety_one) && $copiedItemPlayers->player_ninety_one != ""){$orderItemPlayers->player_ninety_one = $copiedItemPlayers->player_ninety_one;}else{$orderItemPlayers->player_ninety_one = "";}
                        if(isset($copiedItemPlayers->player_ninety_two) && $copiedItemPlayers->player_ninety_two != ""){$orderItemPlayers->player_ninety_two = $copiedItemPlayers->player_ninety_two;}else{$orderItemPlayers->player_ninety_two = "";}
                        if(isset($copiedItemPlayers->player_ninety_three) && $copiedItemPlayers->player_ninety_three != ""){$orderItemPlayers->player_ninety_three = $copiedItemPlayers->player_ninety_three;}else{$orderItemPlayers->player_ninety_three = "";}
                        if(isset($copiedItemPlayers->player_ninety_four) && $copiedItemPlayers->player_ninety_four != ""){$orderItemPlayers->player_ninety_four = $copiedItemPlayers->player_ninety_four;}else{$orderItemPlayers->player_ninety_four = "";}
                        if(isset($copiedItemPlayers->player_ninety_five) && $copiedItemPlayers->player_ninety_five != ""){$orderItemPlayers->player_ninety_five = $copiedItemPlayers->player_ninety_five;}else{$orderItemPlayers->player_ninety_five = "";}
                        if(isset($copiedItemPlayers->player_ninety_six) && $copiedItemPlayers->player_ninety_six != ""){$orderItemPlayers->player_ninety_six = $copiedItemPlayers->player_ninety_six;}else{$orderItemPlayers->player_ninety_six = "";}
                        if(isset($copiedItemPlayers->player_ninety_seven) && $copiedItemPlayers->player_ninety_seven != ""){$orderItemPlayers->player_ninety_seven = $copiedItemPlayers->player_ninety_seven;}else{$orderItemPlayers->player_ninety_seven = "";}
                        if(isset($copiedItemPlayers->player_ninety_eight) && $copiedItemPlayers->player_ninety_eight != ""){$orderItemPlayers->player_ninety_eight = $copiedItemPlayers->player_ninety_eight;}else{$orderItemPlayers->player_ninety_eight = "";}
                        if(isset($copiedItemPlayers->player_ninety_nine) && $copiedItemPlayers->player_ninety_nine != ""){$orderItemPlayers->player_ninety_nine = $copiedItemPlayers->player_ninety_nine;}else{$orderItemPlayers->player_ninety_nine = "";}
                        if(isset($copiedItemPlayers->player_hundred) && $copiedItemPlayers->player_hundred != ""){$orderItemPlayers->player_hundred = $copiedItemPlayers->player_hundred;}else{$orderItemPlayers->player_hundred = "";}

                        if($orderItemPlayers->blank_qty > 0 && isset($copiedItemPlayers->blank_players) && isset($blankProductArray[$copiedItemPlayers->order_items_detail_id])){
                            if($orderItemPlayers->blank_qty < $blankProductArray[$copiedItemPlayers->order_items_detail_id]){
                                for( $i = $orderItemPlayers->blank_qty; $i < $blankProductArray[$copiedItemPlayers->order_items_detail_id]; $i++){
                                    $copiedItemPlayers->blank_players[$i] = null;
                                }
                                $orderItemPlayers->blank_qty = $blankProductArray[$copiedItemPlayers->order_items_detail_id];
                                $orderItemPlayers->blank_player_names = json_encode($copiedItemPlayers->blank_players);

                            } else if($orderItemPlayers->blank_qty == $blankProductArray[$copiedItemPlayers->order_items_detail_id]){
                                $orderItemPlayers->blank_player_names = json_encode($copiedItemPlayers->blank_players);

                            } else if($orderItemPlayers->blank_qty > $blankProductArray[$copiedItemPlayers->order_items_detail_id]){
                                $newArray = [];
                                for($i = 0; $i < $blankProductArray[$copiedItemPlayers->order_items_detail_id]; $i++){
                                    $newArray[$i] = $copiedItemPlayers->blank_players[$i];
                                }
                                $orderItemPlayers->blank_qty = $blankProductArray[$copiedItemPlayers->order_items_detail_id];
                                $orderItemPlayers->blank_player_names = json_encode($newArray);
                            }
                        } else if($orderItemPlayers->blank_qty == 0 && isset($copiedItemPlayers->blank_players) && isset($blankProductArray[$copiedItemPlayers->order_items_detail_id])){
                            if(isset($blankProductArray[$copiedItemPlayers->order_items_detail_id]) && $blankProductArray[$copiedItemPlayers->order_items_detail_id] > 0){ $orderItemPlayers->blank_qty = $blankProductArray[$copiedItemPlayers->order_items_detail_id];}else{$orderItemPlayers->blank_qty = 0;}
                            $orderItemPlayers->blank_player_names = json_encode($copiedItemPlayers->blank_players);
                        } else {
                            $orderItemPlayers->blank_qty = 0;
                            $orderItemPlayers->blank_player_names = "";
                        }

                        $orderItemPlayers->update();

                    } else {
                        $orderItemPlayers = new OrderItemsDetailPlayerName();
                        $orderItemPlayers->order_items_detail_id = $copiedItemDetail->id;

                        if(isset($copiedItemPlayers->player_one) && $copiedItemPlayers->player_one != ""){$orderItemPlayers->player_one = $copiedItemPlayers->player_one;}else{$orderItemPlayers->player_one = "";}
                        if(isset($copiedItemPlayers->player_two) && $copiedItemPlayers->player_two != ""){$orderItemPlayers->player_two = $copiedItemPlayers->player_two;}else{$orderItemPlayers->player_two = "";}
                        if(isset($copiedItemPlayers->player_three) && $copiedItemPlayers->player_three != ""){$orderItemPlayers->player_three = $copiedItemPlayers->player_three;}else{$orderItemPlayers->player_three = "";}
                        if(isset($copiedItemPlayers->player_four) && $copiedItemPlayers->player_four != ""){$orderItemPlayers->player_four = $copiedItemPlayers->player_four;}else{$orderItemPlayers->player_four = "";}
                        if(isset($copiedItemPlayers->player_five) && $copiedItemPlayers->player_five != ""){$orderItemPlayers->player_five = $copiedItemPlayers->player_five;}else{$orderItemPlayers->player_five = "";}
                        if(isset($copiedItemPlayers->player_six) && $copiedItemPlayers->player_six != ""){$orderItemPlayers->player_six = $copiedItemPlayers->player_six;}else{$orderItemPlayers->player_six = "";}
                        if(isset($copiedItemPlayers->player_seven) && $copiedItemPlayers->player_seven != ""){$orderItemPlayers->player_seven = $copiedItemPlayers->player_seven;}else{$orderItemPlayers->player_seven = "";}
                        if(isset($copiedItemPlayers->player_eight) && $copiedItemPlayers->player_eight != ""){$orderItemPlayers->player_eight = $copiedItemPlayers->player_eight;}else{$orderItemPlayers->player_eight = "";}
                        if(isset($copiedItemPlayers->player_nine) && $copiedItemPlayers->player_nine != ""){$orderItemPlayers->player_nine = $copiedItemPlayers->player_nine;}else{$orderItemPlayers->player_nine = "";}
                        if(isset($copiedItemPlayers->player_ten) && $copiedItemPlayers->player_ten != ""){$orderItemPlayers->player_ten = $copiedItemPlayers->player_ten;}else{$orderItemPlayers->player_ten = "";}

                        if(isset($copiedItemPlayers->player_eleven) && $copiedItemPlayers->player_eleven != ""){$orderItemPlayers->player_eleven = $copiedItemPlayers->player_eleven;}else{$orderItemPlayers->player_eleven = "";}
                        if(isset($copiedItemPlayers->player_twelve) && $copiedItemPlayers->player_twelve != ""){$orderItemPlayers->player_twelve = $copiedItemPlayers->player_twelve;}else{$orderItemPlayers->player_twelve = "";}
                        if(isset($copiedItemPlayers->player_thirteen) && $copiedItemPlayers->player_thirteen != ""){$orderItemPlayers->player_thirteen = $copiedItemPlayers->player_thirteen;}else{$orderItemPlayers->player_thirteen = "";}
                        if(isset($copiedItemPlayers->player_fourteen) && $copiedItemPlayers->player_fourteen != ""){$orderItemPlayers->player_fourteen = $copiedItemPlayers->player_fourteen;}else{$orderItemPlayers->player_fourteen = "";}
                        if(isset($copiedItemPlayers->player_fifteen) && $copiedItemPlayers->player_fifteen != ""){$orderItemPlayers->player_fifteen = $copiedItemPlayers->player_fifteen;}else{$orderItemPlayers->player_fifteen = "";}
                        if(isset($copiedItemPlayers->player_sixteen) && $copiedItemPlayers->player_sixteen != ""){$orderItemPlayers->player_sixteen = $copiedItemPlayers->player_sixteen;}else{$orderItemPlayers->player_sixteen = "";}
                        if(isset($copiedItemPlayers->player_seventeen) && $copiedItemPlayers->player_seventeen != ""){$orderItemPlayers->player_seventeen = $copiedItemPlayers->player_seventeen;}else{$orderItemPlayers->player_seventeen = "";}
                        if(isset($copiedItemPlayers->player_eighteen) && $copiedItemPlayers->player_eighteen != ""){$orderItemPlayers->player_eighteen = $copiedItemPlayers->player_eighteen;}else{$orderItemPlayers->player_eighteen = "";}
                        if(isset($copiedItemPlayers->player_nineteen) && $copiedItemPlayers->player_nineteen != ""){$orderItemPlayers->player_nineteen = $copiedItemPlayers->player_nineteen;}else{$orderItemPlayers->player_nineteen = "";}
                        if(isset($copiedItemPlayers->player_twenty) && $copiedItemPlayers->player_twenty != ""){$orderItemPlayers->player_twenty = $copiedItemPlayers->player_twenty;}else{$orderItemPlayers->player_twenty = "";}

                        if(isset($copiedItemPlayers->player_twenty_one) && $copiedItemPlayers->player_twenty_one != ""){$orderItemPlayers->player_twenty_one = $copiedItemPlayers->player_twenty_one;}else{$orderItemPlayers->player_twenty_one = "";}
                        if(isset($copiedItemPlayers->player_twenty_two) && $copiedItemPlayers->player_twenty_two != ""){$orderItemPlayers->player_twenty_two = $copiedItemPlayers->player_twenty_two;}else{$orderItemPlayers->player_twenty_two = "";}
                        if(isset($copiedItemPlayers->player_twenty_three) && $copiedItemPlayers->player_twenty_three != ""){$orderItemPlayers->player_twenty_three = $copiedItemPlayers->player_twenty_three;}else{$orderItemPlayers->player_twenty_three = "";}
                        if(isset($copiedItemPlayers->player_twenty_four) && $copiedItemPlayers->player_twenty_four != ""){$orderItemPlayers->player_twenty_four = $copiedItemPlayers->player_twenty_four;}else{$orderItemPlayers->player_twenty_four = "";}
                        if(isset($copiedItemPlayers->player_twenty_five) && $copiedItemPlayers->player_twenty_five != ""){$orderItemPlayers->player_twenty_five = $copiedItemPlayers->player_twenty_five;}else{$orderItemPlayers->player_twenty_five = "";}
                        if(isset($copiedItemPlayers->player_twenty_six) && $copiedItemPlayers->player_twenty_six != ""){$orderItemPlayers->player_twenty_six = $copiedItemPlayers->player_twenty_six;}else{$orderItemPlayers->player_twenty_six = "";}
                        if(isset($copiedItemPlayers->player_twenty_seven) && $copiedItemPlayers->player_twenty_seven != ""){$orderItemPlayers->player_twenty_seven = $copiedItemPlayers->player_twenty_seven;}else{$orderItemPlayers->player_twenty_seven = "";}
                        if(isset($copiedItemPlayers->player_twenty_eight) && $copiedItemPlayers->player_twenty_eight != ""){$orderItemPlayers->player_twenty_eight = $copiedItemPlayers->player_twenty_eight;}else{$orderItemPlayers->player_twenty_eight = "";}
                        if(isset($copiedItemPlayers->player_twenty_nine) && $copiedItemPlayers->player_twenty_nine != ""){$orderItemPlayers->player_twenty_nine = $copiedItemPlayers->player_twenty_nine;}else{$orderItemPlayers->player_twenty_nine = "";}
                        if(isset($copiedItemPlayers->player_thirty) && $copiedItemPlayers->player_thirty != ""){$orderItemPlayers->player_thirty = $copiedItemPlayers->player_thirty;}else{$orderItemPlayers->player_thirty = "";}

                        if(isset($copiedItemPlayers->player_thirty_one) && $copiedItemPlayers->player_thirty_one != ""){$orderItemPlayers->player_thirty_one = $copiedItemPlayers->player_thirty_one;}else{$orderItemPlayers->player_thirty_one = "";}
                        if(isset($copiedItemPlayers->player_thirty_two) && $copiedItemPlayers->player_thirty_two != ""){$orderItemPlayers->player_thirty_two = $copiedItemPlayers->player_thirty_two;}else{$orderItemPlayers->player_thirty_two = "";}
                        if(isset($copiedItemPlayers->player_thirty_three) && $copiedItemPlayers->player_thirty_three != ""){$orderItemPlayers->player_thirty_three = $copiedItemPlayers->player_thirty_three;}else{$orderItemPlayers->player_thirty_three = "";}
                        if(isset($copiedItemPlayers->player_thirty_four) && $copiedItemPlayers->player_thirty_four != ""){$orderItemPlayers->player_thirty_four = $copiedItemPlayers->player_thirty_four;}else{$orderItemPlayers->player_thirty_four = "";}
                        if(isset($copiedItemPlayers->player_thirty_five) && $copiedItemPlayers->player_thirty_five != ""){$orderItemPlayers->player_thirty_five = $copiedItemPlayers->player_thirty_five;}else{$orderItemPlayers->player_thirty_five = "";}
                        if(isset($copiedItemPlayers->player_thirty_six) && $copiedItemPlayers->player_thirty_six != ""){$orderItemPlayers->player_thirty_six = $copiedItemPlayers->player_thirty_six;}else{$orderItemPlayers->player_thirty_six = "";}
                        if(isset($copiedItemPlayers->player_thirty_seven) && $copiedItemPlayers->player_thirty_seven != ""){$orderItemPlayers->player_thirty_seven = $copiedItemPlayers->player_thirty_seven;}else{$orderItemPlayers->player_thirty_seven = "";}
                        if(isset($copiedItemPlayers->player_thirty_eight) && $copiedItemPlayers->player_thirty_eight != ""){$orderItemPlayers->player_thirty_eight = $copiedItemPlayers->player_thirty_eight;}else{$orderItemPlayers->player_thirty_eight = "";}
                        if(isset($copiedItemPlayers->player_thirty_nine) && $copiedItemPlayers->player_thirty_nine != ""){$orderItemPlayers->player_thirty_nine = $copiedItemPlayers->player_thirty_nine;}else{$orderItemPlayers->player_thirty_nine = "";}
                        if(isset($copiedItemPlayers->player_forty) && $copiedItemPlayers->player_forty != ""){$orderItemPlayers->player_forty = $copiedItemPlayers->player_forty;}else{$orderItemPlayers->player_forty = "";}

                        if(isset($copiedItemPlayers->player_forty_one) && $copiedItemPlayers->player_forty_one != ""){$orderItemPlayers->player_forty_one = $copiedItemPlayers->player_forty_one;}else{$orderItemPlayers->player_forty_one = "";}
                        if(isset($copiedItemPlayers->player_forty_two) && $copiedItemPlayers->player_forty_two != ""){$orderItemPlayers->player_forty_two = $copiedItemPlayers->player_forty_two;}else{$orderItemPlayers->player_forty_two = "";}
                        if(isset($copiedItemPlayers->player_forty_three) && $copiedItemPlayers->player_forty_three != ""){$orderItemPlayers->player_forty_three = $copiedItemPlayers->player_forty_three;}else{$orderItemPlayers->player_forty_three = "";}
                        if(isset($copiedItemPlayers->player_forty_four) && $copiedItemPlayers->player_forty_four != ""){$orderItemPlayers->player_forty_four = $copiedItemPlayers->player_forty_four;}else{$orderItemPlayers->player_forty_four = "";}
                        if(isset($copiedItemPlayers->player_forty_five) && $copiedItemPlayers->player_forty_five != ""){$orderItemPlayers->player_forty_five = $copiedItemPlayers->player_forty_five;}else{$orderItemPlayers->player_forty_five = "";}
                        if(isset($copiedItemPlayers->player_forty_six) && $copiedItemPlayers->player_forty_six != ""){$orderItemPlayers->player_forty_six = $copiedItemPlayers->player_forty_six;}else{$orderItemPlayers->player_forty_six = "";}
                        if(isset($copiedItemPlayers->player_forty_seven) && $copiedItemPlayers->player_forty_seven != ""){$orderItemPlayers->player_forty_seven = $copiedItemPlayers->player_forty_seven;}else{$orderItemPlayers->player_forty_seven = "";}
                        if(isset($copiedItemPlayers->player_forty_eight) && $copiedItemPlayers->player_forty_eight != ""){$orderItemPlayers->player_forty_eight = $copiedItemPlayers->player_forty_eight;}else{$orderItemPlayers->player_forty_eight = "";}
                        if(isset($copiedItemPlayers->player_forty_nine) && $copiedItemPlayers->player_forty_nine != ""){$orderItemPlayers->player_forty_nine = $copiedItemPlayers->player_forty_nine;}else{$orderItemPlayers->player_forty_nine = "";}
                        if(isset($copiedItemPlayers->player_fifty) && $copiedItemPlayers->player_fifty != ""){$orderItemPlayers->player_fifty = $copiedItemPlayers->player_fifty;}else{$orderItemPlayers->player_fifty = "";}

                        if(isset($copiedItemPlayers->player_fifty_one) && $copiedItemPlayers->player_fifty_one != ""){$orderItemPlayers->player_fifty_one = $copiedItemPlayers->player_fifty_one;}else{$orderItemPlayers->player_fifty_one = "";}
                        if(isset($copiedItemPlayers->player_fifty_two) && $copiedItemPlayers->player_fifty_two != ""){$orderItemPlayers->player_fifty_two = $copiedItemPlayers->player_fifty_two;}else{$orderItemPlayers->player_fifty_two = "";}
                        if(isset($copiedItemPlayers->player_fifty_three) && $copiedItemPlayers->player_fifty_three != ""){$orderItemPlayers->player_fifty_three = $copiedItemPlayers->player_fifty_three;}else{$orderItemPlayers->player_fifty_three = "";}
                        if(isset($copiedItemPlayers->player_fifty_four) && $copiedItemPlayers->player_fifty_four != ""){$orderItemPlayers->player_fifty_four = $copiedItemPlayers->player_fifty_four;}else{$orderItemPlayers->player_fifty_four = "";}
                        if(isset($copiedItemPlayers->player_fifty_five) && $copiedItemPlayers->player_fifty_five != ""){$orderItemPlayers->player_fifty_five = $copiedItemPlayers->player_fifty_five;}else{$orderItemPlayers->player_fifty_five = "";}
                        if(isset($copiedItemPlayers->player_fifty_six) && $copiedItemPlayers->player_fifty_six != ""){$orderItemPlayers->player_fifty_six = $copiedItemPlayers->player_fifty_six;}else{$orderItemPlayers->player_fifty_six = "";}
                        if(isset($copiedItemPlayers->player_fifty_seven) && $copiedItemPlayers->player_fifty_seven != ""){$orderItemPlayers->player_fifty_seven = $copiedItemPlayers->player_fifty_seven;}else{$orderItemPlayers->player_fifty_seven = "";}
                        if(isset($copiedItemPlayers->player_fifty_eight) && $copiedItemPlayers->player_fifty_eight != ""){$orderItemPlayers->player_fifty_eight = $copiedItemPlayers->player_fifty_eight;}else{$orderItemPlayers->player_fifty_eight = "";}
                        if(isset($copiedItemPlayers->player_fifty_nine) && $copiedItemPlayers->player_fifty_nine != ""){$orderItemPlayers->player_fifty_nine = $copiedItemPlayers->player_fifty_nine;}else{$orderItemPlayers->player_fifty_nine = "";}
                        if(isset($copiedItemPlayers->player_sixty) && $copiedItemPlayers->player_sixty != ""){$orderItemPlayers->player_sixty = $copiedItemPlayers->player_sixty;}else{$orderItemPlayers->player_sixty = "";}

                        if(isset($copiedItemPlayers->player_sixty_one) && $copiedItemPlayers->player_sixty_one != ""){$orderItemPlayers->player_sixty_one = $copiedItemPlayers->player_sixty_one;}else{$orderItemPlayers->player_sixty_one = "";}
                        if(isset($copiedItemPlayers->player_sixty_two) && $copiedItemPlayers->player_sixty_two != ""){$orderItemPlayers->player_sixty_two = $copiedItemPlayers->player_sixty_two;}else{$orderItemPlayers->player_sixty_two = "";}
                        if(isset($copiedItemPlayers->player_sixty_three) && $copiedItemPlayers->player_sixty_three != ""){$orderItemPlayers->player_sixty_three = $copiedItemPlayers->player_sixty_three;}else{$orderItemPlayers->player_sixty_three = "";}
                        if(isset($copiedItemPlayers->player_sixty_four) && $copiedItemPlayers->player_sixty_four != ""){$orderItemPlayers->player_sixty_four = $copiedItemPlayers->player_sixty_four;}else{$orderItemPlayers->player_sixty_four = "";}
                        if(isset($copiedItemPlayers->player_sixty_five) && $copiedItemPlayers->player_sixty_five != ""){$orderItemPlayers->player_sixty_five = $copiedItemPlayers->player_sixty_five;}else{$orderItemPlayers->player_sixty_five = "";}
                        if(isset($copiedItemPlayers->player_sixty_six) && $copiedItemPlayers->player_sixty_six != ""){$orderItemPlayers->player_sixty_six = $copiedItemPlayers->player_sixty_six;}else{$orderItemPlayers->player_sixty_six = "";}
                        if(isset($copiedItemPlayers->player_sixty_seven) && $copiedItemPlayers->player_sixty_seven != ""){$orderItemPlayers->player_sixty_seven = $copiedItemPlayers->player_sixty_seven;}else{$orderItemPlayers->player_sixty_seven = "";}
                        if(isset($copiedItemPlayers->player_sixty_eight) && $copiedItemPlayers->player_sixty_eight != ""){$orderItemPlayers->player_sixty_eight = $copiedItemPlayers->player_sixty_eight;}else{$orderItemPlayers->player_sixty_eight = "";}
                        if(isset($copiedItemPlayers->player_sixty_nine) && $copiedItemPlayers->player_sixty_nine != ""){$orderItemPlayers->player_sixty_nine = $copiedItemPlayers->player_sixty_nine;}else{$orderItemPlayers->player_sixty_nine = "";}
                        if(isset($copiedItemPlayers->player_seventy) && $copiedItemPlayers->player_seventy != ""){$orderItemPlayers->player_seventy = $copiedItemPlayers->player_seventy;}else{$orderItemPlayers->player_seventy = "";}

                        if(isset($copiedItemPlayers->player_seventy_one) && $copiedItemPlayers->player_seventy_one != ""){$orderItemPlayers->player_seventy_one = $copiedItemPlayers->player_seventy_one;}else{$orderItemPlayers->player_seventy_one = "";}
                        if(isset($copiedItemPlayers->player_seventy_two) && $copiedItemPlayers->player_seventy_two != ""){$orderItemPlayers->player_seventy_two = $copiedItemPlayers->player_seventy_two;}else{$orderItemPlayers->player_seventy_two = "";}
                        if(isset($copiedItemPlayers->player_seventy_three) && $copiedItemPlayers->player_seventy_three != ""){$orderItemPlayers->player_seventy_three = $copiedItemPlayers->player_seventy_three;}else{$orderItemPlayers->player_seventy_three = "";}
                        if(isset($copiedItemPlayers->player_seventy_four) && $copiedItemPlayers->player_seventy_four != ""){$orderItemPlayers->player_seventy_four = $copiedItemPlayers->player_seventy_four;}else{$orderItemPlayers->player_seventy_four = "";}
                        if(isset($copiedItemPlayers->player_seventy_five) && $copiedItemPlayers->player_seventy_five != ""){$orderItemPlayers->player_seventy_five = $copiedItemPlayers->player_seventy_five;}else{$orderItemPlayers->player_seventy_five = "";}
                        if(isset($copiedItemPlayers->player_seventy_six) && $copiedItemPlayers->player_seventy_six != ""){$orderItemPlayers->player_seventy_six = $copiedItemPlayers->player_seventy_six;}else{$orderItemPlayers->player_seventy_six = "";}
                        if(isset($copiedItemPlayers->player_seventy_seven) && $copiedItemPlayers->player_seventy_seven != ""){$orderItemPlayers->player_seventy_seven = $copiedItemPlayers->player_seventy_seven;}else{$orderItemPlayers->player_seventy_seven = "";}
                        if(isset($copiedItemPlayers->player_seventy_eight) && $copiedItemPlayers->player_seventy_eight != ""){$orderItemPlayers->player_seventy_eight = $copiedItemPlayers->player_seventy_eight;}else{$orderItemPlayers->player_seventy_eight = "";}
                        if(isset($copiedItemPlayers->player_seventy_nine) && $copiedItemPlayers->player_seventy_nine != ""){$orderItemPlayers->player_seventy_nine = $copiedItemPlayers->player_seventy_nine;}else{$orderItemPlayers->player_seventy_nine = "";}
                        if(isset($copiedItemPlayers->player_eighty) && $copiedItemPlayers->player_eighty != ""){$orderItemPlayers->player_eighty = $copiedItemPlayers->player_eighty;}else{$orderItemPlayers->player_eighty = "";}

                        if(isset($copiedItemPlayers->player_eighty_one) && $copiedItemPlayers->player_eighty_one != ""){$orderItemPlayers->player_eighty_one = $copiedItemPlayers->player_eighty_one;}else{$orderItemPlayers->player_eighty_one = "";}
                        if(isset($copiedItemPlayers->player_eighty_two) && $copiedItemPlayers->player_eighty_two != ""){$orderItemPlayers->player_eighty_two = $copiedItemPlayers->player_eighty_two;}else{$orderItemPlayers->player_eighty_two = "";}
                        if(isset($copiedItemPlayers->player_eighty_three) && $copiedItemPlayers->player_eighty_three != ""){$orderItemPlayers->player_eighty_three = $copiedItemPlayers->player_eighty_three;}else{$orderItemPlayers->player_eighty_three = "";}
                        if(isset($copiedItemPlayers->player_eighty_four) && $copiedItemPlayers->player_eighty_four != ""){$orderItemPlayers->player_eighty_four = $copiedItemPlayers->player_eighty_four;}else{$orderItemPlayers->player_eighty_four = "";}
                        if(isset($copiedItemPlayers->player_eighty_five) && $copiedItemPlayers->player_eighty_five != ""){$orderItemPlayers->player_eighty_five = $copiedItemPlayers->player_eighty_five;}else{$orderItemPlayers->player_eighty_five = "";}
                        if(isset($copiedItemPlayers->player_eighty_six) && $copiedItemPlayers->player_eighty_six != ""){$orderItemPlayers->player_eighty_six = $copiedItemPlayers->player_eighty_six;}else{$orderItemPlayers->player_eighty_six = "";}
                        if(isset($copiedItemPlayers->player_eighty_seven) && $copiedItemPlayers->player_eighty_seven != ""){$orderItemPlayers->player_eighty_seven = $copiedItemPlayers->player_eighty_seven;}else{$orderItemPlayers->player_eighty_seven = "";}
                        if(isset($copiedItemPlayers->player_eighty_eight) && $copiedItemPlayers->player_eighty_eight != ""){$orderItemPlayers->player_eighty_eight = $copiedItemPlayers->player_eighty_eight;}else{$orderItemPlayers->player_eighty_eight = "";}
                        if(isset($copiedItemPlayers->player_eighty_nine) && $copiedItemPlayers->player_eighty_nine != ""){$orderItemPlayers->player_eighty_nine = $copiedItemPlayers->player_eighty_nine;}else{$orderItemPlayers->player_eighty_nine = "";}
                        if(isset($copiedItemPlayers->player_ninety) && $copiedItemPlayers->player_ninety != ""){$orderItemPlayers->player_ninety = $copiedItemPlayers->player_ninety;}else{$orderItemPlayers->player_ninety = "";}

                        if(isset($copiedItemPlayers->player_ninety_one) && $copiedItemPlayers->player_ninety_one != ""){$orderItemPlayers->player_ninety_one = $copiedItemPlayers->player_ninety_one;}else{$orderItemPlayers->player_ninety_one = "";}
                        if(isset($copiedItemPlayers->player_ninety_two) && $copiedItemPlayers->player_ninety_two != ""){$orderItemPlayers->player_ninety_two = $copiedItemPlayers->player_ninety_two;}else{$orderItemPlayers->player_ninety_two = "";}
                        if(isset($copiedItemPlayers->player_ninety_three) && $copiedItemPlayers->player_ninety_three != ""){$orderItemPlayers->player_ninety_three = $copiedItemPlayers->player_ninety_three;}else{$orderItemPlayers->player_ninety_three = "";}
                        if(isset($copiedItemPlayers->player_ninety_four) && $copiedItemPlayers->player_ninety_four != ""){$orderItemPlayers->player_ninety_four = $copiedItemPlayers->player_ninety_four;}else{$orderItemPlayers->player_ninety_four = "";}
                        if(isset($copiedItemPlayers->player_ninety_five) && $copiedItemPlayers->player_ninety_five != ""){$orderItemPlayers->player_ninety_five = $copiedItemPlayers->player_ninety_five;}else{$orderItemPlayers->player_ninety_five = "";}
                        if(isset($copiedItemPlayers->player_ninety_six) && $copiedItemPlayers->player_ninety_six != ""){$orderItemPlayers->player_ninety_six = $copiedItemPlayers->player_ninety_six;}else{$orderItemPlayers->player_ninety_six = "";}
                        if(isset($copiedItemPlayers->player_ninety_seven) && $copiedItemPlayers->player_ninety_seven != ""){$orderItemPlayers->player_ninety_seven = $copiedItemPlayers->player_ninety_seven;}else{$orderItemPlayers->player_ninety_seven = "";}
                        if(isset($copiedItemPlayers->player_ninety_eight) && $copiedItemPlayers->player_ninety_eight != ""){$orderItemPlayers->player_ninety_eight = $copiedItemPlayers->player_ninety_eight;}else{$orderItemPlayers->player_ninety_eight = "";}
                        if(isset($copiedItemPlayers->player_ninety_nine) && $copiedItemPlayers->player_ninety_nine != ""){$orderItemPlayers->player_ninety_nine = $copiedItemPlayers->player_ninety_nine;}else{$orderItemPlayers->player_ninety_nine = "";}
                        if(isset($copiedItemPlayers->player_hundred) && $copiedItemPlayers->player_hundred != ""){$orderItemPlayers->player_hundred = $copiedItemPlayers->player_hundred;}else{$orderItemPlayers->player_hundred = "";}

                        if(isset($blankProductArray[$copiedItemPlayers->order_items_detail_id]) && $blankProductArray[$copiedItemPlayers->order_items_detail_id] > 0){ $orderItemPlayers->blank_qty = $blankProductArray[$copiedItemPlayers->order_items_detail_id];}else{$orderItemPlayers->blank_qty = 0;}
                        if(isset($copiedItemPlayers->blank_players)){ $orderItemPlayers->blank_player_names = json_encode($copiedItemPlayers->blank_players);}else{$orderItemPlayers->blank_player_names = "";}

                        $orderItemPlayers->save();
                    }
                }
            } else {
                if ($isSizeExist == '') {
                    $isSizeExist = 'no_size';
                }
            }
        }

        if ($isSizeExist = 'size_exist') {
            $orderItem = OrderItem::find($request->item_id);
            $orderItem->qty = $totalQty;
            $orderItem->total = $totalQty * $orderItem->unit_price;
            $orderItem->update();

            $order = Order::find($request->order_id);
            $organization = Organization::find($order->organization_id);
            $orderSubTotal = OrderItem::where('order_id', $request->order_id)->sum('total');
            if ($organization->sales_tax_active == 1) {
                $salesTax = $organization->sales_tax;
            } else {
                $salesTax = 0;
            }
            $orderSalesTax = ($orderSubTotal / 100) * $salesTax;
            $orderShipping = $order->shipping ?? '';
            $orderArtwork = $order->artwork ?? '';
            $orderProcessingFee = $order->processing_fee ?? '';
            $orderFeesTotal = $orderSalesTax + $orderShipping + $orderArtwork + $orderProcessingFee;

            $order->sub_total = $orderSubTotal;
            $order->order_total = $orderSubTotal + $orderFeesTotal;
            $order->sales_tax = $orderSalesTax;
            $order->update();
        }

        return json_encode($isSizeExist);
    }
}
