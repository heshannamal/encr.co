<?php

namespace App\Http\Controllers;

use App\Imports\TeamStoreImport;
use App\Models\Contact;
use App\Models\OrderItemAttribute;
use App\Models\EmbellishmentType;
use App\Models\Fabric;
use App\Models\Factory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemsDetail;
use App\Models\OrderItemsDetailPlayerName;
use App\Models\Organization;
use App\Models\Product;
use App\Models\SubProduct;
use App\Models\ProductSize;
use App\Models\Size;
use App\Models\TeamStoreOrder;
use App\Models\TeamStorePlayerReport;
use App\Models\TeamStoreProductReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Jobs\ProcessTeamStoreImport;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use DB;

class TeamStoreController extends Controller{
    public $completed = false;
    public $percentage = 0;
    public function index()
    {
        if(auth()->user()->can('manage team store orders')){
            $organizations = Organization::select('id', 'organization_name')->where('active', 1)->orderBy('organization_name')->get();

            $teamStores = TeamStoreOrder::where('active', 1)->get();

            return view('pages.order_management.team_store.index', ['teamStores'=>$teamStores, 'organizations'=>$organizations]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function create(Request $request){
        //$contact = Contact::where('organization_id', $request->organization_id)->first();
        $contact = Contact::find($request->customer_id);
        $organization = Organization::find($request->organization_id);

        if ($contact) {
            $vali_message = TeamStoreController::exFileUpValidation($request);

            $error_array_exel_import = array_unique($vali_message);

            if(count($error_array_exel_import) > 0){
                // return redirect()->back()->with(compact('error_array_exel_import'));
                $this->completed = true;
                return response()->json(['error' => true, 'message' => 'error array excel import','data' =>$error_array_exel_import]);

            }else{

                $maxId = Order::max('id');
                $orderNo = "TSR".str_pad(($maxId+1), 6, "0", STR_PAD_LEFT);

                $file = $request->file('team_store_report');

                $import = new TeamStoreImport(2);
                Excel::import($import, $file);
                $sheets = $import->sheets();

                $filename = $organization->organization_name.' - '.$orderNo;
                $destinationPath = 'uploads/team_store';
                $file->move($destinationPath, $filename.'.'.$file->getClientOriginalExtension());
                $filepath = $destinationPath.'/'.$filename.'.'.$file->getClientOriginalExtension();

                $teamStore = new TeamStoreOrder();
                $teamStore->order_no = $orderNo;
                $teamStore->organization_id = $request->organization_id;
                $teamStore->team_store_report_name = $filename;
                $teamStore->team_store_report = $filepath;
                $teamStore->save();

                $playerReportSheet = $sheets[1];
                $playerReportSheetArray = $playerReportSheet->getArray();

                foreach ($playerReportSheetArray as $playerSheetData) {
                    if ($playerSheetData['product_name']) {
                        $teamStoreProductReport = new TeamStorePlayerReport();
                        $teamStoreProductReport->team_store_order_id = $teamStore->id;
                        $teamStoreProductReport->player_name = trim($playerSheetData['player_name']);
                        $teamStoreProductReport->billing_name = trim($playerSheetData['billing_name']);
                        $teamStoreProductReport->order_number = $playerSheetData['order_number'];
                        $teamStoreProductReport->order_quantity = $playerSheetData['order_quantity'];
                        $teamStoreProductReport->product_name = trim(str_replace('"','', $playerSheetData['product_name']));
                        $teamStoreProductReport->player_no = trim($playerSheetData['player_no']);
                        $teamStoreProductReport->quantity = $playerSheetData['quantity'];
                        $teamStoreProductReport->size = trim($playerSheetData['size']);
                        $teamStoreProductReport->save();
                    }
                }

                $productReportSheet = $sheets[0];
                $productReportSheetArray = $productReportSheet->getArray();
                $afterHyphenValues = [];

                foreach ($productReportSheetArray as $sheetData) {
                    if ($sheetData['fabric']) {

                        $product_name = trim($sheetData['product_name']);


                        preg_match('/ - (.+)/', $product_name, $matches);



                        $teamStoreProductReport = new TeamStoreProductReport();
                        $teamStoreProductReport->team_store_order_id = $teamStore->id;
                        $teamStoreProductReport->product_code = trim($sheetData['product_code']);
                        $teamStoreProductReport->product_name = trim(str_replace('"','', $sheetData['product_name']));
                        $teamStoreProductReport->product_year = trim($sheetData['product_year']);
                        $teamStoreProductReport->fabric = trim($sheetData['fabric']);
                        $teamStoreProductReport->embellishment = trim($sheetData['embellishment']);
                        $teamStoreProductReport->quantity = $sheetData['quantity'];
                        $teamStoreProductReport->size = trim($sheetData['size']);
                        $teamStoreProductReport->factory_code = trim($sheetData['factory_code']);
                        if (isset($matches[1])) {
                            $afterHyphenData = $matches[1];

                            $teamStoreProductReport->item_description = $afterHyphenData;
                        }

                        $teamStoreProductReport->save();
                    }
                }

                $newOrder = new Order();
                $newOrder->organization_id = $request->organization_id;
                $newOrder->contact_id = $contact->id;
                $newOrder->order_no = $orderNo;
                $newOrder->order_status_id = 1;
                $newOrder->user_id = $organization->user_id;
                $newOrder->open_date = Carbon::now()->format('m/d/Y');

                $newOrder->active = 1;
                $newOrder->is_new_shipping_address = 0;

                if ($request->has('shipping_direct_ship_to_customers')) {
                    $addressType = 1;
                } else if ($request->has('shipping_bulk_ship_to_coach')) {
                    $addressType = 2;
                } else if ($request->has('shipping_pick_up')) {
                    $addressType = 3;
                } else if ($request->has('shipping_direct_pick_up')) {
                    $addressType = 4;
                }
                $newOrder->address_type = $addressType;

                if($addressType == 2){
                    $newOrder->ex_factory_date = Carbon::now()->subDays(7)->format('m/d/Y');
                    $newOrder->due_date = Carbon::now()->format('m/d/Y');
                }else{
                    $newOrder->ex_factory_date = Carbon::now()->subDays(14)->format('m/d/Y');
                    $newOrder->encore_packing_date = Carbon::now()->subDays(7)->format('m/d/Y');
                    $newOrder->due_date = Carbon::now()->format('m/d/Y');
                }

                $newOrder->street = $contact->shipping_street;
                $newOrder->city = $contact->shipping_city;
                $newOrder->state = $contact->shipping_state;
                $newOrder->postal_code = $contact->shipping_zip;
                $newOrder->country = $contact->shipping_country;
                $newOrder->phone_no = $contact->phone_no;
                $newOrder->email = $contact->email;
                $newOrder->order_type = 1;
                $newOrder->save();

                //methanin gthe

                //total cal methana

                // $productReports = TeamStoreProductReport::where('team_store_order_id', $teamStore->id)->groupBy('product_name')->get();
                // $total_items = $productReports->count();
                $total_items = TeamStoreProductReport::where('team_store_order_id', $teamStore->id)
                                ->distinct('product_name')
                                ->count('product_name');
                return response()->json(['success' => true,'message' => 'Order updated successfully!','newOrderId'=> $newOrder->id, 'teamStore_id'=> $teamStore->id, 'total_items'=> $total_items, 'orderNo'=> $orderNo]);



            }
        } else {

            return response()->json([
                'error' => true,
                'message' => 'Can not find a contact person for this organization. Please assign a contact person!'
            ]);
        }
    }
    private function numberToWord($number) {
        $words = [ 'one' ,'two' ,'three' ,'four' ,'five', 'six' ,'seven' ,'eight' ,'nine' ,'ten',

        'eleven' ,'twelve' ,'thirteen' ,'fourteen' ,'fifteen' , 'sixteen' ,'seventeen' ,'eighteen' ,'nineteen' ,'twenty' ,

        'twenty_one' ,'twenty_two' ,'twenty_three' ,'twenty_four' ,'twenty_five','twenty_six' ,'twenty_seven' ,'twenty_eight' ,'twenty_nine' ,'thirty' ,

        'thirty_one' ,'thirty_two' ,'thirty_three' ,'thirty_four' ,'thirty_five' ,'thirty_six' ,'thirty_seven' ,'thirty_eight' ,'thirty_nine' ,'forty',

        'forty_one' ,'forty_two' ,'forty_three' ,'forty_four' ,'forty_five' ,'forty_six' ,'forty_seven' ,'forty_eight' ,'forty_nine' ,'fifty',

        'fifty_one' ,'fifty_two' ,'fifty_three' ,'fifty_four' ,'fifty_five' ,'fifty_six' ,'fifty_seven' ,'fifty_eight' ,'fifty_nine' ,'sixty' ,

        'sixty_one' ,'sixty_two' ,'sixty_three' ,'sixty_four' ,'sixty_five' ,'sixty_six' ,'sixty_seven' ,'sixty_eight' ,'sixty_nine' ,'seventy',

        'seventy_one' ,'seventy_two' ,'seventy_three' ,'seventy_four' ,'seventy_five','seventy_six' ,'seventy_seven' ,'seventy_eight' ,'seventy_nine' ,'eighty',

        'eighty_one' ,'eighty_two' ,'eighty_three' ,'eighty_four' ,'eighty_five' ,'eighty_six' ,'eighty_seven' ,'eighty_eight' ,'eighty_nine' ,'ninety',

        'ninety_one' ,'ninety_two' ,'ninety_three' ,'ninety_four' ,'ninety_five' ,'ninety_six' ,'ninety_seven' ,'ninety_eight' ,'ninety_nine' ,'hundred',

        'hundred_one' ,'hundred_two' ,'hundred_three' ,'hundred_four' ,'hundred_five', 'hundred_six' ,'hundred_seven' ,'hundred_eight' ,'hundred_nine' ,'hundred_ten',

        'hundred_eleven' ,'hundred_twelve' ,'hundred_thirteen' ,'hundred_fourteen' ,'hundred_fifteen' , 'hundred_sixteen' ,'hundred_seventeen' ,'hundred_eighteen' ,'hundred_nineteen' ,'hundred_twenty' ,

        'hundred_twenty_one' ,'hundred_twenty_two' ,'hundred_twenty_three' ,'hundred_twenty_four' ,'hundred_twenty_five','hundred_twenty_six' ,'hundred_twenty_seven' ,'hundred_twenty_eight' ,'hundred_twenty_nine' ,'hundred_thirty' ,

        'hundred_thirty_one' ,'hundred_thirty_two' ,'hundred_thirty_three' ,'hundred_thirty_four' ,'hundred_thirty_five' ,'hundred_thirty_six' ,'hundred_thirty_seven' ,'hundred_thirty_eight' ,'hundred_thirty_nine' ,'hundred_forty',

        'hundred_forty_one' ,'hundred_forty_two' ,'hundred_forty_three' ,'hundred_forty_four' ,'hundred_forty_five' ,'hundred_forty_six' ,'hundred_forty_seven' ,'hundred_forty_eight' ,'hundred_forty_nine' ,'hundred_fifty'];
        return $words[$number];
    }
    public function TotalCalPart(Request $request){

        $totalQty = $request->totalQty;
        $organization = Organization::find($request->organization_id);
        $totalAmount = $request->totalAmount;
        $teamStore_id = $request->teamStore_id;
        $newOrder_id = $request->newOrderId;

        if($totalQty > 70){
            $shippingFee = 0.5 * $totalQty;
        } else if($totalQty == 0){
            $shippingFee = 0;
        } else {
            $shippingFee = 35;
        }

        if ($organization->sales_tax_active == 1) {
            $salesTax = $organization->sales_tax;
        } else {
            $salesTax = 0;
        }
        $orderSalesTax = ($totalAmount / 100) * $salesTax;

        $existingOrder = Order::find($newOrder_id);
        $existingOrder->sub_total = $totalAmount;
        $existingOrder->sales_tax = $orderSalesTax;
        $existingOrder->shipping = $shippingFee;
        $existingOrder->order_total = $totalAmount + $shippingFee + $orderSalesTax;
        $existingOrder->update();

        $updateTeamStoreOrder = TeamStoreOrder::find($teamStore_id);
        $updateTeamStoreOrder->order_id = $newOrder_id;
        $updateTeamStoreOrder->update();
        return response()->json(['success' => true,'message' => 'Order updated successfully!']);

    }

    public function GenerateOrderItem(Request $request){
        $contact = Contact::find($request->customer_id);
        $organization = Organization::find($request->organization_id);
        // $productReports = TeamStoreProductReport::where('team_store_order_id',  $request->teamStore_id)->groupBy('product_name')->get();
        $productReports = TeamStoreProductReport::where('team_store_order_id', $request->teamStore_id)
                                                ->select('product_name', 'product_code', 'fabric', 'embellishment', 'factory_code', 'product_year', 'item_description', DB::raw('MIN(id) as id'))
                                                ->groupBy('product_name', 'product_code', 'fabric', 'embellishment', 'factory_code', 'product_year', 'item_description')
                                                ->get();
        $orderNo = $request->orderNo;
        $totalQty = 0;
        $totalAmount = 0;
        $deactivatedSubProduct = '';
        foreach ($productReports as $key => $productReport) {
            if($key == $request->item_key){


                    $product = Product::where('product_no', $productReport->product_code)->first();
                    $fabric = Fabric::where('fabric_name', 'LIKE', '%'.$productReport->fabric.'%')->first();
                    $embellishment = EmbellishmentType::where('embellishment_name', 'LIKE', '%'.$productReport->embellishment.'%')->first();
                    $factory = Factory::where('factory_code', 'LIKE', '%'.$productReport->factory_code.'%')->first();
                    $quantity = TeamStoreProductReport::where('team_store_order_id', $request->teamStore_id)->where('product_code', $productReport->product_code)->where('product_name', 'LIKE', $productReport->product_name)->sum('quantity');

                    $orderItem = new OrderItem();
                    $orderItem->item_no = $orderNo.'-'.($request->item_key+1);
                    $orderItem->order_id = $request->newOrderId;
                    $orderItem->product_id = $product->id;
                    $orderItem->organization_id = $request->organization_id;
                    $orderItem->factory_id = $factory->id;
                    $orderItem->support_agent_id = $contact->id;
                    $orderItem->ex_factory_id = 0;
                    $orderItem->open_date = Carbon::now()->format('m/d/Y');
                    if ($request->has('shipping_direct_ship_to_customers')) {
                        $addressType = 1;
                    } else if ($request->has('shipping_bulk_ship_to_coach')) {
                        $addressType = 2;
                    } else if ($request->has('shipping_pick_up')) {
                        $addressType = 3;
                    } else if ($request->has('shipping_direct_pick_up')) {
                        $addressType = 4;
                    }
                    if($addressType == 2){
                        $orderItem->ex_factory_date = Carbon::now()->subDays(7)->format('m/d/Y');
                        $orderItem->in_hand_due_date = Carbon::now()->format('m/d/Y');
                    }else{
                        $orderItem->ex_factory_date = Carbon::now()->subDays(14)->format('m/d/Y');
                        $orderItem->encore_packing_date = Carbon::now()->subDays(7)->format('m/d/Y');
                        $orderItem->in_hand_due_date = Carbon::now()->format('m/d/Y');
                    }

                    $orderItem->est_delivery_date = Carbon::now()->format('m/d/Y');
                    $orderItem->order_status_id = 1;
                    $orderItem->fabric_id = $fabric->id;
                    $orderItem->embellishment_type_id = $embellishment->id;
                    $orderItem->sport = $product->sport;
                    $orderItem->gender = $product->gender;
                    $orderItem->qty = $quantity;
                    $orderItem->unit_price = $product->default_price;
                    $orderItem->product_year = $productReport->product_year;
                    $orderItem->item_description = $productReport->item_description;

                    $sub_product_active = SubProduct::where('parent_product_id' , $product->id)->where('fabric_id' , $fabric->id)->where('active' , 1)->first();
                    $sub_product_deactivated = SubProduct::where('parent_product_id' , $product->id)->where('fabric_id' , $fabric->id)->where('active', '!= ', 1)->first();

                    if($sub_product_active || $sub_product_deactivated){

                        if($sub_product_deactivated){
                            $orderItem->unit_price = $sub_product_deactivated->default_price;
                            $orderItem->total = $quantity * $sub_product_deactivated->default_price;
                            $orderItem->sub_product_no = $sub_product_deactivated->sub_product_no;
                            $orderItem->active = 0;

                            $deactivatedSubProduct = $orderItem;

                        }else{
                            $orderItem->unit_price = $sub_product_active->default_price;
                            $orderItem->total = $quantity * $sub_product_active->default_price;
                            $orderItem->sub_product_no = $sub_product_active->sub_product_no;
                        }
                    }else{

                        $tempCount = SubProduct::where('parent_product_id', $product->id)->count();
                        $ActtempCount = $tempCount + 1;

                        $subProductCode = 'PRO-'.$product->id .'.'.$ActtempCount;

                        $subProduct = new SubProduct();
                        $subProduct->parent_product_id = $product->id;
                        $subProduct->sub_product_no = $subProductCode;

                        $subProduct->product_name = $product->product_name.' - '.$fabric->fabric_name;
                        $subProduct->standard_fabric = $fabric->fabric_name;
                        $subProduct->fabric_id = $fabric->id;

                        $subProduct->active = 0;
                        $subProduct->save();

                        $orderItem->unit_price = $product->default_price ;
                        $orderItem->total = $quantity * $subProduct->default_price;
                        $orderItem->sub_product_no = $subProduct->sub_product_no;
                        $orderItem->active = 0;

                        $deactivatedSubProduct = $orderItem;

                    }
                    if( $orderItem->unit_price == null){
                        return response()->json(['success' => false,'message' => 'Order Item Unit Price Can not be null check product id '.$product->id]);
                    }
                    $orderItem->save();

                    $totalQty += $quantity;
                    $totalAmount += $quantity * $orderItem->unit_price;

                    $productSizes = ProductSize::select('size_id')->where('product_id', $product->id)->get();

                    foreach($productSizes as $sizes){
                        $orderItemsDetails = new OrderItemsDetail();
                        $orderItemsDetails->order_item_id = $orderItem->id;
                        $orderItemsDetails->size_id = $sizes['size_id'];
                        // $orderItemsDetails->setDefaultValues();
                        $orderItemsDetails->save();
                    }

                    $indvNameOrderItem = OrderItem::find($orderItem->id);
                    $checkBox_excel_up_ind_name = "off";
                    if($request->checkBox_excel_up){
                        foreach ($request->checkBox_excel_up as $key => $checked_attribute) {
                            $order_att = new OrderItemAttribute();
                            $order_att->order_item_id = $orderItem->id ;
                            $order_att->attribute_id = $key;
                            $order_att->save();
                            if($key == 1){
                                $indvNameOrderItem->individual_no = 1;
                            }
                            if($key == 2){
                                $indvNameOrderItem->individual_name = 1;
                                $checkBox_excel_up_ind_name = "on";
                            }
                            if($key == 3){
                                $indvNameOrderItem->double_sided = 1;
                            }
                            if($key == 4){
                                $indvNameOrderItem->pockets = 1;
                            }
                            if($key == 5){
                                $indvNameOrderItem->zipper_pockets = 1;
                            }
                            if($key == 6){
                                $indvNameOrderItem->dynamic_details = 1;
                            }
                            if($key == 7){
                                $indvNameOrderItem->contrast_stratching = 1;
                            }
                            if($key == 8){
                                $indvNameOrderItem->printing_over_sems = 1;
                            }
                        }
                    }

                    $indvNameOrderItem->update();

                    // $individualName = false;

                    $playerReports = TeamStorePlayerReport::where('team_store_order_id', $request->teamStore_id)->where('product_name', 'LIKE', $productReport->product_name)->get();
                    foreach ($playerReports as $key => $playerReport) {
                        if ($playerReport->player_no !== null && $playerReport->player_no !== '') {
                            $size = Size::where('size_name', 'LIKE', $playerReport->size)->first();

                            $itemsDetails = OrderItemsDetail::where('order_item_id', $orderItem->id)->where('size_id', $size->id)->first();

                            $itemsDetails->qty += $playerReport->quantity;

                            $player_number_point = 0 ;
                            $player_name_point = 0 ;
                            for ($i = 0; $i < $playerReport->quantity; $i++) {
                                for ($j = $player_number_point; $j < 150; $j++) {
                                    $property = "numseq_" . $this->numberToWord($j);
                                    if ($itemsDetails->$property === null || $itemsDetails->$property === '') {
                                        $itemsDetails->$property = $playerReport->player_no;
                                        $player_number_point = ($j + 1);
                                        break;
                                    }
                                }
                                $itemsDetails->update();
                                $orderItemsDetailPlayerNames = OrderItemsDetailPlayerName::where('order_items_detail_id', $itemsDetails->id)->first();

                                //Check_Individual_Name_CheckBox_isSelected
                                if($checkBox_excel_up_ind_name =="on"){

                                    if ($orderItemsDetailPlayerNames) {
                                        for ($k = $player_name_point; $k < 150; $k++) {
                                            $property = "player_" . $this->numberToWord($k);
                                            if ($orderItemsDetailPlayerNames->$property == null) {
                                                $orderItemsDetailPlayerNames->$property = $playerReport->player_name;
                                                $player_name_point = ($k + 1);
                                                break;
                                            }
                                        }
                                        $orderItemsDetailPlayerNames->update();



                                    } else {

                                        $playerNameDetails = new OrderItemsDetailPlayerName();
                                        $playerNameDetails->order_items_detail_id = $itemsDetails->id;
                                        $playerNameDetails->player_one = $playerReport->player_name;
                                        $playerNameDetails->save();
                                    }
                                }else{
                                    $found_pl_detail_record = OrderItemsDetailPlayerName::where('order_items_detail_id', $itemsDetails->id)->first();
                                    if(!$found_pl_detail_record){
                                        $playerNameDetails = new OrderItemsDetailPlayerName();
                                        $playerNameDetails->order_items_detail_id = $itemsDetails->id;
                                        $playerNameDetails->save();
                                    }

                                }
                            }

                        } else {
                            $size = Size::where('size_name', 'LIKE', $playerReport->size)->first();

                            $itemsDetails = OrderItemsDetail::where('order_item_id', $orderItem->id)->where('size_id', $size->id)->first();
                            if (isset($itemsDetails->blanks)) {
                                $itemsDetails->blanks += $playerReport->quantity;
                            } else {
                                $itemsDetails->blanks = $playerReport->quantity;
                            }
                            $itemsDetails->update();


                            //Check_Individual_Name_CheckBox_isSelected
                            if($checkBox_excel_up_ind_name=="on"){
                                $orderItemsDetailPlayerNames = OrderItemsDetailPlayerName::where('order_items_detail_id', $itemsDetails->id)->first();

                                if ($orderItemsDetailPlayerNames) {
                                    if ($orderItemsDetailPlayerNames->blank_qty == 0) {
                                        $playerNames = [];
                                        for ($i = 0; $i < $playerReport->quantity; $i++) {
                                            array_push($playerNames, $playerReport->player_name);
                                        }

                                        $orderItemsDetailPlayerNames->blank_qty += $playerReport->quantity;
                                        $orderItemsDetailPlayerNames->blank_player_names = json_encode($playerNames);
                                        $orderItemsDetailPlayerNames->update();
                                    } else {
                                        $playerNames = json_decode($orderItemsDetailPlayerNames->blank_player_names);
                                        for ($i = 0; $i < $playerReport->quantity; $i++) {
                                            array_push($playerNames, $playerReport->player_name);
                                        }
                                        $orderItemsDetailPlayerNames->blank_qty += $playerReport->quantity;
                                        $orderItemsDetailPlayerNames->blank_player_names = json_encode($playerNames);
                                        $orderItemsDetailPlayerNames->update();
                                    }

                                } else {
                                    $playerNames = [];
                                    for ($i = 0; $i < $playerReport->quantity; $i++) {
                                        array_push($playerNames, $playerReport->player_name);
                                    }
                                    $playerNameDetails = new OrderItemsDetailPlayerName();
                                    $playerNameDetails->order_items_detail_id = $itemsDetails->id;
                                    $playerNameDetails->blank_qty += $playerReport->quantity;
                                    $playerNameDetails->blank_player_names = json_encode($playerNames);
                                    $playerNameDetails->save();
                                }
                            }

                        }
                    }

                    if($deactivatedSubProduct != ''){
                        $deactivatedSubProduct = $deactivatedSubProduct->id;
                    }
                return response()->json(['success' => true,'totalAmount' => $totalAmount,'totalQty' => $totalQty, 'deactivatedSubProducts'=> $deactivatedSubProduct]);
            }
        }
    }





    public function getTeamStoreReport($id) {
        $teamStore = TeamStoreOrder::find($id);
        return json_encode($teamStore);
    }

    public function exFileUpValidation(Request $request){
        $vali_message="";
        $vali_message_arr=[];
        $proNames_array=array();
        $file = $request->file('team_store_report');

        ///////////////////////////////////// Excel Sheet Column Checking //////////////////////////////////////////
        $import = new TeamStoreImport(1);
        Excel::import($import, $file);
        $sheets = $import->sheets();

        $productReportSheet = $sheets[0];
        $productReportSheetArray = $productReportSheet->getArray();

        if(count($productReportSheetArray)==0){
            $vali_message="Please check Excel Sheet first page column header name.";
            $vali_message_arr [] = $vali_message;
        }

        $isAvlProCode=0;
        $isAvlProName=0;
        $isAvlProYear=0;
        $isAvlProFab=0;
        $isAvlProEmb=0;
        $isAvlProQty=0;
        $isAvlProSize=0;
        $isAvlFac=0;

        $checkColChange=0;

        foreach ($productReportSheetArray[0] as $headers) {

            if(trim(strtolower($headers))=="product code"){
                $isAvlProCode=1;
                if($checkColChange==0){$checkColChange=1;}
            }else if(trim(strtolower($headers))=="product name"){
                $isAvlProName=1;
                if($checkColChange==1){$checkColChange=2;}
            }else if(trim(strtolower($headers))=="year"){
                $isAvlProYear=1;
                if($checkColChange==2){$checkColChange=3;}
            }else if(trim(strtolower($headers))=="fabric"){
                $isAvlProFab=1;
                if($checkColChange==3){$checkColChange=4;}
            }else if(trim(strtolower($headers))=="embellishment"){
                $isAvlProEmb=1;
                if($checkColChange==4){$checkColChange=5;}
            }else if(trim(strtolower($headers))=="quantity"){
                $isAvlProQty=1;
                if($checkColChange==5){$checkColChange=6;}
            }else if(trim(strtolower($headers))=="size"){
                $isAvlProSize=1;
                if($checkColChange==6){$checkColChange=7;}
            }else if(trim(strtolower($headers))=="factory"){
                $isAvlFac=1;
                if($checkColChange==7){$checkColChange=8;}
            }
        }

        $isAvlTot=$isAvlProCode+$isAvlProName+$isAvlProYear+$isAvlProFab+$isAvlProEmb+$isAvlProQty+$isAvlProSize+$isAvlFac;

        if(count($productReportSheetArray[0])!=$isAvlTot){
            $vali_message="Please check Excel Sheet first page column header names.";
            $vali_message_arr [] =  $vali_message;
        }else if((count($productReportSheetArray[0])==$isAvlTot) && (count($productReportSheetArray[0])!=$checkColChange)){
            $vali_message="Columns order changed in Excel Sheet first page. Please check Excel Sheet before import.";
            $vali_message_arr [] =  $vali_message;
        }


        ///////////////////////////////////////////////////////////////////////////////////////////////////
        $productReportSheet = $sheets[1];
        $productReportSheetArray = $productReportSheet->getArray();

        if(count($productReportSheetArray)==0){
            $vali_message="Please check Excel Sheet second page column count. Column is missing";
            $vali_message_arr [] =  $vali_message;
        }

        $isAvlPlaName=0;
        $isAvlBillName=0;
        $isAvlOrderNo=0;
        $isAvlOrderQty=0;
        $isAvlProduct=0;
        $isAvlPlaNo=0;
        $isAvlPlaQty=0;
        $isAvlPlaSize=0;

        $checkColChange=0;

        foreach ($productReportSheetArray[0] as $headers) {

            if(trim(strtolower($headers))=="player name"){
                $isAvlPlaName=1;
                if($checkColChange==0){$checkColChange=1;}
            }else if(trim(strtolower($headers))=="billing name"){
                $isAvlBillName=1;
                if($checkColChange==1){$checkColChange=2;}
            }else if(trim(strtolower($headers))=="order number"){
                $isAvlOrderNo=1;
                if($checkColChange==2){$checkColChange=3;}
            }else if(trim(strtolower($headers))=="order quantity"){
                $isAvlOrderQty=1;
                if($checkColChange==3){$checkColChange=4;}
            }else if(trim(strtolower($headers))=="product"){
                $isAvlProduct=1;
                if($checkColChange==4){$checkColChange=5;}
            }else if(trim(strtolower($headers))=="player number"){
                $isAvlPlaNo=1;
                if($checkColChange==5){$checkColChange=6;}
            }else if(trim(strtolower($headers))=="quantity"){
                $isAvlPlaQty=1;
                if($checkColChange==6){$checkColChange=7;}
            }else if(trim(strtolower($headers))=="size"){
                $isAvlPlaSize=1;
                if($checkColChange==7){$checkColChange=8;}
            }
        }

        $isAvlTot=$isAvlPlaName+$isAvlBillName+$isAvlOrderNo+$isAvlOrderQty+$isAvlProduct+$isAvlPlaNo+$isAvlPlaQty+$isAvlPlaSize;

        if(count($productReportSheetArray[0])!=$isAvlTot){
            $vali_message="Please check Excel Sheet second page column count. Column is missing";
            $vali_message_arr [] = $vali_message;
        }else if((count($productReportSheetArray[0])==$isAvlTot) && (count($productReportSheetArray[0])!=$checkColChange)){
            $vali_message="Columns order changed in Excel Sheet second page. Please check Excel Sheet before import.";
            $vali_message_arr [] = $vali_message;
        }

        ///////////////////////////////////// Excel Sheet Column Checking End //////////////////////////////////////////

        $import = new TeamStoreImport(2);
        Excel::import($import, $file);
        $sheets = $import->sheets();

        $productReportSheet = $sheets[0];
        $productReportSheetArray = $productReportSheet->getArray();

        foreach ($productReportSheetArray as $sheetData) {
            if ($sheetData['fabric']) {
                $proNames_array[]=(trim($sheetData['product_name']));

                if(trim($sheetData['product_code'])==""){
                    $vali_message="Some product codes are missing in the Excel Sheet first page. Please check the Excel Sheet before import.";
                    $vali_message_arr [] = $vali_message;
                }else if(trim($sheetData['fabric'])==""){
                    $vali_message="Some product fabric names are missing in the Excel Sheet first page. Please check the Excel Sheet before import.";
                    $vali_message_arr [] = $vali_message;
                }else if(trim($sheetData['product_name'])==""){
                    $vali_message="Some product names are missing in the Excel Sheet first page. Please check the Excel Sheet before import.";
                    $vali_message_arr [] = $vali_message;
                }else if(trim($sheetData['embellishment'])==""){
                    $vali_message="Some product embellisments are missing in the Excel Sheet first page. Please check the Excel Sheet before import.";
                    $vali_message_arr [] = $vali_message;
                }else if(trim($sheetData['quantity'])==""){
                    $vali_message="Some product quantities are missing in the Excel Sheet first page. Please check the Excel Sheet before import.";
                    $vali_message_arr [] = $vali_message;
                }else if(trim($sheetData['size'])==""){
                    $vali_message="Some product sizes are missing in the Excel Sheet first page. Please check the Excel Sheet before import.";
                    $vali_message_arr [] = $vali_message;
                }else if(trim($sheetData['factory_code'])==""){
                    $vali_message="Some factory codes are missing in the Excel Sheet first page. Please check the Excel Sheet before import.";
                    $vali_message_arr [] = $vali_message;

                ///////////////////////////////////////////////////////////////////////////////////////////////
                }else{
                    $product_no = Product::where('product_no', trim($sheetData['product_code']))->first();
                    $product_fabric = Fabric::where('fabric_name', 'LIKE', '%'.trim($sheetData['fabric']).'%')->where('active', 1)->first();
                    $product_embel = EmbellishmentType::where('embellishment_name', 'LIKE', '%'.trim($sheetData['embellishment']).'%')->where('active', 1)->first();
                    $product_size = Size::where('size_name', 'LIKE', trim($sheetData['size']))->first();
                    $factory = Factory::where('factory_code', 'LIKE', '%'.trim($sheetData['factory_code']).'%')->first();

                    if($product_no==null){
                        $vali_message= "' ".trim($sheetData['product_code'])." ' this product code not available in database. Please check the Excel Sheet first page before import.";
                        $vali_message_arr [] = $vali_message;
                    }else if($product_fabric==null){
                        $vali_message= "' ".trim($sheetData['fabric'])." ' this fabric name not available in database. Please check the Excel Sheet first page before import.";
                        $vali_message_arr [] = $vali_message;
                    }else if($product_embel==null){
                        $vali_message= "' ".trim($sheetData['embellishment'])." ' this embellishment not available in database. Please check the Excel Sheet first page before import.";
                        $vali_message_arr [] = $vali_message;
                    }else if($product_size==null){
                        $vali_message= "' ".trim($sheetData['size'])." ' this product size not available in database. Please check the Excel Sheet first page before import.";
                        $vali_message_arr [] = $vali_message;
                    }else if($factory==null){
                        $vali_message= "' ".trim($sheetData['factory_code'])." ' this factory name not available in database. Please check the Excel Sheet first page before import.";
                        $vali_message_arr [] = $vali_message;
                    }

                }

            } else {
                if (empty(trim($sheetData['embellishment'])) || strcasecmp(trim($sheetData['embellishment']), 'Total') === 0) {
                    //
                } else {
                    $vali_message = trim($sheetData['product_name'])." does not have a fabric. Please check the Excel Sheet before import.";
                    $vali_message_arr [] = $vali_message;
                }
            }
        }

        // if ($vali_message != '') {
        //     return $vali_message;
        // }

        ///////////////////////////////////////////////////////////////////////////////////////////////////

        $productReportSheet = $sheets[1];
        $productReportSheetArray = $productReportSheet->getArray();
        $proNames_array=array_unique($proNames_array);

        foreach ($productReportSheetArray as $sheetData) {
            if ($sheetData['product_name']) {
                if(trim($sheetData['product_name'])==""){
                    $vali_message="Some product names are missing in the Excel Sheet second page. Please check the Excel Sheet before import.";
                    $vali_message_arr [] = $vali_message;

                }else if(trim($sheetData['quantity'])==""){
                    $vali_message="Some product quantities are missing in the Excel Sheet second page. Please check the Excel Sheet before import.";
                    $vali_message_arr [] = $vali_message;

                }else if(trim($sheetData['size'])==""){
                    $vali_message="Some product sizes are missing in the Excel Sheet second page. Please check the Excel Sheet before import.";
                    $vali_message_arr [] = $vali_message;

                }else{
                    $product_size = Size::where('size_name', 'LIKE', trim($sheetData['size']))->first();

                    if($product_size==null){
                        $vali_message= "' ".trim($sheetData['size'])." ' this product size not available in database. Please check the Excel Sheet second page before import.";
                        $vali_message_arr [] = $vali_message;
                    }

                }

                $isProNameSame = 0;
                foreach($proNames_array as $pro_name){
                    if($pro_name==trim($sheetData['product_name'])){
                        $isProNameSame=1;
                    }
                }

                if($isProNameSame==0){
                    $vali_message= "' ".trim($sheetData['product_name'])." ' this product name in second page is not available in first page. Please check the Excel Sheet second page before import.";
                    $vali_message_arr [] = $vali_message;
                }
            }
        }

        return $vali_message_arr;
    }
    public function missing_products(Request $request) {

        $data = [];
        $item_ids = $request->query('item_ids');
        $click_value = 0;
        if ($item_ids) {
            $decode_ids = json_decode($item_ids);
            if(count($decode_ids) == 1){
                $click_value = 1;
            }
            foreach ($decode_ids as $item_id) {
                $item = OrderItem::find($item_id);
                if ($item) {
                    $sub_products = SubProduct::where('parent_product_id', $item->product_id)->get();
                    $data[] = ['item' => $item, 'sub_products' => $sub_products,'clicked' => $click_value];
                }
            }
        }


        if(isset(json_decode($request->order_id)[0]) && count($decode_ids) == 1){
            $order_id = json_decode($request->order_id)[0];
            $other_items = OrderItem::where('order_id',$order_id)->where('active',0)->where('id', '!=', $decode_ids[0])->pluck('id')->toArray();
            foreach ($other_items as $item_id) {
                $item = OrderItem::find($item_id);
                if ($item) {
                    $sub_products = SubProduct::where('parent_product_id', $item->product_id)->get();
                    $data[] = ['item' => $item, 'sub_products' => $sub_products,'clicked' => 0];
                }
            }
        }

        return view('pages.order_management.team_store.missing_products', ['data' => $data]);
    }
    public function missing_products_update(Request $request) {
        $order_items = $request->order_items;
        foreach ($order_items as $key => $value) {

            $sub_product_no = $value['sub_product_no'];
            $sub_product = SubProduct::where('sub_product_no', $sub_product_no)->first();
            $order_item = OrderItem::find($key);
            $orderNo = $order_item->order_id;
            if($order_item && $sub_product->active == 1){
                $order_item->active = 1;
                $order_item->sub_product_no = $sub_product_no;
                $order_item->fabric_id = $sub_product->fabric_id;
                $order_item->unit_price = $sub_product->default_price;
                $order_item->total = $sub_product->default_price * $order_item->qty;
                $order_item->save();
            }

        }
        $order = Order::find($orderNo);
        $organization = Organization::find($order->organization_id);
        $orderSubTotal = OrderItem::where('order_id', $orderNo)->sum('total');
        if ($organization->sales_tax_active == 1) {
            $salesTax = $organization->sales_tax;
        } else {
            $salesTax = 0;
        }
        $orderSalesTax = ($orderSubTotal / 100) * $salesTax;
        $orderShipping = $order->shipping ?? 0;

        $order->sub_total = $orderSubTotal;
        $order->order_total = $orderSubTotal + $orderSalesTax + $orderShipping;
        $order->sales_tax = $orderSalesTax;
        $order->update();

        return redirect()->route('orders.info', ['id' => $orderNo, 'type' => 'order'])->with('active_tab', 'order')->withSuccess('Order Item Updated Successfully!');
    }

    public function team_storeDeleteOrder(Request $request){
        // dd($request->orderId);
        try {
            // Validate the request
            $request->validate([
                'orderId' => 'required|integer|exists:orders,id', // Ensure the orderId exists in the 'orders' table
            ]);

            $orderId = $request->input('orderId');

            // Retrieve the order by ID
            $order = Order::findOrFail($orderId);

            // Delete any related data (e.g., order items)
            // Adjust this logic based on your relationships
            if ($order->orderItems()->exists()) {
                $order->orderItems()->delete(); // Assuming a one-to-many relationship named 'orderItems'
            }

            // Delete the order
            $order->delete();

            // Return a success response
            return response()->json([
                'success' => true,
                'message' => 'Order and related data have been deleted successfully.',
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error deleting order:', ['error' => $e->getMessage()]);

            // Return an error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the order. Please try again.',
            ], 500);
        }
    }
}
