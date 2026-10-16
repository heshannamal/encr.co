<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShippingOrderDetails;
use App\Models\OrderItemAttribute;
use App\Models\OrderItem;
use App\Models\remake_order_item;
use App\Models\OrderItemsDetailPlayerName;
use App\Models\OrderItemsDetail;
use App\Models\SubProduct;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mail\OrderDetailsEmail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\Notification;
use App\Models\OrderItemFile;
use App\Services\EmailNotificationBuilderService;
use App\Services\NotificationBuilderService;
use domainencore\Facades\OrdersCommenFacade\OrdersCommenFacade;
use Illuminate\Support\Facades\Log;

class OrderRemakeController extends Controller
{
    public function add_to_remake_list(Request $request){
        if($request->shipping_order_details_id == null){
            return false;
        }else{
            $shipping_order_details = ShippingOrderDetails::where('id', $request->shipping_order_details_id)->first();
            if($shipping_order_details->has_blank_qty == 'yes'){$shipping_order_details->notify_status = 4;}else{$shipping_order_details->notify_status = 3;}
            $shipping_order_details->update();
            $shipping_order_details = ShippingOrderDetails::where('id', $request->shipping_order_details_id)->first();

            if($shipping_order_details){
                $remake_order_item = new remake_order_item();
                $remake_order_item->shipping_order_details_id = $shipping_order_details->id;
                $remake_order_item->order_id = $shipping_order_details->order_id;
                $remake_order_item->order_item_id = $shipping_order_details->order_item_id;
                $remake_order_item->size_id = $shipping_order_details->size_id;
                $remake_order_item->player_name = $shipping_order_details->player_name;
                $remake_order_item->player_nunmber = $shipping_order_details->player_number;
                $remake_order_item->qty = $shipping_order_details->order_qty;
                $remake_order_item->status = 1;
                $remake_order_item->user_id = Auth::user()->id;
                // $remake_order_item->est_delivery_date = $shipping_order_details->id;
                // $remake_order_item->reason = $shipping_order_details->id;
                $remake_order_item->save();

            return true;
            }
            else{
                return false;
            }
        }


    }

    public function count_remake_items($order_id){
        $shipping_order_details_count = remake_order_item::where('order_id', $order_id)
        ->where('status', 1)
        ->count();


        return  json_encode($shipping_order_details_count);

    }

    public function view_remake_list($order_id){
        $remake_items = DB::table('remake_order_items')
                        ->select('remake_order_items.id','remake_order_items.player_nunmber','sizes.size_name','remake_order_items.qty','remake_order_items.reason','remake_order_items.reason','remake_order_items.status','sub_products.product_name','remake_order_items.est_delivery_date','remake_order_items.ex_factory_date')
                        ->join('order_items','order_items.id','=','remake_order_items.order_item_id')
                        ->join('sub_products','sub_products.sub_product_no','=','order_items.sub_product_no')
                        ->join('sizes','sizes.id','=','remake_order_items.size_id')
                        ->where('remake_order_items.order_id' ,'=', $order_id)
                        ->get();

        return  json_encode($remake_items);
    }

    public function update_remake_qty(Request $request){
        $remake_order_item = remake_order_item::where('id', $request->id)->first();
        $remake_order_item->qty = $request->qty;
        $remake_order_item->update();

        return json_encode(true);
    }

    public function update_remake_reason(Request $request){
        $remake_order_item = remake_order_item::where('id', $request->id)->first();
        $remake_order_item->reason = $request->reason;
        $remake_order_item->update();

        return json_encode(true);
    }

    public function update_remake_est_delivery_date(Request $request){
        $est_delivery_date =Carbon::parse($request->input('est_delivery_date'));
        $formatted_est_delivery_date = $est_delivery_date->format('m/d/Y'); // Format as 'm/d/Y'
        $remake_order_item = remake_order_item::where('id', $request->id)->first();
        $remake_order_item->est_delivery_date = $formatted_est_delivery_date;
        $remake_order_item->update();

        return json_encode(true);
    }
    public function update_remake_ex_factory_date(Request $request){
        $ex_factory_date =Carbon::parse($request->input('ex_factory_date'));
        $formatted_ex_factory_date = $ex_factory_date->format('m/d/Y'); // Format as 'm/d/Y'
        $remake_order_item = remake_order_item::where('id', $request->id)->first();
        $remake_order_item->ex_factory_date = $formatted_ex_factory_date;
        $remake_order_item->update();

        return json_encode(true);
    }

    public function remove_remake_items($id){
        $remake_order_item = remake_order_item::find($id);
        $remake_order_item->delete();

        return json_encode(true);
    }

    public function remake_items(Request $request){
        $remake_order_items= remake_order_item::where('order_id', $request->order_id)
                            ->where('status', 1)
                            ->orderBy('order_item_id')
                            ->get();
        $processedOrderItemIds = [];
        $newOrderItemIds = [];
        $oldOrderItemIds = [];
        $new_order_item_id = null;
        $new_order_item_detail_id =null;
        foreach($remake_order_items as $remake_order_item){
            if (!in_array($remake_order_item->order_item_id, $oldOrderItemIds)) {
                $oldOrderItemIds[] = $remake_order_item->order_item_id;
            }

            //status change
            $remake_order_item->status = 0;
            $remake_order_item->update();
            $shipping_order_details = ShippingOrderDetails::find($remake_order_item->shipping_order_details_id);
            if($shipping_order_details->has_blank_qty == 'yes'){
                $shipping_order_details_qty = ShippingOrderDetails::find($remake_order_item->shipping_order_details_id);
                $shipping_order_details_qty->order_qty =  $shipping_order_details_qty->order_qty - $remake_order_item->qty;
                $shipping_order_details_qty->update();
            }



            if (!in_array($shipping_order_details->order_item_id, $processedOrderItemIds)) {
                // continue; // Skip processing if already processed
                $order_item = OrderItem::find($shipping_order_details->order_item_id);
                $order_item_has_remake = OrderItem::find($shipping_order_details->order_item_id);
                $order_item_has_remake->has_remake_item = 1;
                $order_item_has_remake->update();
                $order_item_count = OrderItem::where('order_id', $request->order_id)->count();
                $new_order_item_count_number = $order_item_count + 1;
                $sub_product = SubProduct::where('sub_product_no' , $order_item->sub_product_no)->first();

                $new_order_item = new OrderItem;
                $new_order_item->fill($order_item->toArray());
                $display_name = '';
                if(!empty($order_item->display_name)){
                    $display_name = $order_item->display_name;
                }else{
                    $product_temp = Product::find($order_item->product_id);
                    if($product_temp){
                        $display_name = $product_temp->product_name;
                    }
                }
                $new_order_item->display_name = strpos($order_item->display_name, "Remake") !== false ? $order_item->display_name : $display_name ." - Remake";
                $new_order_item->item_description =$order_item->item_description;
                $new_order_item->unit_price =0;
                $new_order_item->total =0;
                $order_number = str_pad($request->order_id, 6, "0", STR_PAD_LEFT);
                $new_order_item->item_no =  $order_number."-".$new_order_item_count_number;
                $new_order_item->remake_status =  1;
                $new_order_item->order_status_id =  3;
                $new_order_item->est_delivery_date = $remake_order_item->est_delivery_date;
                $new_order_item->ex_factory_date = $remake_order_item->ex_factory_date;
                $new_order_item->save();

                $new_order_item_id = $new_order_item->id;
                $newOrderItemIds[] = $new_order_item_id;

                //create order item attributes
                $order_item_attributes = OrderItemAttribute::where('order_item_id', $shipping_order_details->order_item_id)->get();
                if ($order_item_attributes !== null) {
                    foreach ($order_item_attributes as $order_item_attribute) {
                        $new_order_item_attribute = new OrderItemAttribute;
                        $new_order_item_attribute->order_item_id = $new_order_item_id;
                        $new_order_item_attribute->attribute_id =$order_item_attribute->attribute_id;
                        $new_order_item_attribute->save();
                    }
                }
                //create order item files
                $order_item_files = OrderItemFile::where('order_item_id', $shipping_order_details->order_item_id)->get();

                if ($order_item_files->isNotEmpty()) {
                    foreach ($order_item_files as $orderItemFile) {
                        $newOrderItemFile = new OrderItemFile();
                        $newOrderItemFile->organization_id = $orderItemFile->organization_id;
                        $newOrderItemFile->contact_id = $orderItemFile->contact_id;
                        $newOrderItemFile->order_id = $orderItemFile->order_id;
                        $newOrderItemFile->order_item_id = $new_order_item_id;

                        $newOrderItemFile->mockup_images = $orderItemFile->mockup_images;
                        $newOrderItemFile->mockup_image_name = $orderItemFile->mockup_image_name;

                        $newOrderItemFile->tech_pack_files = $orderItemFile->tech_pack_files;
                        $newOrderItemFile->tech_pack_file_name = $orderItemFile->tech_pack_file_name;

                        $newOrderItemFile->tech_pack_images = $orderItemFile->tech_pack_images;
                        $newOrderItemFile->tech_pack_image_name = $orderItemFile->tech_pack_image_name;

                        $newOrderItemFile->production_layout_images = $orderItemFile->production_layout_images;
                        $newOrderItemFile->production_layout_image_name = $orderItemFile->production_layout_image_name;

                        $newOrderItemFile->test_print_images = $orderItemFile->test_print_images;
                        $newOrderItemFile->test_print_image_name = $orderItemFile->test_print_image_name;

                        $newOrderItemFile->product_picture_raw_images = $orderItemFile->product_picture_raw_images;
                        $newOrderItemFile->product_picture_raw_image_name = $orderItemFile->product_picture_raw_image_name;

                        $newOrderItemFile->product_picture_edited_images = $orderItemFile->product_picture_edited_images;
                        $newOrderItemFile->product_picture_edited_image_name = $orderItemFile->product_picture_edited_image_name;

                        $newOrderItemFile->save();
                    }
                }

                //new order item detail row
                $new_order_item_detail = new OrderItemsDetail;
                $new_order_item_detail->order_item_id = $new_order_item_id;

                $new_order_item_detail->size_id =$shipping_order_details->size_id;
                if($shipping_order_details->has_blank_qty == 'yes'){
                    $old_order_item_detail = OrderItemsDetail::where('id', $shipping_order_details->order_item_detail_id)
                                     ->first();
                    $old_qty = $old_order_item_detail->blanks;
                    $new_qty = $old_qty - $remake_order_item->qty;
                    $old_order_item_detail->blanks = $new_qty;
                    $old_order_item_detail->update();
                    $new_order_item_detail->blanks = $remake_order_item->qty;
                }
                $seqNameProperty = $shipping_order_details->seq_name; // Assuming "seq_name" is a valid property name
                $seqNumberProperty = $shipping_order_details->seq_number; // Assuming "numseq_one" is a valid property name

                // Check if the properties are not null and exist in $new_order_item_detail

                if ($seqNumberProperty !== null ) {
                    $new_order_item_detail->{$seqNumberProperty} = $shipping_order_details->player_number;
                    $new_order_item_detail->qty =$shipping_order_details->order_qty;
                }
                $new_order_item_detail->save();
                if($shipping_order_details->has_blank_name == 'yes'){
                    if ($seqNameProperty !== null ) {
                        $playerName = $shipping_order_details->player_name;
                        $playerNameArray = [$playerName]; // Convert string to array
                        $playerNameJson = json_encode($playerNameArray); // Encode array as JSON
                        $new_item_player_name = new OrderItemsDetailPlayerName;
                        $new_item_player_name->order_items_detail_id = $new_order_item_detail->id;
                        $new_item_player_name->blank_qty = 1;
                        $new_item_player_name->blank_player_names = $playerNameJson;
                        $new_item_player_name->save();

                        // $new_order_item_detail_qty = OrderItemsDetail::where('id', $new_order_item_detail->id)->first();
                        // $new_order_item_detail_qty_blank = $new_order_item_detail_qty->blanks;
                        // $new_order_item_detail_qty->blanks = $new_order_item_detail_qty_blank + 1;
                        // $new_order_item_detail_qty->update();
                    }

                }else{
                    if ($seqNameProperty !== null ) {
                        $new_item_player_name = new OrderItemsDetailPlayerName;
                        $new_item_player_name->order_items_detail_id = $new_order_item_detail->id;
                        $new_item_player_name->{$seqNameProperty} = $shipping_order_details->player_name;
                        $new_item_player_name->save();
                    }
                }

                $new_order_item_detail_id = $new_order_item_detail->id;
                $processedOrderItemIds[] = $shipping_order_details->order_item_id;
                continue;

            }

            $order_item_detail = OrderItemsDetail::where('order_item_id', $new_order_item_id)
                                     ->where('size_id', $shipping_order_details->size_id)
                                     ->first();

            if ($order_item_detail) {
                if ($shipping_order_details->has_blank_qty == 'yes') {
                    $old_order_item_detail = OrderItemsDetail::where('id', $shipping_order_details->order_item_detail_id)
                                     ->first();
                    $old_qty = $old_order_item_detail->blanks;
                    $new_qty = $old_qty - $remake_order_item->qty;
                    $old_order_item_detail->blanks = $new_qty;
                    $old_order_item_detail->update();
                    $order_item_detail->blanks = $order_item_detail->blanks + $remake_order_item->qty;
                }

                $seqNameProperty = $shipping_order_details->seq_name; // Assuming "seq_name" is a valid property name
                $seqNumberProperty = $shipping_order_details->seq_number; // Assuming "numseq_one" is a valid property name

                // Check if the properties are not null and exist in $order_item_detail
                // if ($seqNameProperty !== null && property_exists($order_item_detail, $seqNameProperty)) {
                //     $order_item_detail->{$seqNameProperty} = $shipping_order_details->player_name;
                // }

                if ($seqNumberProperty !== null) {
                    $order_item_detail->{$seqNumberProperty} = $shipping_order_details->player_number;
                    $qty1=$order_item_detail->qty;
                    $qty2=$remake_order_item->qty;
                    $qty3=$qty1+$qty2;
                    $order_item_detail->qty =$qty3;
                }
                if($shipping_order_details->has_blank_name == 'yes'){
                    if ($seqNameProperty !== null ) {
                        $item_player_name = OrderItemsDetailPlayerName::where('order_items_detail_id', $order_item_detail->id)->first();
                        $currentPlayerNamesJson = $item_player_name->blank_player_names;
                        $currentBlankQty = $item_player_name->blank_qty;
                        $NewBlankQty = $currentBlankQty + 1;
                        $currentPlayerNamesArray = json_decode($currentPlayerNamesJson, true); // Decode JSON to array

                        // Append the new value to the array
                        $newPlayerName = $shipping_order_details->player_name;
                        $currentPlayerNamesArray[] = $newPlayerName;

                        // Encode the modified array as JSON
                        $newPlayerNamesJson = json_encode($currentPlayerNamesArray);
                        $item_player_name->blank_player_names = $newPlayerNamesJson;
                        $item_player_name->blank_qty = $NewBlankQty;
                        $item_player_name->update();

                        // $new_order_item_detail_qty = OrderItemsDetail::where('id', $order_item_detail->id)->first();
                        // $new_order_item_detail_qty_blank = $new_order_item_detail_qty->blanks;
                        // $new_order_item_detail_qty->blanks = $new_order_item_detail_qty_blank + 1;
                        // $new_order_item_detail_qty->update();
                    }
                }else{

                    if ($seqNameProperty !== null ) {
                        $item_player_name = OrderItemsDetailPlayerName::where('order_items_detail_id', $order_item_detail->id)->first();
                        $item_player_name->{$seqNameProperty} = $shipping_order_details->player_name;
                        $item_player_name->update();
                    }
                }

                $order_item_detail->update();
            }else{
                //new order item detail row
                $new_order_item_detail = new OrderItemsDetail;
                $new_order_item_detail->order_item_id = $new_order_item_id;
                // $new_order_item_detail->qty =
                $new_order_item_detail->size_id =$shipping_order_details->size_id;
                if($shipping_order_details->has_blank_qty == 'yes'){
                    $old_order_item_detail = OrderItemsDetail::where('id', $shipping_order_details->order_item_detail_id)
                                     ->first();
                    $old_qty = $old_order_item_detail->blanks;
                    $new_qty = $old_qty - $remake_order_item->qty;
                    $old_order_item_detail->blanks = $new_qty;
                    $old_order_item_detail->update();
                    $new_order_item_detail->blanks = $remake_order_item->qty;
                }
                $seqNameProperty = $shipping_order_details->seq_name; // Assuming "seq_name" is a valid property name
                $seqNumberProperty = $shipping_order_details->seq_number; // Assuming "numseq_one" is a valid property name

                // Check if the properties are not null and exist in $new_order_item_detail
                // if ($seqNameProperty !== null && property_exists($new_order_item_detail, $seqNameProperty)) {
                //     $new_order_item_detail->{$seqNameProperty} = $shipping_order_details->player_name;
                // }

                if ($seqNumberProperty !== null ) {
                    $new_order_item_detail->{$seqNumberProperty} = $shipping_order_details->player_number;
                    $new_order_item_detail->qty =$shipping_order_details->order_qty;

                }
                $new_order_item_detail->save();

                if($shipping_order_details->has_blank_name == 'yes'){
                    if ($seqNameProperty !== null ) {
                        $playerName = $shipping_order_details->player_name;
                        $playerNameArray = [$playerName]; // Convert string to array
                        $playerNameJson = json_encode($playerNameArray); // Encode array as JSON
                        $new_item_player_name = new OrderItemsDetailPlayerName;
                        $new_item_player_name->order_items_detail_id = $new_order_item_detail->id;
                        $new_item_player_name->blank_qty = 1;
                        $new_item_player_name->blank_player_names = $playerNameJson;
                        $new_item_player_name->save();

                        // $new_order_item_detail_qty = OrderItemsDetail::where('id',  $new_order_item_detail->id)->first();
                        // $new_order_item_detail_qty_blank = $new_order_item_detail_qty->blanks;
                        // $new_order_item_detail_qty->blanks = $new_order_item_detail_qty_blank + 1;
                        // $new_order_item_detail_qty->update();
                    }

                }else{
                    if ($seqNameProperty !== null ) {
                        $new_item_player_name = new OrderItemsDetailPlayerName;
                        $new_item_player_name->order_items_detail_id = $new_order_item_detail->id;
                        $new_item_player_name->{$seqNameProperty} = $shipping_order_details->player_name;
                        $new_item_player_name->save();
                    }
                }


            }




        }
        foreach ($newOrderItemIds as $newId) {
            if($newId !== null){
                $order_item_details = OrderItemsDetail::where('order_item_id', $newId)->get();
                $total_qty = 0;
                foreach ($order_item_details as $order_item_detail) {
                    $total_qty = $total_qty + $order_item_detail->qty;
                    $total_qty = $total_qty + $order_item_detail->blanks;
                }

                $for_total_qty_order_item = OrderItem::find($newId);
                $for_total_qty_order_item->qty = $total_qty;
                $for_total_qty_order_item->total = $total_qty * $for_total_qty_order_item->unit_price;
                $for_total_qty_order_item->update();
            }
        }
        foreach ($oldOrderItemIds as $oldID) {
            if($oldID !== null){
                $order_item_details = OrderItemsDetail::where('order_item_id', $oldID)->get();
                $total_qty = 0;
                foreach ($order_item_details as $order_item_detail) {
                    $total_qty = $total_qty + $order_item_detail->qty;
                    $total_qty = $total_qty + $order_item_detail->blanks;
                }

                $for_total_qty_order_item = OrderItem::find($oldID);
                $for_total_qty_order_item->qty = $total_qty;
                $for_total_qty_order_item->total = $total_qty * $for_total_qty_order_item->unit_price;
                $for_total_qty_order_item->update();
            }
        }
        // $users = ['heshannamal222@gmail.com'];
        // $this->sendOrderDetailsMail($request->order_id, $users, $newOrderItemIds);
        $this->emailSendFactory($request->order_id,  $newOrderItemIds, $remake_order_item->est_delivery_date, $remake_order_item->ex_factory_date);
        $this->sendRemakeToProductionNotification($request->order_id,  $newOrderItemIds, $remake_order_item->est_delivery_date, $remake_order_item->ex_factory_date);
        return json_encode($new_order_item_id);

    }
    public function sendOrderDetailsMail($orderId, $users, $newOrderItemIds) {
        // Set mail configuration dynamically
        config([
            'mail.host' => 'server.encr.co',
            'mail.port' => '465',
            'mail.encryption' => 'ssl',
            'mail.username' => 'info@encr.co',
            'mail.password' => 'Encr.co@ec123',
        ]);

        // Set from address and name
        $fromSettings = [
            'address' => 'info@encr.co',
            'name' => 'Encore Custom',
        ];
        config(['mail.from' => $fromSettings]);

        // Prepare array of recipients


        // Fetch order details

        $orderDetails = Order::find($orderId);

        $orderItems = OrderItem::whereIn('id', $newOrderItemIds)

                                ->get();
        $orderItemArray = '';
        foreach ($orderItems as $orderItem) {
            $orderItemArray .= '<li>'.$orderItem->productDetails->product_name.'</li>';
        }

        $teamName = '<p style="margin-top: 0.1rem;">Team Name: '.$orderDetails->organizationDetails->organization_name.'</p>';
        $exFactDate = '<p style="margin-top: 0.1rem;">Ex Factory Date: '.$orderDetails->ex_factory_date.'</p>';
        $inHandDate = '<p style="margin-top: 0.1rem;">In Hand Due Date: '.$orderDetails->due_date.'</p>';

        $data["to"] = 'heshannamal222@gmail.com';
        $data["subject"] = 'New Remake Order items Encore Production | Order - #'.$orderDetails->order_no.' | Team - '.$orderDetails->organizationDetails->organization_name;
        $data["body"] = '<table>'. $teamName . $exFactDate . $inHandDate .'</table><p>Following Remake items has been moved to production regarding order <a target="_blank" href="https://encr.co/order_details/edit/'.$orderId.'/order?active_tab=order">#'.$orderDetails->order_no.'</a></p><ul>'.$orderItemArray.'</ul>';

        Mail::send('emailNotification.factory_notification', $data, function ($message) use ($data) {
            $message->to($data["to"]);

            $message->subject($data["subject"]);
        });

        return "ok"; // Assuming successful sending
    }

    public function emailSendFactory($orderId, $newOrderItemIds, $deliveryDate, $exFactoryDate)
    {
        $allOrderItems = OrderItem::whereIn('id', $newOrderItemIds)->get();

        $factoryArray = [];
        foreach ($allOrderItems as $allOrderItem) {
            $item = OrderItem::find($allOrderItem->id);
            if (isset($item->factory_id)) {
                $factoryArray[] = $item->factory_id;
            }
        }

        if (!$factoryArray) {
            return false;
        }

        $orderDetails = Order::with(['organizationDetails', 'contactDetails'])->find($orderId);

        if (!$orderDetails) {
            return false;
        }

        $itemListHtml = '';
        foreach ($allOrderItems as $orderItem) {
            $productName = $orderItem->display_name ?? optional($orderItem->productDetails)->product_name ?? '-';
            $itemListHtml .= '<tr><td style="padding:12px 16px;font-size:13px;color:#1f2937;">'
                . '<table role="presentation" width="100%" cellpadding="0" cellspacing="0"><tr>'
                . '<td>' . e($productName) . '</td>'
                . '<td align="right"><span style="background:#eef2f7;color:#4b5563;font-size:11px;font-weight:700;padding:3px 10px;border-radius:5px;white-space:nowrap;">Qty - ' . (int) $orderItem->qty . '</span></td>'
                . '</tr></table>'
                . '</td></tr>';
        }

        $discussionLink = route('orders.info', ['id' => $orderDetails->id, 'type' => 'management']);
        $orderLink      = url("order_details/edit/{$orderId}/order") . '?active_tab=order';

        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_remake_production', [
            'orderId'            => $orderId,
            'order_number'       => $orderDetails->order_no,
            'organization_name'  => optional($orderDetails->organizationDetails)->organization_name ?? '',
            'customer_details'   => trim(optional($orderDetails->contactDetails)->first_name . ' ' . optional($orderDetails->contactDetails)->last_name),
            'send_relevent_factory' => true,
            'factorys_array'     => $factoryArray,
            'new_order_items'    => $allOrderItems,
            'ex_factory_date'    => $exFactoryDate,
            'inhand_date'        => $deliveryDate,
            'order_link'         => $orderLink,
            'discussion_link'    => $discussionLink,
            'order_items_list'   => $itemListHtml,
        ]);

        return true;
    }


    public function sendRemakeToProductionNotification($orderId, $newOrderItemIds, $deliveryDate, $exFactoryDate)
    {
        $delDate = Carbon::parse($deliveryDate)->format('m/d/Y');
        $exFacDate = Carbon::parse($exFactoryDate)->format('m/d/Y');

        $newOrderItemIds = (array) $newOrderItemIds;
        if (empty($newOrderItemIds)) {
            return;
        }

        $order = Order::with('organizationDetails')->find($orderId);
        if (!$order) {
            return;
        }

        $orderItems = OrderItem::with('orderItemDetails.sizeDetails')
        ->whereIn('id', $newOrderItemIds)
        ->get();


        if ($orderItems->isEmpty()) {
            return;
        }

        $builder = new NotificationBuilderService();
        $orderLink = url('order_details/edit/' . $order->id . '/order') . '?active_tab=order';
        $itemRowHtml = '';

        foreach ($orderItems as $orderItem) {

            $subProduct = SubProduct::where('sub_product_no', $orderItem->sub_product_no)->first();
            $itemName = optional($subProduct)->product_name ?? $orderItem->item_no;

            $mockupImage = optional($subProduct)->mockup_img_1;
            if (!empty($mockupImage)) {
                $itemImage = url('assets/' . ltrim($mockupImage, '/'));
            } else {
                $itemImage = url('assets/img/products/product defaul image.jpg');
            }

            $itemRowHtml .= '<div style="display:flex;align-items:center;justify-content:space-between;gap:12px;padding:14px 16px;background:#ffffff">
                <div style="display:flex;align-items:center;gap:12px">
                    <img src="' . $itemImage . '" style="width:44px;height:44px;border-radius:6px;object-fit:cover;flex-shrink:0" alt="' . e($itemName) . '">
                    <div>
                        <div style="font-size:14px;font-weight:600;color:#111827">' . e($itemName) . '</div>
                    </div>
                </div>
                <div style="display:flex;gap:8px;flex-shrink:0">
                    <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:6px;padding:6px 12px;text-align:center">
                        <div style="font-size:9px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:#9ca3af;display:flex;align-items:center;gap:4px;justify-content:center"><i class="far fa-calendar-alt"></i> EX-FACTORY DATE</div>
                        <div style="font-size:12px;font-weight:600;color:#111827;margin-top:2px">' . $exFacDate . '</div>
                    </div>
                    <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:6px;padding:6px 12px;text-align:center">
                        <div style="font-size:9px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:#9ca3af;display:flex;align-items:center;gap:4px;justify-content:center"><i class="far fa-calendar-alt"></i> IN-HAND DUE DATE</div>
                        <div style="font-size:12px;font-weight:600;color:#111827;margin-top:2px">' . $delDate . '</div>
                    </div>
                </div>
            </div>';

            
        }

        $discussionLink = route('orders.info', ['id' => $orderId, 'type' => 'management']);


        $builder->sendNotification(
            'key_remake_to_production',
            [
                '{order_no}'          => $order->order_no,
                '{order_link}'        => $orderLink,
                '{organization_name}' => optional($order->organizationDetails)->organization_name ?? '',
                '{item_rows}'         => $itemRowHtml,
                '{discussion_url}'    => $discussionLink,
            ],
            [
                'order_id'                   => $order->id,
                'order_item_id'              => implode(',', $newOrderItemIds),
                'target_notification_field'  => 'key_remake_to_production',
                'new_notification'           => 1,
            ]
        );

        return true;
    }

    public function remake_studio_item(Request $request)
    {
        $order_item_id = $request->order_item_id;
        if (!$order_item_id) {
            return response()->json(['success' => false, 'message' => 'Order Item ID is required'], 400);
        }

        $order_item = OrderItem::find($order_item_id);
        if (!$order_item) {
            return response()->json(['success' => false, 'message' => 'Order Item not found'], 444);
        }

        if(isset($order_item->productDetails) && $order_item->productDetails->gender == 'Men'){
            $studioProductSize = 6;
        } else {
            $studioProductSize = 5;
        }

        if(isset($order_item->productDetails->productManufacturePrice)){
            $unit_price = $order_item->productDetails->productManufacturePrice->price;
        } else {
            $unit_price = $order_item->unit_price;
        }

        DB::beginTransaction();
        try {
            $studioExfactory = OrdersCommenFacade::getStudioExfacotry();
            $order_item_count = OrderItem::where('order_id', $order_item->order_id)->count();
            $new_order_item_count_number = $order_item_count + 1;
            $order_number = str_pad($order_item->order_id, 6, "0", STR_PAD_LEFT);

            // Create new duplicated OrderItem marked as studio item
            $new_order_item = new OrderItem();
            $new_order_item->fill($order_item->toArray());

            $new_order_item->ex_factory_id = $studioExfactory->id;
            $new_order_item->qty = 1;
            $new_order_item->unit_price = $unit_price;
            $new_order_item->total = $unit_price;
            $new_order_item->item_no = $order_number . "-" . $new_order_item_count_number;
            $new_order_item->is_studio_item = 1;
            // $new_order_item->order_status_id = 3; // Production status
            $new_order_item->save();

            $new_order_item_id = $new_order_item->id;

            // Duplicate order item attributes
            $order_item_attributes = OrderItemAttribute::where('order_item_id', $order_item->id)->get();
            if ($order_item_attributes->isNotEmpty()) {
                foreach ($order_item_attributes as $attribute) {
                    if($attribute->attribute_id == 1 || $attribute->attribute_id == 2){
                        continue;
                    }
                    $new_attribute = new OrderItemAttribute();
                    $new_attribute->order_item_id = $new_order_item_id;
                    $new_attribute->attribute_id = $attribute->attribute_id;
                    $new_attribute->save();
                }
            }

            // Duplicate order item files
            $order_item_files = OrderItemFile::where('order_item_id', $order_item->id)->get();
            if ($order_item_files->isNotEmpty()) {
                foreach ($order_item_files as $file) {
                    $newFile = new OrderItemFile();
                    $newFile->organization_id = $file->organization_id;
                    $newFile->contact_id = $file->contact_id;
                    $newFile->order_id = $file->order_id;
                    $newFile->order_item_id = $new_order_item_id;
                    $newFile->mockup_images = $file->mockup_images;
                    $newFile->mockup_image_name = $file->mockup_image_name;
                    $newFile->tech_pack_files = $file->tech_pack_files;
                    $newFile->tech_pack_file_name = $file->tech_pack_file_name;
                    $newFile->tech_pack_images = $file->tech_pack_images;
                    $newFile->tech_pack_image_name = $file->tech_pack_image_name;
                    $newFile->production_layout_images = $file->production_layout_images;
                    $newFile->production_layout_image_name = $file->production_layout_image_name;
                    $newFile->test_print_images = $file->test_print_images;
                    $newFile->test_print_image_name = $file->test_print_image_name;
                    $newFile->product_picture_raw_images = $file->product_picture_raw_images;
                    $newFile->product_picture_raw_image_name = $file->product_picture_raw_image_name;
                    $newFile->product_picture_edited_images = $file->product_picture_edited_images;
                    $newFile->product_picture_edited_image_name = $file->product_picture_edited_image_name;
                    $newFile->save();
                }
            }

            // Duplicate order item details (roster & blank entries)
            $order_item_details = OrderItemsDetail::where('order_item_id', $order_item->id)->get();
            if ($order_item_details->isNotEmpty()) {
                foreach ($order_item_details as $detail) {
                    $new_detail = new OrderItemsDetail();
                    $new_detail->order_item_id = $new_order_item_id;
                    $new_detail->size_id = $detail->size_id;
                    if($detail->size_id == $studioProductSize){
                        $new_detail->blanks = 1;
                    }
                    $new_detail->save();

                    $orderItemsDetailsPlayerName = new OrderItemsDetailPlayerName();
                    $orderItemsDetailsPlayerName->order_items_detail_id = $new_detail->id;
                    $orderItemsDetailsPlayerName->save();
                }
            }

            DB::commit();

            $this->sendAddStudioItemToProductionNotification($new_order_item->order_id,  $new_order_item->id, $new_order_item->est_delivery_date, $new_order_item->ex_factory_date);
            $this->emailAddStudioItemToProduction($new_order_item->order_id,  $new_order_item->id, $new_order_item->est_delivery_date, $new_order_item->ex_factory_date);

            return response()->json([
                'success' => true,
                'message' => 'The new item was successfully added as a Studio Item!',
                'new_order_item_id' => $new_order_item_id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error duplicating item: ' . $e->getMessage()
            ], 500);
        }
    }

    public function emailAddStudioItemToProduction($orderId, $newOrderItemId, $deliveryDate, $exFactoryDate)
    {
        $allOrderItems = OrderItem::where('id', $newOrderItemId)->get();

        $orderDetails = Order::with(['organizationDetails', 'contactDetails'])->find($orderId);

        if (!$orderDetails) {
            return false;
        }

        $itemListHtml = '';
        foreach ($allOrderItems as $orderItem) {
            $productName = $orderItem->display_name ?? optional($orderItem->productDetails)->product_name ?? '-';
            $itemListHtml .= '<tr><td style="padding:12px 16px;font-size:13px;color:#1f2937;">'
                . '<table role="presentation" width="100%" cellpadding="0" cellspacing="0"><tr>'
                . '<td>' . e($productName) . '</td>'
                . '<td align="right"><span style="background:#eef2f7;color:#4b5563;font-size:11px;font-weight:700;padding:3px 10px;border-radius:5px;white-space:nowrap;">Qty - ' . (int) $orderItem->qty . '</span></td>'
                . '</tr></table>'
                . '</td></tr>';
        }

        $discussionLink = route('orders.info', ['id' => $orderDetails->id, 'type' => 'management']);
        $orderLink      = url("order_details/edit/{$orderId}/order") . '?active_tab=order';

        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_add_as_studio_item', [
            'orderId'            => $orderId,
            'order_number'       => $orderDetails->order_no,
            'organization_name'  => optional($orderDetails->organizationDetails)->organization_name ?? '',
            'customer_details'   => trim(optional($orderDetails->contactDetails)->first_name . ' ' . optional($orderDetails->contactDetails)->last_name),
            'new_order_items'    => $allOrderItems,
            'ex_factory_date'    => $exFactoryDate,
            'order_link'         => $orderLink,
            'discussion_link'    => $discussionLink,
            'order_items_list'   => $itemListHtml,
        ]);

        return true;
    }

    public function sendAddStudioItemToProductionNotification($orderId, $newOrderItemId, $deliveryDate, $exFactoryDate)
    {
        $delDate = Carbon::parse($deliveryDate)->format('m/d/Y');
        $exFacDate = Carbon::parse($exFactoryDate)->format('m/d/Y');

        if (!isset($newOrderItemId)) {
            return;
        }

        $order = Order::with('organizationDetails')->find($orderId);
        if (!$order) {
            return;
        }

        $orderItem = OrderItem::with('orderItemDetails.sizeDetails')->where('id', $newOrderItemId)->first();


        if (empty($orderItem)) {
            return;
        }

        $builder = new NotificationBuilderService();
        $orderLink = url('order_details/edit/' . $order->id . '/order') . '?active_tab=order';
        $itemRowHtml = '';


        $subProduct = SubProduct::where('sub_product_no', $orderItem->sub_product_no)->first();
        $itemName = optional($subProduct)->product_name ?? $orderItem->item_no;

        $mockupImage = optional($subProduct)->mockup_img_1;
        if (!empty($mockupImage)) {
            $itemImage = url('assets/' . ltrim($mockupImage, '/'));
        } else {
            $itemImage = url('assets/img/products/product defaul image.jpg');
        }

        $itemRowHtml .= '<div style="display:flex;align-items:center;justify-content:space-between;gap:12px;padding:14px 16px;background:#ffffff">
            <div style="display:flex;align-items:center;gap:12px">
                <img src="' . $itemImage . '" style="width:44px;height:44px;border-radius:6px;object-fit:cover;flex-shrink:0" alt="' . e($itemName) . '">
                <div>
                    <div style="font-size:14px;font-weight:600;color:#111827">' . e($itemName) . '</div>
                </div>
            </div>
            <div style="display:flex;gap:8px;flex-shrink:0">
                <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:6px;padding:6px 12px;text-align:center">
                    <div style="font-size:9px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:#9ca3af;display:flex;align-items:center;gap:4px;justify-content:center"><i class="far fa-calendar-alt"></i> EX-FACTORY DATE</div>
                    <div style="font-size:12px;font-weight:600;color:#111827;margin-top:2px">' . $exFacDate . '</div>
                </div>
                <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:6px;padding:6px 12px;text-align:center">
                    <div style="font-size:9px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:#9ca3af;display:flex;align-items:center;gap:4px;justify-content:center"><i class="far fa-calendar-alt"></i> IN-HAND DUE DATE</div>
                    <div style="font-size:12px;font-weight:600;color:#111827;margin-top:2px">' . $delDate . '</div>
                </div>
            </div>
        </div>';

        $discussionLink = route('orders.info', ['id' => $orderId, 'type' => 'management']);


        $builder->sendNotification(
            'key_add_studio_item_to_production',
            [
                '{order_no}'          => $order->order_no,
                '{order_link}'        => $orderLink,
                '{organization_name}' => optional($order->organizationDetails)->organization_name ?? '',
                '{item_rows}'         => $itemRowHtml,
                '{discussion_url}'    => $discussionLink,
            ],
            [
                'order_id'                   => $order->id,
                'order_item_id'              => $newOrderItemId,
                'target_notification_field'  => 'key_add_studio_item_to_production',
                'new_notification'           => 1,
            ]
        );

        return true;
    }
}

// add column to order items
//ALTER TABLE `order_items` ADD `remake_status` INT(10) NOT NULL DEFAULT '0' AFTER `suggested_ex_fac_date`, ADD `has_remake_item` INT(10) NOT NULL DEFAULT '0' AFTER `remake_status`;
