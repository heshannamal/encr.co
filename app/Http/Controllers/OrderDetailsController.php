<?php

namespace App\Http\Controllers;

require 'vendor/Carbon/autoload.php';

use App\Models\CheckPayment;
use App\Models\OtherPayment;
use Illuminate\Http\Request;
use App\Models\ContactOrganization;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemsDetail;
use App\Models\EmbellishmentType;
use App\Models\ExFactory;
use App\Models\Fabric;
use App\Models\Factory;
use App\Models\Holiday;
use App\Models\Notification;
use App\Models\OrderFolder;
use App\Models\OrderStatus;
use App\Models\Organization;
use App\Models\Product;
use App\Models\SubProduct;
use App\Models\User;
use App\Models\OrderItemFile;
use App\Models\PaymentLog;
use App\Models\ShippedOrders;
use App\Models\ShippingOrderDetails;
use App\Models\ShippingNotificationDraft;
use App\Models\OrderItemsDetailPlayerName;
use App\Models\Sport;
use App\Models\VenmoPayment;
use App\Models\PaypalPayment;
use App\Models\OrderItemAttribute;
use App\Models\OrderItemSubAttribute;
use App\Models\OrderItemAttributeGroup;
use App\Models\ProductFabric;
use App\Models\ProductSport;
use App\Models\ProductCategoryList;
use App\Models\ProductCategory;
use App\Models\ProductEmbellishmentType;
use App\Models\ProductAttribute;
use App\Models\Attribute;
use App\Models\ClouserType;
use App\Models\AdditionPayment;
use App\Models\FactoryInvoice;
use App\Models\InvoiceProduct;
use App\Models\BulkInvoice;
use App\Models\Price;
use App\Models\Contact;
use App\Models\PurchaseorderReceipt;
use App\Models\OrderPaymentUpdateLog;
use App\Exports\OrderItemExport;
use App\Exports\OrganizationsExport;
use App\Models\AccountsLog;
use App\Models\AttributeGroup;
use App\Models\ProjectIcon;
use App\Models\ProjectType;
use App\Models\ProjectStatus;
use App\Models\Project;
use App\Models\PmSection;
use App\Models\PmSectionDiscussion;
use App\Models\PmSectionSubDiscussion;
use App\Services\EmailNotificationBuilderService;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use ZipArchive;
use App\Traits\ProjectHelper;

use domainencore\Facades\OrderDatesFacade\InHandDateFacade;
use domainencore\Facades\OrderDatesFacade\ExFactoryDateFacade;
use domainencore\Facades\OrderDatesFacade\ItemExFactoryDateFacade;
use domainencore\Facades\ShippingFacade\ShippingFacade;
use domainencore\Facades\PatternCodeFacade\PatternCodeFacade;
use domainencore\Facades\ProjectFacade\ProjectFacade;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mail;

use App\ShipTrait\ShippingHelper;
use App\Traits\OrderCommenHelper;

use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use domainencore\Facades\OrdersCommenFacade\OrdersCommenFacade;
use App\Services\NotificationBuilderService;
use App\Services\SimplePdfBuilder;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class OrderDetailsController extends Controller
{
    use ShippingHelper;
    use OrderCommenHelper;
    use ProjectHelper;

    // private $smptEncryption = 'TLS';
    // private $smptPort = '587';
    // private $smptHost = 'smtp-mail.outlook.com';
    // private $mailUsername = 'info@encorebrand.com';
    // private $mailPassword = 'EncoreCus!0077';

    private $smptEncryption = 'SSL';
    private $smptPort = '465';
    private $smptHost = 'mail.encr.co';
    private $mailUsername = 'info@encr.co';
    private $mailPassword = 'Encr.co@ec123';

    protected $inventoryOrgIds;

    public function __construct()
    {
        $this->inventoryOrgIds = OrdersCommenFacade::getEncoreOrgIds()->toArray();
    }

    public function index(){
        $newOrders = Order::select('id', 'order_no')->where('order_status_id', 1)->where('active', 1)->get();

        $orders = Order::with('organizationDetails', 'userDetails', 'statusDetails')->where('order_status_id', 2)->where('active', 1)->get();

        return view('pages.order_management.order_quotation.index', ['orders'=>$orders,'newOrders'=>$newOrders]);
    }

    public function edit($orderId, $type){
        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;
        $userRoleId = $this->userRoleId;
        $userId = Auth::user()->id;

        $emptyInvoice = $orderId;

        $orderDetailsQuery = Order::with('organizationDetails', 'contactDetails', 'studioOrderItems');

        $ordersQuery = Order::with('organizationDetails', 'userDetails', 'statusDetails', 'contactDetails', 'contactOrganizations.contacts', 'studioOrderItems');

            if($oderSearch == 'factory'){
                $orderDetailsQuery->with(['orderItems'=>function($qry) use($factoryIds){
                    $qry->with('orderItemDetails', 'orderItemDetails.playerDetails', 'productDetails', 'embellishmentDetails',
                    'orderItemDetails.sizeDetails', 'factoryDetails', 'exFactoryDetails', 'orderItemFiles', 'productAttributes.attributes',
                    'orderItemAttributes.attribute', 'productFabrics.fabrics', 'productEmbellishmentTypes.embellishmentTypes')
                        ->whereIn('factory_id', $factoryIds);
                }]);
                $ordersQuery->with(['orderItems'=>function($qry) use($factoryIds){
                    $qry->with('productDetails', 'statusDetails', 'notifiedUser', 'orderItemAttributes.attribute')
                        ->whereIn('factory_id', $factoryIds);
                }]);
            } else {
                $orderDetailsQuery->with('orderItems', 'orderItems.orderItemDetails', 'orderItems.orderItemDetails.playerDetails', 'orderItems.productDetails', 'orderItems.embellishmentDetails',
                'orderItems.orderItemDetails.sizeDetails', 'orderItems.factoryDetails', 'orderItems.exFactoryDetails', 'orderItems.orderItemFiles', 'orderItems.productAttributes.attributes',
                'orderItems.orderItemAttributes.attribute', 'orderItems.productFabrics.fabrics', 'orderItems.productEmbellishmentTypes.embellishmentTypes');
                $ordersQuery->with('orderItems', 'orderItems.productDetails', 'orderItems.statusDetails', 'orderItems.notifiedUser','orderItems.orderItemAttributes.attribute');
            }

        $orderDetails = $orderDetailsQuery->where('orders.id', $orderId)->get();
        $orders = $ordersQuery->where('id', $orderId)->get();

        $order_item_id_array = OrderItem::where('order_id', $orderId)->where('active', 1)->pluck('id')->toArray();

        $test_print_due_date_arr = [];

        foreach ($order_item_id_array as $order_item_id) {
            $item = OrderItem::where('id', $order_item_id)->first();
            if (!empty($item->test_print_due_date)) {
                $test_print_due_date_arr[] = Carbon::createFromFormat('m/d/Y', $item->test_print_due_date);
            }
        }

        if (count($test_print_due_date_arr) > 0) {
            usort($test_print_due_date_arr, function($a, $b) {
                return $b <=> $a;
            });
            $most_recent_date = $test_print_due_date_arr[0];
            $Order_test_print_due_date = $most_recent_date->format('m/d/Y');
        } else {
            $Order_test_print_due_date = 'No available';
        }

        $orderFolderExist = '';
        $orderItemQtyExist = '';
        $orderInhandExist = '';
        $orderExfactoryExist = '';
        $orderEmbellishmentExist = '';
        $orderItemActive = '';


        foreach ($order_item_id_array as $order_item_id) {
            $orderItemUnque = OrderItem::find($order_item_id);
            $orderItemProduct = SubProduct::where('sub_product_no', $orderItemUnque->sub_product_no)->first();
            if (!OrderItemFile::where('order_item_id', $order_item_id)->where(function($query) {$query->whereNotNull('tech_pack_images')->orWhereNotNull('tech_pack_files');})->exists()) {
                $orderFolderExist .= '<ul style="margin-bottom: 0;"><a class="class-for-status-validation" style="color: #ff0000;font-size: .8rem;font-weight: 400;font-style: inherit;cursor: pointer; target="blank" onclick="EyeIconClick('.$order_item_id.')">' . $orderItemProduct->product_name. ',</a> </ul>';
            }

            if ($orderItemUnque->qty == 0) {
                $orderItemQtyExist .= '<ul style="margin-bottom: 0;"><a class="class-for-status-validation" style="color: #ff0000;font-size: .8rem;font-weight: 400;font-style: inherit;cursor: pointer; target="blank" onclick="EyeIconClick('.$order_item_id.')">' . $orderItemProduct->product_name. ',</a> </ul>';
            }

            if (empty($orderItemUnque->in_hand_due_date)) {
                $orderInhandExist .= '<ul style="margin-bottom: 0;"><a class="class-for-status-validation" style="color: #ff0000;font-size: .8rem;font-weight: 400;font-style: inherit;cursor: pointer; target="blank" onclick="EyeIconClick('.$order_item_id.')">' . $orderItemProduct->product_name. ',</a> </ul>';
            }

            if (empty($orderItemUnque->ex_factory_date)) {
                $orderExfactoryExist .= '<ul style="margin-bottom: 0;"><a class="class-for-status-validation" style="color: #ff0000;font-size: .8rem;font-weight: 400;font-style: inherit;cursor: pointer; target="blank" onclick="EyeIconClick('.$order_item_id.')">' . $orderItemProduct->product_name. ',</a> </ul>';
            }
            if (empty($orderItemUnque->embellishment_type_id)) {
                $product_type_of_embellishment = '';
                if(empty($orderItemProduct->type_of_embellishment)){
                    $product_type_of_embellishment .= '(this product does not have embellishment. Please contact Admin!)';
                }
                $orderEmbellishmentExist .= '<ul style="margin-bottom: 0;"><a class="class-for-status-validation" style="color: #ff0000;font-size: .8rem;font-weight: 400;font-style: inherit;cursor: pointer; target="blank" onclick="EyeIconClick('.$order_item_id.')">' . $orderItemProduct->product_name .' '.$product_type_of_embellishment. ',</a> </ul>';
            }
            if ($orderItemUnque->active == 0) {
                $orderItemActive .= '<ul style="margin-bottom: 0;"><a class="class-for-status-validation" style="color: #ff0000;font-size: .8rem;font-weight: 400;font-style: inherit;cursor: pointer; target="blank" onclick="EyeIconClick('.$order_item_id.')">' . $orderItemProduct->product_name. ',</a> </ul>';
            }
        }

        $organizationQuery = Organization::select('id', 'organization_name','pl_status');
            if($this->isInventoryOrder($orders[0]->organization_id)){
                $organizationQuery->whereIn('id', $this->inventoryOrgIds);
            } else {
                $organizationQuery->whereNotIn('id', $this->inventoryOrgIds);
            }
        $organizations = $organizationQuery->where('active', 1)->orderBy('organization_name')->get();

        $orderStatuses = OrderStatus::select('id', 'status_name')->where('active', 1)->orderBy('id')->get();

        $users = User::select('id', 'name', 'profile_pic', 'user_role_id')->orderBy('name')->get();
        $Sales_rep_users = User::select('id', 'name', 'profile_pic', 'user_role_id')->whereJsonContains('role_id', "3")->orderBy('name')->where('active',1)->get();

        $activeUsers = User::select('id', 'name', 'profile_pic', 'user_role_id')->orderBy('name')->where('active','1')->get();

        $activeUserGroups = Role::whereNotIn('id', [1])->where('active','1')->orderBy('name')->get();

        foreach($activeUsers as $user){
            $userList = array('id'=>$user->id, 'name'=>$user->name, 'profile_pic'=>$user->profile_pic);
            $userInfo[] = $userList;
        }

        $products = Product::where('active', [1, 0])->orderBy('product_name')->get();
        $subProducts = SubProduct::orderBy('product_name')->where('active' , 1)->get();

        $product_sports = ProductSport::where('deleted_at', NULL)->orderBy('product_id')->get();
        $product_category = ProductCategoryList::where('deleted_at', NULL)->orderBy('product_id')->get();
        $categories = ProductCategory::where('active', 1)->orderBy('id')->get();

        $factories = Factory::where('active', 1)->orderBy('factory_name')->get();

        $fabrics = Fabric::where('active', 1)->orderBy('fabric_name')->get();

        $attributes = Attribute::where('active', 1)->orderBy('id')->get();

        $clouser_types = ClouserType::where('active', 1)->orderBy('clouser_name')->get();

        $embellishmentTypes = EmbellishmentType::where('active', 1)->orderBy('embellishment_name')->get();

        $exFactories = ExFactory::where('active', 1)->orderBy('ex_factory_name')->get();

        $Notifications = Notification::where('is_payment', 0)
            ->where('order_id', $orderId)
            ->where('is_comment', 0)
            ->where('is_order_edit', 0)
            ->where('active', 1)
            ->where('notification_message', 'like', '%has been moved to production%')
            ->where('order_reject_or_confirm', null)
            ->first();
        $checkstatus = Order::where('id',$orderId)->first();
        if ($Notifications && $Notifications->order_reject_or_confirm == null && $checkstatus->factory_confirmation_date == 'Waiting for factory Confirmation') {
            $Notifications = $Notifications;
        } else {
            $Notifications = null;
        }

        $cardPays = PaymentLog::where('order_id', $orderId)->get();

        $exfactoryLogs = ExFactoryDateFacade::get($orderId);
        $inHandDueDateLogs = InHandDateFacade::get($orderId);

        $cardPayment = PaymentLog::where('order_id', $orderId)->sum('amount');
        $checkPayment = CheckPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
        $otherPayment = OtherPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
        $paypalPayement = PaypalPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
        $venmoPayment = VenmoPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');

        $payment = 0;
//
        if($cardPayment > 0 && $paypalPayement > 0){
            $payment = round(((($cardPayment + $paypalPayement) * 100)/103),2) + $checkPayment + $venmoPayment + $otherPayment;

        } else if ($cardPayment > 0 && $paypalPayement == 0) {
            $payment = round(($cardPayment * 100)/103,2) + $checkPayment + $venmoPayment + $otherPayment;

        } else if ($cardPayment == 0 && $paypalPayement > 0) {
            $payment = $checkPayment + round((($paypalPayement * 100)/103),2) + $venmoPayment + $otherPayment;

        } else {
            $payment = round(($cardPayment + $checkPayment + $paypalPayement + $venmoPayment + $otherPayment),2);
        }

        $balnceToBePaid = 0;
        $processingFee = 0;
        $orderTotal = $orders->sum('order_total');
        $totalPayment = round($cardPayment, 2) + round($paypalPayement, 2);

        if ($payment == 0 && $orderTotal > 0) {
            $paymentStatus = 0; // Pending

        } else if ($payment < round($orderDetails[0]->order_total, 2) && $payment > 0) {
            $paymentStatus = 1; // Partial
            $balnceToBePaid = $orderDetails[0]->order_total - $payment;
            $processingFee = round(($cardPayment + $paypalPayement)*3/103 , 2);

        } else {
            $paymentStatus = 2; // Paid
            if($totalPayment > 0 && $totalPayment > $orderTotal){
                // $processingFee = $totalPayment - $orderTotal;
                $processingFee = round(($cardPayment + $paypalPayement)*3/103 , 2);

            }
        }
        if($orderTotal == 0){
            $balnceToBePaid = 0;
            $paymentStatus = 2;
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
        //return array_search('37', $arrayPlayerNamesPattern);
        //$arrayData = array($mainArrayString);
        //$checkdata = "num2";
        //return $arrayPlayerNames[0]->$checkdata;

        //return $arrayPlayerNamesPattern;

        $sports = Sport::where('active', 1)->orderBy('sport_name')->get();

        // Google Drive Folder Creation
        // $directories = Storage::disk('google')->directories();

        // $orderYear = Carbon::parse($orderDetails[0]->created_at)->format('Y');

        // $yearPath = '';
        // foreach($directories as $directory){
        //     $folder = Storage::disk('google')->getMetadata($directory);

        //     if ($folder['name'] == $orderYear) {
        //         $yearPath = $folder['path'];
        //     }
        // }

        // $orderDirectories = Storage::disk('google')->directories($yearPath);

        // if ($orderDirectories) {
        //     $folders = [];
        //     foreach($orderDirectories as $orderDirectory){
        //         $folder = Storage::disk('google')->getMetadata($orderDirectory);

        //         array_push($folders, $folder['name']);
        //     }

        //     if (!in_array('Order '.$orderId, $folders)) {
        //         self::createDriveOrder($yearPath, $orderId);
        //     }

        // } else {
        //     self::createDriveOrder($yearPath, $orderId);
        // }

        $shippingNotifyDraft = ShippingNotificationDraft::where('order_id', $orderId)->where('user_id', Auth::user()->id)->where('status', 1)->first();

        $organizationIMG = Organization::get(['sport', 'id']);

        $sportIMG = Sport::where('active', 1)->get();

        // $seqArr = [
        //     'numseq_one','numseq_two','numseq_three','numseq_four','numseq_five','numseq_six','numseq_seven','numseq_eight','numseq_nine','numseq_ten',
        //     'numseq_eleven','numseq_twelve','numseq_thirteen','numseq_fourteen','numseq_fifteen','numseq_sixteen','numseq_seventeen','numseq_eighteen','numseq_nineteen','numseq_twenty',
        //     'numseq_twenty_one','numseq_twenty_two','numseq_twenty_three','numseq_twenty_four','numseq_twenty_five','numseq_twenty_six','numseq_twenty_seven','numseq_twenty_eight','numseq_twenty_nine','numseq_thirty',
        //     'numseq_thirty_one','numseq_thirty_two','numseq_thirty_three','numseq_thirty_four','numseq_thirty_five','numseq_thirty_six','numseq_thirty_seven','numseq_thirty_eight','numseq_thirty_nine','numseq_forty',
        //     'numseq_forty_one','numseq_forty_two','numseq_forty_three','numseq_forty_four','numseq_forty_five','numseq_forty_six','numseq_forty_seven','numseq_forty_eight','numseq_forty_nine','numseq_fifty',
        //     'numseq_fifty_one','numseq_fifty_two','numseq_fifty_three','numseq_fifty_four','numseq_fifty_five','numseq_fifty_six','numseq_fifty_seven','numseq_fifty_eight','numseq_fifty_nine','numseq_sixty',
        //     'numseq_sixty_one','numseq_sixty_two','numseq_sixty_three','numseq_sixty_four','numseq_sixty_five','numseq_sixty_six','numseq_sixty_seven','numseq_sixty_eight','numseq_sixty_nine','numseq_seventy',
        //     'numseq_seventy_one','numseq_seventy_two','numseq_seventy_three','numseq_seventy_four','numseq_seventy_five','numseq_seventy_six','numseq_seventy_seven','numseq_seventy_eight','numseq_seventy_nine','numseq_eighty',
        //     'numseq_eighty_one','numseq_eighty_two','numseq_eighty_three','numseq_eighty_four','numseq_eighty_five','numseq_eighty_six','numseq_eighty_seven','numseq_eighty_eight','numseq_eighty_nine','numseq_ninety',
        //     'numseq_ninety_one','numseq_ninety_two','numseq_ninety_three','numseq_ninety_four','numseq_ninety_five','numseq_ninety_six','numseq_ninety_seven','numseq_ninety_eight','numseq_ninety_nine','numseq_hundred',
        // ];
        // foreach ($orders as $order){
        //     foreach ($order->orderItems as $orderItem){
        //         foreach ($orderItem->orderItemDetails as $orderItemDetail){
        //             foreach ($seqArr as $seq){
        //                 // dd($seq);
        //                 if(isset($orderItemDetail[$seq]) && $orderItemDetail[$seq] != ''){
        //                     dump($orderItemDetail->id);
        //                     dump($orderItemDetail[$seq]);
        //                 }
        //             }
        //             dd($orderItemDetail[$seqArr[1]]);
        //         }
        //     }
        // }
        // foreach ($seqArr as $seq){
        //     dd($seq);
        // }

        // dd(count($orderDetails[0]->orderItems));

        $shipTrait = $this;
        $orderTrait = $this;
        // foreach(json_decode('["Sandaruwan","Enosh","Amith",null,null,null,null,null,null,null]') as $key=>$exec)
        // {
        //     dump($key);
        //     dump($exec);
        //     if($exec != null){
        //         dump('not null');
        //     } else {
        //         dump('null');
        //     }
        // }
        // dd( json_decode('["Sandaruwan","Enosh","Amith",null,null,null,null,null,null,null]'));

        $bulk_invoice = BulkInvoice::whereRaw('FIND_IN_SET(?, order_ids)', [$orderId])
                           ->where('active', 1)
                           ->first();
        if($bulk_invoice && $bulk_invoice->payment_status == 0 && $paymentStatus == 2){
            $bulk_invoice->payment_status = 2;
            $bulk_invoice->save();
        }

        if($type == 'order'){
            return view('pages.order_management.order_quotation.edit', [
                        'fabrics'=>$fabrics,'orders'=>$orders, 'organizations'=>$organizations, 'orderDetails'=>$orderDetails, 'orderStatuses'=>$orderStatuses,
                        'users'=>$users,'Sales_rep_users'=>$Sales_rep_users, 'emptyInvoice'=>$emptyInvoice, 'products'=>$products, 'fabrics'=>$fabrics, 'embellishmentTypes'=>$embellishmentTypes,
                        'factories'=>$factories, 'exFactories'=>$exFactories, 'userInfo'=>$userInfo, 'paymentStatus'=>$paymentStatus, 'ShippedOrdersDetails'=>$shippedArray,
                        'balnceToBePaid'=>$balnceToBePaid, 'activeUsers'=>$activeUsers, 'activeUserGroups'=>$activeUserGroups, 'arrayPlayerNames'=>$arrayPlayerNames,
                        'arrayPlayerNamesPattern'=>$arrayPlayerNamesPattern, 'sports'=>$sports, 'shippingNotifyDraft'=>$shippingNotifyDraft, 'payment'=>$payment,
                        'oderSearch'=>$oderSearch, 'factoryIds'=>$factoryIds, 'userRoleId'=>$userRoleId, 'userId'=>$userId, 'exfactoryLogs'=>$exfactoryLogs, 'inHandDueDateLogs'=>$inHandDueDateLogs,
                        'organizationIMG'=>$organizationIMG, 'sportIMG'=>$sportIMG, 'shipTrait'=>$shipTrait, 'orderTrait'=>$orderTrait, 'orderId'=>$orderId, 'processingFee'=>$processingFee, 'subProducts'=>$subProducts ,
                        'product_sports'=>$product_sports , 'product_category'=>$product_category , 'categories' => $categories , 'clouser_types'=>$clouser_types , 'Notifications'=>$Notifications , 'attributes'=>$attributes,
                        'orderFolderExist'=>$orderFolderExist, 'orderItemQtyExist'=>$orderItemQtyExist, 'orderInhandExist'=>$orderInhandExist, 'orderExfactoryExist'=>$orderExfactoryExist, 'orderEmbellishmentExist'=>$orderEmbellishmentExist, 'Order_test_print_due_date'=>$Order_test_print_due_date, 'orderItemActive'=>$orderItemActive
            ]);
        } elseif($type == 'shipping'){
            $shippingTblStatus = ShippingFacade::shippingOrderDetailTableStatus($orderId,$orderDetails); //return values -> yes = already saved / no = no data in table
            return view('pages.order_management.order_quotation.edit_shipping', [
                        'fabrics'=>$fabrics,'orders'=>$orders, 'organizations'=>$organizations, 'orderDetails'=>$orderDetails, 'orderStatuses'=>$orderStatuses,
                        'users'=>$users,'Sales_rep_users'=>$Sales_rep_users, 'emptyInvoice'=>$emptyInvoice, 'products'=>$products, 'fabrics'=>$fabrics, 'embellishmentTypes'=>$embellishmentTypes,
                        'factories'=>$factories, 'exFactories'=>$exFactories, 'userInfo'=>$userInfo, 'paymentStatus'=>$paymentStatus, 'ShippedOrdersDetails'=>$shippedArray,
                        'balnceToBePaid'=>$balnceToBePaid, 'activeUsers'=>$activeUsers, 'activeUserGroups'=>$activeUserGroups, 'arrayPlayerNames'=>$arrayPlayerNames,
                        'arrayPlayerNamesPattern'=>$arrayPlayerNamesPattern, 'sports'=>$sports, 'shippingNotifyDraft'=>$shippingNotifyDraft,
                        'oderSearch'=>$oderSearch, 'factoryIds'=>$factoryIds, 'userRoleId'=>$userRoleId, 'userId'=>$userId, 'exfactoryLogs'=>$exfactoryLogs, 'inHandDueDateLogs'=>$inHandDueDateLogs,
                        'organizationIMG'=>$organizationIMG, 'sportIMG'=>$sportIMG, 'shipTrait'=>$shipTrait, 'orderTrait'=>$orderTrait, 'orderId'=>$orderId, 'processingFee'=>$processingFee, 'shippingTblStatus'=>$shippingTblStatus, 'subProducts'=>$subProducts,
                        'product_sports'=>$product_sports , 'product_category'=>$product_category , 'categories' => $categories , 'clouser_types'=>$clouser_types , 'Notifications'=>$Notifications , 'attributes'=>$attributes
            ]);
        } elseif($type == 'management'){

        $defaultProjectId = 19;

        $this->generateOrderProjectSections($orderId);

        $project = Project::findOrFail($defaultProjectId);
        $projectAssignees = ProjectFacade::getAssignees($defaultProjectId);
        $activeUsers = User::select('id', 'name', 'profile_pic', 'user_role_id')->orderBy('name')->where('active','1')->get();
        $projectStatus = ProjectStatus::select('id', 'status_name')->orderBy('id')->get();
        foreach ($activeUsers as $user) {
            $userInfo[] = [
                'id' => $user->id,
                'name' => $user->name,
                'profile_pic' => $user->profile_pic
            ];
        }

        $projectAssigneeInfo = [];
        foreach($projectAssignees[0] as $projectAssignee){
            $projectAssigneeInfo[] = array('id'=>$projectAssignee['id'], 'name'=>$projectAssignee['name'], 'profile_pic'=>$projectAssignee['image']);
        }

            return view('pages.order_management.order_quotation.edit_order_management', [
                        'fabrics'=>$fabrics,'orders'=>$orders, 'organizations'=>$organizations, 'orderDetails'=>$orderDetails, 'orderStatuses'=>$orderStatuses,
                        'users'=>$users,'Sales_rep_users'=>$Sales_rep_users, 'emptyInvoice'=>$emptyInvoice, 'products'=>$products, 'fabrics'=>$fabrics, 'embellishmentTypes'=>$embellishmentTypes,
                        'factories'=>$factories, 'exFactories'=>$exFactories, 'userInfo'=>$userInfo, 'paymentStatus'=>$paymentStatus, 'ShippedOrdersDetails'=>$shippedArray,
                        'balnceToBePaid'=>$balnceToBePaid, 'activeUsers'=>$activeUsers, 'activeUserGroups'=>$activeUserGroups, 'arrayPlayerNames'=>$arrayPlayerNames,
                        'arrayPlayerNamesPattern'=>$arrayPlayerNamesPattern, 'sports'=>$sports, 'shippingNotifyDraft'=>$shippingNotifyDraft,
                        'oderSearch'=>$oderSearch, 'factoryIds'=>$factoryIds, 'userRoleId'=>$userRoleId, 'userId'=>$userId, 'exfactoryLogs'=>$exfactoryLogs, 'inHandDueDateLogs'=>$inHandDueDateLogs,
                        'organizationIMG'=>$organizationIMG, 'sportIMG'=>$sportIMG, 'shipTrait'=>$shipTrait, 'orderTrait'=>$orderTrait, 'orderId'=>$orderId, 'processingFee'=>$processingFee, 'subProducts'=>$subProducts ,
                        'product_sports'=>$product_sports , 'product_category'=>$product_category , 'categories' => $categories , 'clouser_types'=>$clouser_types , 'Notifications'=>$Notifications , 'attributes'=>$attributes,
                        'projectAssignees'=>$projectAssignees, 'projectAssigneeInfo'=>$projectAssigneeInfo, 'project'=>$project
            ]);
        }

    }

    public function generateOrderProjectSections($id)
    {
        $defaultProjectId = 19;

        $projectSections = PmSection::where('project_id', $defaultProjectId)
            ->where('order_id', $id)
            ->get();

        $order = Order::with('organizationDetails', 'userDetails')->find($id);

        if (!$order) {
            return false;
        }
        if($order->order_status_id == 1 || $order->order_status_id == 7){
            return false;
        }

        $sectionCount = PmSection::where('project_id', $defaultProjectId)->count();

        $dueDate = null;

        try {
            if (!empty($order->ex_factory_date)) {
                $dueDate = Carbon::createFromFormat('m/d/Y', $order->ex_factory_date)
                    ->format('Y-m-d');
            }
        } catch (\Exception $e) {
            $dueDate = null;
        }

        if ($projectSections->isEmpty()) {

            $newDiscussion = new PmSection();
            $newDiscussion->project_id = $defaultProjectId;
            $newDiscussion->section_name = '#' . $order->order_no . ' - ' . ($order->organizationDetails->organization_name ?? '');
            $newDiscussion->sort_index = $sectionCount + 1;
            $newDiscussion->order_id = $id;
            $newDiscussion->user_id = $order->userDetails->id ?? null;
            $newDiscussion->save();

            $discussionList = [
                'Shipping Details' => [
                    'assignee_id' => 75,
                    'sub_task' => 'For Packing Team'
                ],
                'Discussion' => [
                    'assignee_id' => 98,
                    'sub_task' => 'Additional Notes'
                ],
                'Production Layouts' => [
                    'assignee_id' => 98,
                    'sub_task' => 'Customer Approval'
                ],
                'Estimated Shipping Date' => [
                    'assignee_id' => 98,
                    'sub_task' => 'Factory Confirmation'
                ]
            ];

            $sortIndex = 1;

            foreach ($discussionList as $key => $discussion) {

                $newSubDiscussion = new PmSectionDiscussion();
                $newSubDiscussion->section_id = $newDiscussion->id;
                $newSubDiscussion->project_id = $defaultProjectId;
                $newSubDiscussion->assignee_id = 62;
                $newSubDiscussion->assigned_by = $order->userDetails->id ?? null;
                $newSubDiscussion->discussion_name = $key;
                $newSubDiscussion->due_date = $dueDate;
                $newSubDiscussion->user_id = $order->userDetails->id ?? null;
                $newSubDiscussion->sort_index = $sortIndex;
                $newSubDiscussion->save();

                $PmSectionSubDiscussion = new PmSectionSubDiscussion();
                $PmSectionSubDiscussion->section_id = $newDiscussion->id;
                $PmSectionSubDiscussion->project_id = $defaultProjectId;
                $PmSectionSubDiscussion->assignee_id = $discussion['assignee_id'];
                $PmSectionSubDiscussion->assigned_by = $order->userDetails->id ?? null;
                $PmSectionSubDiscussion->discussion_id = $newSubDiscussion->id;
                $PmSectionSubDiscussion->discussion_name = $discussion['sub_task'];
                $PmSectionSubDiscussion->due_date = $dueDate;
                $PmSectionSubDiscussion->user_id = $order->userDetails->id ?? null;
                $PmSectionSubDiscussion->sort_index = 1;
                $PmSectionSubDiscussion->save();

                $sortIndex++;
            }
        }

        return true;
    }

    public function orderItemview($orderId, $orderitemId){
        $this->userGroupFactories();
        $orderDetailsQuery = Order::with('organizationDetails', 'contactDetails');

        $ordersQuery = Order::with('organizationDetails', 'userDetails', 'statusDetails', 'contactDetails', 'contactOrganizations.contacts');
        $orderDetailsQuery = Order::with([
            // Basic order relationships
            'organizationDetails.contactOrganizations.contacts',
            'contactDetails',
            'userDetails',
            'statusDetails',
            'contactOrganizations.contacts',

            // Order items with condition for specific orderItemId
            'orderItems' => function($query) use ($orderitemId) {
                $query->where('id', $orderitemId);
            },

            // Nested relationships for the filtered order item
            'orderItems.orderItemDetails.playerDetails',
            'orderItems.orderItemDetails.sizeDetails',
            'orderItems.productDetails.productFactories.factory',
            'orderItems.embellishmentDetails',
            'orderItems.factoryDetails',
            'orderItems.exFactoryDetails',
            'orderItems.orderItemFiles',
            'orderItems.productAttributes.attributes',
            'orderItems.orderItemAttributes.attribute',
            'orderItems.productFabrics.fabrics',
            'orderItems.subProduct.embellishmentTypes',
            'orderItems.productEmbellishmentTypes.embellishmentTypes',
            'orderItems.statusDetails',
            'orderItems.notifiedUser'
        ]);

        $orders = $orderDetailsQuery->where('orders.id', $orderId)->first();
        // $orders = $ordersQuery->where('id', $orderId)->first();

        $order_item_id_array = OrderItem::where('order_id', $orderId)->where('active', 1)->pluck('id')->toArray();

        $test_print_due_date_arr = [];

        foreach ($order_item_id_array as $order_item_id) {
            $item = OrderItem::where('id', $order_item_id)->first();
            if (!empty($item->test_print_due_date)) {
                $test_print_due_date_arr[] = Carbon::createFromFormat('m/d/Y', $item->test_print_due_date);
            }
        }

        if (count($test_print_due_date_arr) > 0) {
            usort($test_print_due_date_arr, function($a, $b) {
                return $b <=> $a;
            });
            $most_recent_date = $test_print_due_date_arr[0];
            $Order_test_print_due_date = $most_recent_date->format('m/d/Y');
        } else {
            $Order_test_print_due_date = 'No available';
        }

        $organizationQuery = Organization::select('id', 'organization_name');
            if($this->isInventoryOrder($orders->organization_id)){
                $organizationQuery->whereIn('id', $this->inventoryOrgIds);
            } else {
                $organizationQuery->whereNotIn('id', $this->inventoryOrgIds);
            }

        $orderStatuses = OrderStatus::select('id', 'status_name')->where('active', 1)->orderBy('id')->get();

        $activeUserGroups = Role::whereNotIn('id', [1])->where('active','1')->orderBy('name')->get();

        $subProducts = SubProduct::orderBy('product_name')->where('active' , 1)->get();

        $factories = Factory::where('active', 1)->orderBy('factory_name')->get();

        $fabrics = Fabric::where('active', 1)->orderBy('fabric_name')->get();

        $attributes = Attribute::where('active', 1)->where('is_sub_attribute', 0)->orderBy('id')->get();

        $attributeGroups = AttributeGroup::with('groupAttributes')->where('active', 1)->orderBy('id')->get();

        $subAttributes = Attribute::where('active', 1)->where('is_sub_attribute', 1)->orderBy('id')->get();

        $clouser_types = ClouserType::where('active', 1)->orderBy('clouser_name')->get();

        $embellishmentTypes = EmbellishmentType::where('active', 1)->orderBy('embellishment_name')->get();

        // $exFactories = ExFactory::where('order_item_id',$orderitemId)->where('active', 1)->orderBy('ex_factory_name')->get();
        // Initialize the results array
        $results = [];

        // Fetch all contacts from the order's organizationDetails
        if ($orders && $orders->organizationDetails) {
            foreach ($orders->organizationDetails->contactOrganizations as $contactOrganization) {
                foreach ($contactOrganization->contacts as $contact) {
                    $results[] = [
                        'id' => 'con_' . $contact->id,  // Prefix 'con_' for contacts
                        'name' => $contact->first_name . ' ' . $contact->last_name,
                        'type' => 'contact',  // Adding 'type' to specify it's a contact
                        'table_id' => $contact->id,  // Adding 'table_id' for contact
                    ];
                }
            }
        }
        // Fetch all active ex-factories based on the order item
        $exFactories = ExFactory::where('order_item_id', $orderitemId)
            ->where('active', 1)
            ->orderBy('ex_factory_name')
            ->get(['id', 'contact_id', 'ex_factory_name']);

        // Merge exFactories while excluding duplicates based on contact_id
        foreach ($exFactories as $exFactory) {
            // Check if the contact_id already exists in the results
            $contactKey = $exFactory->contact_id ? $exFactory->contact_id : null;
            $isDuplicate = $contactKey && in_array($contactKey, array_column($results, 'table_id'));

            // If a duplicate contact exists, remove the contact entry before adding the exFactory
            if ($isDuplicate) {
                // Remove the contact entry from results by filtering out the contact with the same contact_id
                $results = array_filter($results, function($result) use ($contactKey) {
                    return !($result['type'] == 'contact' && $result['table_id'] == $contactKey);
                });
            }

            // Only add exFactory if contact_id is not present in the results
            $results[] = [
                'id' => 'ex_' . $exFactory->id,  // Prefix 'ex_' for exFactories
                'name' => $exFactory->ex_factory_name,
                'type' => 'exFactory',  // Adding 'type' to specify it's an exFactory
                'table_id' => $exFactory->id,  // Adding 'table_id' for exFactory
            ];
        }
        $exFactories = ExFactory::where('order_item_id', $orderitemId)
            ->where('active', 1)
            ->orderBy('ex_factory_name')
            ->get();
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
        $cardPayment = PaymentLog::where('order_id', $orderId)->sum('amount');
        $checkPayment = CheckPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
        $otherPayment = OtherPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
        $paypalPayement = PaypalPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
        $venmoPayment = VenmoPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');

        $payment = 0;

        if($cardPayment > 0 && $paypalPayement > 0){
            $payment = round(((($cardPayment + $paypalPayement) * 100)/103),2) + $checkPayment + $venmoPayment + $otherPayment;

        } else if ($cardPayment > 0 && $paypalPayement == 0) {
            $payment = round(($cardPayment * 100)/103,2) + $checkPayment + $venmoPayment + $otherPayment;

        } else if ($cardPayment == 0 && $paypalPayement > 0) {
            $payment = $checkPayment + round((($paypalPayement * 100)/103),2) + $venmoPayment + $otherPayment;

        } else {
            $payment = round(($cardPayment + $checkPayment + $paypalPayement + $venmoPayment + $otherPayment),2);
        }

        $balnceToBePaid = 0;
        $processingFee = 0;
        $orderTotal = $orders->sum('order_total');
        $totalPayment = round($cardPayment, 2) + round($paypalPayement, 2);

        if ($payment == 0 && $orderTotal > 0) {
            $paymentStatus = 0; // Pending


        } else if ($payment < round($orders->order_total, 2) && $payment > 0) {
            $paymentStatus = 1; // Partial
            $balnceToBePaid = $orders->order_total - $payment;
            $processingFee = round(($cardPayment + $venmoPayment)*3/103 , 2);

        } else {
            $paymentStatus = 2; // Paid
            if($totalPayment > 0 && $totalPayment > $orderTotal){
                // $processingFee = $totalPayment - $orderTotal;
                $processingFee = round(($cardPayment + $venmoPayment)*3/103 , 2);

            }
        }
        if($orderTotal == 0){
            $balnceToBePaid = 0;
            $paymentStatus = 2;
        }
        $orderTrait = $this;
        $bulk_invoice = BulkInvoice::whereRaw('FIND_IN_SET(?, order_ids)', [$orderId])
                           ->where('active', 1)
                           ->first();
        if($bulk_invoice && $bulk_invoice->payment_status == 0 && $paymentStatus == 2){
            $bulk_invoice->payment_status = 2;
            $bulk_invoice->save();
        }
        $blade = 'orderItemDetails';

            return view('pages.order_management.orders.view_orderitem', [
                        // 'organizations'=>$organizations,
                        'order'=>$orders,
                        'orders' => null,
                        // 'orderDetails'=>$orderDetails,
                        'orderStatuses'=>$orderStatuses,
                        // 'users'=>$users,
                        // 'emptyInvoice'=>$emptyInvoice,
                        //  'products'=>$products,
                         'fabrics'=>$fabrics,
                         'embellishmentTypes'=>$embellishmentTypes,
                        'factories'=>$factories,
                        'exFactories'=>$results,
                        'exFactoriesData'=>$exFactories,
                        // 'userInfo'=>$userInfo,
                        // 'ShippedOrdersDetails'=>$shippedArray,
                        // 'activeUsers'=>$activeUsers,
                        'arrayPlayerNamesPattern'=>$arrayPlayerNamesPattern,
                        // 'sports'=>$sports,
                        // 'shippingNotifyDraft'=>$shippingNotifyDraft,
                        // 'oderSearch'=>$oderSearch,
                        // 'factoryIds'=>$factoryIds,
                        // 'userRoleId'=>$userRoleId,
                        // 'userId'=>$userId,
                        // 'exfactoryLogs'=>$exfactoryLogs,
                        // 'inHandDueDateLogs'=>$inHandDueDateLogs,
                        // 'organizationIMG'=>$organizationIMG,
                        // 'sportIMG'=>$sportIMG,
                        // 'shipTrait'=>$shipTrait,
                        'orderTrait'=>$orderTrait,
                        // 'orderId'=>$orderId,
                        'subProducts'=>$subProducts ,
                        // 'product_sports'=>$product_sports ,
                        // 'product_category'=>$product_category ,
                        // 'categories' => $categories ,
                        'clouser_types'=>$clouser_types ,
                        // 'Notifications'=>$Notifications ,
                        'attributes'=>$attributes,
                        'attributeGroups'=>$attributeGroups,
                        // 'orderFolderExist'=>$orderFolderExist,
                        // 'orderItemQtyExist'=>$orderItemQtyExist,
                        // 'orderInhandExist'=>$orderInhandExist,
                        // 'orderExfactoryExist'=>$orderExfactoryExist,
                        // 'orderEmbellishmentExist'=>$orderEmbellishmentExist,
                        // 'Order_test_print_due_date'=>$Order_test_print_due_date,
                        // 'orderItemActive'=>$orderItemActive,
                        // 'blade'=>$blade
            ]);


    }

    public function reorderItems(Request $request)
    {
        $orderId = (int) $request->input('order_id');
        $itemIds = $request->input('item_ids', []);

        if (is_string($itemIds)) {
            $decoded = json_decode($itemIds, true);
            if (is_array($decoded)) {
                $itemIds = $decoded;
            } else {
                $itemIds = preg_split('/\s*,\s*/', $itemIds, -1, PREG_SPLIT_NO_EMPTY);
            }
        }

        if (!is_array($itemIds)) {
            $itemIds = $itemIds ? [$itemIds] : [];
        }

        $itemIds = array_values(array_filter(array_map('intval', $itemIds)));

        if (!$orderId || empty($itemIds)) {
            return response()->json(['success' => false, 'message' => 'Invalid reorder payload.'], 422);
        }

        $order = Order::find($orderId);
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found.'], 404);
        }

        $orderedIds = array_values(array_unique(array_map('intval', $itemIds)));

        $allItemIds = OrderItem::where('order_id', $orderId)
            ->ordered()
            ->pluck('id')
            ->map(function ($id) {
                return (int) $id;
            })
            ->toArray();

        foreach ($orderedIds as $itemId) {
            if (!in_array($itemId, $allItemIds, true)) {
                return response()->json(['success' => false, 'message' => 'One or more items do not belong to this order.'], 422);
            }
        }

        if (count($orderedIds) === count($allItemIds)) {
            $finalOrder = $orderedIds;
        } else {
            $remainingIds = array_values(array_diff($allItemIds, $orderedIds));
            $remainingOrdered = OrderItem::whereIn('id', $remainingIds)
                ->ordered()
                ->pluck('id')
                ->map(function ($id) {
                    return (int) $id;
                })
                ->toArray();

            $finalOrder = array_merge($orderedIds, $remainingOrdered);
        }

        DB::transaction(function () use ($orderId, $finalOrder) {
            foreach ($finalOrder as $index => $itemId) {
                OrderItem::where('id', $itemId)
                    ->where('order_id', $orderId)
                    ->update([
                        'sort_order' => $index + 1,
                    ]);
            }
        });

        return response()->json(['success' => true, 'message' => 'Order items reordered successfully.']);
    }

    public function get_pattern_code(Request $request)
    {
        $attribute_ids = $request->attribute_ids;
        $sub_product_no = $request->sub_product_no;
        return PatternCodeFacade::getOrderItemPatternCode($sub_product_no, $attribute_ids);
    }
    public function get_customers_with_orders()
    {
        return Excel::download(new OrganizationsExport, 'organizations.xlsx');
    }

    public function reject_or_confirm_order_directly(Request $request){
        // dd($request);

        $oldNotification = Notification::find($request->notification_id);
        $order = Order::with('organizationDetails')->find($oldNotification->order_id);

        if (isset($request->reject_reason)) {
            $order->reject_or_confirm = 1;
            $order->reject_reason = $request->reject_reason;
            $order->suggested_ex_fac_date = $request->ex_fac_date;
            $order->factory_confirmation_date = 'Waiting for rep Confirmation';
            $order->update();

            $orderItemIds = explode(',', $oldNotification->order_item_id);

            foreach ($orderItemIds as $orderIds) {
                $orderItem = OrderItem::find($orderIds);
                if($orderItem){
                    $orderItem->is_urgent = 0;
                    $orderItem->reject_or_confirm = 1;
                    $orderItem->reject_reason = $request->reject_reason;
                    $orderItem->suggested_ex_fac_date = $request->ex_fac_date;
                    $orderItem->save();
                }
            }

            $allOrderItems = OrderItem::where('order_id', $order->id)->get();

            $allConfirmed = $allOrderItems->every(function ($rejectedOrderItem) {
                return $rejectedOrderItem->reject_or_confirm == 1;
            });

            $oldNotification->order_reject_or_confirm = 1;
            $oldNotification->order_ex_fac_date = $request->ex_fac_date;
            $oldNotification->update();

            $existingNotifications = Notification::where('is_payment', 0)->where('order_id', $oldNotification->order_id)
            ->where('is_comment', 0)->where('is_order_edit',0)
            ->where('active',1)->where('notification_message', 'like', '%has been moved to production%')
            ->whereNull('order_reject_or_confirm')->get();

            foreach ($existingNotifications as $existingNotification) {
                $existingNotification->order_reject_or_confirm = 1;
                $existingNotification->update();
            }

            $users = User::where('role_id', 'LIKE', '%"2"%')->where('active', 1)->pluck('id')->toArray();

            if (!is_null($order->order_procesing_user_id) && !in_array($order->order_procesing_user_id, $users)) {
                $users[] = $order->order_procesing_user_id;
            }
            if (!is_null($order->user_id) && !in_array($order->user_id, $users)) {
                $users[] = $order->user_id;
            }

            // foreach ($users as $user) {
            //     $notification = new Notification();
            //     $notification->notification_title = 'Ex-factory date for Order | Order - #' . $order->order_no . ' has been rejected.';
            //     $notification->notification_message = 'Ex-factory date for Order | Order - #' . $order->order_no . ' has been rejected.
            //                                         <ul> Suggested date is ' . $request->ex_fac_date . '.</ul>
            //                                         <ul> The reason to reject is "' . $request->reject_reason . '".</ul>
            //                                         <ul>
            //                                             <button type="button" class="btn btn-reject-factory-ex btn-danger mt-3">Reject</button>
            //                                             <button type="button" class="btn btn-confirm-factory-ex btn-success mt-3">Confirm</button>
            //                                         </ul>';
            //     $notification->user_id = $user;
            //     $notification->order_id = $order->id;
            //     $notification->order_in_hand_due_date = $oldNotification->order_in_hand_due_date;
            //     $notification->order_ex_fac_date = $request->ex_fac_date;
            //     $notification->order_item_id = $oldNotification->order_item_id;
            //     $notification->save();
            // }

            $DownloadTestPrint = route('DownloadTestPrint', [ 'id' => $oldNotification->order_item_id ]);
            $quoteCSV_Download = route('quoteCSV_Download', ['id' => $order->id]);

            $builder = new NotificationBuilderService();

            $builder->sendNotification('key_reject_or_confirm_order_directly', [
                '{order_no}' => $order->order_no,
                '{ex_fac_date}' => $request->ex_fac_date,
                '{reject_reason}' => $request->reject_reason,
                '{DownloadTestPrint}' => $DownloadTestPrint,
                '{quoteCSV_Download}' => $quoteCSV_Download,
            ], [

                'order_id' => $order->id,
                'order_in_hand_due_date' => $oldNotification->order_in_hand_due_date,
                'order_ex_fac_date' => $request->ex_fac_date,
                'order_item_id' => $oldNotification->order_item_id,
            ]);

            email_Notify()->sendEmailFromTemplate('key_email_factory_reject_ex_fac_date', [
                'orderId' => $order->id,
                'organizationname' => $order->organizationDetails->organization_name,
                'suggested_date' => $request->ex_fac_date,
                'reject_reason' => $request->reject_reason,
                'order_link' => url("order_details/edit/{$order->id}/order?active_tab=order"),
            ]);

            return response()->json(['message' => 'Data updated' , 'status' => 201]);

        }

        if (isset($request->confirm_text)) {
            $order->is_urgent = 0;
            $order->factory_confirmation_date = \Carbon\Carbon::now()->format('m/d/Y');
            $order->reject_or_confirm = 2;
            $order->update();

            $orderItemIds = explode(',', $oldNotification->order_item_id);

            foreach ($orderItemIds as $orderIds) {
                $orderItem = OrderItem::find($orderIds);
                $orderItem->is_urgent = 0;
                $orderItem->reject_or_confirm = 2;
                $orderItem->update();
            }

            $oldNotification->order_reject_or_confirm = 2;
            $oldNotification->update();

            $existingNotifications = Notification::where('is_payment', 0)->where('order_id', $oldNotification->order_id)
            ->where('is_comment', 0)->where('is_order_edit',0)
            ->where('active',1)->where('notification_message', 'like', '%has been moved to production%')
            ->whereNull('order_reject_or_confirm')->get();

            foreach ($existingNotifications as $existingNotification) {
                $existingNotification->order_reject_or_confirm = 2;
                $existingNotification->update();
            }

            $users = User::where('role_id', 'LIKE', '%"2"%')->where('active', 1)->pluck('id')->toArray();

            if (!is_null($order->order_procesing_user_id) && !in_array($order->order_procesing_user_id, $users)) {
                $users[] = $order->order_procesing_user_id;
            }
            if (!is_null($order->user_id) && !in_array($order->user_id, $users)) {
                $users[] = $order->user_id;
            }

            // foreach ($users as $user) {
            //     $notification = new Notification();
            //     $notification->notification_title = 'Ex-factory date confirmed for Order | Order - #' . $order->order_no;
            //     $notification->notification_message = 'Ex-factory date confirmed for Order | Order - #' . $order->order_no;
            //     $notification->user_id = $user;
            //     $notification->order_id = $order->id;
            //     $notification->order_in_hand_due_date = $oldNotification->order_in_hand_due_date;
            //     $notification->order_ex_fac_date = $oldNotification->order_ex_fac_date;
            //     $notification->order_item_id = $oldNotification->order_item_id;
            //     $notification->save();
            // }
            $builder = new NotificationBuilderService();

            $builder->sendNotification('key_Ex_factory_date_confirm', [
                '{order_no}' => $order->order_no,
            ], [

                'order_id' => $order->id,
                'order_in_hand_due_date' => $oldNotification->order_in_hand_due_date,
                'order_ex_fac_date' => $oldNotification->order_ex_fac_date,
                'order_item_id' => $oldNotification->order_item_id,
            ]);

            email_Notify()->sendEmailFromTemplate('key_email_factory_confirm_ex_fac_date', [
                'orderId' => $order->id,
                'organizationname' => $order->organizationDetails->organization_name,
                'ex_factory_date' => $oldNotification->order_ex_fac_date,
                'order_link' => url("order_details/edit/{$order->id}/order?active_tab=order"),
            ]);

            $this->create_invoice_by_factory_confirmation($order->id);

            return response()->json(['message' => 'Data updated' , 'status' => 200]);
        }


    }
    public function reject_or_confirm_factory_suggest(Request $request){

        $oldNotification = Notification::find($request->notification_id);
        $order = Order::find($oldNotification->order_id);

        if (isset($request->reject_reason)) {
            if ($order->factory_confirmation_date == null) {
                $order->factory_confirmation_date = 'Rejected by factory';
            }
            $order->reject_or_confirm = 1;
            $order->reject_reason = $request->reject_reason;
            $order->suggested_ex_fac_date = $request->ex_fac_date;
            $order->factory_confirmation_date = 'Waiting for factory Confirmation';
            $order->update();

            $orderItemIds = explode(',', $oldNotification->order_item_id);

            foreach ($orderItemIds as $orderIds) {
                $orderItem = OrderItem::find($orderIds);
                $orderItem->is_urgent = 1;
                $orderItem->reject_or_confirm = 1;
                $orderItem->reject_reason = $request->reject_reason;
                $orderItem->suggested_ex_fac_date = $request->ex_fac_date;
                $orderItem->update();
            }

            // $allOrderItems = OrderItem::where('order_id', $order->id)->get();

            // $allConfirmed = $allOrderItems->every(function ($rejectedOrderItem) {
            //     return $rejectedOrderItem->reject_or_confirm == 1;
            // });

            $oldNotification->order_reject_or_confirm = 1;
            $oldNotification->order_ex_fac_date = $request->ex_fac_date;
            $oldNotification->update();

            $factoryArray = [];
            foreach($orderItemIds as $orderItemId){
                $item = OrderItem::find($orderItemId);
                if(isset($item->factory_id)){
                    $factoryArray[] = $item->factory_id;
                }
            }

            $this->notifyFactoryUsersExFac($order->id,$request->ex_fac_date,$factoryArray);
            $this->emailFactoryUsersExFac($order->id,$request->ex_fac_date,$factoryArray);

            return redirect()->back()->withSuccess('Data updated!');

        }

        if (isset($request->confirm_text)) {

            $exDateLog = ExFactoryDateFacade::create($order->id, Auth::user()->name, $order->ex_factory_date, $oldNotification->order_ex_fac_date, 'Factory suggested ex-factory date has been confirmed by rep');

            $order->is_urgent = 1;
            $order->factory_confirmation_date = \Carbon\Carbon::now()->format('m/d/Y');
            $order->ex_factory_date = $oldNotification->order_ex_fac_date;
            $order->reject_or_confirm = 2;
            $order->update();


            $orderItemIds = explode(',', $oldNotification->order_item_id);

            // $allOrderItems = OrderItem::where('order_id', $order->id)->get();

            foreach ($orderItemIds as $orderIds) {
                $orderItem = OrderItem::find($orderIds);
                $orderItem->is_urgent = 1;
                $orderItem->reject_or_confirm = 2;
                $orderItem->ex_factory_date = $oldNotification->order_ex_fac_date;
                $orderItem->update();
            }

            $oldNotification->order_reject_or_confirm = 2;
            $oldNotification->update();

            $factoryArray = [];
            foreach($orderItemIds as $orderItemId){
                $item = OrderItem::find($orderItemId);
                if(isset($item->factory_id)){
                    $factoryArray[] = $item->factory_id;
                }
            }

            foreach (array_unique($factoryArray) as $factory_id) {

                if($factory_id == 2){     // PBS Factory
                    $userRoleId = 5;  // PBS
                }
                if($factory_id == 1){     // WDC Factory
                    $userRoleId = 6;  // WDC
                    }
                if($factory_id == 3){     // BII Factory
                    $userRoleId = 7;  // BII
                }
                if($factory_id == 7){     // UET Factory
                    $userRoleId = 8;  // UET
                }
                if($factory_id == 10){     // ZYS Factory
                    $userRoleId = 11;  // ZYS
                }
                if($factory_id == 16){     // Test Factory
                    $userRoleId = 12;  // Test
                }

                $userIds =  User::whereHas("roles", function($q) use($userRoleId) {
                    $q->where("id", $userRoleId);
                })->where('active', 1)->get()->pluck('id');

                foreach ($userIds as $user) {
                    $notification = new Notification();
                    $notification->notification_title = 'Ex-factory date confirmed for Urgent Order | Order - #' . $order->order_no;
                    $notification->notification_message = 'Ex-factory date confirmed for Urgent Order | Order - #' . $order->order_no;
                    $notification->user_id = $user;
                    $notification->is_urgent = 1;
                    $notification->order_reject_or_confirm = 2;
                    $notification->order_in_hand_due_date = $order->due_date;
                    $notification->order_ex_fac_date = $oldNotification->order_ex_fac_date;
                    $notification->order_id = $order->id;
                    $notification->order_item_id = $oldNotification->order_item_id;
                    $notification->save();
                }
            }

            $this->create_invoice_by_factory_confirmation($order->id);

            return redirect()->back()->withSuccess('Data updated!');
        }


    }

    public function create_invoice_by_factory_confirmation($order_id)
    {

        // Do not create factory invoice for Test Organization
        // Test Organization ID = 2890
        $isTestOrganization = Order::where('id', $order_id)
            ->where('organization_id', 2890)
            ->exists();

        if ($isTestOrganization) {
            return;
        }
        $isExist = FactoryInvoice::where('order_id', $order_id)->where('active', 1)->exists();

        if (!$isExist) {
            $maxId = FactoryInvoice::max('id');
            $invoice_no = 'INV' . str_pad(($maxId + 1), 4, "0", STR_PAD_LEFT);

            $invoice = new FactoryInvoice();
            $invoice->invoice_number = $invoice_no;
            $invoice->order_id = $order_id;
            $invoice->total_amount = 0;
            $invoice->sub_total = 0;
            $invoice->reduce_value = 0;
            $invoice->status = 0;
            $invoice->save();

            $invoiceId = $invoice->id;

            $order_items = orderItem::where('factory_id', 1)->where('active', 1)->where('order_id', $order_id)->get();

            $sum = 0.00;

            foreach ($order_items as $order_item) {
                $manufacture = Price::where('price_type', '5')->where('active', 1)->where('product_id', $order_item->product_id)->first();
                $manufacture_price = $manufacture ? $manufacture->price : 0.00;
                InvoiceProduct::create([
                    'invoice_id' => $invoiceId,
                    'product_id' => $order_item->product_id,
                    'qty' => $order_item->qty,
                    'order_item_id' => $order_item->id,
                    'unit_price' => $manufacture_price,
                    'total_price' => ($manufacture_price * $order_item->qty),
                ]);

                $sum += ($manufacture_price * $order_item->qty);
            }

            $saved_invoice = FactoryInvoice::find($invoiceId);
            $saved_invoice->total_amount = number_format($sum, 2, '.', '');
            $saved_invoice->sub_total = number_format($sum, 2, '.', '');
            $saved_invoice->save();
        }
    }


    public function attributes_update(){
        $order_items = OrderItem::get();
        // dd($order_items);
        OrderItemAttribute::query()->delete();
        foreach ($order_items as $order_item) {
            if($order_item->individual_name == 1){

                $item_attribute = new OrderItemAttribute();
                $item_attribute->order_item_id = $order_item->id;
                $item_attribute->attribute_id = 2;
                $item_attribute->save();

            }
            if($order_item->individual_no == 1){

                $item_attribute = new OrderItemAttribute();
                $item_attribute->order_item_id = $order_item->id;
                $item_attribute->attribute_id = 1;
                $item_attribute->save();

            }
            if($order_item->zipper_pockets == 1){

                $item_attribute = new OrderItemAttribute();
                $item_attribute->order_item_id = $order_item->id;
                $item_attribute->attribute_id = 5;
                $item_attribute->save();

            }
            if($order_item->pockets == 1){

                $item_attribute = new OrderItemAttribute();
                $item_attribute->order_item_id = $order_item->id;
                $item_attribute->attribute_id = 4;
                $item_attribute->save();

            }
            if($order_item->double_sided == 1){ //Reversible

                $item_attribute = new OrderItemAttribute();
                $item_attribute->order_item_id = $order_item->id;
                $item_attribute->attribute_id = 3;
                $item_attribute->save();

            }
            if($order_item->dynamic_details == 1){

                $item_attribute = new OrderItemAttribute();
                $item_attribute->order_item_id = $order_item->id;
                $item_attribute->attribute_id = 6;
                $item_attribute->save();

            }
            if($order_item->contrast_stratching == 1){

                $item_attribute = new OrderItemAttribute();
                $item_attribute->order_item_id = $order_item->id;
                $item_attribute->attribute_id = 7;
                $item_attribute->save();

            }
            if($order_item->printing_over_sems == 1){

                $item_attribute = new OrderItemAttribute();
                $item_attribute->order_item_id = $order_item->id;
                $item_attribute->attribute_id = 8;
                $item_attribute->save();

            }
        }
        dd('Completed !!!');
    }

    public function createDriveOrder($yearPath, $orderId) {
        Storage::disk('google')->makeDirectory($yearPath.'/Order '.$orderId);

        $orderDirectories = Storage::disk('google')->directories($yearPath);
        $orderPath = '';
        foreach($orderDirectories as $orderDirectory){
            $folder = Storage::disk('google')->getMetadata($orderDirectory);

            if ($folder['name'] == ('Order '.$orderId)) {
                $orderPath = $folder['path'];

                $orderFolder = new OrderFolder();
                $orderFolder->order_id = $orderId;
                $orderFolder->order_folder_id = $orderPath;
                $orderFolder->save();

                Storage::disk('google')->makeDirectory($orderPath.'/Tech Pack');
                Storage::disk('google')->makeDirectory($orderPath.'/Mockups');
                Storage::disk('google')->makeDirectory($orderPath.'/Production Layouts');
                Storage::disk('google')->makeDirectory($orderPath.'/Production Pics');
                Storage::disk('google')->makeDirectory($orderPath.'/Discussions');
                Storage::disk('google')->makeDirectory($orderPath.'/Test Print');
            }
        }

        $fileDirectories = Storage::disk('google')->directories($orderPath);

        $techPackFolderId = '';
        $mockupsFolderId = '';
        $productionLayoutsFolderId = '';
        $productionPicsFolderId = '';
        $discussionsFolderId = '';
        $testPrintFolderId = '';
        foreach($fileDirectories as $fileDirectory){
            $folder = Storage::disk('google')->getMetadata($fileDirectory);

            if ($folder['name'] == 'Tech Pack') {
                $techPackFolderId = $folder['path'];

            } else if ($folder['name'] == 'Mockups') {
                $mockupsFolderId = $folder['path'];

            } else if ($folder['name'] == 'Production Layouts') {
                $productionLayoutsFolderId = $folder['path'];

            } else if ($folder['name'] == 'Production Pics') {
                $productionPicsFolderId = $folder['path'];

            } else if ($folder['name'] == 'Discussions') {
                $discussionsFolderId = $folder['path'];

            }  else if ($folder['name'] == 'Test Print') {
                $testPrintFolderId = $folder['path'];
            }
        }

        $orderFolder = OrderFolder::where('order_id', $orderId)->first();
        $orderFolder->tech_pack_folder_id = $techPackFolderId;
        $orderFolder->mockups_folder_id = $mockupsFolderId;
        $orderFolder->production_layouts_folder_id = $productionLayoutsFolderId;
        $orderFolder->production_pics_folder_id = $productionPicsFolderId;
        $orderFolder->discussions_folder_id = $discussionsFolderId;
        $orderFolder->test_print_folder_id = $testPrintFolderId;
        $orderFolder->update();
    }

    public function update(Request $request){
        $notifyChanges = $request->notify_changes;
        parse_str(str_replace([',', '[', ']'], ['&', '[\'', '\']'], $notifyChanges), $notifyFieldArr);

            $editedInProductionMap = [];
            $itemSnapshots         = [];
            foreach($request->orderItem as $orderItems){
                $totQty = $orderItems['TOTALqty'];
                if(isset($orderItems['unitprice'])){
                    $unitPrice = $orderItems['unitprice'];
                    $totPrice = $totQty * $unitPrice;
                }

                // Order Item Query
                $orderItem = OrderItem::find($orderItems['orderItemId']);
                // Order Query
                $order = Order::find($orderItem->order_id);

                if($orderItem->order_status_id == 1 && $orderItems['order_status_id'] == 3){
                    $order->production_date = Carbon::now()->format('m/d/Y');
                    $this->notifyFactoryUsers($orderItem, $request->item_is_urgent);
                    $this->notifyFactoryUsersByEmail($orderItem, $request->item_is_urgent);
                }

                if($orderItem->order_status_id == 3 && $orderItems['order_status_id'] == 1){
                    $this->notifyFactoryUsers($orderItem, $request->item_is_urgent);
                    $this->notifyFactoryUsersByEmail($orderItem, $request->item_is_urgent);
                }

                $editedInProduction = ($orderItem->order_status_id == 3 && $orderItems['order_status_id'] == 3);



                $changed_sub_product = SubProduct::where('sub_product_no' , $orderItems['styleName'])->first();
                $orderItem->product_id = $changed_sub_product->parent_product_id;
                $orderItem->fabric_id = $changed_sub_product->fabric_id;
                // $orderItem->fabric_id = $orderItems['fabric'];
                $orderItem->sub_product_no = $orderItems['styleName'];

                $orderItem->display_name = $orderItems['display_name'];

                $orderItem->secondary_fabric_id = $orderItems['secondary_fabric'];
                $orderItem->embellishment_type_id = $orderItems['estabilishment'];
                $orderItem->clouser_type = $orderItems['clouser_type'];
                // $orderItem->open_date = $orderItems['open_date'];
                // $orderItem->close_date = $orderItems['close_date'];
                $orderItem->ex_factory_date = $orderItems['ex_factory_date'];
                $orderItem->is_urgent = $request->item_is_urgent;

                if(isset($orderItems['test_print_needed'])){
                    $orderItem->test_print_needed = 1;
                }else{
                    $orderItem->test_print_needed = 0;
                }
                if(isset($orderItems['test_print_needed']) && isset($orderItems['test_print_due_date'])){
                    $orderItem->test_print_due_date = $orderItems['test_print_due_date'];
                    if(!empty($orderItem->factory_id)){
                        $this->NotifyFactory($request->order_id, $request->order_item_id, $orderItems['test_print_due_date']);
                    }
                }else{
                    $orderItem->test_print_due_date = null;
                }

                if($request->order_type == 1){
                    $orderItem->encore_packing_date = $orderItems['encore_packing_date'];
                }

                $orderItem->in_hand_due_date = $orderItems['in_hand_by'];
                $orderItem->est_delivery_date = $orderItems['ex_factory_date'];
                $orderItem->factory_id = $orderItems['factory'];
                // $orderItem->ex_factory_id = $orderItems['ex_factory_id'];
                // Check if 'ex_factory_id' exists in the request and process accordingly
                if (isset($orderItems['ex_factory_id'])) {
                    if (strpos($orderItems['ex_factory_id'], 'ex_') === 0) {
                        // Remove the 'ex_' prefix and save it as ex_factory_id (assuming it's an integer)
                        $orderItem->ex_factory_id = (int) str_replace('ex_', '', $orderItems['ex_factory_id']);
                    } elseif (strpos($orderItems['ex_factory_id'], 'con_') === 0) {
                        // If 'con_' prefix is detected, remove 'con_' and find the corresponding contact
                        $contactId = (int) str_replace('con_', '', $orderItems['ex_factory_id']);

                        // Find the contact by ID (assuming you have a Contact model)
                        $contact = Contact::find($contactId);

                        if ($contact) {
                            $exFactory = new ExFactory();
                            $exFactory->ex_factory_name = $contact->first_name . ' ' . $contact->last_name;
                            $exFactory->order_item_id = $orderItems['orderItemId'];
                            $exFactory->contact_id = $contactId;
                            $exFactory->apartment = $contact->apartment ?? '';
                            $exFactory->po_box = $contact->shipping_po_box ?? '';
                            $exFactory->city = $contact->shipping_city ?? '';
                            $exFactory->state = $contact->shipping_state ?? '';
                            $exFactory->postal_code = $contact->shipping_zip ?? '';
                            $exFactory->country = $contact->shipping_country ?? '';
                            $exFactory->active = 1;
                            $exFactory->created_by = Auth::user()->id;
                            $exFactory->save();

                            $orderItem->ex_factory_id = $exFactory->id;
                        }
                    }elseif($orderItems['ex_factory_id'] == 0){
                        $orderItem->ex_factory_id = $orderItems['ex_factory_id'];
                    }
                }
                $orderItem->order_status_id = $orderItems['order_status_id'];
                $orderItem->qty = $totQty;
                if(isset($orderItems['unitprice'])){
                    $orderItem->unit_price = $unitPrice;
                    $orderItem->total = $totPrice;
                }

                //$orderItem->extra_size = $orderItems['extra_size'];

                // if(isset($orderItems['individual_no']))
                if (isset($orderItems['item_attributes']) && array_key_exists(1, $orderItems['item_attributes'])) {
                    if(isset($orderItems['extra_size'])){ $orderItem->extra_size = $orderItems['extra_size']; }
                    if(isset($orderItems['extra_size_two'])){ $orderItem->extra_size_two = $orderItems['extra_size_two']; }
                    if(isset($orderItems['extra_size_three'])){ $orderItem->extra_size_three = $orderItems['extra_size_three']; }
                }else{
                    if(isset($orderItems['updated_extra_size'])){ $orderItem->extra_size = $orderItems['updated_extra_size']; }
                    if(isset($orderItems['updated_extra_size_two'])){ $orderItem->extra_size_two = $orderItems['updated_extra_size_two']; }
                    if(isset($orderItems['updated_extra_size_three'])){ $orderItem->extra_size_three = $orderItems['updated_extra_size_three']; }
                }

                OrderItemAttribute::where('order_item_id', $orderItems['orderItemId'])->forceDelete();
                OrderItemSubAttribute::where('order_item_id', $orderItems['orderItemId'])->forceDelete();

                 if(isset($orderItems['item_attributes'])){
                    foreach ($orderItems['item_attributes'] as $key => $value) {
                        $item_attribute = new OrderItemAttribute();
                        $item_attribute->order_item_id = $orderItems['orderItemId'];
                        $item_attribute->attribute_id = $key;
                        $item_attribute->save();

                        if($key == 1){
                            $orderItem->individual_no = 1;
                        }
                        if($key == 2){
                            $orderItem->individual_name = 1;
                        }
                        if($key == 3){
                            $orderItem->double_sided = 1;
                        }
                        if($key == 4){
                            $orderItem->pockets = 1;
                        }
                        if($key == 5){
                            $orderItem->zipper_pockets = 1;
                        }
                        if($key == 6){
                            $orderItem->dynamic_details = 1;
                        }
                        if($key == 7){
                            $orderItem->contrast_stratching = 1;
                        }
                        if($key == 8){
                            $orderItem->printing_over_sems = 1;
                        }
                    }
                 }


                OrderItemAttributeGroup::where('order_item_id', $orderItems['orderItemId'])->forceDelete();
                if(isset($orderItems['item_attribute_groups'])){
                    foreach ($orderItems['item_attribute_groups'] as $key => $value) {
                        $item_attribute_group = new OrderItemAttributeGroup();
                        $item_attribute_group->order_item_id = $orderItems['orderItemId'];
                        $item_attribute_group->attribute_group_id = $key;
                        $item_attribute_group->save();
                    }
                }

                if(isset($orderItems['item_sub_attributes'])){
                    foreach ($orderItems['item_sub_attributes'] as $key => $value) {
                        $item_attribute = new OrderItemAttribute();
                        $item_attribute->order_item_id = $orderItems['orderItemId'];
                        $item_attribute->attribute_id = $value;
                        $item_attribute->save();
                    }

                    foreach ($orderItems['item_sub_attributes'] as $key => $value) {
                        $item_sub_attribute = new OrderItemSubAttribute();
                        $item_sub_attribute->order_item_id = $orderItems['orderItemId'];
                        $item_sub_attribute->attribute_id = $value;
                        $item_sub_attribute->save();
                    }
                }

                $orderItem->tracking_no = $orderItems['tracking_no'];
                $orderItem->tracking_link = $orderItems['tracking_link'];


                $orderItem->item_description = $orderItems['item_description'];

                // Capture original values before saving (for notification diff)
                $itemOriginalValues = $orderItem->getOriginal();
                $orderItem->update();
                // Capture what actually changed after saving
                $itemChangedValues  = $orderItem->getChanges();

                $editedInProductionMap[$orderItems['orderItemId']] = $editedInProduction;
                if ($editedInProduction) {
                    $itemSnapshots[$orderItems['orderItemId']] = [
                        'item'    => $orderItem,
                        'orig'    => $itemOriginalValues,
                        'changed' => $itemChangedValues,
                    ];
                }


                // $order = Order::find($orderItem->order_id);
                $organization = Organization::find($order->organization_id);
                $orderSubTotal = OrderItem::where('order_id', $orderItem->order_id)->where('active', 1)->where('is_studio_item', 0)->sum('total');
                $orderSubTotalStudio = OrderItem::where('order_id', $orderItem->order_id)->where('active', 1)->where('is_studio_item', 1)->sum('total');


                if ($organization->sales_tax_active == 1) {
                    $salesTax = $organization->sales_tax;
                } else {
                    $salesTax = 0;
                }
                // $orderSalesTax = ($orderSubTotal / 100) * $salesTax;
                // $orderShipping = $order->shipping ?? 0.00;
                // $orderArtwork = $order->artwork ?? 0.00;
                // $orderProcessingFee = $order->processing_fee ?? '';
                // $orderFeesTotal = $orderSalesTax + $orderShipping + $orderArtwork + $orderProcessingFee;
                // $orderFeesTotal = $orderSalesTax + $orderShipping + $orderArtwork;

                // if($order->discount_hidation == 1 ){

                //     if($order->discountType == 1){

                //         $discountAmount = ($orderSubTotal / 100) * $order->discount;

                //     } elseif($order->discountType == 2) {

                //         $discountAmount = $order->discount;
                //     }

                // }else{
                //     $discountAmount = 0.00;
                // }
                $order->sub_total = $orderSubTotal;
                $order->studio_item_sub_total = $orderSubTotalStudio ?? '0.00';
                // $order->order_total = $orderSubTotal + $orderFeesTotal;
                // $order->sales_tax = $orderSalesTax;
                $order->update();
            }
//         }

//         if(isset($notifyFieldArr['product'])){
            $blankProductArray = [];
            $sizeQtyChanges = [];
            $sizeQtyChangesByItem = [];
            $orderItemsDetailInfo = [];
            $numseqChangesByItem = [];
            foreach($request->product as $productDetails){
                $OrderItemsDetail = OrderItemsDetail::find($productDetails['orderNo']);
                $numseqOriginalValues = $OrderItemsDetail->getOriginal();
                $ownerItemId = $OrderItemsDetail->order_item_id;

                $orderItemsDetailInfo[$productDetails['orderNo']] = [
                    'order_item_id' => $ownerItemId,
                    'size_id'        => $OrderItemsDetail->size_id,
                ];

                if ($editedInProductionMap[$ownerItemId] ?? false) {
                    $oldQty = (string) $OrderItemsDetail->getOriginal('blanks');
                    $newQty = (string) $productDetails['blanks'];

                    if ($this->valuesAreEqual($oldQty, $newQty) === false) {
                        $sizeQtyChangesByItem[$ownerItemId][$OrderItemsDetail->id] = [
                            'old'     => $oldQty,
                            'new'     => $newQty,
                            'size_id' => $OrderItemsDetail->size_id,
                        ];
                    }
                }
                $OrderItemsDetail->blanks = $productDetails['blanks'];
                $OrderItemsDetail->qty = $productDetails['qty'];   // leave as-is, unrelated legacy write

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

                if($productDetails['numseq_fifty_one'] != ""){$OrderItemsDetail->numseq_fifty_one = $productDetails['numseq_fifty_one'];}else{$OrderItemsDetail->numseq_fifty_one = "";}
                if($productDetails['numseq_fifty_two'] != ""){$OrderItemsDetail->numseq_fifty_two = $productDetails['numseq_fifty_two'];}else{$OrderItemsDetail->numseq_fifty_two = "";}
                if($productDetails['numseq_fifty_three'] != ""){$OrderItemsDetail->numseq_fifty_three = $productDetails['numseq_fifty_three'];}else{$OrderItemsDetail->numseq_fifty_three = "";}
                if($productDetails['numseq_fifty_four'] != ""){$OrderItemsDetail->numseq_fifty_four = $productDetails['numseq_fifty_four'];}else{$OrderItemsDetail->numseq_fifty_four = "";}
                if($productDetails['numseq_fifty_five'] != ""){$OrderItemsDetail->numseq_fifty_five = $productDetails['numseq_fifty_five'];}else{$OrderItemsDetail->numseq_fifty_five = "";}
                if($productDetails['numseq_fifty_six'] != ""){$OrderItemsDetail->numseq_fifty_six = $productDetails['numseq_fifty_six'];}else{$OrderItemsDetail->numseq_fifty_six = "";}
                if($productDetails['numseq_fifty_seven'] != ""){$OrderItemsDetail->numseq_fifty_seven = $productDetails['numseq_fifty_seven'];}else{$OrderItemsDetail->numseq_fifty_seven = "";}
                if($productDetails['numseq_fifty_eight'] != ""){$OrderItemsDetail->numseq_fifty_eight = $productDetails['numseq_fifty_eight'];}else{$OrderItemsDetail->numseq_fifty_eight = "";}
                if($productDetails['numseq_fifty_nine'] != ""){$OrderItemsDetail->numseq_fifty_nine = $productDetails['numseq_fifty_nine'];}else{$OrderItemsDetail->numseq_fifty_nine = "";}
                if($productDetails['numseq_sixty'] != ""){$OrderItemsDetail->numseq_sixty = $productDetails['numseq_sixty'];}else{$OrderItemsDetail->numseq_sixty = "";}

                if($productDetails['numseq_sixty_one'] != ""){$OrderItemsDetail->numseq_sixty_one = $productDetails['numseq_sixty_one'];}else{$OrderItemsDetail->numseq_sixty_one = "";}
                if($productDetails['numseq_sixty_two'] != ""){$OrderItemsDetail->numseq_sixty_two = $productDetails['numseq_sixty_two'];}else{$OrderItemsDetail->numseq_sixty_two = "";}
                if($productDetails['numseq_sixty_three'] != ""){$OrderItemsDetail->numseq_sixty_three = $productDetails['numseq_sixty_three'];}else{$OrderItemsDetail->numseq_sixty_three = "";}
                if($productDetails['numseq_sixty_four'] != ""){$OrderItemsDetail->numseq_sixty_four = $productDetails['numseq_sixty_four'];}else{$OrderItemsDetail->numseq_sixty_four = "";}
                if($productDetails['numseq_sixty_five'] != ""){$OrderItemsDetail->numseq_sixty_five = $productDetails['numseq_sixty_five'];}else{$OrderItemsDetail->numseq_sixty_five = "";}
                if($productDetails['numseq_sixty_six'] != ""){$OrderItemsDetail->numseq_sixty_six = $productDetails['numseq_sixty_six'];}else{$OrderItemsDetail->numseq_sixty_six = "";}
                if($productDetails['numseq_sixty_seven'] != ""){$OrderItemsDetail->numseq_sixty_seven = $productDetails['numseq_sixty_seven'];}else{$OrderItemsDetail->numseq_sixty_seven = "";}
                if($productDetails['numseq_sixty_eight'] != ""){$OrderItemsDetail->numseq_sixty_eight = $productDetails['numseq_sixty_eight'];}else{$OrderItemsDetail->numseq_sixty_eight = "";}
                if($productDetails['numseq_sixty_nine'] != ""){$OrderItemsDetail->numseq_sixty_nine = $productDetails['numseq_sixty_nine'];}else{$OrderItemsDetail->numseq_sixty_nine = "";}
                if($productDetails['numseq_seventy'] != ""){$OrderItemsDetail->numseq_seventy = $productDetails['numseq_seventy'];}else{$OrderItemsDetail->numseq_seventy = "";}

                if($productDetails['numseq_seventy_one'] != ""){$OrderItemsDetail->numseq_seventy_one = $productDetails['numseq_seventy_one'];}else{$OrderItemsDetail->numseq_seventy_one = "";}
                if($productDetails['numseq_seventy_two'] != ""){$OrderItemsDetail->numseq_seventy_two = $productDetails['numseq_seventy_two'];}else{$OrderItemsDetail->numseq_seventy_two = "";}
                if($productDetails['numseq_seventy_three'] != ""){$OrderItemsDetail->numseq_seventy_three = $productDetails['numseq_seventy_three'];}else{$OrderItemsDetail->numseq_seventy_three = "";}
                if($productDetails['numseq_seventy_four'] != ""){$OrderItemsDetail->numseq_seventy_four = $productDetails['numseq_seventy_four'];}else{$OrderItemsDetail->numseq_seventy_four = "";}
                if($productDetails['numseq_seventy_five'] != ""){$OrderItemsDetail->numseq_seventy_five = $productDetails['numseq_seventy_five'];}else{$OrderItemsDetail->numseq_seventy_five = "";}
                if($productDetails['numseq_seventy_six'] != ""){$OrderItemsDetail->numseq_seventy_six = $productDetails['numseq_seventy_six'];}else{$OrderItemsDetail->numseq_seventy_six = "";}
                if($productDetails['numseq_seventy_seven'] != ""){$OrderItemsDetail->numseq_seventy_seven = $productDetails['numseq_seventy_seven'];}else{$OrderItemsDetail->numseq_seventy_seven = "";}
                if($productDetails['numseq_seventy_eight'] != ""){$OrderItemsDetail->numseq_seventy_eight = $productDetails['numseq_seventy_eight'];}else{$OrderItemsDetail->numseq_seventy_eight = "";}
                if($productDetails['numseq_seventy_nine'] != ""){$OrderItemsDetail->numseq_seventy_nine = $productDetails['numseq_seventy_nine'];}else{$OrderItemsDetail->numseq_seventy_nine = "";}
                if($productDetails['numseq_eighty'] != ""){$OrderItemsDetail->numseq_eighty = $productDetails['numseq_eighty'];}else{$OrderItemsDetail->numseq_eighty = "";}

                if($productDetails['numseq_eighty_one'] != ""){$OrderItemsDetail->numseq_eighty_one = $productDetails['numseq_eighty_one'];}else{$OrderItemsDetail->numseq_eighty_one = "";}
                if($productDetails['numseq_eighty_two'] != ""){$OrderItemsDetail->numseq_eighty_two = $productDetails['numseq_eighty_two'];}else{$OrderItemsDetail->numseq_eighty_two = "";}
                if($productDetails['numseq_eighty_three'] != ""){$OrderItemsDetail->numseq_eighty_three = $productDetails['numseq_eighty_three'];}else{$OrderItemsDetail->numseq_eighty_three = "";}
                if($productDetails['numseq_eighty_four'] != ""){$OrderItemsDetail->numseq_eighty_four = $productDetails['numseq_eighty_four'];}else{$OrderItemsDetail->numseq_eighty_four = "";}
                if($productDetails['numseq_eighty_five'] != ""){$OrderItemsDetail->numseq_eighty_five = $productDetails['numseq_eighty_five'];}else{$OrderItemsDetail->numseq_eighty_five = "";}
                if($productDetails['numseq_eighty_six'] != ""){$OrderItemsDetail->numseq_eighty_six = $productDetails['numseq_eighty_six'];}else{$OrderItemsDetail->numseq_eighty_six = "";}
                if($productDetails['numseq_eighty_seven'] != ""){$OrderItemsDetail->numseq_eighty_seven = $productDetails['numseq_eighty_seven'];}else{$OrderItemsDetail->numseq_eighty_seven = "";}
                if($productDetails['numseq_eighty_eight'] != ""){$OrderItemsDetail->numseq_eighty_eight = $productDetails['numseq_eighty_eight'];}else{$OrderItemsDetail->numseq_eighty_eight = "";}
                if($productDetails['numseq_eighty_nine'] != ""){$OrderItemsDetail->numseq_eighty_nine = $productDetails['numseq_eighty_nine'];}else{$OrderItemsDetail->numseq_eighty_nine = "";}
                if($productDetails['numseq_ninety'] != ""){$OrderItemsDetail->numseq_ninety = $productDetails['numseq_ninety'];}else{$OrderItemsDetail->numseq_ninety = "";}

                if($productDetails['numseq_ninety_one'] != ""){$OrderItemsDetail->numseq_ninety_one = $productDetails['numseq_ninety_one'];}else{$OrderItemsDetail->numseq_ninety_one = "";}
                if($productDetails['numseq_ninety_two'] != ""){$OrderItemsDetail->numseq_ninety_two = $productDetails['numseq_ninety_two'];}else{$OrderItemsDetail->numseq_ninety_two = "";}
                if($productDetails['numseq_ninety_three'] != ""){$OrderItemsDetail->numseq_ninety_three = $productDetails['numseq_ninety_three'];}else{$OrderItemsDetail->numseq_ninety_three = "";}
                if($productDetails['numseq_ninety_four'] != ""){$OrderItemsDetail->numseq_ninety_four = $productDetails['numseq_ninety_four'];}else{$OrderItemsDetail->numseq_ninety_four = "";}
                if($productDetails['numseq_ninety_five'] != ""){$OrderItemsDetail->numseq_ninety_five = $productDetails['numseq_ninety_five'];}else{$OrderItemsDetail->numseq_ninety_five = "";}
                if($productDetails['numseq_ninety_six'] != ""){$OrderItemsDetail->numseq_ninety_six = $productDetails['numseq_ninety_six'];}else{$OrderItemsDetail->numseq_ninety_six = "";}
                if($productDetails['numseq_ninety_seven'] != ""){$OrderItemsDetail->numseq_ninety_seven = $productDetails['numseq_ninety_seven'];}else{$OrderItemsDetail->numseq_ninety_seven = "";}
                if($productDetails['numseq_ninety_eight'] != ""){$OrderItemsDetail->numseq_ninety_eight = $productDetails['numseq_ninety_eight'];}else{$OrderItemsDetail->numseq_ninety_eight = "";}
                if($productDetails['numseq_ninety_nine'] != ""){$OrderItemsDetail->numseq_ninety_nine = $productDetails['numseq_ninety_nine'];}else{$OrderItemsDetail->numseq_ninety_nine = "";}
                if($productDetails['numseq_hundred'] != ""){$OrderItemsDetail->numseq_hundred = $productDetails['numseq_hundred'];}else{$OrderItemsDetail->numseq_hundred = "";}

                if ($productDetails['numseq_hundred_one'] != ""){ $OrderItemsDetail->numseq_hundred_one = $productDetails['numseq_hundred_one']; } else { $OrderItemsDetail->numseq_hundred_one = "";}
                if ($productDetails['numseq_hundred_two'] != ""){ $OrderItemsDetail->numseq_hundred_two = $productDetails['numseq_hundred_two']; } else { $OrderItemsDetail->numseq_hundred_two = "";}
                if ($productDetails['numseq_hundred_three'] != ""){ $OrderItemsDetail->numseq_hundred_three = $productDetails['numseq_hundred_three']; } else { $OrderItemsDetail->numseq_hundred_three = "";}
                if ($productDetails['numseq_hundred_four'] != ""){ $OrderItemsDetail->numseq_hundred_four = $productDetails['numseq_hundred_four']; } else { $OrderItemsDetail->numseq_hundred_four = "";}
                if ($productDetails['numseq_hundred_five'] != ""){ $OrderItemsDetail->numseq_hundred_five = $productDetails['numseq_hundred_five']; } else { $OrderItemsDetail->numseq_hundred_five = "";}
                if ($productDetails['numseq_hundred_six'] != ""){ $OrderItemsDetail->numseq_hundred_six = $productDetails['numseq_hundred_six']; } else { $OrderItemsDetail->numseq_hundred_six = "";}
                if ($productDetails['numseq_hundred_seven'] != ""){ $OrderItemsDetail->numseq_hundred_seven = $productDetails['numseq_hundred_seven']; } else { $OrderItemsDetail->numseq_hundred_seven = "";}
                if ($productDetails['numseq_hundred_eight'] != ""){ $OrderItemsDetail->numseq_hundred_eight = $productDetails['numseq_hundred_eight']; } else { $OrderItemsDetail->numseq_hundred_eight = "";}
                if ($productDetails['numseq_hundred_nine'] != ""){ $OrderItemsDetail->numseq_hundred_nine = $productDetails['numseq_hundred_nine']; } else { $OrderItemsDetail->numseq_hundred_nine = "";}
                if ($productDetails['numseq_hundred_ten'] != ""){ $OrderItemsDetail->numseq_hundred_ten = $productDetails['numseq_hundred_ten']; } else { $OrderItemsDetail->numseq_hundred_ten = "";}

                if ($productDetails['numseq_hundred_eleven'] != ""){ $OrderItemsDetail->numseq_hundred_eleven = $productDetails['numseq_hundred_eleven']; } else { $OrderItemsDetail->numseq_hundred_eleven = "";}
                if ($productDetails['numseq_hundred_twelve'] != ""){ $OrderItemsDetail->numseq_hundred_twelve = $productDetails['numseq_hundred_twelve']; } else { $OrderItemsDetail->numseq_hundred_twelve = "";}
                if ($productDetails['numseq_hundred_thirteen'] != ""){ $OrderItemsDetail->numseq_hundred_thirteen = $productDetails['numseq_hundred_thirteen']; } else { $OrderItemsDetail->numseq_hundred_thirteen = "";}
                if ($productDetails['numseq_hundred_fourteen'] != ""){ $OrderItemsDetail->numseq_hundred_fourteen = $productDetails['numseq_hundred_fourteen']; } else { $OrderItemsDetail->numseq_hundred_fourteen = "";}
                if ($productDetails['numseq_hundred_fifteen'] != ""){ $OrderItemsDetail->numseq_hundred_fifteen = $productDetails['numseq_hundred_fifteen']; } else { $OrderItemsDetail->numseq_hundred_fifteen = "";}
                if ($productDetails['numseq_hundred_sixteen'] != ""){ $OrderItemsDetail->numseq_hundred_sixteen = $productDetails['numseq_hundred_sixteen']; } else { $OrderItemsDetail->numseq_hundred_sixteen = "";}
                if ($productDetails['numseq_hundred_seventeen'] != ""){ $OrderItemsDetail->numseq_hundred_seventeen = $productDetails['numseq_hundred_seventeen']; } else { $OrderItemsDetail->numseq_hundred_seventeen = "";}
                if ($productDetails['numseq_hundred_eighteen'] != ""){ $OrderItemsDetail->numseq_hundred_eighteen = $productDetails['numseq_hundred_eighteen']; } else { $OrderItemsDetail->numseq_hundred_eighteen = "";}
                if ($productDetails['numseq_hundred_nineteen'] != ""){ $OrderItemsDetail->numseq_hundred_nineteen = $productDetails['numseq_hundred_nineteen']; } else { $OrderItemsDetail->numseq_hundred_nineteen = "";}
                if ($productDetails['numseq_hundred_twenty'] != ""){ $OrderItemsDetail->numseq_hundred_twenty = $productDetails['numseq_hundred_twenty']; } else { $OrderItemsDetail->numseq_hundred_twenty = "";}

                if ($productDetails['numseq_hundred_twenty_one'] != ""){ $OrderItemsDetail->numseq_hundred_twenty_one = $productDetails['numseq_hundred_twenty_one']; } else { $OrderItemsDetail->numseq_hundred_twenty_one = "";}
                if ($productDetails['numseq_hundred_twenty_two'] != ""){ $OrderItemsDetail->numseq_hundred_twenty_two = $productDetails['numseq_hundred_twenty_two']; } else { $OrderItemsDetail->numseq_hundred_twenty_two = "";}
                if ($productDetails['numseq_hundred_twenty_three'] != ""){ $OrderItemsDetail->numseq_hundred_twenty_three = $productDetails['numseq_hundred_twenty_three']; } else { $OrderItemsDetail->numseq_hundred_twenty_three = "";}
                if ($productDetails['numseq_hundred_twenty_four'] != ""){ $OrderItemsDetail->numseq_hundred_twenty_four = $productDetails['numseq_hundred_twenty_four']; } else { $OrderItemsDetail->numseq_hundred_twenty_four = "";}
                if ($productDetails['numseq_hundred_twenty_five'] != ""){ $OrderItemsDetail->numseq_hundred_twenty_five = $productDetails['numseq_hundred_twenty_five']; } else { $OrderItemsDetail->numseq_hundred_twenty_five = "";}
                if ($productDetails['numseq_hundred_twenty_six'] != ""){ $OrderItemsDetail->numseq_hundred_twenty_six = $productDetails['numseq_hundred_twenty_six']; } else { $OrderItemsDetail->numseq_hundred_twenty_six = "";}
                if ($productDetails['numseq_hundred_twenty_seven'] != ""){ $OrderItemsDetail->numseq_hundred_twenty_seven = $productDetails['numseq_hundred_twenty_seven']; } else { $OrderItemsDetail->numseq_hundred_twenty_seven = "";}
                if ($productDetails['numseq_hundred_twenty_eight'] != ""){ $OrderItemsDetail->numseq_hundred_twenty_eight = $productDetails['numseq_hundred_twenty_eight']; } else { $OrderItemsDetail->numseq_hundred_twenty_eight = "";}
                if ($productDetails['numseq_hundred_twenty_nine'] != ""){ $OrderItemsDetail->numseq_hundred_twenty_nine = $productDetails['numseq_hundred_twenty_nine']; } else { $OrderItemsDetail->numseq_hundred_twenty_nine = "";}
                if ($productDetails['numseq_hundred_thirty'] != ""){ $OrderItemsDetail->numseq_hundred_thirty = $productDetails['numseq_hundred_thirty']; } else { $OrderItemsDetail->numseq_hundred_thirty = "";}

                if ($productDetails['numseq_hundred_thirty_one'] != ""){ $OrderItemsDetail->numseq_hundred_thirty_one = $productDetails['numseq_hundred_thirty_one']; } else { $OrderItemsDetail->numseq_hundred_thirty_one = "";}
                if ($productDetails['numseq_hundred_thirty_two'] != ""){ $OrderItemsDetail->numseq_hundred_thirty_two = $productDetails['numseq_hundred_thirty_two']; } else { $OrderItemsDetail->numseq_hundred_thirty_two = "";}
                if ($productDetails['numseq_hundred_thirty_three'] != ""){ $OrderItemsDetail->numseq_hundred_thirty_three = $productDetails['numseq_hundred_thirty_three']; } else { $OrderItemsDetail->numseq_hundred_thirty_three = "";}
                if ($productDetails['numseq_hundred_thirty_four'] != ""){ $OrderItemsDetail->numseq_hundred_thirty_four = $productDetails['numseq_hundred_thirty_four']; } else { $OrderItemsDetail->numseq_hundred_thirty_four = "";}
                if ($productDetails['numseq_hundred_thirty_five'] != ""){ $OrderItemsDetail->numseq_hundred_thirty_five = $productDetails['numseq_hundred_thirty_five']; } else { $OrderItemsDetail->numseq_hundred_thirty_five = "";}
                if ($productDetails['numseq_hundred_thirty_six'] != ""){ $OrderItemsDetail->numseq_hundred_thirty_six = $productDetails['numseq_hundred_thirty_six']; } else { $OrderItemsDetail->numseq_hundred_thirty_six = "";}
                if ($productDetails['numseq_hundred_thirty_seven'] != ""){ $OrderItemsDetail->numseq_hundred_thirty_seven = $productDetails['numseq_hundred_thirty_seven']; } else { $OrderItemsDetail->numseq_hundred_thirty_seven = "";}
                if ($productDetails['numseq_hundred_thirty_eight'] != ""){ $OrderItemsDetail->numseq_hundred_thirty_eight = $productDetails['numseq_hundred_thirty_eight']; } else { $OrderItemsDetail->numseq_hundred_thirty_eight = "";}
                if ($productDetails['numseq_hundred_thirty_nine'] != ""){ $OrderItemsDetail->numseq_hundred_thirty_nine = $productDetails['numseq_hundred_thirty_nine']; } else { $OrderItemsDetail->numseq_hundred_thirty_nine = "";}
                if ($productDetails['numseq_hundred_forty'] != ""){ $OrderItemsDetail->numseq_hundred_forty = $productDetails['numseq_hundred_forty']; } else { $OrderItemsDetail->numseq_hundred_forty = "";}

                if ($productDetails['numseq_hundred_forty_one'] != ""){ $OrderItemsDetail->numseq_hundred_forty_one = $productDetails['numseq_hundred_forty_one']; } else { $OrderItemsDetail->numseq_hundred_forty_one = "";}
                if ($productDetails['numseq_hundred_forty_two'] != ""){ $OrderItemsDetail->numseq_hundred_forty_two = $productDetails['numseq_hundred_forty_two']; } else { $OrderItemsDetail->numseq_hundred_forty_two = "";}
                if ($productDetails['numseq_hundred_forty_three'] != ""){ $OrderItemsDetail->numseq_hundred_forty_three = $productDetails['numseq_hundred_forty_three']; } else { $OrderItemsDetail->numseq_hundred_forty_three = "";}
                if ($productDetails['numseq_hundred_forty_four'] != ""){ $OrderItemsDetail->numseq_hundred_forty_four = $productDetails['numseq_hundred_forty_four']; } else { $OrderItemsDetail->numseq_hundred_forty_four = "";}
                if ($productDetails['numseq_hundred_forty_five'] != ""){ $OrderItemsDetail->numseq_hundred_forty_five = $productDetails['numseq_hundred_forty_five']; } else { $OrderItemsDetail->numseq_hundred_forty_five = "";}
                if ($productDetails['numseq_hundred_forty_six'] != ""){ $OrderItemsDetail->numseq_hundred_forty_six = $productDetails['numseq_hundred_forty_six']; } else { $OrderItemsDetail->numseq_hundred_forty_six = "";}
                if ($productDetails['numseq_hundred_forty_seven'] != ""){ $OrderItemsDetail->numseq_hundred_forty_seven = $productDetails['numseq_hundred_forty_seven']; } else { $OrderItemsDetail->numseq_hundred_forty_seven = "";}
                if ($productDetails['numseq_hundred_forty_eight'] != ""){ $OrderItemsDetail->numseq_hundred_forty_eight = $productDetails['numseq_hundred_forty_eight']; } else { $OrderItemsDetail->numseq_hundred_forty_eight = "";}
                if ($productDetails['numseq_hundred_forty_nine'] != ""){ $OrderItemsDetail->numseq_hundred_forty_nine = $productDetails['numseq_hundred_forty_nine']; } else { $OrderItemsDetail->numseq_hundred_forty_nine = "";}
                if ($productDetails['numseq_hundred_fifty'] != ""){ $OrderItemsDetail->numseq_hundred_fifty = $productDetails['numseq_hundred_fifty']; } else { $OrderItemsDetail->numseq_hundred_fifty = "";}
                $OrderItemsDetail->update();

                $numseqChangedValues = $OrderItemsDetail->getChanges();
                if ($editedInProductionMap[$ownerItemId] ?? false) {
                    foreach ($numseqChangedValues as $field => $newVal) {
                        if (strpos($field, 'numseq_') !== 0) {
                            continue;
                        }
                        $oldVal = $numseqOriginalValues[$field] ?? null;
                        if ($this->valuesAreEqual($oldVal, $newVal)) {
                            continue;
                        }
                        $numseqChangesByItem[$ownerItemId][$OrderItemsDetail->id][$field] = [
                            'old'     => $oldVal,
                            'new'     => $newVal,
                            'size_id' => $OrderItemsDetail->size_id,
                        ];
                    }
                }
            }

//         }


        $playerNameChangesByItem = [];
        if (isset($request->playerName)) {
            foreach($request->playerName as $playerDetails){
                $playerNameDetails = OrderItemsDetailPlayerName::where('order_items_detail_id', $playerDetails['itemId'])->first();

                if ($playerNameDetails) {
                    $playerOriginalValues = $playerNameDetails->getOriginal();
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

                    if(isset($playerDetails['player_hundred_one']) && $playerDetails['player_hundred_one'] != ""){$playerNameDetails->player_hundred_one = $playerDetails['player_hundred_one'];}else{$playerNameDetails->player_hundred_one = "";}
                    if(isset($playerDetails['player_hundred_two']) && $playerDetails['player_hundred_two'] != ""){$playerNameDetails->player_hundred_two = $playerDetails['player_hundred_two'];}else{$playerNameDetails->player_hundred_two = "";}
                    if(isset($playerDetails['player_hundred_three']) && $playerDetails['player_hundred_three'] != ""){$playerNameDetails->player_hundred_three = $playerDetails['player_hundred_three'];}else{$playerNameDetails->player_hundred_three = "";}
                    if(isset($playerDetails['player_hundred_four']) && $playerDetails['player_hundred_four'] != ""){$playerNameDetails->player_hundred_four = $playerDetails['player_hundred_four'];}else{$playerNameDetails->player_hundred_four = "";}
                    if(isset($playerDetails['player_hundred_five']) && $playerDetails['player_hundred_five'] != ""){$playerNameDetails->player_hundred_five = $playerDetails['player_hundred_five'];}else{$playerNameDetails->player_hundred_five = "";}
                    if(isset($playerDetails['player_hundred_six']) && $playerDetails['player_hundred_six'] != ""){$playerNameDetails->player_hundred_six = $playerDetails['player_hundred_six'];}else{$playerNameDetails->player_hundred_six = "";}
                    if(isset($playerDetails['player_hundred_seven']) && $playerDetails['player_hundred_seven'] != ""){$playerNameDetails->player_hundred_seven = $playerDetails['player_hundred_seven'];}else{$playerNameDetails->player_hundred_seven = "";}
                    if(isset($playerDetails['player_hundred_eight']) && $playerDetails['player_hundred_eight'] != ""){$playerNameDetails->player_hundred_eight = $playerDetails['player_hundred_eight'];}else{$playerNameDetails->player_hundred_eight = "";}
                    if(isset($playerDetails['player_hundred_nine']) && $playerDetails['player_hundred_nine'] != ""){$playerNameDetails->player_hundred_nine = $playerDetails['player_hundred_nine'];}else{$playerNameDetails->player_hundred_nine = "";}
                    if(isset($playerDetails['player_hundred_ten']) && $playerDetails['player_hundred_ten'] != ""){$playerNameDetails->player_hundred_ten = $playerDetails['player_hundred_ten'];}else{$playerNameDetails->player_hundred_ten = "";}

                    if(isset($playerDetails['player_hundred_eleven']) && $playerDetails['player_hundred_eleven'] != ""){$playerNameDetails->player_hundred_eleven = $playerDetails['player_hundred_eleven'];}else{$playerNameDetails->player_hundred_eleven = "";}
                    if(isset($playerDetails['player_hundred_twelve']) && $playerDetails['player_hundred_twelve'] != ""){$playerNameDetails->player_hundred_twelve = $playerDetails['player_hundred_twelve'];}else{$playerNameDetails->player_hundred_twelve = "";}
                    if(isset($playerDetails['player_hundred_thirteen']) && $playerDetails['player_hundred_thirteen'] != ""){$playerNameDetails->player_hundred_thirteen = $playerDetails['player_hundred_thirteen'];}else{$playerNameDetails->player_hundred_thirteen = "";}
                    if(isset($playerDetails['player_hundred_fourteen']) && $playerDetails['player_hundred_fourteen'] != ""){$playerNameDetails->player_hundred_fourteen = $playerDetails['player_hundred_fourteen'];}else{$playerNameDetails->player_hundred_fourteen = "";}
                    if(isset($playerDetails['player_hundred_fifteen']) && $playerDetails['player_hundred_fifteen'] != ""){$playerNameDetails->player_hundred_fifteen = $playerDetails['player_hundred_fifteen'];}else{$playerNameDetails->player_hundred_fifteen = "";}
                    if(isset($playerDetails['player_hundred_sixteen']) && $playerDetails['player_hundred_sixteen'] != ""){$playerNameDetails->player_hundred_sixteen = $playerDetails['player_hundred_sixteen'];}else{$playerNameDetails->player_hundred_sixteen = "";}
                    if(isset($playerDetails['player_hundred_seventeen']) && $playerDetails['player_hundred_seventeen'] != ""){$playerNameDetails->player_hundred_seventeen = $playerDetails['player_hundred_seventeen'];}else{$playerNameDetails->player_hundred_seventeen = "";}
                    if(isset($playerDetails['player_hundred_eighteen']) && $playerDetails['player_hundred_eighteen'] != ""){$playerNameDetails->player_hundred_eighteen = $playerDetails['player_hundred_eighteen'];}else{$playerNameDetails->player_hundred_eighteen = "";}
                    if(isset($playerDetails['player_hundred_nineteen']) && $playerDetails['player_hundred_nineteen'] != ""){$playerNameDetails->player_hundred_nineteen = $playerDetails['player_hundred_nineteen'];}else{$playerNameDetails->player_hundred_nineteen = "";}
                    if(isset($playerDetails['player_hundred_twenty']) && $playerDetails['player_hundred_twenty'] != ""){$playerNameDetails->player_hundred_twenty = $playerDetails['player_hundred_twenty'];}else{$playerNameDetails->player_hundred_twenty = "";}

                    if(isset($playerDetails['player_hundred_twenty_one']) && $playerDetails['player_hundred_twenty_one'] != ""){$playerNameDetails->player_hundred_twenty_one = $playerDetails['player_hundred_twenty_one'];}else{$playerNameDetails->player_hundred_twenty_one = "";}
                    if(isset($playerDetails['player_hundred_twenty_two']) && $playerDetails['player_hundred_twenty_two'] != ""){$playerNameDetails->player_hundred_twenty_two = $playerDetails['player_hundred_twenty_two'];}else{$playerNameDetails->player_hundred_twenty_two = "";}
                    if(isset($playerDetails['player_hundred_twenty_three']) && $playerDetails['player_hundred_twenty_three'] != ""){$playerNameDetails->player_hundred_twenty_three = $playerDetails['player_hundred_twenty_three'];}else{$playerNameDetails->player_hundred_twenty_three = "";}
                    if(isset($playerDetails['player_hundred_twenty_four']) && $playerDetails['player_hundred_twenty_four'] != ""){$playerNameDetails->player_hundred_twenty_four = $playerDetails['player_hundred_twenty_four'];}else{$playerNameDetails->player_hundred_twenty_four = "";}
                    if(isset($playerDetails['player_hundred_twenty_five']) && $playerDetails['player_hundred_twenty_five'] != ""){$playerNameDetails->player_hundred_twenty_five = $playerDetails['player_hundred_twenty_five'];}else{$playerNameDetails->player_hundred_twenty_five = "";}
                    if(isset($playerDetails['player_hundred_twenty_six']) && $playerDetails['player_hundred_twenty_six'] != ""){$playerNameDetails->player_hundred_twenty_six = $playerDetails['player_hundred_twenty_six'];}else{$playerNameDetails->player_hundred_twenty_six = "";}
                    if(isset($playerDetails['player_hundred_twenty_seven']) && $playerDetails['player_hundred_twenty_seven'] != ""){$playerNameDetails->player_hundred_twenty_seven = $playerDetails['player_hundred_twenty_seven'];}else{$playerNameDetails->player_hundred_twenty_seven = "";}
                    if(isset($playerDetails['player_hundred_twenty_eight']) && $playerDetails['player_hundred_twenty_eight'] != ""){$playerNameDetails->player_hundred_twenty_eight = $playerDetails['player_hundred_twenty_eight'];}else{$playerNameDetails->player_hundred_twenty_eight = "";}
                    if(isset($playerDetails['player_hundred_twenty_nine']) && $playerDetails['player_hundred_twenty_nine'] != ""){$playerNameDetails->player_hundred_twenty_nine = $playerDetails['player_hundred_twenty_nine'];}else{$playerNameDetails->player_hundred_twenty_nine = "";}
                    if(isset($playerDetails['player_hundred_thirty']) && $playerDetails['player_hundred_thirty'] != ""){$playerNameDetails->player_hundred_thirty = $playerDetails['player_hundred_thirty'];}else{$playerNameDetails->player_hundred_thirty = "";}

                    if(isset($playerDetails['player_hundred_thirty_one']) && $playerDetails['player_hundred_thirty_one'] != ""){$playerNameDetails->player_hundred_thirty_one = $playerDetails['player_hundred_thirty_one'];}else{$playerNameDetails->player_hundred_thirty_one = "";}
                    if(isset($playerDetails['player_hundred_thirty_two']) && $playerDetails['player_hundred_thirty_two'] != ""){$playerNameDetails->player_hundred_thirty_two = $playerDetails['player_hundred_thirty_two'];}else{$playerNameDetails->player_hundred_thirty_two = "";}
                    if(isset($playerDetails['player_hundred_thirty_three']) && $playerDetails['player_hundred_thirty_three'] != ""){$playerNameDetails->player_hundred_thirty_three = $playerDetails['player_hundred_thirty_three'];}else{$playerNameDetails->player_hundred_thirty_three = "";}
                    if(isset($playerDetails['player_hundred_thirty_four']) && $playerDetails['player_hundred_thirty_four'] != ""){$playerNameDetails->player_hundred_thirty_four = $playerDetails['player_hundred_thirty_four'];}else{$playerNameDetails->player_hundred_thirty_four = "";}
                    if(isset($playerDetails['player_hundred_thirty_five']) && $playerDetails['player_hundred_thirty_five'] != ""){$playerNameDetails->player_hundred_thirty_five = $playerDetails['player_hundred_thirty_five'];}else{$playerNameDetails->player_hundred_thirty_five = "";}
                    if(isset($playerDetails['player_hundred_thirty_six']) && $playerDetails['player_hundred_thirty_six'] != ""){$playerNameDetails->player_hundred_thirty_six = $playerDetails['player_hundred_thirty_six'];}else{$playerNameDetails->player_hundred_thirty_six = "";}
                    if(isset($playerDetails['player_hundred_thirty_seven']) && $playerDetails['player_hundred_thirty_seven'] != ""){$playerNameDetails->player_hundred_thirty_seven = $playerDetails['player_hundred_thirty_seven'];}else{$playerNameDetails->player_hundred_thirty_seven = "";}
                    if(isset($playerDetails['player_hundred_thirty_eight']) && $playerDetails['player_hundred_thirty_eight'] != ""){$playerNameDetails->player_hundred_thirty_eight = $playerDetails['player_hundred_thirty_eight'];}else{$playerNameDetails->player_hundred_thirty_eight = "";}
                    if(isset($playerDetails['player_hundred_thirty_nine']) && $playerDetails['player_hundred_thirty_nine'] != ""){$playerNameDetails->player_hundred_thirty_nine = $playerDetails['player_hundred_thirty_nine'];}else{$playerNameDetails->player_hundred_thirty_nine = "";}
                    if(isset($playerDetails['player_hundred_forty']) && $playerDetails['player_hundred_forty'] != ""){$playerNameDetails->player_hundred_forty = $playerDetails['player_hundred_forty'];}else{$playerNameDetails->player_hundred_forty = "";}

                    if(isset($playerDetails['player_hundred_forty_one']) && $playerDetails['player_hundred_forty_one'] != ""){$playerNameDetails->player_hundred_forty_one = $playerDetails['player_hundred_forty_one'];}else{$playerNameDetails->player_hundred_forty_one = "";}
                    if(isset($playerDetails['player_hundred_forty_two']) && $playerDetails['player_hundred_forty_two'] != ""){$playerNameDetails->player_hundred_forty_two = $playerDetails['player_hundred_forty_two'];}else{$playerNameDetails->player_hundred_forty_two = "";}
                    if(isset($playerDetails['player_hundred_forty_three']) && $playerDetails['player_hundred_forty_three'] != ""){$playerNameDetails->player_hundred_forty_three = $playerDetails['player_hundred_forty_three'];}else{$playerNameDetails->player_hundred_forty_three = "";}
                    if(isset($playerDetails['player_hundred_forty_four']) && $playerDetails['player_hundred_forty_four'] != ""){$playerNameDetails->player_hundred_forty_four = $playerDetails['player_hundred_forty_four'];}else{$playerNameDetails->player_hundred_forty_four = "";}
                    if(isset($playerDetails['player_hundred_forty_five']) && $playerDetails['player_hundred_forty_five'] != ""){$playerNameDetails->player_hundred_forty_five = $playerDetails['player_hundred_forty_five'];}else{$playerNameDetails->player_hundred_forty_five = "";}
                    if(isset($playerDetails['player_hundred_forty_six']) && $playerDetails['player_hundred_forty_six'] != ""){$playerNameDetails->player_hundred_forty_six = $playerDetails['player_hundred_forty_six'];}else{$playerNameDetails->player_hundred_forty_six = "";}
                    if(isset($playerDetails['player_hundred_forty_seven']) && $playerDetails['player_hundred_forty_seven'] != ""){$playerNameDetails->player_hundred_forty_seven = $playerDetails['player_hundred_forty_seven'];}else{$playerNameDetails->player_hundred_forty_seven = "";}
                    if(isset($playerDetails['player_hundred_forty_eight']) && $playerDetails['player_hundred_forty_eight'] != ""){$playerNameDetails->player_hundred_forty_eight = $playerDetails['player_hundred_forty_eight'];}else{$playerNameDetails->player_hundred_forty_eight = "";}
                    if(isset($playerDetails['player_hundred_forty_nine']) && $playerDetails['player_hundred_forty_nine'] != ""){$playerNameDetails->player_hundred_forty_nine = $playerDetails['player_hundred_forty_nine'];}else{$playerNameDetails->player_hundred_forty_nine = "";}
                    if(isset($playerDetails['player_hundred_fifty']) && $playerDetails['player_hundred_fifty'] != ""){$playerNameDetails->player_hundred_fifty = $playerDetails['player_hundred_fifty'];}else{$playerNameDetails->player_hundred_fifty = "";}

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

                    $playerChangedValues = $playerNameDetails->getChanges();
                    $detailId    = $playerDetails['itemId'];
                    $ownerItemId = $orderItemsDetailInfo[$detailId]['order_item_id'] ?? null;
                    $sizeIdForDetail = $orderItemsDetailInfo[$detailId]['size_id'] ?? null;

                    // Fallback: row wasn't part of the `product` submission — look it up directly
                    if ($ownerItemId === null) {
                        $detailModel = OrderItemsDetail::find($detailId);
                        if ($detailModel) {
                            $ownerItemId     = $detailModel->order_item_id;
                            $sizeIdForDetail = $detailModel->size_id;
                        }
                    }


                    if ($ownerItemId && ($editedInProductionMap[$ownerItemId] ?? false)) {
                    foreach ($playerChangedValues as $field => $newVal) {
                        // Handle the individual named-player columns (player_one, player_two, ...)
                        if (strpos($field, 'player_') === 0) {
                            $oldVal = $playerOriginalValues[$field] ?? null;
                            if ($this->valuesAreEqual($oldVal, $newVal)) {
                                continue;
                            }
                            $playerNameChangesByItem[$ownerItemId][$detailId][$field] = [
                                'old'     => $oldVal,
                                'new'     => $newVal,
                                'size_id' => $sizeIdForDetail,
                            ];
                            continue;
                        }

                        // Handle the blank/unnamed player roster, stored as a JSON array
                        if ($field === 'blank_player_names') {
                            $oldRaw = $playerOriginalValues[$field] ?? null;
                            $oldArr = json_decode($oldRaw ?? '[]', true) ?: [];
                            $newArr = json_decode($newVal ?? '[]', true) ?: [];

                            $max = max(count($oldArr), count($newArr));
                            for ($i = 0; $i < $max; $i++) {
                                $oldName = $oldArr[$i] ?? null;
                                $newName = $newArr[$i] ?? null;
                                if ($this->valuesAreEqual($oldName, $newName)) {
                                    continue;
                                }
                                $playerNameChangesByItem[$ownerItemId][$detailId]['blank_player_' . $i] = [
                                    'old'     => $oldName,
                                    'new'     => $newName,
                                    'size_id' => $sizeIdForDetail,
                                ];
                            }
                        }
                    }
                }

                } else {
                    $playerNameDetails = new OrderItemsDetailPlayerName();
                    $playerNameDetails->order_items_detail_id = $playerDetails['itemId'];
                    $playerOriginalValues = $playerNameDetails->getOriginal();
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

                    if(isset($playerDetails['player_hundred_one']) && $playerDetails['player_hundred_one'] != ""){$playerNameDetails->player_hundred_one = $playerDetails['player_hundred_one'];}else{$playerNameDetails->player_hundred_one = "";}
                    if(isset($playerDetails['player_hundred_two']) && $playerDetails['player_hundred_two'] != ""){$playerNameDetails->player_hundred_two = $playerDetails['player_hundred_two'];}else{$playerNameDetails->player_hundred_two = "";}
                    if(isset($playerDetails['player_hundred_three']) && $playerDetails['player_hundred_three'] != ""){$playerNameDetails->player_hundred_three = $playerDetails['player_hundred_three'];}else{$playerNameDetails->player_hundred_three = "";}
                    if(isset($playerDetails['player_hundred_four']) && $playerDetails['player_hundred_four'] != ""){$playerNameDetails->player_hundred_four = $playerDetails['player_hundred_four'];}else{$playerNameDetails->player_hundred_four = "";}
                    if(isset($playerDetails['player_hundred_five']) && $playerDetails['player_hundred_five'] != ""){$playerNameDetails->player_hundred_five = $playerDetails['player_hundred_five'];}else{$playerNameDetails->player_hundred_five = "";}
                    if(isset($playerDetails['player_hundred_six']) && $playerDetails['player_hundred_six'] != ""){$playerNameDetails->player_hundred_six = $playerDetails['player_hundred_six'];}else{$playerNameDetails->player_hundred_six = "";}
                    if(isset($playerDetails['player_hundred_seven']) && $playerDetails['player_hundred_seven'] != ""){$playerNameDetails->player_hundred_seven = $playerDetails['player_hundred_seven'];}else{$playerNameDetails->player_hundred_seven = "";}
                    if(isset($playerDetails['player_hundred_eight']) && $playerDetails['player_hundred_eight'] != ""){$playerNameDetails->player_hundred_eight = $playerDetails['player_hundred_eight'];}else{$playerNameDetails->player_hundred_eight = "";}
                    if(isset($playerDetails['player_hundred_nine']) && $playerDetails['player_hundred_nine'] != ""){$playerNameDetails->player_hundred_nine = $playerDetails['player_hundred_nine'];}else{$playerNameDetails->player_hundred_nine = "";}
                    if(isset($playerDetails['player_hundred_ten']) && $playerDetails['player_hundred_ten'] != ""){$playerNameDetails->player_hundred_ten = $playerDetails['player_hundred_ten'];}else{$playerNameDetails->player_hundred_ten = "";}

                    if(isset($playerDetails['player_hundred_eleven']) && $playerDetails['player_hundred_eleven'] != ""){$playerNameDetails->player_hundred_eleven = $playerDetails['player_hundred_eleven'];}else{$playerNameDetails->player_hundred_eleven = "";}
                    if(isset($playerDetails['player_hundred_twelve']) && $playerDetails['player_hundred_twelve'] != ""){$playerNameDetails->player_hundred_twelve = $playerDetails['player_hundred_twelve'];}else{$playerNameDetails->player_hundred_twelve = "";}
                    if(isset($playerDetails['player_hundred_thirteen']) && $playerDetails['player_hundred_thirteen'] != ""){$playerNameDetails->player_hundred_thirteen = $playerDetails['player_hundred_thirteen'];}else{$playerNameDetails->player_hundred_thirteen = "";}
                    if(isset($playerDetails['player_hundred_fourteen']) && $playerDetails['player_hundred_fourteen'] != ""){$playerNameDetails->player_hundred_fourteen = $playerDetails['player_hundred_fourteen'];}else{$playerNameDetails->player_hundred_fourteen = "";}
                    if(isset($playerDetails['player_hundred_fifteen']) && $playerDetails['player_hundred_fifteen'] != ""){$playerNameDetails->player_hundred_fifteen = $playerDetails['player_hundred_fifteen'];}else{$playerNameDetails->player_hundred_fifteen = "";}
                    if(isset($playerDetails['player_hundred_sixteen']) && $playerDetails['player_hundred_sixteen'] != ""){$playerNameDetails->player_hundred_sixteen = $playerDetails['player_hundred_sixteen'];}else{$playerNameDetails->player_hundred_sixteen = "";}
                    if(isset($playerDetails['player_hundred_seventeen']) && $playerDetails['player_hundred_seventeen'] != ""){$playerNameDetails->player_hundred_seventeen = $playerDetails['player_hundred_seventeen'];}else{$playerNameDetails->player_hundred_seventeen = "";}
                    if(isset($playerDetails['player_hundred_eighteen']) && $playerDetails['player_hundred_eighteen'] != ""){$playerNameDetails->player_hundred_eighteen = $playerDetails['player_hundred_eighteen'];}else{$playerNameDetails->player_hundred_eighteen = "";}
                    if(isset($playerDetails['player_hundred_nineteen']) && $playerDetails['player_hundred_nineteen'] != ""){$playerNameDetails->player_hundred_nineteen = $playerDetails['player_hundred_nineteen'];}else{$playerNameDetails->player_hundred_nineteen = "";}
                    if(isset($playerDetails['player_hundred_twenty']) && $playerDetails['player_hundred_twenty'] != ""){$playerNameDetails->player_hundred_twenty = $playerDetails['player_hundred_twenty'];}else{$playerNameDetails->player_hundred_twenty = "";}

                    if(isset($playerDetails['player_hundred_twenty_one']) && $playerDetails['player_hundred_twenty_one'] != ""){$playerNameDetails->player_hundred_twenty_one = $playerDetails['player_hundred_twenty_one'];}else{$playerNameDetails->player_hundred_twenty_one = "";}
                    if(isset($playerDetails['player_hundred_twenty_two']) && $playerDetails['player_hundred_twenty_two'] != ""){$playerNameDetails->player_hundred_twenty_two = $playerDetails['player_hundred_twenty_two'];}else{$playerNameDetails->player_hundred_twenty_two = "";}
                    if(isset($playerDetails['player_hundred_twenty_three']) && $playerDetails['player_hundred_twenty_three'] != ""){$playerNameDetails->player_hundred_twenty_three = $playerDetails['player_hundred_twenty_three'];}else{$playerNameDetails->player_hundred_twenty_three = "";}
                    if(isset($playerDetails['player_hundred_twenty_four']) && $playerDetails['player_hundred_twenty_four'] != ""){$playerNameDetails->player_hundred_twenty_four = $playerDetails['player_hundred_twenty_four'];}else{$playerNameDetails->player_hundred_twenty_four = "";}
                    if(isset($playerDetails['player_hundred_twenty_five']) && $playerDetails['player_hundred_twenty_five'] != ""){$playerNameDetails->player_hundred_twenty_five = $playerDetails['player_hundred_twenty_five'];}else{$playerNameDetails->player_hundred_twenty_five = "";}
                    if(isset($playerDetails['player_hundred_twenty_six']) && $playerDetails['player_hundred_twenty_six'] != ""){$playerNameDetails->player_hundred_twenty_six = $playerDetails['player_hundred_twenty_six'];}else{$playerNameDetails->player_hundred_twenty_six = "";}
                    if(isset($playerDetails['player_hundred_twenty_seven']) && $playerDetails['player_hundred_twenty_seven'] != ""){$playerNameDetails->player_hundred_twenty_seven = $playerDetails['player_hundred_twenty_seven'];}else{$playerNameDetails->player_hundred_twenty_seven = "";}
                    if(isset($playerDetails['player_hundred_twenty_eight']) && $playerDetails['player_hundred_twenty_eight'] != ""){$playerNameDetails->player_hundred_twenty_eight = $playerDetails['player_hundred_twenty_eight'];}else{$playerNameDetails->player_hundred_twenty_eight = "";}
                    if(isset($playerDetails['player_hundred_twenty_nine']) && $playerDetails['player_hundred_twenty_nine'] != ""){$playerNameDetails->player_hundred_twenty_nine = $playerDetails['player_hundred_twenty_nine'];}else{$playerNameDetails->player_hundred_twenty_nine = "";}
                    if(isset($playerDetails['player_hundred_thirty']) && $playerDetails['player_hundred_thirty'] != ""){$playerNameDetails->player_hundred_thirty = $playerDetails['player_hundred_thirty'];}else{$playerNameDetails->player_hundred_thirty = "";}

                    if(isset($playerDetails['player_hundred_thirty_one']) && $playerDetails['player_hundred_thirty_one'] != ""){$playerNameDetails->player_hundred_thirty_one = $playerDetails['player_hundred_thirty_one'];}else{$playerNameDetails->player_hundred_thirty_one = "";}
                    if(isset($playerDetails['player_hundred_thirty_two']) && $playerDetails['player_hundred_thirty_two'] != ""){$playerNameDetails->player_hundred_thirty_two = $playerDetails['player_hundred_thirty_two'];}else{$playerNameDetails->player_hundred_thirty_two = "";}
                    if(isset($playerDetails['player_hundred_thirty_three']) && $playerDetails['player_hundred_thirty_three'] != ""){$playerNameDetails->player_hundred_thirty_three = $playerDetails['player_hundred_thirty_three'];}else{$playerNameDetails->player_hundred_thirty_three = "";}
                    if(isset($playerDetails['player_hundred_thirty_four']) && $playerDetails['player_hundred_thirty_four'] != ""){$playerNameDetails->player_hundred_thirty_four = $playerDetails['player_hundred_thirty_four'];}else{$playerNameDetails->player_hundred_thirty_four = "";}
                    if(isset($playerDetails['player_hundred_thirty_five']) && $playerDetails['player_hundred_thirty_five'] != ""){$playerNameDetails->player_hundred_thirty_five = $playerDetails['player_hundred_thirty_five'];}else{$playerNameDetails->player_hundred_thirty_five = "";}
                    if(isset($playerDetails['player_hundred_thirty_six']) && $playerDetails['player_hundred_thirty_six'] != ""){$playerNameDetails->player_hundred_thirty_six = $playerDetails['player_hundred_thirty_six'];}else{$playerNameDetails->player_hundred_thirty_six = "";}
                    if(isset($playerDetails['player_hundred_thirty_seven']) && $playerDetails['player_hundred_thirty_seven'] != ""){$playerNameDetails->player_hundred_thirty_seven = $playerDetails['player_hundred_thirty_seven'];}else{$playerNameDetails->player_hundred_thirty_seven = "";}
                    if(isset($playerDetails['player_hundred_thirty_eight']) && $playerDetails['player_hundred_thirty_eight'] != ""){$playerNameDetails->player_hundred_thirty_eight = $playerDetails['player_hundred_thirty_eight'];}else{$playerNameDetails->player_hundred_thirty_eight = "";}
                    if(isset($playerDetails['player_hundred_thirty_nine']) && $playerDetails['player_hundred_thirty_nine'] != ""){$playerNameDetails->player_hundred_thirty_nine = $playerDetails['player_hundred_thirty_nine'];}else{$playerNameDetails->player_hundred_thirty_nine = "";}
                    if(isset($playerDetails['player_hundred_forty']) && $playerDetails['player_hundred_forty'] != ""){$playerNameDetails->player_hundred_forty = $playerDetails['player_hundred_forty'];}else{$playerNameDetails->player_hundred_forty = "";}

                    if(isset($playerDetails['player_hundred_forty_one']) && $playerDetails['player_hundred_forty_one'] != ""){$playerNameDetails->player_hundred_forty_one = $playerDetails['player_hundred_forty_one'];}else{$playerNameDetails->player_hundred_forty_one = "";}
                    if(isset($playerDetails['player_hundred_forty_two']) && $playerDetails['player_hundred_forty_two'] != ""){$playerNameDetails->player_hundred_forty_two = $playerDetails['player_hundred_forty_two'];}else{$playerNameDetails->player_hundred_forty_two = "";}
                    if(isset($playerDetails['player_hundred_forty_three']) && $playerDetails['player_hundred_forty_three'] != ""){$playerNameDetails->player_hundred_forty_three = $playerDetails['player_hundred_forty_three'];}else{$playerNameDetails->player_hundred_forty_three = "";}
                    if(isset($playerDetails['player_hundred_forty_four']) && $playerDetails['player_hundred_forty_four'] != ""){$playerNameDetails->player_hundred_forty_four = $playerDetails['player_hundred_forty_four'];}else{$playerNameDetails->player_hundred_forty_four = "";}
                    if(isset($playerDetails['player_hundred_forty_five']) && $playerDetails['player_hundred_forty_five'] != ""){$playerNameDetails->player_hundred_forty_five = $playerDetails['player_hundred_forty_five'];}else{$playerNameDetails->player_hundred_forty_five = "";}
                    if(isset($playerDetails['player_hundred_forty_six']) && $playerDetails['player_hundred_forty_six'] != ""){$playerNameDetails->player_hundred_forty_six = $playerDetails['player_hundred_forty_six'];}else{$playerNameDetails->player_hundred_forty_six = "";}
                    if(isset($playerDetails['player_hundred_forty_seven']) && $playerDetails['player_hundred_forty_seven'] != ""){$playerNameDetails->player_hundred_forty_seven = $playerDetails['player_hundred_forty_seven'];}else{$playerNameDetails->player_hundred_forty_seven = "";}
                    if(isset($playerDetails['player_hundred_forty_eight']) && $playerDetails['player_hundred_forty_eight'] != ""){$playerNameDetails->player_hundred_forty_eight = $playerDetails['player_hundred_forty_eight'];}else{$playerNameDetails->player_hundred_forty_eight = "";}
                    if(isset($playerDetails['player_hundred_forty_nine']) && $playerDetails['player_hundred_forty_nine'] != ""){$playerNameDetails->player_hundred_forty_nine = $playerDetails['player_hundred_forty_nine'];}else{$playerNameDetails->player_hundred_forty_nine = "";}
                    if(isset($playerDetails['player_hundred_fifty']) && $playerDetails['player_hundred_fifty'] != ""){$playerNameDetails->player_hundred_fifty = $playerDetails['player_hundred_fifty'];}else{$playerNameDetails->player_hundred_fifty = "";}

                    if(isset($blankProductArray[$playerDetails['itemId']]) && $blankProductArray[$playerDetails['itemId']] > 0){ $playerNameDetails->blank_qty = $blankProductArray[$playerDetails['itemId']];}else{$playerNameDetails->blank_qty = 0;}
                    if(isset($playerDetails['blank_players'])){ $playerNameDetails->blank_player_names = json_encode($playerDetails['blank_players']);}else{$playerNameDetails->blank_player_names = "";}

                    $playerNameDetails->save();


                    $playerChangedValues = $playerNameDetails->getChanges();
                    $detailId    = $playerDetails['itemId'];
                    $ownerItemId = $orderItemsDetailInfo[$detailId]['order_item_id'] ?? null;
                    $sizeIdForDetail = $orderItemsDetailInfo[$detailId]['size_id'] ?? null;

                    // Fallback: row wasn't part of the `product` submission — look it up directly
                    if ($ownerItemId === null) {
                        $detailModel = OrderItemsDetail::find($detailId);
                        if ($detailModel) {
                            $ownerItemId     = $detailModel->order_item_id;
                            $sizeIdForDetail = $detailModel->size_id;
                        }
                    }



                    if ($ownerItemId && ($editedInProductionMap[$ownerItemId] ?? false)) {
                        foreach ($playerChangedValues as $field => $newVal) {
                            // Handle the individual named-player columns (player_one, player_two, ...)
                            if (strpos($field, 'player_') === 0) {
                                $oldVal = $playerOriginalValues[$field] ?? null;
                                if ($this->valuesAreEqual($oldVal, $newVal)) {
                                    continue;
                                }
                                $playerNameChangesByItem[$ownerItemId][$detailId][$field] = [
                                    'old'     => $oldVal,
                                    'new'     => $newVal,
                                    'size_id' => $sizeIdForDetail,
                                ];
                                continue;
                            }

                            // Handle the blank/unnamed player roster, stored as a JSON array
                            if ($field === 'blank_player_names') {
                                $oldRaw = $playerOriginalValues[$field] ?? null;
                                $oldArr = json_decode($oldRaw ?? '[]', true) ?: [];
                                $newArr = json_decode($newVal ?? '[]', true) ?: [];

                                $max = max(count($oldArr), count($newArr));
                                for ($i = 0; $i < $max; $i++) {
                                    $oldName = $oldArr[$i] ?? null;
                                    $newName = $newArr[$i] ?? null;
                                    if ($this->valuesAreEqual($oldName, $newName)) {
                                        continue;
                                    }
                                    $playerNameChangesByItem[$ownerItemId][$detailId]['blank_player_' . $i] = [
                                        'old'     => $oldName,
                                        'new'     => $newName,
                                        'size_id' => $sizeIdForDetail,
                                    ];
                                }
                            }
                        }
                    }

                }

            }


            if (isset($request->notify_changes)) {
                foreach ($itemSnapshots as $orderItemId => $snapshot) {
                    $this->notifyFactoryOfChanges(
                        $snapshot['item'],
                        $snapshot['changed'],
                        $snapshot['orig'],
                        $sizeQtyChangesByItem[$orderItemId] ?? [],
                        $request->notify_changes,
                        $request->item_is_urgent,
                        $playerNameChangesByItem[$orderItemId] ?? [],
                        $numseqChangesByItem[$orderItemId] ?? []
                    );

                    $this->notifyEditsFactoryUsers(
                        $snapshot['item'],
                        $snapshot['changed'],
                        $snapshot['orig'],
                        $sizeQtyChangesByItem[$orderItemId] ?? [],
                        $request->notify_changes,
                        $request->item_is_urgent,
                        $playerNameChangesByItem[$orderItemId] ?? [],
                        $numseqChangesByItem[$orderItemId] ?? []
                    );
                }
            }

        }

        // For email Notifications
//         foreach($request->orderItem as $orderItems){
//             $orderItem = OrderItem::find($orderItems['orderItemId']);
//             if($orderItem->order_status_id == 1 && $orderItems['order_status_id'] == 3){
//                 $this->notifyFactoryUsers($orderItem);
//             } elseif ($orderItem->order_status_id == 3){
//                 if(isset($request->notify_changes)){
//                     $this->notifyEditsFactoryUsers($orderItem, $request->notify_changes);
//                 }
//             }
//         }

        if(isset($request->saveLeave))
        {
            if($request->saveLeave == "yes")
            {
                return "DoneAjaxPost";
            }
        }

        $this->setShippingFee($request->order_id);

        //return $insertPlayerNameArray;
        $order_update = Order::find($request->order_id);

        $subtotal = $order_update->sub_total;
        $orderSalesTax = $order_update->sales_tax ?? 0.00;

        $organization = Organization::find($order_update->organization_id);
        if ($organization->sales_tax_active == 1) {
            $salesTax = $organization->sales_tax;
        } else {
            $salesTax = 0;
        }

        $orderShipping = $order_update->shipping ?? 0.00;
        $orderArtwork = $order_update->artwork ?? 0.00;

        $order_total_amount = $subtotal + $orderArtwork;

        $discountAmount = 0.00; // ALWAYS initialize first

        if ($order_update->discount_hidation == 1) {

            if ($order_update->discountType == 1) {
                $discountAmount = ($order_total_amount / 100) * ($order_update->discount ?? 0);

            } elseif ($order_update->discountType == 2) {
                $discountAmount = $order_update->discount ?? 0;
            }
        }

        $taxableAmount = max(0, $order_total_amount - $discountAmount);

        $orderSalesTax = ($taxableAmount / 100) * ($salesTax ?? 0);

        $order_update->sub_total = $subtotal;
        $order_update->order_total = $order_total_amount + $orderSalesTax - $discountAmount + $orderShipping;
        $order_update->sales_tax = $orderSalesTax;
        $order_update->save();

        AccountsLog::where('order_id', $order_update->id)->where('type', 0)->where('status', 1)->where('note', 'Outstanding Invoice')->update(
            [
                'amount' => $order_update->order_total,
                'debit_balance' => $order_update->order_total,
            ]
        );

        return back()->withSuccess('Order Updated Successfully!');
    }

    private function valuesAreEqual($old, $new): bool
    {
        if ($old === null && $new === null) {
            return true;
        }
        if (is_numeric($old) && is_numeric($new)) {
            // avoids bcmath dependency — safe float comparison
            return abs((float) $old - (float) $new) < 0.0001;
        }
        return (string) $old === (string) $new;
    }

    public function notifyFactoryOfChanges(
        OrderItem $orderItem,
        array $itemChangedValues  = [],
        array $itemOriginalValues = [],
        array $sizeQtyChanges     = [],
        $notifyChanges = null,
        $isUrgent = 0,
        array $playerNameChanges  = [],
        array $numseqChanges      = []
    ) {
        $order = Order::find($orderItem->order_id);
        if (!$order) {
            return;
        }

        $productName = $orderItem->productDetails->product_name ?? '';
        $changes     = [];

        // ---------------------------------------------------------------
        // 1. Top-level OrderItem field changes — numeric-safe comparison
        // ---------------------------------------------------------------
        $whitelist = [
            'sub_product_no'        => 'Style Name',
            'display_name'          => 'Display Name',
            'fabric_id'              => 'Fabric',
            'secondary_fabric_id'    => 'Second Fabric',
            'embellishment_type_id'  => 'Embellishment',
            'clouser_type'           => 'Clouser Type',
            'ex_factory_date'        => 'Ex Factory Date',
            'in_hand_due_date'       => 'In Hand Due Date',
            'est_delivery_date'      => 'Est Delivery Date',
            'factory_id'             => 'Factory',
            'ex_factory_id'          => 'Ex-Factory Address',
            'order_status_id'        => 'Item Status',
            'unit_price'             => 'Unit Price',
            'tracking_no'            => 'Tracking No',
            'tracking_link'          => 'Tracking Link',
            'item_description'       => 'Item Description',
            'is_urgent'              => 'Urgent Status',
            'test_print_needed'      => 'Test Print Needed',
            'test_print_due_date'    => 'Test Print Due Date',
            'individual_no'          => 'Individual Number',
            'individual_name'        => 'Individual Name',
            'double_sided'           => 'Reversible',
            'pockets'                => 'Pockets',
            'zipper_pockets'         => 'Zipper Pockets',
            'contrast_stratching'    => 'Contrast Stitching',
            'printing_over_sems'     => 'Printing Over Seams',
            'dynamic_details'        => 'Dynamic Details',
        ];

        foreach ($itemChangedValues as $field => $newValue) {
            if (!isset($whitelist[$field])) {
                continue;
            }
            $oldValue = $itemOriginalValues[$field] ?? null;

            if ($this->valuesAreEqual($oldValue, $newValue)) {
                continue; // formatting-only diff, e.g. "45" vs "45.00"
            }

            $changes[$field] = [
                'label'    => $whitelist[$field],
                'previous' => $this->resolveNotificationFieldValue($field, $oldValue),
                'current'  => $this->resolveNotificationFieldValue($field, $newValue),
            ];
        }

        foreach ($numseqChanges as $detailId => $fields) {
            foreach ($fields as $field => $diff) {
                if ($this->valuesAreEqual($diff['old'] ?? null, $diff['new'] ?? null)) {
                    continue;
                }

                $sizeName = optional(\App\Models\Size::find($diff['size_id'] ?? null))->size_name;
                $seqNo    = $this->wordSuffixToNumber(str_replace('numseq_', '', $field));
                $label    = trim(($sizeName ? $sizeName . ' - ' : '') . 'Number #' . ($seqNo ?? ''));

                $changes['numseq_' . $detailId . '_' . $field] = [
                    'label'    => $label,
                    'previous' => ($diff['old'] ?? '') !== '' ? $diff['old'] : '-',
                    'current'  => ($diff['new'] ?? '') !== '' ? $diff['new'] : '-',
                ];
            }
        }


        foreach ($sizeQtyChanges as $detailId => $diff) {
            if ($this->valuesAreEqual($diff['old'] ?? null, $diff['new'] ?? null)) {
                continue;
            }

            $sizeName = optional(\App\Models\Size::find($diff['size_id'] ?? null))->size_name ?? 'Unknown Size';

            $changes['size_qty_' . $detailId] = [
                'label'    => $sizeName,
                'previous' => ($diff['old'] ?? '') !== '' ? $diff['old'] : '-',
                'current'  => $diff['new'] ?? '-',
            ];
        }

        foreach ($playerNameChanges as $detailId => $fields) {
            foreach ($fields as $field => $diff) {
                if ($this->valuesAreEqual($diff['old'] ?? null, $diff['new'] ?? null)) {
                    continue;
                }

                $sizeName = optional(\App\Models\Size::find($diff['size_id'] ?? null))->size_name;

                if (strpos($field, 'blank_player_') === 0) {
                    $playerNo = ((int) str_replace('blank_player_', '', $field)) + 1;
                    $label    = trim(($sizeName ? $sizeName . ' - ' : '') . 'Blank Player ' . $playerNo);
                } else {
                    $playerNo = $this->wordSuffixToNumber(str_replace('player_', '', $field));
                    $label    = trim(($sizeName ? $sizeName . ' - ' : '') . 'Player ' . ($playerNo ?? ''));
                }

                $changes['player_' . $detailId . '_' . $field] = [
                    'label'    => $label,
                    'previous' => ($diff['old'] ?? '') !== '' && $diff['old'] !== null ? $diff['old'] : '-',
                    'current'  => ($diff['new'] ?? '') !== '' && $diff['new'] !== null ? $diff['new'] : '-',
                ];
            }
        }


        if ($notifyChanges) {
            $fieldMap = [
                'styleName'           => 'sub_product_no',
                'fabric'               => 'fabric_id',
                'secondary_fabric'     => 'secondary_fabric_id',
                'estabilishment'       => 'embellishment_type_id',
                'clouser_type'         => 'clouser_type',
                'ex_factory_date'      => 'ex_factory_date',
                'in_hand_by'           => 'in_hand_due_date',
                'factory'              => 'factory_id',
                'ex_factory_id'        => 'ex_factory_id',
                'order_status_id'      => 'order_status_id',
                'unitprice'            => 'unit_price',
                'tracking_no'          => 'tracking_no',
                'tracking_link'        => 'tracking_link',
                'double_sided'         => 'double_sided',
                'individual_no'        => 'individual_no',
                'individual_name'      => 'individual_name',
                'pockets'              => 'pockets',
                'zipper_pockets'       => 'zipper_pockets',
                'contrast_stratching'  => 'contrast_stratching',
                'printing_over_sems'   => 'printing_over_sems',
                'dynamic_details'      => 'dynamic_details',
            ];

            foreach (explode(',', $notifyChanges) as $field) {
                $field = trim($field);
                if ($field === '') {
                    continue;
                }

                $auditKey = isset($fieldMap[$field]) ? $fieldMap[$field] : $field;
                if (isset($changes[$auditKey])) {
                    continue;
                }

                $label = null;
                if (Str::contains($field, 'mock_up_images'))                    { $label = 'Mock Up Images'; }
                elseif (Str::contains($field, 'teck_pack_files'))               { $label = 'Tech Pack Files'; }
                elseif (Str::contains($field, 'teck_pack_images'))              { $label = 'Tech Pack Images'; }
                elseif (Str::contains($field, 'production_layout_images'))      { $label = 'Production Layout Images'; }
                elseif (Str::contains($field, 'test_print_images'))             { $label = 'Test Print Images'; }
                elseif (Str::contains($field, 'product_picture_raw_images'))    { $label = 'Raw Photos'; }
                elseif (Str::contains($field, 'product_picture_edited_images')) { $label = 'Edited Photos'; }


                if ($label) {
                    $changes[$field] = [
                        'label'    => $label,
                        'previous' => '-',
                        'current'  => 'Updated',
                    ];
                }
            }
        }

        if (empty($changes)) {
            return; // nothing actually changed
        }

        // ---------------------------------------------------------------
        // Build HTML change rows
        // ---------------------------------------------------------------
        $changesRowsHtml = '';
        $totalChanges    = count($changes);
        $idx             = 0;
        foreach ($changes as $change) {
            $idx++;
            $border = ($idx === $totalChanges) ? '' : ' border-bottom:1px solid #f0f0f0;';
            $changesRowsHtml .= '<tr>';
            $changesRowsHtml .= '<td style="padding:12px 16px; font-size:13px; color:#374151;' . $border . '">' . e($change['label'])    . '</td>';
            $changesRowsHtml .= '<td style="padding:12px 16px; font-size:13px; color:#9ca3af;'  . $border . '">' . e($change['previous']) . '</td>';
            $changesRowsHtml .= '<td style="padding:12px 16px; font-size:13px; color:#111827; font-weight:700;' . $border . '">' . e($change['current']) . '</td>';
            $changesRowsHtml .= '</tr>';
        }

        $urgentBadgeHtml = '';
        if ($isUrgent == 1) {
            $urgentBadgeHtml =
                '<span style="display:inline-flex;align-items:center;gap:5px;color:#dc2626;font-size:12px;font-weight:700;letter-spacing:.3px;margin-left:4px;background-color:#FFEDEE;border-radius:10px;padding:5px;margin-top:20px;">' .
                '<span style="width:7px;height:7px;border-radius:50%;background:#dc2626;display:inline-block;flex-shrink:0;"></span>' .
                'Urgent order</span>';
        }

        $builder = new NotificationBuilderService();
        $builder->sendNotification('key_order_item_edited', [
            '{order_no}'      => $order->order_no,
            '{order_link}'    => url("order_details/edit/{$order->id}/order") . '?active_tab=order',
            '{urgent_badge}'  => $urgentBadgeHtml,
            '{team_name}'     => optional($order->organizationDetails)->organization_name ?? '',
            '{item_name}'     => $productName,
            '{edited_by_pic}' => Auth::user()->profile_pic_url,
            '{edited_by}'     => Auth::user()->name,
            '{edited_date}'   => Carbon::now()->format('F d, Y'),
            '{changes_rows}'  => $changesRowsHtml,
        ], [
            'order_id'                  => $order->id,
            'order_item_id'             => $orderItem->id,
            'target_notification_field' => 'key_order_item_edited',
            'new_notification'          => 1,
            'is_order_edit'             => 1,
        ]);
    }

    private function resolveNotificationFieldValue($key, $value)
    {
        if ($value === null || $value === '') {
            return '-';
        }

        switch ($key) {
            case 'fabric_id':
            case 'secondary_fabric_id':
                return optional(\App\Models\Fabric::find($value))->fabric_name ?? $value;
            case 'embellishment_type_id':
                return optional(\App\Models\EmbellishmentType::find($value))->embellishment_name ?? $value;
            case 'factory_id':
                return optional(\App\Models\Factory::find($value))->factory_name ?? $value;
            case 'ex_factory_id':
                return optional(\App\Models\ExFactory::find($value))->ex_factory_name ?? $value;
            case 'order_status_id':
                return optional(\App\Models\OrderStatus::find($value))->status_name ?? $value;
            case 'clouser_type':
                return optional(\App\Models\ClouserType::find($value))->clouser_name ?? $value;
            case 'sub_product_no':
                return optional(\App\Models\SubProduct::where('sub_product_no', $value)->first())->product_name ?? $value;
            case 'unit_price':
                return number_format((float) $value, 2);
            case 'is_urgent':
            case 'test_print_needed':
            case 'individual_no':
            case 'individual_name':
            case 'double_sided':
            case 'pockets':
            case 'zipper_pockets':
            case 'contrast_stratching':
            case 'printing_over_sems':
            case 'dynamic_details':
                return $value ? 'Yes' : 'No';
            default:
                return $value;
        }
    }

    private function wordSuffixToNumber(string $words): ?int
    {
        $units = [
            'one' => 1, 'two' => 2, 'three' => 3, 'four' => 4, 'five' => 5,
            'six' => 6, 'seven' => 7, 'eight' => 8, 'nine' => 9, 'ten' => 10,
            'eleven' => 11, 'twelve' => 12, 'thirteen' => 13, 'fourteen' => 14,
            'fifteen' => 15, 'sixteen' => 16, 'seventeen' => 17, 'eighteen' => 18,
            'nineteen' => 19,
        ];
        $tens = [
            'twenty' => 20, 'thirty' => 30, 'forty' => 40, 'fifty' => 50,
            'sixty' => 60, 'seventy' => 70, 'eighty' => 80, 'ninety' => 90,
        ];

        $parts = explode('_', strtolower(trim($words)));
        $i = 0;
        $total = 0;

        if (isset($parts[$i]) && $parts[$i] === 'hundred') {
            $total += 100;
            $i++;
        }

        if (isset($parts[$i])) {
            if (isset($tens[$parts[$i]])) {
                $total += $tens[$parts[$i]];
                $i++;
                if (isset($parts[$i]) && isset($units[$parts[$i]])) {
                    $total += $units[$parts[$i]];
                }
            } elseif (isset($units[$parts[$i]])) {
                $total += $units[$parts[$i]];
            }
        }

        return $total > 0 ? $total : null;
    }



    public function NotifyFactory($orderId, $orderItemId, $test_print_due_date)
    {
        $orderItem = OrderItem::find($orderItemId);
        $subProduct = SubProduct::find($orderItem->product_id);


        $order = Order::with('organizationDetails')->find($orderId);
        if (!$order) {
            return;
        }

        $key = explode('-', $orderItem->item_no)[1] ?? null;
        $key = $key !== null ? ((int) $key - 1) : 0;

        $itemLink = url('order_details/item/view/' . $orderId . '/' . $orderItemId);

        $itemRowsHtml = '<div style="display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-bottom:1px solid #f3f4f6;font-size:13px;background: #f9fafb">
            <span style="display:flex;align-items:center;gap:8px;color:#111827">
                <span style="width:6px;height:6px;border-radius:50%;background:#0d9488;flex-shrink:0"></span>
                ' . e(optional($orderItem)->display_name) . '
                <a href="' . $itemLink . '" style="color:#9ca3af;text-decoration:none;font-size:12px" target="_blank"><i class="fas fa-external-link-alt"></i></a>
            </span>
            <span style="color:#6b7280">Pattern Code: <strong style="color:#111827">' . e(optional($subProduct)->pattern_code ?: 'Not available') . '</strong></span>
        </div>';

        $test_print = OrderItemFile::whereNotNull('tech_pack_images')
            ->where('order_item_id', $orderItemId)
            ->pluck('tech_pack_images')
            ->toArray();

        $techPackUrl = !empty($test_print) ? route('DownloadTestPrint', ['id' => $orderItemId]) : '#';
        $discussionLink = route('orders.info', ['id' => $orderId, 'type' => 'management']);
        $rosterLink     = url('orders/csv/' . $order->id);

        $orderLink = url('order_details/edit/' . $order->id . '/order') . '?active_tab=order';

        $builder = new NotificationBuilderService();

        $builder->sendNotification(
            'key_test_print_request',
            [
                '{order_no}'             => $order->order_no,
                '{order_link}'           => $orderLink,
                '{test_print_due_date}'  => $test_print_due_date,
                '{organization_name}'    => optional($order->organizationDetails)->organization_name ?? '',
                '{tech_pack_url}'        => $techPackUrl,
                '{roster_url}'           => $rosterLink,
                '{discussion_url}'       => $discussionLink,
                '{order_description}'    => $order->order_description ?? '',
                '{item_rows}'            => $itemRowsHtml,
            ],
            [
                'order_id'                   => $order->id,
                'order_item_id'              => $orderItemId,
                'target_notification_field'  => 'key_test_print_request',
                'new_notification'           => 1,
            ]
        );
    }






    public function DownloadTestPrint($ids)
    {
        if (!is_array($ids)) {
            $ids = explode(',', $ids);
        }

        // Temporary folder for all files
        $techPackFolder = sys_get_temp_dir() . '/Tech_Pack_Files_' . uniqid();
        mkdir($techPackFolder, 0777, true);

        foreach ($ids as $id) {
            $tech_pack = OrderItemFile::whereNotNull('tech_pack_files')
                ->where('order_item_id', $id)
                ->pluck('tech_pack_files')
                ->toArray();

            $unique_order_item = OrderItem::find($id);
            $sub_product_unique = SubProduct::where('sub_product_no', $unique_order_item->sub_product_no)->first();

            $sub_product_cleaned = preg_replace('/[^a-zA-Z0-9]/', '_', $sub_product_unique->product_name);

            $tempDir = $techPackFolder . '/' . $id . '_' . $sub_product_cleaned;
            mkdir($tempDir, 0777, true);

            foreach ($tech_pack as $index => $imageUrl) {
                $img_num = $index + 1;
                $filename = $tempDir . '/tech_pack_file_' . $img_num . '.pdf';

                // --- Encode only the basename of the URL ---
                $parsed = parse_url($imageUrl);
                $pathParts = pathinfo($parsed['path']);
                $encodedPath = $pathParts['dirname'] . '/' . rawurlencode($pathParts['basename']);

                $encodedUrl = $parsed['scheme'] . '://' . $parsed['host'] . $encodedPath;
                if (isset($parsed['query'])) {
                    $encodedUrl .= '?' . $parsed['query'];
                }

                // Try direct copy first
                if (!@copy($encodedUrl, $filename)) {
                    // Fallback: use cURL
                    $ch = curl_init($encodedUrl);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0'); // some servers need UA
                    $data = curl_exec($ch);
                    if ($data === false) {
                        error_log('Failed to download image (cURL): ' . $encodedUrl . ' | Error: ' . curl_error($ch));
                    } else {
                        file_put_contents($filename, $data);
                    }
                    curl_close($ch);
                }
            }
        }

        // --- Create ZIP ---
        $zipFile = $techPackFolder . '.zip';
        $zip = new \ZipArchive;
        if ($zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return response()->json(['error' => 'Failed to create zip archive'], 500);
        }

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($techPackFolder),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($techPackFolder) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();

        // Return as download and delete after sending
        return response()->download($zipFile)->deleteFileAfterSend(true);
    }

    // public function DownloadTestPrint($ids) {
    //     if (!is_array($ids)) {
    //         $ids = explode(',', $ids);
    //     }

    //     $techPackFolder = sys_get_temp_dir() . '/Tech Pack Files'. uniqid();
    //     mkdir($techPackFolder, 0777, true);

    //     foreach ($ids as $id) {
    //         $tech_pack = OrderItemFile::whereNotNull('tech_pack_images')
    //             ->where('order_item_id', $id)
    //             ->pluck('tech_pack_images')
    //             ->toArray();

    //         $unique_order_item = OrderItem::find($id);
    //         $sub_product_unique = SubProduct::where('sub_product_no', $unique_order_item->sub_product_no)->first();

    //         $sub_product_cleaned = preg_replace('/[^a-zA-Z0-9]/', '_', $sub_product_unique->product_name);

    //         $tempDir = $techPackFolder . '/' . $id . '_' . $sub_product_cleaned;
    //         mkdir($tempDir, 0777, true);

    //         foreach ($tech_pack as $index => $imageUrl) {
    //             $img_num = $index + 1;
    //             $filename = $tempDir . '/tech_pack_image_' . $img_num . '.jpg';
    //             if (!copy($imageUrl, $filename)) {
    //                 error_log('Failed to download image: ' . $imageUrl);
    //             }
    //         }
    //     }

    //     $zipFile = $techPackFolder . '.zip';
    //     $zip = new ZipArchive;
    //     if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
    //         return response()->json(['error' => 'Failed to create zip archive'], 500);
    //     }

    //     $files = new RecursiveIteratorIterator(
    //         new RecursiveDirectoryIterator($techPackFolder),
    //         RecursiveIteratorIterator::LEAVES_ONLY
    //     );

    //     foreach ($files as $name => $file) {
    //         if (!$file->isDir()) {
    //             $filePath = $file->getRealPath();
    //             $relativePath = substr($filePath, strlen($techPackFolder) + 1);
    //             $zip->addFile($filePath, $relativePath);
    //         }
    //     }
    //     $zip->close();

    //     return response()->download($zipFile)->deleteFileAfterSend(true);
    // }





    public function addQuotaion($id){
        $OrderItemsDetail = Order:: find($id);
        $OrderItemsDetail->order_status_id = 2;
        $OrderItemsDetail->update();

        return redirect()->route('order_details');
    }

    public function acceptRequest($id){
        $order = Order::find($id);
        $order->is_editable = 1;
        $order->is_requested = 0;
        $order->update();

        return redirect()->back()->withSuccess('Request Accepted Successfully!');
    }

    public function mentionUsers(Request $request){
        $userArray = array_map('intval', explode(',', $request->mentioned_users));

        if(isset($request->mentioned_groups)){
            $groupArray = array_map('intval', explode(',', $request->mentioned_groups));
                $userIds =  User::whereHas("roles", function($q) use($groupArray) {
                                    $q->whereIn("id", $groupArray);
                                })->whereNotIn('id', [Auth::user()->id])->where('active', 1)->get()->pluck('id');

                foreach($userIds as $user){
                    array_push($userArray, $user);
                }
        }

        foreach(array_unique($userArray) as $user){
            $order = Order::find($request->order_id);

            if($user != 0 && Auth::user()->id != $user){
                $notification = new Notification();
                $notification->notification_title = 'New Comment - Order #'.$order->order_no;
                $notification->notification_message = Auth::user()->name.' created a new comment';
                $notification->is_read = 0;
                $notification->user_id = $user;
                $notification->order_id = $request->order_id;
                $notification->is_comment = 1;
                $notification->task_id = $request->discussion_id;
                $notification->task_name = $request->discussion_title;
                $notification->task_comments = $request->comments;
                $notification->comment_mention_id = $request->comment_mention_id;
                $notification->save();
            }
        }

        return json_encode('Notification Created Successfully!');
    }

    public function printOrderItem($id){
        $orderItem = OrderItem::with('productDetails', 'factoryDetails', 'exFactoryDetails', 'fabricDetails', 'secFabricDetails',
                                     'embellishmentDetails', 'orderItemDetails.sizeDetails')
                              ->find($id);

        $order = Order::with('organizationDetails', 'userDetails', 'contactDetails')->find($orderItem->order_id);

        $blackQty = orderItemsDetail::where('order_item_id', $orderItem->id)->sum('blanks');

        $numQty = orderItemsDetail::where('order_item_id', $orderItem->id)->sum('qty');

        //return $orderItem->exFactoryDetails;

        return view('pages.order_management.order_quotation.order_item_print', [
            'order'=>$order, 'orderItem'=>$orderItem, 'blackQty'=>$blackQty, 'numQty'=>$numQty
        ]);
    }


    public function shippingsave(Request $request){

        for($i = 0; $i<count($request->itemID);$i++)
        {
            $shippedOrder = new ShippedOrders;

            $shippedOrder->order_id = $request->orderID;
            $shippedOrder->order_item_id = $request->itemID[$i];
            $shippedOrder->order_item_qty = $request->itemOrderQty[$i];
            $shippedOrder->order_item_shipped_qty = $request->itemShippedQty[$i];
            $shippedOrder->order_item_backordered_qty = $request->itemBackOrderedQty[$i];
            $shippedOrder->est_delivery_date  = $request->itemEstDiliveryDate[$i];
            $shippedOrder->order_item_tracking_no = $request->itemtrackingNo[$i];

            $shippedOrder->save();
        }


        echo "Shipping Details Saved";
    }

    public function shippingupdate(Request $request){
        // $mainArr = [];
        $updatedItems = [];
        $deliveryDate = null;

        $reload = 'no';
        try{
            foreach($request->items as $itemId=>$item)
            {
                foreach($item as $itemDetailId=>$itemDetail)
                {
                    foreach($itemDetail as $key=>$subItem)
                    {
                        if($key == 'blks' || $key == 'blkc'){
                            foreach($subItem as $subChildItemArr){
                                $subChildItem = $subChildItemArr;
                                $subChildItem['selected_shipping_detail_ids'] = $request->selected_ship_ids;
                                $subChildItem['save_type'] = $request->save_type;
                                $subChildItem['order_id'] = $request->order_id;
                                $subChildItem['order_item_id'] = $itemId;
                                $subChildItem['order_item_detail_id'] = $itemDetailId;
                                if(isset($subChildItem['has_blank_name']) && $subChildItem['has_blank_name'] == 'yes'){
                                    $subChildItem['has_blank_qty'] = 'yes';
                                } else {
                                    if($key === 'blks' || $key === 'blkc'){
                                        $subChildItem['has_blank_qty'] = 'yes';
                                    } else {
                                        $subChildItem['has_blank_qty'] = 'no';
                                    }
                                }

                                if(isset($subChildItem['est_delivery_date'])){
                                    $subChildItem['est_delivery_date'] = Carbon::parse($subChildItem['est_delivery_date'])->format('Y-m-d');
                                    $deliveryDate = $subChildItem['est_delivery_date'];

                                }

                                $resp = ShippingFacade::store($subChildItem);

                                // $mainArr[] = $subChildItem;
                                if($resp == 'stored'){
                                    $reload = 'yes';
                                }
                            }
                        } else {
                            $subItem['selected_shipping_detail_ids'] = $request->selected_ship_ids;
                            $subItem['save_type'] = $request->save_type;
                            $subItem['order_id'] = $request->order_id;
                            $subItem['order_item_id'] = $itemId;
                            $subItem['order_item_detail_id'] = $itemDetailId;
                            if(isset($subItem['has_blank_name']) && $subItem['has_blank_name'] == 'yes'){
                                $subItem['has_blank_qty'] = 'yes';
                            } else {
                                if($key === 'blk'){
                                    $subItem['has_blank_qty'] = 'yes';
                                } else {
                                    $subItem['has_blank_qty'] = 'no';
                                }
                            }

                            if(isset($subItem['est_delivery_date'])){
                                $subItem['est_delivery_date'] = Carbon::parse($subItem['est_delivery_date'])->format('Y-m-d');
                                $deliveryDate = $subItem['est_delivery_date'];
                            }
                            $resp = ShippingFacade::store($subItem);
                            // $mainArr[] = $subItem;

                            if($resp == 'stored'){
                                $reload = 'yes';
                            }
                        }
                    }
                }
            }

            if($request->save_type == 'notify_save'){
                ShippingFacade::sendNotificationToSales($request->order_id, $request->selected_ship_ids);
                ShippingFacade::sendNotificationEmailToSales($request->order_id, $request->selected_ship_ids, $deliveryDate);
            }
            // return json_encode($mainArr);
            return json_encode([$reload,'Shipping Details Updated']);
        } catch(\Throwable $th) {
            return json_encode(['no',$th->getMessage()]);;
        }
    }

    public function mistaken_shipping_updates(Request $request){
        foreach ($request->shipment_editing_details as $shipment_editing_detail){
            $shipping_item = ShippingOrderDetails::where('id' , $shipment_editing_detail['checkbox_value'])->first();
            $shipping_item->shipped_qty = $shipment_editing_detail['shipping_qty'];
            $shipping_item->back_ordered_qty = $shipment_editing_detail['backordered_qty'];

            $shipping_item->est_delivery_date = Carbon::parse($shipment_editing_detail['est_delivery_date'])->format('Y-m-d');

            $shipping_item->tracking_no = $shipment_editing_detail['tracking_no'];
            $shipping_item->tracking_link = $shipment_editing_detail['tracking_link'];
            $shipping_item->notify_status = $request->status;
            $shipping_item->save();
        }
        $response = [
            'message' => 'Shipping Details Updated'
        ];

        return response()->json($response);
    }

    // public function shippingupdate(Request $request){
    //     return json_encode($request->items);
    //     $NotifyUser = User::where('email', 'enrich@encroms.com')->first();   // Developer
    //     // $NotifyUser = User::where('email', 'alissha@encorebrand.com')->first();     // Alissha
    //     $orderDetails = Order::select('id', 'order_no', 'organization_id', 'user_id')->where('id', $request->orderID)->first();

    //     for($item = 0; $item<count($request->itemID);$item++)
    //     {
    //         //return  $request->itemEstDiliveryDate[$item];
    //         $OrderedItem = OrderItem::find($request->itemID[$item]);
    //         /*$ShippedOrder->order_id = $request->orderID;
    //         $ShippedOrder->order_item_id = $request->itemID[$item];

    //         $ShippedOrder->order_item_qty = $request->itemOrderQty[$item];*/
    //         $OrderedItem->shipped_qty = $request->itemShippedQty[$item];

    //         $OrderedItem->backordered_qty = $request->itemBackOrderedQty[$item];
    //         if(isset($request->itemEstDiliveryDate[$item]) && $request->itemEstDiliveryDate[$item] != "")
    //         {
    //             $OrderedItem->est_shipping_delivery_date  = date('Y-m-d',strtotime($request->itemEstDiliveryDate[$item]));
    //         }
    //         else
    //         {
    //             $OrderedItem->est_shipping_delivery_date  = null;
    //         }

    //         $OrderedItem->tracking_no = $request->itemtrackingNo[$item];
    //         $OrderedItem->tracking_link = $request->itemtrackingLink[$item];
    //         $OrderedItem->update();

    //     }

    //     if(Auth::user()->id != $NotifyUser->id){
    //         $notification = new Notification();
    //         $notification->notification_title = 'Shipping Notification | Order - #'.$orderDetails->order_no;
    //         $notification->notification_message = 'Shipping Details have been updated by '.Auth::user()->name.' regarding order #'.$orderDetails->order_no;
    //         $notification->user_id = $NotifyUser->id;
    //         $notification->order_id = $orderDetails->id;
    //         $notification->save();
    //     }


    //     echo "Shipping Details Updated";
    // }

    public function sendMailNotification(Request $request) {
        $requestOrder = $request->orderID;
        $OrderItems = OrderItem::select('order_id')->where('order_id', $requestOrder)->get();
        if(count($OrderItems) >= 1) {
        //    $mailAddress = "info@encr.co";
        //    $mailPass = "EncoreCus!0077";
            $orderDetails = Order::select('id', 'order_no', 'organization_id', 'user_id')->where('id', $requestOrder)->first();
            $organizationalDetails = Organization::select('organization_name', 'email')->where('id', $orderDetails->organization_id)->first();

            $shippedArray = [];
            $ShippedOrders = OrderItem::select('id', 'order_id', 'qty','shipped_qty', 'backordered_qty','est_shipping_delivery_date', 'tracking_no' ,'product_id')->where('order_id', $requestOrder)->get();

            foreach($ShippedOrders as $shippedOrder) {
                $productname = Product::select('product_name')->where('id', $shippedOrder->product_id)->first();
                $shippedArray[] = array(
                    'id' => $shippedOrder->id,
                    'order_id' => $shippedOrder->order_id,
                    'orderItemName' => $productname->product_name,
                    'order_item_qty' => $shippedOrder->qty,
                    'order_item_shipped_qty' => $shippedOrder->shipped_qty,
                    'order_item_backordered_qty' => $shippedOrder->backordered_qty,
                    'est_delivery_date' => $shippedOrder->est_shipping_delivery_date,
                    'order_item_tracking_no' => $shippedOrder->tracking_no
                );
            }


           $orderData = ShippingOrderDetails::with('orderItems')
            ->where('order_id', $requestOrder)
            ->whereNotNull('tracking_no')
            ->latest('id')
            ->get();



            $copyOnClick = "(function(el){"
                . "var v=el.getAttribute('data-tracking');"
                . "if(!v||v==='-')return;"
                . "var done=function(){"
                    . "var o=el.className;"
                    . "el.classList.remove('far','fa-copy');"
                    . "el.classList.add('fas','fa-check');"
                    . "el.style.color='#0d9488';"
                    . "setTimeout(function(){el.className=o;el.style.color='#9ca3af';},1200);"
                . "};"
                . "var legacyCopy=function(){"
                    . "var t=document.createElement('textarea');"
                    . "t.value=v;t.style.position='fixed';t.style.opacity='0';"
                    . "document.body.appendChild(t);t.select();"
                    . "try{document.execCommand('copy');}catch(e){}"
                    . "document.body.removeChild(t);done();"
                . "};"
                . "if(navigator.clipboard&&window.isSecureContext){"
                    . "navigator.clipboard.writeText(v).then(done).catch(legacyCopy);"
                . "}else{legacyCopy();}"
                . "})(this)";

            $itemRowsHtml = '';
            foreach ($orderData as $shipment) {
                $productName = optional($shipment->orderItems)->display_name ?? '';
                $trackingNo  = $shipment->tracking_no ?? '';

                $itemRowsHtml .= '<div style="display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-bottom:1px solid #f3f4f6;font-size:13px">
                    <span style="display:flex;align-items:center;gap:8px;color:#111827">
                        <span style="width:6px;height:6px;border-radius:50%;background:#16a34a;flex-shrink:0"></span>
                        ' . e($productName) . ' - ' . e($shipment->size_name) . '
                    </span>
                    <span style="color:#111827;display:flex;align-items:center;gap:6px">
                        <strong>' . e($trackingNo ?: 'N/A') . '</strong>
                        <i class="far fa-copy" data-tracking="' . e($trackingNo ?: '-') . '" style="cursor:pointer;color:#9ca3af;font-size:12px" onclick="' . $copyOnClick . '" title="Copy tracking number"></i>
                    </span>
                </div>';
            }
            config(['mail.host' => $this->smptHost]);
            config(['mail.port' => $this->smptPort]);
            config(['mail.encryption' => $this->smptEncryption]);
            config(['mail.username' => $this->mailUsername]); //logged user email
            config(['mail.password' => $this->mailPassword]); //logged user email pass

            $fromSettings = [
              'address' => $this->mailUsername,
              'name' => 'Encore Custom',
            ];
            config(['mail.from' => $fromSettings]);

            $organizationalName = $organizationalDetails->organization_name;
            $data["subject"] = $request->subject_email;
            $data["clubName"] = "$organizationalName";
            $data["shippedItems"] = $shippedArray;
            $data["notifyBody"] = $request->notifyBody;

            // $data["to"] = $organizationalDetails->email;//email to be send to organization about the tracking
            // $data["to"] = "neil@encorebrand.com";
            $toEmails = $request->to_emails; //email to be send to custom mail addresses the enter

            $data["to"] = [];
            foreach ($toEmails as $toEmail) {
                array_push($data["to"], $toEmail);
            }

            $ccEmails = explode(',', $request->cc_emails);
            $data["cc"] = [];
            if (isset($ccEmails)) {
                foreach ($ccEmails as $ccEmail) {
                    if($ccEmail != ''){
                        array_push($data["cc"], $ccEmail);

                        $user = User::where('email', $ccEmail)->first();

                        if(Auth::user()->id !== $user->id){
                            $firstShipment = $orderData->first();
                            $inHandDueDateRaw = optional($firstShipment?->orderItems)->in_hand_due_date;

                            $builder = new NotificationBuilderService();
                            $builder->sendNotification(
                                'key_shipping_notification_sent',
                                [
                                    '{organization_name}'  => optional($orderDetails->organizationDetails)->organization_name ?? '',
                                    '{order_no}'           => $orderDetails->order_no,
                                    '{order_link}'         => url("order_details/edit/{$requestOrder}/shipping"),
                                    '{in_hand_due_date}' => $this->formatNotificationDate($inHandDueDateRaw),
                                    '{shipment_item_rows}' => $itemRowsHtml,
                                ],
                                [
                                    'order_id'                   => $requestOrder,
                                    'user_id'                    => $user->id,
                                    'target_notification_field'  => 'key_shipping_notification_sent',
                                    'new_notification'           => 1,
                                ]
                            );
                        }
                    }
                }
            }

            Mail::send('emailNotification.custom_email', $data, function ($message) use ($data) {
                $message->to($data["to"]);
                if(count($data["cc"]) > 0){
                    $message->cc($data["cc"]);
                }
                $message->subject($data["subject"]);
            });

            $orderItemIds = $request->order_item_array;
            $orderItemArr = [];
            $orderItemArr = explode(',', $orderItemIds);

            foreach ($orderItemArr as $orderItemId) {
                // $orderItem = OrderItem::find($orderItemId);
                $orderItem = ShippingOrderDetails::find($orderItemId);
                if($orderItem){
                    if($orderItem->back_ordered_qty != '' && $orderItem->back_ordered_qty != null && $orderItem->back_ordered_qty > 0){
                        $newOrderItem = $orderItem->toArray();
                        $newOrderItem['id'] = null;
                        $newOrderItem['order_qty'] = $orderItem->back_ordered_qty;
                        $newOrderItem['shipped_qty'] = null;
                        $newOrderItem['back_ordered_qty'] = null;
                        $newOrderItem['is_back_ordered'] = 1;
                        $newOrderItem['initail_order_qty'] = $orderItem->back_ordered_qty;
                        $newOrderItem['est_delivery_date'] = null;
                        $newOrderItem['tracking_no'] = null;
                        $newOrderItem['tracking_link'] = null;
                        ShippingFacade::create($newOrderItem);

                        $orderItem->initail_order_qty = $orderItem->order_qty;
                        $orderItem->order_qty = $orderItem->shipped_qty;
                        $orderItem->back_ordered_qty = null;
                    }

                    $orderItem->notify_status = 1;
                    // $orderItem->notified_user_id = Auth::user()->id;
                    $orderItem->notified_by = Auth::user()->id;
                    $orderItem->update();
                }
            }

            $draft = ShippingNotificationDraft::where('order_id', $requestOrder)->where('user_id', Auth::user()->id)->where('status', 1)->first();
            if($draft){
                $draft->status = 0;
                $draft->update();
            }
            echo "Mail Sent Successfully";

        } else {
            echo "No any shipped products to the order";
        }


       //return view('emailNotification.email');
    }

    private function formatNotificationDate($value): string
    {
        if (blank($value)) {
            return '-';
        }

        if ($value instanceof \DateTimeInterface) {
            return Carbon::instance($value)->format('M d, Y');
        }

        $value = trim((string) $value);

        $formats = [
            'Y-m-d H:i:s',
            'Y-m-d',
            'm-d-Y',
            'm/d/Y',
        ];

        foreach ($formats as $format) {
            try {
                $date = Carbon::createFromFormat($format, $value);

                if ($date !== false) {
                    return $date->format('M d, Y');
                }
            } catch (\Throwable $exception) {
                // Try the next supported format.
            }
        }

        return '-';
    }

    public function saveDraftNotification(Request $request) {
        $requestOrder = $request->orderID;
        $sendTo = json_encode($request->to_emails);
        $copyTo = json_encode($request->cc_emails);
        $subject_email = $request->subject_email;
        $notifyBody = $request->notifyBody;
        $orderItems = json_encode($request->order_item_array);

        $draft = ShippingNotificationDraft::where('order_id', $requestOrder)->where('user_id', Auth::user()->id)->where('status', 1)->first();
        if($draft){
            $draft->send_to = $sendTo;
            $draft->copy_to = $copyTo;
            $draft->subject = $subject_email;
            $draft->message = $notifyBody;
            $draft->items = $orderItems;
            $draft->update();
        } else {
            $newDraft = new ShippingNotificationDraft();
            $newDraft->order_id = $requestOrder;
            $newDraft->user_id = Auth::user()->id;
            $newDraft->send_to = $sendTo;
            $newDraft->copy_to = $copyTo;
            $newDraft->subject = $subject_email;
            $newDraft->message = $notifyBody;
            $newDraft->items = $orderItems;
            $newDraft->status = 1;
            $newDraft->save();
        }

        echo "Mail Drafted Successfully";
    }

    public function getdraftedShippingDetails($orderId){
        $draft = ShippingNotificationDraft::where('order_id', $orderId)->where('user_id', Auth::user()->id)->where('status', 1)->first();
        return json_encode($draft);
    }

    public function itemNoteSave(Request $request)
    {
        $OrderItemDetails = OrderItem::find($request->orderItemId);
        $OrderItemDetails->item_notes = $request->orderItemNotes;
        $OrderItemDetails->update();

        echo json_encode(array('Done Save Item Note',$request->orderItemNotesbtn));
    }

    public function saveOrderItemPlayernames(Request $request)
    {
        foreach($request->playername as $playernameDetails){
            if($playernameDetails['playername'] != "" || $playernameDetails['playername'] != null)
            {
                $OrderItemsDetailPlayerName = new OrderItemsDetailPlayerName();
                $OrderItemsDetailPlayerName->order_items_detail_id = $playernameDetails['orderitemdetailsid'];
                $OrderItemsDetailPlayerName->order_item_id = $playernameDetails['orderitemdetailsid'];
                $OrderItemsDetailPlayerName->number_sequence = $playernameDetails['playernumber'];
                $OrderItemsDetailPlayerName->name = $playernameDetails['playername'];
                $OrderItemsDetailPlayerName->active = 1;
                $OrderItemsDetailPlayerName->save();
            }
        }
        echo "Done";
    }

    public function changeExFactoryDate(Request $request) {
        $order = Order::find($request->order_id);

        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $newExLog = ExFactoryDateFacade::create($request->order_id, Auth::id(), $order->ex_factory_date, $request->new_ex_factory_date, $request->reason);

        if($request->order_type == 0 || ($request->order_type == 1 && $request->address_type == 2)){

            $estDeliveryDate =Carbon::parse($request->new_ex_factory_date)->addDays(5)->format('m/d/Y');
            $order->ex_factory_date = $request->new_ex_factory_date;
            $order->est_delivery_date = $estDeliveryDate;

            $order->flag = $this->changeFlagByOrder($order->order_status_id, $request->new_ex_factory_date);
            $order->update();

            if ($request->change_type == 1) {
                // $order = Order::find($request->order_id);

                $orderItemQuery = OrderItem::where('order_id', $request->order_id);
                if($oderSearch == 'factory'){
                    $orderItemQuery->whereIn('factory_id', $factoryIds);
                }
                $orderItems = $orderItemQuery->get();
                foreach ($orderItems as $orderItem) {
                    $orderItem->ex_factory_date = $request->new_ex_factory_date;
                    $orderItem->est_delivery_date = $estDeliveryDate;

                    $orderItem->update();
                }
            }

            return json_encode([$order->est_delivery_date,'',$newExLog]);

        }else if($request->order_type == 1){
            $orderPackingDate = Carbon::parse($request->new_ex_factory_date)->addDays(7)->format('m/d/Y');
            $estDiliveyDate = Carbon::parse($orderPackingDate)->addDays(5)->format('m/d/Y');

            $order->ex_factory_date = $request->new_ex_factory_date;
            $order->encore_packing_date =  $orderPackingDate;
            $order->est_delivery_date = $estDiliveyDate;

            $order->flag = $this->changeFlagByOrder($order->order_status_id, $request->new_ex_factory_date);
            $order->update();

            if ($request->change_type == 1) {

                $orderItemQuery = OrderItem::where('order_id', $request->order_id);
                if($oderSearch == 'factory'){
                    $orderItemQuery->whereIn('factory_id', $factoryIds);
                }
                $orderItems = $orderItemQuery->get();

                foreach ($orderItems as $orderItem) {
                    $orderItem->ex_factory_date = $request->new_ex_factory_date;
                    $orderItem->encore_packing_date = $orderPackingDate;
                    $orderItem->est_delivery_date = $estDiliveyDate;

                    $orderItem->update();
                }
            }

            return json_encode([$order->est_delivery_date,$order->encore_packing_date,$newExLog]);

        }
    }

    public function changeEncorePackingDate(Request $request) {
        if ($request->change_type == 1) {
            $order = Order::find($request->order_id);
            $order->ex_factory_date = Carbon::parse($request->new_encore_packing_date)->subDays(7)->format('m/d/Y');
            $order->encore_packing_date = $request->new_encore_packing_date;
            $order->due_date = Carbon::parse($request->new_encore_packing_date)->addDays(7)->format('m/d/Y');
            $order->update();

            $orderItems = OrderItem::where('order_id', $request->order_id)->get();
            foreach ($orderItems as $orderItem) {
                $orderItem->ex_factory_date = Carbon::parse($request->new_encore_packing_date)->subDays(7)->format('m/d/Y');
                $orderItem->encore_packing_date = $request->new_encore_packing_date;
                $orderItem->in_hand_due_date = Carbon::parse($request->new_encore_packing_date)->addDays(7)->format('m/d/Y');
                $orderItem->update();
            }
        } else {
            $order = Order::find($request->order_id);
            $order->ex_factory_date = Carbon::parse($request->new_encore_packing_date)->subDays(7)->format('m/d/Y');
            $order->encore_packing_date = $request->new_encore_packing_date;
            $order->due_date = Carbon::parse($request->new_encore_packing_date)->addDays(7)->format('m/d/Y');
            $order->update();
        }

        return json_encode([$order->ex_factory_date,$order->due_date]);
    }

    public function changeDueDate(Request $request) {

        $order = Order::find($request->order_id);
        if($order->order_status_id != 1){
            if($request->authenticate_status != 'approved'){
                return json_encode('auth_error');
            }
        }

        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

                // return json_encode([$request->order_id, Auth::id(), $order->due_date, $request->new_due_date, $request->reason]);
        // InHandDateFacade::create($orderId, $userId, $preDate, $newDate, $reason);
        InHandDateFacade::create($request->order_id, Auth::id(), $order->due_date, $request->new_due_date, $request->reason);

        if($request->order_type == 0 || ($request->order_type == 1 && $request->address_type == 2)){
            $oderExFactoryDate = Carbon::parse($request->new_due_date)->subDays(7)->format('m/d/Y');
            $oderEstDeliveryDate = Carbon::parse($oderExFactoryDate)->addDays(5)->format('m/d/Y');

            $order->due_date = $request->new_due_date;
            $order->ex_factory_date = $oderExFactoryDate;
            $order->est_delivery_date = $oderEstDeliveryDate;
            $order->update();

            if ($request->change_type == 1) {
                $orderItemQuery = OrderItem::where('order_id', $request->order_id);
                if($oderSearch == 'factory'){
                    $orderItemQuery->whereIn('factory_id', $factoryIds);
                }
                $orderItems = $orderItemQuery->get();
                foreach ($orderItems as $orderItem) {
                    $orderItem->in_hand_due_date = $request->new_due_date;
                    $orderItem->est_delivery_date = $oderEstDeliveryDate;
                    $orderItem->ex_factory_date = $oderExFactoryDate;
                    $orderItem->update();
                }
            }

            return json_encode([$order->ex_factory_date, $order->est_delivery_date]);

        }else if($request->order_type == 1){
            $oderExFactoryDate = Carbon::parse($request->new_due_date)->subDays(14)->format('m/d/Y');
            $oderPackingDate = Carbon::parse($request->new_due_date)->subDays(7)->format('m/d/Y');
            $oderEstDeliveryDate = Carbon::parse($oderPackingDate)->addDays(5)->format('m/d/Y');

            $order->due_date = $request->new_due_date;
            $order->encore_packing_date = Carbon::parse($request->new_due_date)->subDays(7)->format('m/d/Y');
            $order->ex_factory_date = $oderExFactoryDate;
            $order->est_delivery_date = $oderEstDeliveryDate;
            $order->update();

            if ($request->change_type == 1) {
                $orderItemQuery = OrderItem::where('order_id', $request->order_id);
                if($oderSearch == 'factory'){
                    $orderItemQuery->whereIn('factory_id', $factoryIds);
                }
                $orderItems = $orderItemQuery->get();
                foreach ($orderItems as $orderItem) {
                    $orderItem->in_hand_due_date = $request->new_due_date;
                    $orderItem->est_delivery_date = $request->new_due_date;
                    $orderItem->encore_packing_date = Carbon::parse($request->new_due_date)->subDays(7)->format('m/d/Y');
                    $orderItem->ex_factory_date = $oderExFactoryDate;
                    $orderItem->update();
                }
            }

            return json_encode([$order->ex_factory_date, $order->est_delivery_date ,$order->encore_packing_date]);
        }

    }

    public function changeFlagByOrder($orderStatus, $exFactoryDate){
        $date = Carbon::now();
        $nowDate = $date->format('Y-m-d');
        $betweenDate = Carbon::now()->addDays(5)->format('Y-m-d');

        if(isset($exFactoryDate)){
            $exFactoryCarbonDate = Carbon::parse($exFactoryDate)->format('Y-m-d');
            if($orderStatus == 3){
                if($exFactoryCarbonDate < $nowDate){
                    $color = '#fb5779';
                } else if($exFactoryCarbonDate == $nowDate){
                    $color = '#19db7d';
                } else if($exFactoryCarbonDate <= $betweenDate && $exFactoryCarbonDate > $nowDate){
                    $color = '#ff7510';
                } else if($exFactoryCarbonDate > $betweenDate){
                    $color = '#f6f8f9';
                }
            } else {
                $color = '#f6f8f9';
            }
        } else {
            $color = '#f6f8f9';
        }
        return $color;
    }

    public function shippingDetails(Request $request){
        $shippingDetails = [];

        $order = Order::select('organization_id', 'user_id', 'email', 'order_type', 'contact_id')->where('id', $request->order_id)->first();

        $toEmailArr = [];

        if($order->order_type == 1 && $order->contact_id == 3613){
            array_push($toEmailArr, 'mikayla@encorebrand.com');
        }

        $organization = Organization::find($order->organization_id);
        if ($organization->email) {
            array_push($toEmailArr, $organization->email);
        }

        $contactList = ContactOrganization::with('contacts')->where('organization_id', $order->organization_id)->get();
        foreach ($contactList as $contact) {
            array_push($toEmailArr, $contact->contacts[0]->email);
        }

        $shippingDetails['to'] = [];
        foreach (array_unique($toEmailArr) as $toEmail) {
            array_push($shippingDetails['to'], $toEmail);
        }

        $shippingDetails['cc'] = [];
        $leadSalesPerson = User::find($order->user_id);
        array_push($shippingDetails["cc"], $leadSalesPerson->email);


        $Order_proccessing_rep = Auth::user()->email;

        // Check if the email is not already in the "cc" array
        if (!in_array($Order_proccessing_rep, $shippingDetails["cc"])) {
            // Add the email to the "cc" array
            array_push($shippingDetails["cc"], $Order_proccessing_rep);
        }
        // $users = User::whereHas("roles", function($q) {
        //                         $q->where("id", 9);
        //                     })->where('active', 1)->get();

        $users = User::whereIn('id', [5])->get();

        foreach ($users as $user) {
            array_push($shippingDetails["cc"], $user->email);
        }

        $orderItemIds = $request->order_item_array;
		// $orderItemArr = [];
		$orderItemArr = explode(',', $orderItemIds);

        // $orderItems = [];
        // foreach ($orderItemArr as $orderItemId) {
        //     $orderItems[] = OrderItem::with('productDetails')->where('id', $orderItemId)->first();
        // }
        // $shippingDetails['orderItems'] = $orderItems;

        $shippingDetails['orderItems'] = ShippingFacade::getNotifiedProduct($orderItemArr);
        // $shippingDetails['orderItems'] = ShippingOrderDetails::with('orderItems.productDetails')->whereIn('id', $orderItemArr)->get();

        $OrderDetails =  Order::with('orderItems', 'orderItems.productDetails', 'organizationDetails', 'contactDetails', 'contactDetails')
                                        ->where('orders.id', $request->order_id)
                                        ->first();


        $destination = '';
        if($OrderDetails->is_new_shipping_address == 1){
            $destination .= $OrderDetails->apartment.',' ?? '';
            $destination .= $OrderDetails->street .',' ?? '';
            $destination .= $OrderDetails->city .',' ?? '';
            $destination .= $OrderDetails->state .',' ?? '';
            $destination .= $OrderDetails->postal_code .',' ?? '';
            $destination .= $OrderDetails->country.'.' ?? '';
        }else if($OrderDetails->is_new_shipping_address == 3){
            $destination .= $OrderDetails->contactDetails['apartment2'] ?? '';
            $destination .= $OrderDetails->contactDetails['shipping_street_2'] .',' ?? '';
            $destination .= $OrderDetails->contactDetails['shipping_city_2'] .',' ?? '';
            $destination .= $OrderDetails->contactDetails['shipping_state_2'] .',' ?? '';
            $destination .= $OrderDetails->contactDetails['shipping_zip_2'] .',' ?? '';
            $destination .= $OrderDetails->contactDetails['shipping_country_2'] ?? '';
        }else{
            $destination .= $OrderDetails->contactDetails['apartment'] ?? '';
            $destination .= $OrderDetails->contactDetails['shipping_street'] .',' ?? '';
            $destination .= $OrderDetails->contactDetails['shipping_city'] .',' ?? '';
            $destination .= $OrderDetails->contactDetails['shipping_state'] .',' ?? '';
            $destination .= $OrderDetails->contactDetails['shipping_zip'] .',' ?? '';
            $destination .= $OrderDetails->contactDetails['shipping_country'] ?? '';
        }

        $shippingDetails['order'] = $OrderDetails;

        $shippingDetails['destination'] = $destination;

        $shippingDetails['sub_products'] = SubProduct::get();

        return json_encode($shippingDetails);
    }

    public function shippingSummery(Request $request){
        $shippingDetails = [];
        $shippingDetails['orderItems'] = ShippingFacade::getShipmentSummery($request->order_id);
        $shippingDetails['sub_products'] = SubProduct::get();

        return json_encode($shippingDetails);
    }

    public function getSalesTeam($orderId){
        $order = Order::select('user_id')->where('id', $orderId)->first();
        $leadSalesPerson = $order->user_id;

        // $usersHave = User::whereHas("roles", function($q) { $q->where("id", 9); })->whereNotIn('id', [94])->where('active', 1);
        $usersHave = $users = User::whereIn('id', [5]);
        $usersHaveGrouped = User::where('id', $leadSalesPerson)->union($usersHave)->get();

        // $usersHaveGroupedIds = User::whereHas("roles", function($q) { $q->where("id", 9); })->whereNotIn('id', [94])->where('active', 1)->get()->pluck('id');
        $usersHaveGroupedIds = $users = User::whereIn('id', [5])->get()->pluck('id');

        $usersHaveNoGroup = User::where('active', 1)->whereNotIn('id', $usersHaveGroupedIds)->where('id', '!=', $leadSalesPerson)->orderBy('name')->get();

        return json_encode(array( $usersHaveGrouped, $usersHaveNoGroup));
    }

    public function userGroupFactories(){
        $user = Auth::user();
        $factoryIds = [];
        $userRoleId = [];
        if($user->hasRole([1, 2, 3, 4, 10, 30])){
            $oderSearch = 'all';
        } else {
            $oderSearch = 'factory';
            foreach($user->roles as $userRole){
                if($userRole->id == 5){     // PBS Factory
                    $factoryIds[] = 2;  // PBS
                    $userRoleId = $userRole->id;
                }
                if($userRole->id == 6){     // WDC Factory
                    $factoryIds[] = 1;  // WDC
                    $userRoleId = $userRole->id;
                }
                if($userRole->id == 7){     // BII Factory
                    $factoryIds[] = 3;  // BII
                    $userRoleId = $userRole->id;
                }
                if($userRole->id == 8){     // UET Factory
                    $factoryIds[] = 7;  // UET
                    $userRoleId = $userRole->id;
                }
                if($userRole->id == 11){     // ZYS Factory
                    $factoryIds[] = 10;  // ZYS
                    $userRoleId = $userRole->id;
                }
                if($userRole->id == 12){     // Test Factory
                    $factoryIds[] = 16;  // Test
                    $userRoleId = $userRole->id;
                }
            }
        }

        $this->oderSearch = $oderSearch;
        $this->factoryIds = $factoryIds;
        $this->userRoleId = $userRoleId;

        return $this;
    }

    public function setShippingFee($orderId){
        $order = Order::find($orderId);
        $orderTotal = $order->order_total;
        $orderTotal = $orderTotal - $order->shipping;
        $orderQty = OrderItem::where('order_id', $orderId)->where('active', 1)->get()->sum('qty');
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

    public function notifyFactoryUsersByEmail($item, $isUrgent){
        if(isset($item->factory_id)){
            $data["cc"] = [];

            if($item->factory_id == 2){     // PBS Factory
                $userRoleId = 5;  // PBS
            }
            if($item->factory_id == 1){     // WDC Factory
                $userRoleId = 6;  // WDC
            }
            if($item->factory_id == 3){     // BII Factory
                $userRoleId = 7;  // BII
                // array_push($data["cc"], 'alissha@encorebrand.com');
            }
            if($item->factory_id == 7){     // UET Factory
                $userRoleId = 8;  // UET
            }
            if($item->factory_id == 10){     // ZYS Factory
                $userRoleId = 11;  // ZYS
            }
            if($item->factory_id == 16){     // Test Factory
                $userRoleId = 12;  // Test
            }

            $orderDetails = Order::find($item->order_id);

            $users =  User::select('id', 'email')->whereHas("roles", function($q) use($userRoleId) {
                                            $q->where("id", $userRoleId);
                                        })
                                        ->whereNotIn('id', [Auth::user()->id])->where('active', 1)->get();

            foreach($users as $user){


                config(['mail.host' => $this->smptHost]);
                config(['mail.port' => $this->smptPort]);
                config(['mail.encryption' => $this->smptEncryption]);
                config(['mail.username' => $this->mailUsername]); //logged user email
                config(['mail.password' => $this->mailPassword]); //logged user email pass

                $fromSettings = [
                    'address' => $this->mailUsername,
                    'name' => 'Encore Custom',
                ];
                config(['mail.from' => $fromSettings]);

                $teamName = '<p style="margin-top: 0.1rem;">Team Name: '.$orderDetails->organizationDetails->organization_name.'</p>';
                $exFactDate = '<p style="margin-top: 0.1rem;">Ex Factory Date: '.$orderDetails->ex_factory_date.'</p>';
                $inHandDate = '<p style="margin-top: 0.1rem;">In Hand Due Date: '.$orderDetails->due_date.'</p>';

                $data["to"] = $user->email;
                $data["subject"] = 'New Order Encore Production | Order - #'.$orderDetails->order_no.' | Team - '.$orderDetails->organizationDetails->organization_name;
                $data["body"] = '<table>'. $teamName . $exFactDate . $inHandDate .'</table><p>Order item '.$item->productDetails->product_name.' has been moved to production regarding order <a target="_blank" href="https://encr.co/order_details/edit/'.$item->order_id.'/order?active_tab='.$item->id.'">#'.$orderDetails->order_no.'</a></p>';

                // Mail::send('emailNotification.factory_notification', $data, function ($message) use ($data) {
                //     $message->to($data["to"]);
                //     $message->cc($data["cc"]);
                //     $message->subject($data["subject"]);
                // });
            }
            $factoryArray[] = $item->factory_id;
            $newOrderItems[] = $item;
            email_Notify()->sendEmailFromTemplate('key_email_moveToProduction', [
                'orderId' => $item->order_id,
                'orderNo' => $orderDetails->order_no,
                'organizationname' => $orderDetails->organizationDetails->organization_name,
                'send_relevent_factory' => true,
                'factorys_array' => $factoryArray,
                'new_order_items' => $newOrderItems,
            ]);
        }
    }


    public function notifyFactoryUsers($item, $isUrgent)
    {
        // new function
        if (!isset($item->factory_id)) {
            return;
        }

        $orderDetails = Order::with('organizationDetails')->find($item->order_id);
        if (!$orderDetails) {
            return;
        }

        $orderId = $item->order_id;
        $commaSeparatedIds = (string) $item->id;


        $itemListHtml = '<div style="display:flex;align-items:center;justify-content:space-between;padding:10px 14px;font-size:13px;color:#1f2937;border-bottom:1px solid #f3f4f6">
            <div style="font-weight:600;color:#111827">' . e($item->productDetails->product_name ?? 'Item') . '</div>
            <div style="color:#6b7280">Qty: ' . e($item->qty ?? '-') . '</div>
        </div>';

        $discussionLink = route('orders.info', ['id' => $orderDetails->id, 'type' => 'management']);
        $rosterLink     = url('orders/csv/' . $orderDetails->id);
        $techpackLink   = url('orders/DownloadTestPrint/' . $commaSeparatedIds);
        $playerReport   = route('store.generatePlayerCSV', ['id' => $orderDetails->id]);

        $templateKey = $isUrgent == 1
            ? 'key_urgent_order_moved_to_production'
            : 'key_order_production';

        $notification_builder = new NotificationBuilderService();
        $notification_builder->sendNotification(
            $templateKey,
            [
                '{order_number}'      => $orderDetails->order_no,
                '{order_link}'        => url("order_details/edit/{$orderId}/order") . '?active_tab=order',
                '{ex_factory_date}'   => $item->ex_factory_date ?? $orderDetails->ex_factory_date,
                '{in_hand_due_date}'  => $item->in_hand_due_date ?? $orderDetails->due_date,
                '{organization_name}' => optional($orderDetails->organizationDetails)->organization_name ?? '',
                '{order_description}' => $orderDetails->order_description ?? '',
                '{order_items_list}'  => $itemListHtml,
                '{techpack_link}'     => $techpackLink,
                '{roster_link}'       => $rosterLink,
                '{discussion_link}'   => $discussionLink,
                '{playerReport}'      => $playerReport,
            ],
            [
                'order_id'                   => $orderDetails->id,
                'order_item_id'              => $commaSeparatedIds,
                'order_ex_fac_date'          => $item->ex_factory_date ?? $orderDetails->ex_factory_date,
                'order_in_hand_due_date'     => $item->in_hand_due_date ?? $orderDetails->due_date,
                'target_notification_field' => $templateKey,
                'new_notification'           => 1,
            ]
        );
    }

    public function notifyFactoryUsersByEmailOnQuotes($item){
        if(isset($item->factory_id)){
            $data["cc"] = [];

            if($item->factory_id == 2){     // PBS Factory
                $userRoleId = 5;  // PBS
            }
            if($item->factory_id == 1){     // WDC Factory
                $userRoleId = 6;  // WDC
            }
            if($item->factory_id == 3){     // BII Factory
                $userRoleId = 7;  // BII
                // array_push($data["cc"], 'alissha@encorebrand.com');
            }
            if($item->factory_id == 7){     // UET Factory
                $userRoleId = 8;  // UET
            }
            if($item->factory_id == 10){     // ZYS Factory
                $userRoleId = 11;  // ZYS
            }
            if($item->factory_id == 16){     // Test Factory
                $userRoleId = 12;  // Test
            }

            $orderDetails = Order::find($item->order_id);

            $users =  User::select('id', 'email')->whereHas("roles", function($q) use($userRoleId) {
                                            $q->where("id", $userRoleId);
                                        })
                                        ->whereNotIn('id', [Auth::user()->id])->where('active', 1)->get();

            foreach($users as $user){


                config(['mail.host' => $this->smptHost]);
                config(['mail.port' => $this->smptPort]);
                config(['mail.encryption' => $this->smptEncryption]);
                config(['mail.username' => $this->mailUsername]); //logged user email
                config(['mail.password' => $this->mailPassword]); //logged user email pass

                $fromSettings = [
                    'address' => $this->mailUsername,
                    'name' => 'Encore Custom',
                ];
                config(['mail.from' => $fromSettings]);

                $teamName = '<p style="margin-top: 0.1rem;">Team Name: '.$orderDetails->organizationDetails->organization_name.'</p>';
                $exFactDate = '<p style="margin-top: 0.1rem;">Ex Factory Date: '.$orderDetails->ex_factory_date.'</p>';
                $inHandDate = '<p style="margin-top: 0.1rem;">In Hand Due Date: '.$orderDetails->due_date.'</p>';

                $data["to"] = $user->email;
                $data["subject"] = 'Order Encore Quote | Order - #'.$orderDetails->order_no.' | Team - '.$orderDetails->organizationDetails->organization_name;
                $data["body"] = '<table>'. $teamName . $exFactDate . $inHandDate .'</table><p>Order item '.$item->productDetails->product_name.' has been moved to quotes regarding order <a target="_blank" href="https://encr.co/order_details/edit/'.$item->order_id.'/order?active_tab='.$item->id.'">#'.$orderDetails->order_no.'</a></p>';

                // Mail::send('emailNotification.factory_notification', $data, function ($message) use ($data) {
                //     $message->to($data["to"]);
                //     $message->cc($data["cc"]);
                //     $message->subject($data["subject"]);
                // });
            }
            $factoryArray[] = $item->factory_id;
            $newOrderItems[] = $item;
            email_Notify()->sendEmailFromTemplate('key_email_production_order_to_quotes_system_user', [
                'orderId' => $item->order_id,
                'orderNo' => $orderDetails->order_no,
                'organizationname' => $orderDetails->organizationDetails->organization_name,
                'send_relevent_factory' => true,
                'factorys_array' => $factoryArray,
                'new_order_items' => $newOrderItems,
            ]);

            email_Notify()->sendEmailFromTemplate('key_email_production_order_to_quotes_factory_user', [
                'orderId' => $item->order_id,
                'orderNo' => $orderDetails->order_no,
                'organizationname' => $orderDetails->organizationDetails->organization_name,
                'send_relevent_factory' => true,
                'factorys_array' => $factoryArray,
                'new_order_items' => $newOrderItems,
            ]);
        }
    }


    public function notifyFactoryUsersOnQuotes($item)
    {
        // new function
        if (!isset($item->factory_id)) {
            return;
        }

        $orderDetails = Order::with('organizationDetails')->find($item->order_id);
        if (!$orderDetails) {
            return;
        }

        $orderId = $item->order_id;
        $commaSeparatedIds = (string) $item->id;


        $itemListHtml = '<div style="display:flex;align-items:center;justify-content:space-between;padding:10px 14px;font-size:13px;color:#1f2937;border-bottom:1px solid #f3f4f6">
            <div style="font-weight:600;color:#111827">' . e($item->productDetails->product_name ?? 'Item') . '</div>
            <div style="color:#6b7280">Qty: ' . e($item->qty ?? '-') . '</div>
        </div>';

        $discussionLink = route('orders.info', ['id' => $orderDetails->id, 'type' => 'management']);
        $rosterLink     = url('orders/csv/' . $orderDetails->id);
        $techpackLink   = url('orders/DownloadTestPrint/' . $commaSeparatedIds);
        $playerReport   = route('store.generatePlayerCSV', ['id' => $orderDetails->id]);

        $templateKey = 'key_production_order_to_quotes_system_user';

        $notification_builder = new NotificationBuilderService();
        $notification_builder->sendNotification(
            $templateKey,
            [
                '{order_number}'      => $orderDetails->order_no,
                '{order_link}'        => url("order_details/edit/{$orderId}/order") . '?active_tab=order',
                '{ex_factory_date}'   => $item->ex_factory_date ?? $orderDetails->ex_factory_date,
                '{in_hand_due_date}'  => $item->in_hand_due_date ?? $orderDetails->due_date,
                '{organization_name}' => optional($orderDetails->organizationDetails)->organization_name ?? '',
                '{order_description}' => $orderDetails->order_description ?? '',
                '{order_items_list}'  => $itemListHtml,
                '{techpack_link}'     => $techpackLink,
                '{roster_link}'       => $rosterLink,
                '{discussion_link}'   => $discussionLink,
                '{playerReport}'      => $playerReport,
            ],
            [
                'order_id'                   => $orderDetails->id,
                'order_item_id'              => $commaSeparatedIds,
                'order_ex_fac_date'          => $item->ex_factory_date ?? $orderDetails->ex_factory_date,
                'order_in_hand_due_date'     => $item->in_hand_due_date ?? $orderDetails->due_date,
                'target_notification_field' => $templateKey,
                'new_notification'           => 1,
            ]
        );

        $templateKey2 = 'key_production_order_to_quotes_factory_user';

        $notification_builder2 = new NotificationBuilderService();
        $notification_builder2->sendNotification(
            $templateKey2,
            [
                '{order_number}'      => $orderDetails->order_no,
                '{order_link}'        => url("order_details/edit/{$orderId}/order") . '?active_tab=order',
                '{ex_factory_date}'   => $item->ex_factory_date ?? $orderDetails->ex_factory_date,
                '{in_hand_due_date}'  => $item->in_hand_due_date ?? $orderDetails->due_date,
                '{organization_name}' => optional($orderDetails->organizationDetails)->organization_name ?? '',
                '{order_description}' => $orderDetails->order_description ?? '',
                '{order_items_list}'  => $itemListHtml,
                '{techpack_link}'     => $techpackLink,
                '{roster_link}'       => $rosterLink,
                '{discussion_link}'   => $discussionLink,
                '{playerReport}'      => $playerReport,
            ],
            [
                'order_id'                   => $orderDetails->id,
                'order_item_id'              => $commaSeparatedIds,
                'order_ex_fac_date'          => $item->ex_factory_date ?? $orderDetails->ex_factory_date,
                'order_in_hand_due_date'     => $item->in_hand_due_date ?? $orderDetails->due_date,
                'target_notification_field' => $templateKey,
                'new_notification'           => 1,
            ]
        );
    }

    public function notifyFactoryUsersExFac($orderId, $order_ex_fac_date_suggest,$factoryArray){

        if($factoryArray){
            foreach (array_unique($factoryArray) as $factory_id) {
                if($factory_id == 2){     // PBS Factory
                    $userRoleId = 5;  // PBS
                }
                if($factory_id == 1){     // WDC Factory
                    $userRoleId = 6;  // WDC
                }
                if($factory_id == 3){     // BII Factory
                    $userRoleId = 7;  // BII
                }
                if($factory_id == 7){     // UET Factory
                    $userRoleId = 8;  // UET
                }
                if($factory_id == 10){     // ZYS Factory
                    $userRoleId = 11;  // ZYS
                }
                if($factory_id == 16){     // Test Factory
                    $userRoleId = 12;  // Test
                }

                $orderDetails = Order::find($orderId);

                $orderItems = OrderItem::where('order_id', $orderId)->where('factory_id', $factory_id)->get();

                $userIds =  User::whereHas("roles", function($q) use($userRoleId) {
                                                $q->where("id", $userRoleId);
                                            })->where('active', 1)->get()->pluck('id');

                foreach($userIds as $user){
                    $notification = new Notification();
                    $notification->notification_title = 'Ex factory date confirmation needed for Urgent Order | Order - #'.$orderDetails->order_no.' ex-factory date.';

                    $message = 'For Order #'.$orderDetails->order_no.' suggest new ex. factory date.<ul><li style="text-align: left; list-style-type: none;"><u>Items in this order:</u></li>';

                    foreach ($orderItems as $orderItem) {
                        $optional_text = ($orderItem->item_description ? ' - ' . $orderItem->item_description : '') . ' - (Qty' . $orderItem->qty.')';
                        $sub_product_name = SubProduct::where('sub_product_no' , $orderItem->sub_product_no)->first()->product_name;
                        $message = $message . "<li style='text-align: left;'>" . $sub_product_name . $optional_text . "</li>";
                    }

                    $message = $message."</ul>";
                    $orderItemIds = OrderItem::where('order_id', $orderId)->where('factory_id', $factory_id)->get();

                    $ids = [];

                    foreach($orderItemIds as $ordersItem) {
                        $ids[] = $ordersItem->id;
                    }

                    $commaSeparatedIds = implode(',', $ids);

                    $notification->order_item_id = $commaSeparatedIds;


                    $notification->notification_message = $message;
                    $notification->user_id = $user;
                    $notification->order_id = $orderId;
                    $notification->is_urgent = 1;
                    $notification->order_ex_fac_date = $order_ex_fac_date_suggest;
                    $notification->order_in_hand_due_date = $orderDetails->due_date;
                    $notification->save();
                }
            }
        }
    }

    public function emailFactoryUsersExFac($orderId,$suggestedExFac,$factoryArray){
        $orderDetails = Order::find($orderId);
        if($factoryArray){
            foreach (array_unique($factoryArray) as $factory_id) {
                $data["cc"] = [];
                array_push($data["cc"], 'alissha@encorebrand.com');

                if($factory_id == 2){     // PBS Factory
                    $userRoleId = 5;  // PBS
                }
                if($factory_id == 1){     // WDC Factory
                    $userRoleId = 6;  // WDC
                }
                if($factory_id == 3){     // BII Factory
                    $userRoleId = 7;  // BII
                }
                if($factory_id == 7){     // UET Factory
                    $userRoleId = 8;  // UET
                }
                if($factory_id == 10){     // ZYS Factory
                    $userRoleId = 11;  // ZYS
                }
                if($factory_id == 16){     // Test Factory
                    $userRoleId = 12;  // Test
                }



                $users =  User::select('id', 'email')->whereHas("roles", function($q) use($userRoleId) {
                                                $q->where("id", $userRoleId);
                                            })->where('active', 1)->get();

                foreach($users as $user){
                    config(['mail.host' => $this->smptHost]);
                    config(['mail.port' => $this->smptPort]);
                    config(['mail.encryption' => $this->smptEncryption]);
                    config(['mail.username' => $this->mailUsername]); //logged user email
                    config(['mail.password' => $this->mailPassword]); //logged user email pass

                    $fromSettings = [
                        'address' => $this->mailUsername,
                        'name' => 'Encore Custom',
                    ];
                    config(['mail.from' => $fromSettings]);

                    $orderItems = OrderItem::where('order_id', $orderId)->where('factory_id', $factory_id)->get();
                    $orderItemArray = '';
                    foreach ($orderItems as $orderItem) {
                        $orderItemArray .= '<li>'.$orderItem->productDetails->product_name.'</li>';
                    }

                    $teamName = '<p style="margin-top: 0.1rem;">Team Name: '.$orderDetails->organizationDetails->organization_name.'</p>';
                    $exFactDate = '<p style="margin-top: 0.1rem;">Ex Factory Date: '.$suggestedExFac.'</p>';
                    $inHandDate = '<p style="margin-top: 0.1rem;">In Hand Due Date: '.$orderDetails->due_date.'</p>';

                    $data["to"] = $user->email;
                    $data["subject"] = 'New Ex. factory Date | Order - #'.$orderDetails->order_no.' | Team - '.$orderDetails->organizationDetails->organization_name;
                    $data["body"] = '<table>'. $teamName . $exFactDate . $inHandDate .'</table><p>New ex. factory date suggested for following items<a target="_blank" href="https://encr.co/order_details/edit/'.$orderId.'/order?active_tab=order">#'.$orderDetails->order_no.'</a></p><ul>'.$orderItemArray.'</ul>';

                    // Mail::send('emailNotification.factory_notification', $data, function ($message) use ($data) {
                    //     $message->to($data["to"]);
                    //     $message->cc($data["cc"]);
                    //     $message->subject($data["subject"]);
                    // });
                }
            }
        }
        email_Notify()->sendEmailFromTemplate('key_email_change_ex_factory_date', [
            'orderId' => $orderId,
            'orderNo' => $orderDetails->order_no,
            'organizationname' => $orderDetails->organizationDetails->organization_name,
            'send_relevent_factory' => true,
            'factorys_array' => $factoryArray,
            'suggestedExFac' => $suggestedExFac,
            'due_date' => $orderDetails->due_date,
            'order_link' => 'https://encr.co/order_details/edit/'.$orderId.'/order?active_tab=order',
        ]);
    }

    public function notifyEditsFactoryUsers(
        OrderItem $orderItem,
        array $itemChangedValues  = [],
        array $itemOriginalValues = [],
        array $sizeQtyChanges     = [],
        $notifyChanges = null,
        $isUrgent = 0,
        array $playerNameChanges  = [],
        array $numseqChanges      = []
    ) {
        if (!isset($orderItem->factory_id)) {
            return;
        }

        $order = Order::with(['organizationDetails', 'contactDetails'])->find($orderItem->order_id);
        if (!$order) {
            return;
        }

        $productName = $orderItem->display_name ?? optional($orderItem->productDetails)->product_name ?? '-';
        $changes = [];

        $whitelist = [
            'sub_product_no'        => 'Style Name',
            'display_name'          => 'Display Name',
            'fabric_id'              => 'Fabric',
            'secondary_fabric_id'    => 'Second Fabric',
            'embellishment_type_id'  => 'Embellishment',
            'clouser_type'           => 'Clouser Type',
            'ex_factory_date'        => 'Ex Factory Date',
            'in_hand_due_date'       => 'In Hand Due Date',
            'est_delivery_date'      => 'Est Delivery Date',
            'factory_id'             => 'Factory',
            'ex_factory_id'          => 'Ex-Factory Address',
            'order_status_id'        => 'Item Status',
            'unit_price'             => 'Unit Price',
            'tracking_no'            => 'Tracking No',
            'tracking_link'          => 'Tracking Link',
            'item_description'       => 'Item Description',
            'is_urgent'              => 'Urgent Status',
            'test_print_needed'      => 'Test Print Needed',
            'test_print_due_date'    => 'Test Print Due Date',
            'individual_no'          => 'Individual Number',
            'individual_name'        => 'Individual Name',
            'double_sided'           => 'Reversible',
            'pockets'                => 'Pockets',
            'zipper_pockets'         => 'Zipper Pockets',
            'contrast_stratching'    => 'Contrast Stitching',
            'printing_over_sems'     => 'Printing Over Seams',
            'dynamic_details'        => 'Dynamic Details',
        ];

        foreach ($itemChangedValues as $field => $newValue) {
            if (!isset($whitelist[$field])) {
                continue;
            }
            $oldValue = $itemOriginalValues[$field] ?? null;
            if ($this->valuesAreEqual($oldValue, $newValue)) {
                continue;
            }
            $changes[$field] = [
                'label'    => $whitelist[$field],
                'previous' => $this->resolveNotificationFieldValue($field, $oldValue),
                'current'  => $this->resolveNotificationFieldValue($field, $newValue),
            ];
        }

        foreach ($numseqChanges as $detailId => $fields) {
            foreach ($fields as $field => $diff) {
                if ($this->valuesAreEqual($diff['old'] ?? null, $diff['new'] ?? null)) {
                    continue;
                }
                $sizeName = optional(\App\Models\Size::find($diff['size_id'] ?? null))->size_name;
                $seqNo    = $this->wordSuffixToNumber(str_replace('numseq_', '', $field));
                $label    = trim(($sizeName ? $sizeName . ' - ' : '') . 'Number #' . ($seqNo ?? ''));

                $changes['numseq_' . $detailId . '_' . $field] = [
                    'label'    => $label,
                    'previous' => ($diff['old'] ?? '') !== '' ? $diff['old'] : '-',
                    'current'  => ($diff['new'] ?? '') !== '' ? $diff['new'] : '-',
                ];
            }
        }


        foreach ($sizeQtyChanges as $detailId => $diff) {
            if ($this->valuesAreEqual($diff['old'] ?? null, $diff['new'] ?? null)) {
                continue;
            }
            $sizeName = optional(\App\Models\Size::find($diff['size_id'] ?? null))->size_name ?? 'Unknown Size';

            $changes['size_qty_' . $detailId] = [
                'label'    => $sizeName,
                'previous' => ($diff['old'] ?? '') !== '' ? $diff['old'] : '-',
                'current'  => $diff['new'] ?? '-',
            ];
        }

        foreach ($playerNameChanges as $detailId => $fields) {
            foreach ($fields as $field => $diff) {
                if ($this->valuesAreEqual($diff['old'] ?? null, $diff['new'] ?? null)) {
                    continue;
                }
                $sizeName = optional(\App\Models\Size::find($diff['size_id'] ?? null))->size_name;

                if (strpos($field, 'blank_player_') === 0) {
                    $playerNo = ((int) str_replace('blank_player_', '', $field)) + 1;
                    $label    = trim(($sizeName ? $sizeName . ' - ' : '') . 'Blank Player ' . $playerNo);
                } else {
                    $playerNo = $this->wordSuffixToNumber(str_replace('player_', '', $field));
                    $label    = trim(($sizeName ? $sizeName . ' - ' : '') . 'Player ' . ($playerNo ?? ''));
                }

                $changes['player_' . $detailId . '_' . $field] = [
                    'label'    => $label,
                    'previous' => ($diff['old'] ?? '') !== '' && $diff['old'] !== null ? $diff['old'] : '-',
                    'current'  => ($diff['new'] ?? '') !== '' && $diff['new'] !== null ? $diff['new'] : '-',
                ];
            }
        }

        if (empty($changes)) {
            return; // nothing meaningful changed, don't send an empty email
        }


        $changeRows = '';
        foreach ($changes as $change) {
           $changeRows .= '<tr>'
            . '<td style="padding:12px 16px;font-size:13px;color:#111827;font-weight:700;border-bottom:1px solid #f0f0f0;word-break:break-word;">' . e($change['label']) . '</td>'
            . '<td style="padding:12px 16px;font-size:13px;color:#6b7280;border-bottom:1px solid #f0f0f0;word-break:break-word;">' . e($change['previous']) . '</td>'
            . '<td style="padding:12px 16px;font-size:13px;color:#111827;font-weight:700;border-bottom:1px solid #f0f0f0;word-break:break-word;">' . e($change['current']) . '</td>'
            . '</tr>';
        }

        $orderItemDetail = OrderItemsDetail::where('order_item_id', $orderItem->id)->first();
        $sizeName = $orderItemDetail->size_name ?? null;

        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_edit_item_details', [
            'orderId'            => $orderItem->order_id,
            'order_number'       => $order->order_no,
            'organization_name'  => optional($order->organizationDetails)->organization_name ?? '',
            'customer_details'   => trim(optional($order->contactDetails)->first_name . ' ' . optional($order->contactDetails)->last_name),
            'product_name'       => $productName,
            'size_name'          => $sizeName,
            'qty'                => $orderItem->qty,
            'edited_by'          => Auth::user()->name,
            'edited_on'          => Carbon::now()->format('F j, Y'),
            'changes_rows'       => $changeRows,
            'send_relevent_factory' => true,
            'factorys_array'     => [$orderItem->factory_id],
            'new_order_items'    => [$orderItem],
            'order_link'         => url("order_details/edit/{$orderItem->order_id}/order") . '?active_tab=' . $orderItem->id,
        ]);
    }

    public function pasteRoster(Request $request) {
        $isSizeExist = '';
        $orderItem = OrderItem::with('productDetails')->find($request->item_id);
        $copiedItem = OrderItem::with('productDetails')->find($request->copied_item_id);

        if ($orderItem->productDetails->size_id == $copiedItem->productDetails->size_id) {
            $isSizeExist = 'size_exist';

            $copiedItemDetails = OrderItemsDetail::where('order_item_id', $request->copied_item_id)->get();

            $totalQty = 0;
            $blankProductArray = [];
            foreach ($copiedItemDetails as $copiedItemDetail) {
                $orderItemsDetail = OrderItemsDetail::where('order_item_id', $request->item_id)->where('size_id', $copiedItemDetail->size_id)->first();

                if ($orderItemsDetail) {
                    $orderItem = OrderItem::find($request->item_id);
                    $orderItem->extra_size = $copiedItem->extra_size;
                    $orderItem->extra_size_two = $copiedItem->extra_size_two;
                    $orderItem->extra_size_three = $copiedItem->extra_size_three;
                    $orderItem->update();

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

                    if ($copiedItemDetail->numseq_hundred_one != ""){ $orderItemsDetail->numseq_hundred_one = $copiedItemDetail->numseq_hundred_one; } else { $orderItemsDetail->numseq_hundred_one = "";}
                    if ($copiedItemDetail->numseq_hundred_two != ""){ $orderItemsDetail->numseq_hundred_two = $copiedItemDetail->numseq_hundred_two; } else { $orderItemsDetail->numseq_hundred_two = "";}
                    if ($copiedItemDetail->numseq_hundred_three != ""){ $orderItemsDetail->numseq_hundred_three = $copiedItemDetail->numseq_hundred_three; } else { $orderItemsDetail->numseq_hundred_three = "";}
                    if ($copiedItemDetail->numseq_hundred_four != ""){ $orderItemsDetail->numseq_hundred_four = $copiedItemDetail->numseq_hundred_four; } else { $orderItemsDetail->numseq_hundred_four = "";}
                    if ($copiedItemDetail->numseq_hundred_five != ""){ $orderItemsDetail->numseq_hundred_five = $copiedItemDetail->numseq_hundred_five; } else { $orderItemsDetail->numseq_hundred_five = "";}
                    if ($copiedItemDetail->numseq_hundred_six != ""){ $orderItemsDetail->numseq_hundred_six = $copiedItemDetail->numseq_hundred_six; } else { $orderItemsDetail->numseq_hundred_six = "";}
                    if ($copiedItemDetail->numseq_hundred_seven != ""){ $orderItemsDetail->numseq_hundred_seven = $copiedItemDetail->numseq_hundred_seven; } else { $orderItemsDetail->numseq_hundred_seven = "";}
                    if ($copiedItemDetail->numseq_hundred_eight != ""){ $orderItemsDetail->numseq_hundred_eight = $copiedItemDetail->numseq_hundred_eight; } else { $orderItemsDetail->numseq_hundred_eight = "";}
                    if ($copiedItemDetail->numseq_hundred_nine != ""){ $orderItemsDetail->numseq_hundred_nine = $copiedItemDetail->numseq_hundred_nine; } else { $orderItemsDetail->numseq_hundred_nine = "";}
                    if ($copiedItemDetail->numseq_hundred_ten != ""){ $orderItemsDetail->numseq_hundred_ten = $copiedItemDetail->numseq_hundred_ten; } else { $orderItemsDetail->numseq_hundred_ten = "";}

                    if ($copiedItemDetail->numseq_hundred_eleven != ""){ $orderItemsDetail->numseq_hundred_eleven = $copiedItemDetail->numseq_hundred_eleven; } else { $orderItemsDetail->numseq_hundred_eleven = "";}
                    if ($copiedItemDetail->numseq_hundred_twelve != ""){ $orderItemsDetail->numseq_hundred_twelve = $copiedItemDetail->numseq_hundred_twelve; } else { $orderItemsDetail->numseq_hundred_twelve = "";}
                    if ($copiedItemDetail->numseq_hundred_thirteen != ""){ $orderItemsDetail->numseq_hundred_thirteen = $copiedItemDetail->numseq_hundred_thirteen; } else { $orderItemsDetail->numseq_hundred_thirteen = "";}
                    if ($copiedItemDetail->numseq_hundred_fourteen != ""){ $orderItemsDetail->numseq_hundred_fourteen = $copiedItemDetail->numseq_hundred_fourteen; } else { $orderItemsDetail->numseq_hundred_fourteen = "";}
                    if ($copiedItemDetail->numseq_hundred_fifteen != ""){ $orderItemsDetail->numseq_hundred_fifteen = $copiedItemDetail->numseq_hundred_fifteen; } else { $orderItemsDetail->numseq_hundred_fifteen = "";}
                    if ($copiedItemDetail->numseq_hundred_sixteen != ""){ $orderItemsDetail->numseq_hundred_sixteen = $copiedItemDetail->numseq_hundred_sixteen; } else { $orderItemsDetail->numseq_hundred_sixteen = "";}
                    if ($copiedItemDetail->numseq_hundred_seventeen != ""){ $orderItemsDetail->numseq_hundred_seventeen = $copiedItemDetail->numseq_hundred_seventeen; } else { $orderItemsDetail->numseq_hundred_seventeen = "";}
                    if ($copiedItemDetail->numseq_hundred_eighteen != ""){ $orderItemsDetail->numseq_hundred_eighteen = $copiedItemDetail->numseq_hundred_eighteen; } else { $orderItemsDetail->numseq_hundred_eighteen = "";}
                    if ($copiedItemDetail->numseq_hundred_nineteen != ""){ $orderItemsDetail->numseq_hundred_nineteen = $copiedItemDetail->numseq_hundred_nineteen; } else { $orderItemsDetail->numseq_hundred_nineteen = "";}
                    if ($copiedItemDetail->numseq_hundred_twenty != ""){ $orderItemsDetail->numseq_hundred_twenty = $copiedItemDetail->numseq_hundred_twenty; } else { $orderItemsDetail->numseq_hundred_twenty = "";}

                    if ($copiedItemDetail->numseq_hundred_twenty_one != ""){ $orderItemsDetail->numseq_hundred_twenty_one = $copiedItemDetail->numseq_hundred_twenty_one; } else { $orderItemsDetail->numseq_hundred_twenty_one = "";}
                    if ($copiedItemDetail->numseq_hundred_twenty_two != ""){ $orderItemsDetail->numseq_hundred_twenty_two = $copiedItemDetail->numseq_hundred_twenty_two; } else { $orderItemsDetail->numseq_hundred_twenty_two = "";}
                    if ($copiedItemDetail->numseq_hundred_twenty_three != ""){ $orderItemsDetail->numseq_hundred_twenty_three = $copiedItemDetail->numseq_hundred_twenty_three; } else { $orderItemsDetail->numseq_hundred_twenty_three = "";}
                    if ($copiedItemDetail->numseq_hundred_twenty_four != ""){ $orderItemsDetail->numseq_hundred_twenty_four = $copiedItemDetail->numseq_hundred_twenty_four; } else { $orderItemsDetail->numseq_hundred_twenty_four = "";}
                    if ($copiedItemDetail->numseq_hundred_twenty_five != ""){ $orderItemsDetail->numseq_hundred_twenty_five = $copiedItemDetail->numseq_hundred_twenty_five; } else { $orderItemsDetail->numseq_hundred_twenty_five = "";}
                    if ($copiedItemDetail->numseq_hundred_twenty_six != ""){ $orderItemsDetail->numseq_hundred_twenty_six = $copiedItemDetail->numseq_hundred_twenty_six; } else { $orderItemsDetail->numseq_hundred_twenty_six = "";}
                    if ($copiedItemDetail->numseq_hundred_twenty_seven != ""){ $orderItemsDetail->numseq_hundred_twenty_seven = $copiedItemDetail->numseq_hundred_twenty_seven; } else { $orderItemsDetail->numseq_hundred_twenty_seven = "";}
                    if ($copiedItemDetail->numseq_hundred_twenty_eight != ""){ $orderItemsDetail->numseq_hundred_twenty_eight = $copiedItemDetail->numseq_hundred_twenty_eight; } else { $orderItemsDetail->numseq_hundred_twenty_eight = "";}
                    if ($copiedItemDetail->numseq_hundred_twenty_nine != ""){ $orderItemsDetail->numseq_hundred_twenty_nine = $copiedItemDetail->numseq_hundred_twenty_nine; } else { $orderItemsDetail->numseq_hundred_twenty_nine = "";}
                    if ($copiedItemDetail->numseq_hundred_thirty != ""){ $orderItemsDetail->numseq_hundred_thirty = $copiedItemDetail->numseq_hundred_thirty; } else { $orderItemsDetail->numseq_hundred_thirty = "";}

                    if ($copiedItemDetail->numseq_hundred_thirty_one != ""){ $orderItemsDetail->numseq_hundred_thirty_one = $copiedItemDetail->numseq_hundred_thirty_one; } else { $orderItemsDetail->numseq_hundred_thirty_one = "";}
                    if ($copiedItemDetail->numseq_hundred_thirty_two != ""){ $orderItemsDetail->numseq_hundred_thirty_two = $copiedItemDetail->numseq_hundred_thirty_two; } else { $orderItemsDetail->numseq_hundred_thirty_two = "";}
                    if ($copiedItemDetail->numseq_hundred_thirty_three != ""){ $orderItemsDetail->numseq_hundred_thirty_three = $copiedItemDetail->numseq_hundred_thirty_three; } else { $orderItemsDetail->numseq_hundred_thirty_three = "";}
                    if ($copiedItemDetail->numseq_hundred_thirty_four != ""){ $orderItemsDetail->numseq_hundred_thirty_four = $copiedItemDetail->numseq_hundred_thirty_four; } else { $orderItemsDetail->numseq_hundred_thirty_four = "";}
                    if ($copiedItemDetail->numseq_hundred_thirty_five != ""){ $orderItemsDetail->numseq_hundred_thirty_five = $copiedItemDetail->numseq_hundred_thirty_five; } else { $orderItemsDetail->numseq_hundred_thirty_five = "";}
                    if ($copiedItemDetail->numseq_hundred_thirty_six != ""){ $orderItemsDetail->numseq_hundred_thirty_six = $copiedItemDetail->numseq_hundred_thirty_six; } else { $orderItemsDetail->numseq_hundred_thirty_six = "";}
                    if ($copiedItemDetail->numseq_hundred_thirty_seven != ""){ $orderItemsDetail->numseq_hundred_thirty_seven = $copiedItemDetail->numseq_hundred_thirty_seven; } else { $orderItemsDetail->numseq_hundred_thirty_seven = "";}
                    if ($copiedItemDetail->numseq_hundred_thirty_eight != ""){ $orderItemsDetail->numseq_hundred_thirty_eight = $copiedItemDetail->numseq_hundred_thirty_eight; } else { $orderItemsDetail->numseq_hundred_thirty_eight = "";}
                    if ($copiedItemDetail->numseq_hundred_thirty_nine != ""){ $orderItemsDetail->numseq_hundred_thirty_nine = $copiedItemDetail->numseq_hundred_thirty_nine; } else { $orderItemsDetail->numseq_hundred_thirty_nine = "";}
                    if ($copiedItemDetail->numseq_hundred_forty != ""){ $orderItemsDetail->numseq_hundred_forty = $copiedItemDetail->numseq_hundred_forty; } else { $orderItemsDetail->numseq_hundred_forty = "";}

                    if ($copiedItemDetail->numseq_hundred_forty_one != ""){ $orderItemsDetail->numseq_hundred_forty_one = $copiedItemDetail->numseq_hundred_forty_one; } else { $orderItemsDetail->numseq_hundred_forty_one = "";}
                    if ($copiedItemDetail->numseq_hundred_forty_two != ""){ $orderItemsDetail->numseq_hundred_forty_two = $copiedItemDetail->numseq_hundred_forty_two; } else { $orderItemsDetail->numseq_hundred_forty_two = "";}
                    if ($copiedItemDetail->numseq_hundred_forty_three != ""){ $orderItemsDetail->numseq_hundred_forty_three = $copiedItemDetail->numseq_hundred_forty_three; } else { $orderItemsDetail->numseq_hundred_forty_three = "";}
                    if ($copiedItemDetail->numseq_hundred_forty_four != ""){ $orderItemsDetail->numseq_hundred_forty_four = $copiedItemDetail->numseq_hundred_forty_four; } else { $orderItemsDetail->numseq_hundred_forty_four = "";}
                    if ($copiedItemDetail->numseq_hundred_forty_five != ""){ $orderItemsDetail->numseq_hundred_forty_five = $copiedItemDetail->numseq_hundred_forty_five; } else { $orderItemsDetail->numseq_hundred_forty_five = "";}
                    if ($copiedItemDetail->numseq_hundred_forty_six != ""){ $orderItemsDetail->numseq_hundred_forty_six = $copiedItemDetail->numseq_hundred_forty_six; } else { $orderItemsDetail->numseq_hundred_forty_six = "";}
                    if ($copiedItemDetail->numseq_hundred_forty_seven != ""){ $orderItemsDetail->numseq_hundred_forty_seven = $copiedItemDetail->numseq_hundred_forty_seven; } else { $orderItemsDetail->numseq_hundred_forty_seven = "";}
                    if ($copiedItemDetail->numseq_hundred_forty_eight != ""){ $orderItemsDetail->numseq_hundred_forty_eight = $copiedItemDetail->numseq_hundred_forty_eight; } else { $orderItemsDetail->numseq_hundred_forty_eight = "";}
                    if ($copiedItemDetail->numseq_hundred_forty_nine != ""){ $orderItemsDetail->numseq_hundred_forty_nine = $copiedItemDetail->numseq_hundred_forty_nine; } else { $orderItemsDetail->numseq_hundred_forty_nine = "";}
                    if ($copiedItemDetail->numseq_hundred_fifty != ""){ $orderItemsDetail->numseq_hundred_fifty = $copiedItemDetail->numseq_hundred_fifty; } else { $orderItemsDetail->numseq_hundred_fifty = "";}
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

                            if(isset($copiedItemPlayers->player_hundred_one) && $copiedItemPlayers->player_hundred_one != ""){$orderItemPlayers->player_hundred_one = $copiedItemPlayers->player_hundred_one;}else{$orderItemPlayers->player_hundred_one = "";}
                            if(isset($copiedItemPlayers->player_hundred_two) && $copiedItemPlayers->player_hundred_two != ""){$orderItemPlayers->player_hundred_two = $copiedItemPlayers->player_hundred_two;}else{$orderItemPlayers->player_hundred_two = "";}
                            if(isset($copiedItemPlayers->player_hundred_three) && $copiedItemPlayers->player_hundred_three != ""){$orderItemPlayers->player_hundred_three = $copiedItemPlayers->player_hundred_three;}else{$orderItemPlayers->player_hundred_three = "";}
                            if(isset($copiedItemPlayers->player_hundred_four) && $copiedItemPlayers->player_hundred_four != ""){$orderItemPlayers->player_hundred_four = $copiedItemPlayers->player_hundred_four;}else{$orderItemPlayers->player_hundred_four = "";}
                            if(isset($copiedItemPlayers->player_hundred_five) && $copiedItemPlayers->player_hundred_five != ""){$orderItemPlayers->player_hundred_five = $copiedItemPlayers->player_hundred_five;}else{$orderItemPlayers->player_hundred_five = "";}
                            if(isset($copiedItemPlayers->player_hundred_six) && $copiedItemPlayers->player_hundred_six != ""){$orderItemPlayers->player_hundred_six = $copiedItemPlayers->player_hundred_six;}else{$orderItemPlayers->player_hundred_six = "";}
                            if(isset($copiedItemPlayers->player_hundred_seven) && $copiedItemPlayers->player_hundred_seven != ""){$orderItemPlayers->player_hundred_seven = $copiedItemPlayers->player_hundred_seven;}else{$orderItemPlayers->player_hundred_seven = "";}
                            if(isset($copiedItemPlayers->player_hundred_eight) && $copiedItemPlayers->player_hundred_eight != ""){$orderItemPlayers->player_hundred_eight = $copiedItemPlayers->player_hundred_eight;}else{$orderItemPlayers->player_hundred_eight = "";}
                            if(isset($copiedItemPlayers->player_hundred_nine) && $copiedItemPlayers->player_hundred_nine != ""){$orderItemPlayers->player_hundred_nine = $copiedItemPlayers->player_hundred_nine;}else{$orderItemPlayers->player_hundred_nine = "";}
                            if(isset($copiedItemPlayers->player_hundred_ten) && $copiedItemPlayers->player_hundred_ten != ""){$orderItemPlayers->player_hundred_ten = $copiedItemPlayers->player_hundred_ten;}else{$orderItemPlayers->player_hundred_ten = "";}

                            if(isset($copiedItemPlayers->player_hundred_eleven) && $copiedItemPlayers->player_hundred_eleven != ""){$orderItemPlayers->player_hundred_eleven = $copiedItemPlayers->player_hundred_eleven;}else{$orderItemPlayers->player_hundred_eleven = "";}
                            if(isset($copiedItemPlayers->player_hundred_twelve) && $copiedItemPlayers->player_hundred_twelve != ""){$orderItemPlayers->player_hundred_twelve = $copiedItemPlayers->player_hundred_twelve;}else{$orderItemPlayers->player_hundred_twelve = "";}
                            if(isset($copiedItemPlayers->player_hundred_thirteen) && $copiedItemPlayers->player_hundred_thirteen != ""){$orderItemPlayers->player_hundred_thirteen = $copiedItemPlayers->player_hundred_thirteen;}else{$orderItemPlayers->player_hundred_thirteen = "";}
                            if(isset($copiedItemPlayers->player_hundred_fourteen) && $copiedItemPlayers->player_hundred_fourteen != ""){$orderItemPlayers->player_hundred_fourteen = $copiedItemPlayers->player_hundred_fourteen;}else{$orderItemPlayers->player_hundred_fourteen = "";}
                            if(isset($copiedItemPlayers->player_hundred_fifteen) && $copiedItemPlayers->player_hundred_fifteen != ""){$orderItemPlayers->player_hundred_fifteen = $copiedItemPlayers->player_hundred_fifteen;}else{$orderItemPlayers->player_hundred_fifteen = "";}
                            if(isset($copiedItemPlayers->player_hundred_sixteen) && $copiedItemPlayers->player_hundred_sixteen != ""){$orderItemPlayers->player_hundred_sixteen = $copiedItemPlayers->player_hundred_sixteen;}else{$orderItemPlayers->player_hundred_sixteen = "";}
                            if(isset($copiedItemPlayers->player_hundred_seventeen) && $copiedItemPlayers->player_hundred_seventeen != ""){$orderItemPlayers->player_hundred_seventeen = $copiedItemPlayers->player_hundred_seventeen;}else{$orderItemPlayers->player_hundred_seventeen = "";}
                            if(isset($copiedItemPlayers->player_hundred_eighteen) && $copiedItemPlayers->player_hundred_eighteen != ""){$orderItemPlayers->player_hundred_eighteen = $copiedItemPlayers->player_hundred_eighteen;}else{$orderItemPlayers->player_hundred_eighteen = "";}
                            if(isset($copiedItemPlayers->player_hundred_nineteen) && $copiedItemPlayers->player_hundred_nineteen != ""){$orderItemPlayers->player_hundred_nineteen = $copiedItemPlayers->player_hundred_nineteen;}else{$orderItemPlayers->player_hundred_nineteen = "";}
                            if(isset($copiedItemPlayers->player_hundred_twenty) && $copiedItemPlayers->player_hundred_twenty != ""){$orderItemPlayers->player_hundred_twenty = $copiedItemPlayers->player_hundred_twenty;}else{$orderItemPlayers->player_hundred_twenty = "";}

                            if(isset($copiedItemPlayers->player_hundred_twenty_one) && $copiedItemPlayers->player_hundred_twenty_one != ""){$orderItemPlayers->player_hundred_twenty_one = $copiedItemPlayers->player_hundred_twenty_one;}else{$orderItemPlayers->player_hundred_twenty_one = "";}
                            if(isset($copiedItemPlayers->player_hundred_twenty_two) && $copiedItemPlayers->player_hundred_twenty_two != ""){$orderItemPlayers->player_hundred_twenty_two = $copiedItemPlayers->player_hundred_twenty_two;}else{$orderItemPlayers->player_hundred_twenty_two = "";}
                            if(isset($copiedItemPlayers->player_hundred_twenty_three) && $copiedItemPlayers->player_hundred_twenty_three != ""){$orderItemPlayers->player_hundred_twenty_three = $copiedItemPlayers->player_hundred_twenty_three;}else{$orderItemPlayers->player_hundred_twenty_three = "";}
                            if(isset($copiedItemPlayers->player_hundred_twenty_four) && $copiedItemPlayers->player_hundred_twenty_four != ""){$orderItemPlayers->player_hundred_twenty_four = $copiedItemPlayers->player_hundred_twenty_four;}else{$orderItemPlayers->player_hundred_twenty_four = "";}
                            if(isset($copiedItemPlayers->player_hundred_twenty_five) && $copiedItemPlayers->player_hundred_twenty_five != ""){$orderItemPlayers->player_hundred_twenty_five = $copiedItemPlayers->player_hundred_twenty_five;}else{$orderItemPlayers->player_hundred_twenty_five = "";}
                            if(isset($copiedItemPlayers->player_hundred_twenty_six) && $copiedItemPlayers->player_hundred_twenty_six != ""){$orderItemPlayers->player_hundred_twenty_six = $copiedItemPlayers->player_hundred_twenty_six;}else{$orderItemPlayers->player_hundred_twenty_six = "";}
                            if(isset($copiedItemPlayers->player_hundred_twenty_seven) && $copiedItemPlayers->player_hundred_twenty_seven != ""){$orderItemPlayers->player_hundred_twenty_seven = $copiedItemPlayers->player_hundred_twenty_seven;}else{$orderItemPlayers->player_hundred_twenty_seven = "";}
                            if(isset($copiedItemPlayers->player_hundred_twenty_eight) && $copiedItemPlayers->player_hundred_twenty_eight != ""){$orderItemPlayers->player_hundred_twenty_eight = $copiedItemPlayers->player_hundred_twenty_eight;}else{$orderItemPlayers->player_hundred_twenty_eight = "";}
                            if(isset($copiedItemPlayers->player_hundred_twenty_nine) && $copiedItemPlayers->player_hundred_twenty_nine != ""){$orderItemPlayers->player_hundred_twenty_nine = $copiedItemPlayers->player_hundred_twenty_nine;}else{$orderItemPlayers->player_hundred_twenty_nine = "";}
                            if(isset($copiedItemPlayers->player_hundred_thirty) && $copiedItemPlayers->player_hundred_thirty != ""){$orderItemPlayers->player_hundred_thirty = $copiedItemPlayers->player_hundred_thirty;}else{$orderItemPlayers->player_hundred_thirty = "";}

                            if(isset($copiedItemPlayers->player_hundred_thirty_one) && $copiedItemPlayers->player_hundred_thirty_one != ""){$orderItemPlayers->player_hundred_thirty_one = $copiedItemPlayers->player_hundred_thirty_one;}else{$orderItemPlayers->player_hundred_thirty_one = "";}
                            if(isset($copiedItemPlayers->player_hundred_thirty_two) && $copiedItemPlayers->player_hundred_thirty_two != ""){$orderItemPlayers->player_hundred_thirty_two = $copiedItemPlayers->player_hundred_thirty_two;}else{$orderItemPlayers->player_hundred_thirty_two = "";}
                            if(isset($copiedItemPlayers->player_hundred_thirty_three) && $copiedItemPlayers->player_hundred_thirty_three != ""){$orderItemPlayers->player_hundred_thirty_three = $copiedItemPlayers->player_hundred_thirty_three;}else{$orderItemPlayers->player_hundred_thirty_three = "";}
                            if(isset($copiedItemPlayers->player_hundred_thirty_four) && $copiedItemPlayers->player_hundred_thirty_four != ""){$orderItemPlayers->player_hundred_thirty_four = $copiedItemPlayers->player_hundred_thirty_four;}else{$orderItemPlayers->player_hundred_thirty_four = "";}
                            if(isset($copiedItemPlayers->player_hundred_thirty_five) && $copiedItemPlayers->player_hundred_thirty_five != ""){$orderItemPlayers->player_hundred_thirty_five = $copiedItemPlayers->player_hundred_thirty_five;}else{$orderItemPlayers->player_hundred_thirty_five = "";}
                            if(isset($copiedItemPlayers->player_hundred_thirty_six) && $copiedItemPlayers->player_hundred_thirty_six != ""){$orderItemPlayers->player_hundred_thirty_six = $copiedItemPlayers->player_hundred_thirty_six;}else{$orderItemPlayers->player_hundred_thirty_six = "";}
                            if(isset($copiedItemPlayers->player_hundred_thirty_seven) && $copiedItemPlayers->player_hundred_thirty_seven != ""){$orderItemPlayers->player_hundred_thirty_seven = $copiedItemPlayers->player_hundred_thirty_seven;}else{$orderItemPlayers->player_hundred_thirty_seven = "";}
                            if(isset($copiedItemPlayers->player_hundred_thirty_eight) && $copiedItemPlayers->player_hundred_thirty_eight != ""){$orderItemPlayers->player_hundred_thirty_eight = $copiedItemPlayers->player_hundred_thirty_eight;}else{$orderItemPlayers->player_hundred_thirty_eight = "";}
                            if(isset($copiedItemPlayers->player_hundred_thirty_nine) && $copiedItemPlayers->player_hundred_thirty_nine != ""){$orderItemPlayers->player_hundred_thirty_nine = $copiedItemPlayers->player_hundred_thirty_nine;}else{$orderItemPlayers->player_hundred_thirty_nine = "";}
                            if(isset($copiedItemPlayers->player_hundred_forty) && $copiedItemPlayers->player_hundred_forty != ""){$orderItemPlayers->player_hundred_forty = $copiedItemPlayers->player_hundred_forty;}else{$orderItemPlayers->player_hundred_forty = "";}

                            if(isset($copiedItemPlayers->player_hundred_forty_one) && $copiedItemPlayers->player_hundred_forty_one != ""){$orderItemPlayers->player_hundred_forty_one = $copiedItemPlayers->player_hundred_forty_one;}else{$orderItemPlayers->player_hundred_forty_one = "";}
                            if(isset($copiedItemPlayers->player_hundred_forty_two) && $copiedItemPlayers->player_hundred_forty_two != ""){$orderItemPlayers->player_hundred_forty_two = $copiedItemPlayers->player_hundred_forty_two;}else{$orderItemPlayers->player_hundred_forty_two = "";}
                            if(isset($copiedItemPlayers->player_hundred_forty_three) && $copiedItemPlayers->player_hundred_forty_three != ""){$orderItemPlayers->player_hundred_forty_three = $copiedItemPlayers->player_hundred_forty_three;}else{$orderItemPlayers->player_hundred_forty_three = "";}
                            if(isset($copiedItemPlayers->player_hundred_forty_four) && $copiedItemPlayers->player_hundred_forty_four != ""){$orderItemPlayers->player_hundred_forty_four = $copiedItemPlayers->player_hundred_forty_four;}else{$orderItemPlayers->player_hundred_forty_four = "";}
                            if(isset($copiedItemPlayers->player_hundred_forty_five) && $copiedItemPlayers->player_hundred_forty_five != ""){$orderItemPlayers->player_hundred_forty_five = $copiedItemPlayers->player_hundred_forty_five;}else{$orderItemPlayers->player_hundred_forty_five = "";}
                            if(isset($copiedItemPlayers->player_hundred_forty_six) && $copiedItemPlayers->player_hundred_forty_six != ""){$orderItemPlayers->player_hundred_forty_six = $copiedItemPlayers->player_hundred_forty_six;}else{$orderItemPlayers->player_hundred_forty_six = "";}
                            if(isset($copiedItemPlayers->player_hundred_forty_seven) && $copiedItemPlayers->player_hundred_forty_seven != ""){$orderItemPlayers->player_hundred_forty_seven = $copiedItemPlayers->player_hundred_forty_seven;}else{$orderItemPlayers->player_hundred_forty_seven = "";}
                            if(isset($copiedItemPlayers->player_hundred_forty_eight) && $copiedItemPlayers->player_hundred_forty_eight != ""){$orderItemPlayers->player_hundred_forty_eight = $copiedItemPlayers->player_hundred_forty_eight;}else{$orderItemPlayers->player_hundred_forty_eight = "";}
                            if(isset($copiedItemPlayers->player_hundred_forty_nine) && $copiedItemPlayers->player_hundred_forty_nine != ""){$orderItemPlayers->player_hundred_forty_nine = $copiedItemPlayers->player_hundred_forty_nine;}else{$orderItemPlayers->player_hundred_forty_nine = "";}
                            if(isset($copiedItemPlayers->player_hundred_fifty) && $copiedItemPlayers->player_hundred_fifty != ""){$orderItemPlayers->player_hundred_fifty = $copiedItemPlayers->player_hundred_fifty;}else{$orderItemPlayers->player_hundred_fifty = "";}

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

                            if(isset($copiedItemPlayers->player_hundred_one) && $copiedItemPlayers->player_hundred_one != ""){$orderItemPlayers->player_hundred_one = $copiedItemPlayers->player_hundred_one;}else{$orderItemPlayers->player_hundred_one = "";}
                            if(isset($copiedItemPlayers->player_hundred_two) && $copiedItemPlayers->player_hundred_two != ""){$orderItemPlayers->player_hundred_two = $copiedItemPlayers->player_hundred_two;}else{$orderItemPlayers->player_hundred_two = "";}
                            if(isset($copiedItemPlayers->player_hundred_three) && $copiedItemPlayers->player_hundred_three != ""){$orderItemPlayers->player_hundred_three = $copiedItemPlayers->player_hundred_three;}else{$orderItemPlayers->player_hundred_three = "";}
                            if(isset($copiedItemPlayers->player_hundred_four) && $copiedItemPlayers->player_hundred_four != ""){$orderItemPlayers->player_hundred_four = $copiedItemPlayers->player_hundred_four;}else{$orderItemPlayers->player_hundred_four = "";}
                            if(isset($copiedItemPlayers->player_hundred_five) && $copiedItemPlayers->player_hundred_five != ""){$orderItemPlayers->player_hundred_five = $copiedItemPlayers->player_hundred_five;}else{$orderItemPlayers->player_hundred_five = "";}
                            if(isset($copiedItemPlayers->player_hundred_six) && $copiedItemPlayers->player_hundred_six != ""){$orderItemPlayers->player_hundred_six = $copiedItemPlayers->player_hundred_six;}else{$orderItemPlayers->player_hundred_six = "";}
                            if(isset($copiedItemPlayers->player_hundred_seven) && $copiedItemPlayers->player_hundred_seven != ""){$orderItemPlayers->player_hundred_seven = $copiedItemPlayers->player_hundred_seven;}else{$orderItemPlayers->player_hundred_seven = "";}
                            if(isset($copiedItemPlayers->player_hundred_eight) && $copiedItemPlayers->player_hundred_eight != ""){$orderItemPlayers->player_hundred_eight = $copiedItemPlayers->player_hundred_eight;}else{$orderItemPlayers->player_hundred_eight = "";}
                            if(isset($copiedItemPlayers->player_hundred_nine) && $copiedItemPlayers->player_hundred_nine != ""){$orderItemPlayers->player_hundred_nine = $copiedItemPlayers->player_hundred_nine;}else{$orderItemPlayers->player_hundred_nine = "";}
                            if(isset($copiedItemPlayers->player_hundred_ten) && $copiedItemPlayers->player_hundred_ten != ""){$orderItemPlayers->player_hundred_ten = $copiedItemPlayers->player_hundred_ten;}else{$orderItemPlayers->player_hundred_ten = "";}

                            if(isset($copiedItemPlayers->player_hundred_eleven) && $copiedItemPlayers->player_hundred_eleven != ""){$orderItemPlayers->player_hundred_eleven = $copiedItemPlayers->player_hundred_eleven;}else{$orderItemPlayers->player_hundred_eleven = "";}
                            if(isset($copiedItemPlayers->player_hundred_twelve) && $copiedItemPlayers->player_hundred_twelve != ""){$orderItemPlayers->player_hundred_twelve = $copiedItemPlayers->player_hundred_twelve;}else{$orderItemPlayers->player_hundred_twelve = "";}
                            if(isset($copiedItemPlayers->player_hundred_thirteen) && $copiedItemPlayers->player_hundred_thirteen != ""){$orderItemPlayers->player_hundred_thirteen = $copiedItemPlayers->player_hundred_thirteen;}else{$orderItemPlayers->player_hundred_thirteen = "";}
                            if(isset($copiedItemPlayers->player_hundred_fourteen) && $copiedItemPlayers->player_hundred_fourteen != ""){$orderItemPlayers->player_hundred_fourteen = $copiedItemPlayers->player_hundred_fourteen;}else{$orderItemPlayers->player_hundred_fourteen = "";}
                            if(isset($copiedItemPlayers->player_hundred_fifteen) && $copiedItemPlayers->player_hundred_fifteen != ""){$orderItemPlayers->player_hundred_fifteen = $copiedItemPlayers->player_hundred_fifteen;}else{$orderItemPlayers->player_hundred_fifteen = "";}
                            if(isset($copiedItemPlayers->player_hundred_sixteen) && $copiedItemPlayers->player_hundred_sixteen != ""){$orderItemPlayers->player_hundred_sixteen = $copiedItemPlayers->player_hundred_sixteen;}else{$orderItemPlayers->player_hundred_sixteen = "";}
                            if(isset($copiedItemPlayers->player_hundred_seventeen) && $copiedItemPlayers->player_hundred_seventeen != ""){$orderItemPlayers->player_hundred_seventeen = $copiedItemPlayers->player_hundred_seventeen;}else{$orderItemPlayers->player_hundred_seventeen = "";}
                            if(isset($copiedItemPlayers->player_hundred_eighteen) && $copiedItemPlayers->player_hundred_eighteen != ""){$orderItemPlayers->player_hundred_eighteen = $copiedItemPlayers->player_hundred_eighteen;}else{$orderItemPlayers->player_hundred_eighteen = "";}
                            if(isset($copiedItemPlayers->player_hundred_nineteen) && $copiedItemPlayers->player_hundred_nineteen != ""){$orderItemPlayers->player_hundred_nineteen = $copiedItemPlayers->player_hundred_nineteen;}else{$orderItemPlayers->player_hundred_nineteen = "";}
                            if(isset($copiedItemPlayers->player_hundred_twenty) && $copiedItemPlayers->player_hundred_twenty != ""){$orderItemPlayers->player_hundred_twenty = $copiedItemPlayers->player_hundred_twenty;}else{$orderItemPlayers->player_hundred_twenty = "";}

                            if(isset($copiedItemPlayers->player_hundred_twenty_one) && $copiedItemPlayers->player_hundred_twenty_one != ""){$orderItemPlayers->player_hundred_twenty_one = $copiedItemPlayers->player_hundred_twenty_one;}else{$orderItemPlayers->player_hundred_twenty_one = "";}
                            if(isset($copiedItemPlayers->player_hundred_twenty_two) && $copiedItemPlayers->player_hundred_twenty_two != ""){$orderItemPlayers->player_hundred_twenty_two = $copiedItemPlayers->player_hundred_twenty_two;}else{$orderItemPlayers->player_hundred_twenty_two = "";}
                            if(isset($copiedItemPlayers->player_hundred_twenty_three) && $copiedItemPlayers->player_hundred_twenty_three != ""){$orderItemPlayers->player_hundred_twenty_three = $copiedItemPlayers->player_hundred_twenty_three;}else{$orderItemPlayers->player_hundred_twenty_three = "";}
                            if(isset($copiedItemPlayers->player_hundred_twenty_four) && $copiedItemPlayers->player_hundred_twenty_four != ""){$orderItemPlayers->player_hundred_twenty_four = $copiedItemPlayers->player_hundred_twenty_four;}else{$orderItemPlayers->player_hundred_twenty_four = "";}
                            if(isset($copiedItemPlayers->player_hundred_twenty_five) && $copiedItemPlayers->player_hundred_twenty_five != ""){$orderItemPlayers->player_hundred_twenty_five = $copiedItemPlayers->player_hundred_twenty_five;}else{$orderItemPlayers->player_hundred_twenty_five = "";}
                            if(isset($copiedItemPlayers->player_hundred_twenty_six) && $copiedItemPlayers->player_hundred_twenty_six != ""){$orderItemPlayers->player_hundred_twenty_six = $copiedItemPlayers->player_hundred_twenty_six;}else{$orderItemPlayers->player_hundred_twenty_six = "";}
                            if(isset($copiedItemPlayers->player_hundred_twenty_seven) && $copiedItemPlayers->player_hundred_twenty_seven != ""){$orderItemPlayers->player_hundred_twenty_seven = $copiedItemPlayers->player_hundred_twenty_seven;}else{$orderItemPlayers->player_hundred_twenty_seven = "";}
                            if(isset($copiedItemPlayers->player_hundred_twenty_eight) && $copiedItemPlayers->player_hundred_twenty_eight != ""){$orderItemPlayers->player_hundred_twenty_eight = $copiedItemPlayers->player_hundred_twenty_eight;}else{$orderItemPlayers->player_hundred_twenty_eight = "";}
                            if(isset($copiedItemPlayers->player_hundred_twenty_nine) && $copiedItemPlayers->player_hundred_twenty_nine != ""){$orderItemPlayers->player_hundred_twenty_nine = $copiedItemPlayers->player_hundred_twenty_nine;}else{$orderItemPlayers->player_hundred_twenty_nine = "";}
                            if(isset($copiedItemPlayers->player_hundred_thirty) && $copiedItemPlayers->player_hundred_thirty != ""){$orderItemPlayers->player_hundred_thirty = $copiedItemPlayers->player_hundred_thirty;}else{$orderItemPlayers->player_hundred_thirty = "";}

                            if(isset($copiedItemPlayers->player_hundred_thirty_one) && $copiedItemPlayers->player_hundred_thirty_one != ""){$orderItemPlayers->player_hundred_thirty_one = $copiedItemPlayers->player_hundred_thirty_one;}else{$orderItemPlayers->player_hundred_thirty_one = "";}
                            if(isset($copiedItemPlayers->player_hundred_thirty_two) && $copiedItemPlayers->player_hundred_thirty_two != ""){$orderItemPlayers->player_hundred_thirty_two = $copiedItemPlayers->player_hundred_thirty_two;}else{$orderItemPlayers->player_hundred_thirty_two = "";}
                            if(isset($copiedItemPlayers->player_hundred_thirty_three) && $copiedItemPlayers->player_hundred_thirty_three != ""){$orderItemPlayers->player_hundred_thirty_three = $copiedItemPlayers->player_hundred_thirty_three;}else{$orderItemPlayers->player_hundred_thirty_three = "";}
                            if(isset($copiedItemPlayers->player_hundred_thirty_four) && $copiedItemPlayers->player_hundred_thirty_four != ""){$orderItemPlayers->player_hundred_thirty_four = $copiedItemPlayers->player_hundred_thirty_four;}else{$orderItemPlayers->player_hundred_thirty_four = "";}
                            if(isset($copiedItemPlayers->player_hundred_thirty_five) && $copiedItemPlayers->player_hundred_thirty_five != ""){$orderItemPlayers->player_hundred_thirty_five = $copiedItemPlayers->player_hundred_thirty_five;}else{$orderItemPlayers->player_hundred_thirty_five = "";}
                            if(isset($copiedItemPlayers->player_hundred_thirty_six) && $copiedItemPlayers->player_hundred_thirty_six != ""){$orderItemPlayers->player_hundred_thirty_six = $copiedItemPlayers->player_hundred_thirty_six;}else{$orderItemPlayers->player_hundred_thirty_six = "";}
                            if(isset($copiedItemPlayers->player_hundred_thirty_seven) && $copiedItemPlayers->player_hundred_thirty_seven != ""){$orderItemPlayers->player_hundred_thirty_seven = $copiedItemPlayers->player_hundred_thirty_seven;}else{$orderItemPlayers->player_hundred_thirty_seven = "";}
                            if(isset($copiedItemPlayers->player_hundred_thirty_eight) && $copiedItemPlayers->player_hundred_thirty_eight != ""){$orderItemPlayers->player_hundred_thirty_eight = $copiedItemPlayers->player_hundred_thirty_eight;}else{$orderItemPlayers->player_hundred_thirty_eight = "";}
                            if(isset($copiedItemPlayers->player_hundred_thirty_nine) && $copiedItemPlayers->player_hundred_thirty_nine != ""){$orderItemPlayers->player_hundred_thirty_nine = $copiedItemPlayers->player_hundred_thirty_nine;}else{$orderItemPlayers->player_hundred_thirty_nine = "";}
                            if(isset($copiedItemPlayers->player_hundred_forty) && $copiedItemPlayers->player_hundred_forty != ""){$orderItemPlayers->player_hundred_forty = $copiedItemPlayers->player_hundred_forty;}else{$orderItemPlayers->player_hundred_forty = "";}

                            if(isset($copiedItemPlayers->player_hundred_forty_one) && $copiedItemPlayers->player_hundred_forty_one != ""){$orderItemPlayers->player_hundred_forty_one = $copiedItemPlayers->player_hundred_forty_one;}else{$orderItemPlayers->player_hundred_forty_one = "";}
                            if(isset($copiedItemPlayers->player_hundred_forty_two) && $copiedItemPlayers->player_hundred_forty_two != ""){$orderItemPlayers->player_hundred_forty_two = $copiedItemPlayers->player_hundred_forty_two;}else{$orderItemPlayers->player_hundred_forty_two = "";}
                            if(isset($copiedItemPlayers->player_hundred_forty_three) && $copiedItemPlayers->player_hundred_forty_three != ""){$orderItemPlayers->player_hundred_forty_three = $copiedItemPlayers->player_hundred_forty_three;}else{$orderItemPlayers->player_hundred_forty_three = "";}
                            if(isset($copiedItemPlayers->player_hundred_forty_four) && $copiedItemPlayers->player_hundred_forty_four != ""){$orderItemPlayers->player_hundred_forty_four = $copiedItemPlayers->player_hundred_forty_four;}else{$orderItemPlayers->player_hundred_forty_four = "";}
                            if(isset($copiedItemPlayers->player_hundred_forty_five) && $copiedItemPlayers->player_hundred_forty_five != ""){$orderItemPlayers->player_hundred_forty_five = $copiedItemPlayers->player_hundred_forty_five;}else{$orderItemPlayers->player_hundred_forty_five = "";}
                            if(isset($copiedItemPlayers->player_hundred_forty_six) && $copiedItemPlayers->player_hundred_forty_six != ""){$orderItemPlayers->player_hundred_forty_six = $copiedItemPlayers->player_hundred_forty_six;}else{$orderItemPlayers->player_hundred_forty_six = "";}
                            if(isset($copiedItemPlayers->player_hundred_forty_seven) && $copiedItemPlayers->player_hundred_forty_seven != ""){$orderItemPlayers->player_hundred_forty_seven = $copiedItemPlayers->player_hundred_forty_seven;}else{$orderItemPlayers->player_hundred_forty_seven = "";}
                            if(isset($copiedItemPlayers->player_hundred_forty_eight) && $copiedItemPlayers->player_hundred_forty_eight != ""){$orderItemPlayers->player_hundred_forty_eight = $copiedItemPlayers->player_hundred_forty_eight;}else{$orderItemPlayers->player_hundred_forty_eight = "";}
                            if(isset($copiedItemPlayers->player_hundred_forty_nine) && $copiedItemPlayers->player_hundred_forty_nine != ""){$orderItemPlayers->player_hundred_forty_nine = $copiedItemPlayers->player_hundred_forty_nine;}else{$orderItemPlayers->player_hundred_forty_nine = "";}
                            if(isset($copiedItemPlayers->player_hundred_fifty) && $copiedItemPlayers->player_hundred_fifty != ""){$orderItemPlayers->player_hundred_fifty = $copiedItemPlayers->player_hundred_fifty;}else{$orderItemPlayers->player_hundred_fifty = "";}

                            if(isset($blankProductArray[$copiedItemPlayers->order_items_detail_id]) && $blankProductArray[$copiedItemPlayers->order_items_detail_id] > 0){ $orderItemPlayers->blank_qty = $blankProductArray[$copiedItemPlayers->order_items_detail_id];}else{$orderItemPlayers->blank_qty = 0;}
                            if(isset($copiedItemPlayers->blank_players)){ $orderItemPlayers->blank_player_names = json_encode($copiedItemPlayers->blank_players);}else{$orderItemPlayers->blank_player_names = "";}

                            $orderItemPlayers->save();
                        }
                    }

                } else {
                    $orderItem = OrderItem::find($request->item_id);
                    $orderItem->extra_size = $copiedItem->extra_size;
                    $orderItem->extra_size_two = $copiedItem->extra_size_two;
                    $orderItem->extra_size_three = $copiedItem->extra_size_three;
                    $orderItem->update();

                    $orderItemsDetail = new OrderItemsDetail();
                    $orderItemsDetail->blanks = $copiedItemDetail->blanks;
                    $orderItemsDetail->qty = $copiedItemDetail->qty;
                    $orderItemsDetail->size_id = $copiedItemDetail->size_id;
                    $orderItemsDetail->show_extra = $copiedItemDetail->show_extra;

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

                    if ($copiedItemDetail->numseq_hundred_one != ""){ $orderItemsDetail->numseq_hundred_one = $copiedItemDetail->numseq_hundred_one; } else { $orderItemsDetail->numseq_hundred_one = "";}
                    if ($copiedItemDetail->numseq_hundred_two != ""){ $orderItemsDetail->numseq_hundred_two = $copiedItemDetail->numseq_hundred_two; } else { $orderItemsDetail->numseq_hundred_two = "";}
                    if ($copiedItemDetail->numseq_hundred_three != ""){ $orderItemsDetail->numseq_hundred_three = $copiedItemDetail->numseq_hundred_three; } else { $orderItemsDetail->numseq_hundred_three = "";}
                    if ($copiedItemDetail->numseq_hundred_four != ""){ $orderItemsDetail->numseq_hundred_four = $copiedItemDetail->numseq_hundred_four; } else { $orderItemsDetail->numseq_hundred_four = "";}
                    if ($copiedItemDetail->numseq_hundred_five != ""){ $orderItemsDetail->numseq_hundred_five = $copiedItemDetail->numseq_hundred_five; } else { $orderItemsDetail->numseq_hundred_five = "";}
                    if ($copiedItemDetail->numseq_hundred_six != ""){ $orderItemsDetail->numseq_hundred_six = $copiedItemDetail->numseq_hundred_six; } else { $orderItemsDetail->numseq_hundred_six = "";}
                    if ($copiedItemDetail->numseq_hundred_seven != ""){ $orderItemsDetail->numseq_hundred_seven = $copiedItemDetail->numseq_hundred_seven; } else { $orderItemsDetail->numseq_hundred_seven = "";}
                    if ($copiedItemDetail->numseq_hundred_eight != ""){ $orderItemsDetail->numseq_hundred_eight = $copiedItemDetail->numseq_hundred_eight; } else { $orderItemsDetail->numseq_hundred_eight = "";}
                    if ($copiedItemDetail->numseq_hundred_nine != ""){ $orderItemsDetail->numseq_hundred_nine = $copiedItemDetail->numseq_hundred_nine; } else { $orderItemsDetail->numseq_hundred_nine = "";}
                    if ($copiedItemDetail->numseq_hundred_ten != ""){ $orderItemsDetail->numseq_hundred_ten = $copiedItemDetail->numseq_hundred_ten; } else { $orderItemsDetail->numseq_hundred_ten = "";}

                    if ($copiedItemDetail->numseq_hundred_eleven != ""){ $orderItemsDetail->numseq_hundred_eleven = $copiedItemDetail->numseq_hundred_eleven; } else { $orderItemsDetail->numseq_hundred_eleven = "";}
                    if ($copiedItemDetail->numseq_hundred_twelve != ""){ $orderItemsDetail->numseq_hundred_twelve = $copiedItemDetail->numseq_hundred_twelve; } else { $orderItemsDetail->numseq_hundred_twelve = "";}
                    if ($copiedItemDetail->numseq_hundred_thirteen != ""){ $orderItemsDetail->numseq_hundred_thirteen = $copiedItemDetail->numseq_hundred_thirteen; } else { $orderItemsDetail->numseq_hundred_thirteen = "";}
                    if ($copiedItemDetail->numseq_hundred_fourteen != ""){ $orderItemsDetail->numseq_hundred_fourteen = $copiedItemDetail->numseq_hundred_fourteen; } else { $orderItemsDetail->numseq_hundred_fourteen = "";}
                    if ($copiedItemDetail->numseq_hundred_fifteen != ""){ $orderItemsDetail->numseq_hundred_fifteen = $copiedItemDetail->numseq_hundred_fifteen; } else { $orderItemsDetail->numseq_hundred_fifteen = "";}
                    if ($copiedItemDetail->numseq_hundred_sixteen != ""){ $orderItemsDetail->numseq_hundred_sixteen = $copiedItemDetail->numseq_hundred_sixteen; } else { $orderItemsDetail->numseq_hundred_sixteen = "";}
                    if ($copiedItemDetail->numseq_hundred_seventeen != ""){ $orderItemsDetail->numseq_hundred_seventeen = $copiedItemDetail->numseq_hundred_seventeen; } else { $orderItemsDetail->numseq_hundred_seventeen = "";}
                    if ($copiedItemDetail->numseq_hundred_eighteen != ""){ $orderItemsDetail->numseq_hundred_eighteen = $copiedItemDetail->numseq_hundred_eighteen; } else { $orderItemsDetail->numseq_hundred_eighteen = "";}
                    if ($copiedItemDetail->numseq_hundred_nineteen != ""){ $orderItemsDetail->numseq_hundred_nineteen = $copiedItemDetail->numseq_hundred_nineteen; } else { $orderItemsDetail->numseq_hundred_nineteen = "";}
                    if ($copiedItemDetail->numseq_hundred_twenty != ""){ $orderItemsDetail->numseq_hundred_twenty = $copiedItemDetail->numseq_hundred_twenty; } else { $orderItemsDetail->numseq_hundred_twenty = "";}

                    if ($copiedItemDetail->numseq_hundred_twenty_one != ""){ $orderItemsDetail->numseq_hundred_twenty_one = $copiedItemDetail->numseq_hundred_twenty_one; } else { $orderItemsDetail->numseq_hundred_twenty_one = "";}
                    if ($copiedItemDetail->numseq_hundred_twenty_two != ""){ $orderItemsDetail->numseq_hundred_twenty_two = $copiedItemDetail->numseq_hundred_twenty_two; } else { $orderItemsDetail->numseq_hundred_twenty_two = "";}
                    if ($copiedItemDetail->numseq_hundred_twenty_three != ""){ $orderItemsDetail->numseq_hundred_twenty_three = $copiedItemDetail->numseq_hundred_twenty_three; } else { $orderItemsDetail->numseq_hundred_twenty_three = "";}
                    if ($copiedItemDetail->numseq_hundred_twenty_four != ""){ $orderItemsDetail->numseq_hundred_twenty_four = $copiedItemDetail->numseq_hundred_twenty_four; } else { $orderItemsDetail->numseq_hundred_twenty_four = "";}
                    if ($copiedItemDetail->numseq_hundred_twenty_five != ""){ $orderItemsDetail->numseq_hundred_twenty_five = $copiedItemDetail->numseq_hundred_twenty_five; } else { $orderItemsDetail->numseq_hundred_twenty_five = "";}
                    if ($copiedItemDetail->numseq_hundred_twenty_six != ""){ $orderItemsDetail->numseq_hundred_twenty_six = $copiedItemDetail->numseq_hundred_twenty_six; } else { $orderItemsDetail->numseq_hundred_twenty_six = "";}
                    if ($copiedItemDetail->numseq_hundred_twenty_seven != ""){ $orderItemsDetail->numseq_hundred_twenty_seven = $copiedItemDetail->numseq_hundred_twenty_seven; } else { $orderItemsDetail->numseq_hundred_twenty_seven = "";}
                    if ($copiedItemDetail->numseq_hundred_twenty_eight != ""){ $orderItemsDetail->numseq_hundred_twenty_eight = $copiedItemDetail->numseq_hundred_twenty_eight; } else { $orderItemsDetail->numseq_hundred_twenty_eight = "";}
                    if ($copiedItemDetail->numseq_hundred_twenty_nine != ""){ $orderItemsDetail->numseq_hundred_twenty_nine = $copiedItemDetail->numseq_hundred_twenty_nine; } else { $orderItemsDetail->numseq_hundred_twenty_nine = "";}
                    if ($copiedItemDetail->numseq_hundred_thirty != ""){ $orderItemsDetail->numseq_hundred_thirty = $copiedItemDetail->numseq_hundred_thirty; } else { $orderItemsDetail->numseq_hundred_thirty = "";}

                    if ($copiedItemDetail->numseq_hundred_thirty_one != ""){ $orderItemsDetail->numseq_hundred_thirty_one = $copiedItemDetail->numseq_hundred_thirty_one; } else { $orderItemsDetail->numseq_hundred_thirty_one = "";}
                    if ($copiedItemDetail->numseq_hundred_thirty_two != ""){ $orderItemsDetail->numseq_hundred_thirty_two = $copiedItemDetail->numseq_hundred_thirty_two; } else { $orderItemsDetail->numseq_hundred_thirty_two = "";}
                    if ($copiedItemDetail->numseq_hundred_thirty_three != ""){ $orderItemsDetail->numseq_hundred_thirty_three = $copiedItemDetail->numseq_hundred_thirty_three; } else { $orderItemsDetail->numseq_hundred_thirty_three = "";}
                    if ($copiedItemDetail->numseq_hundred_thirty_four != ""){ $orderItemsDetail->numseq_hundred_thirty_four = $copiedItemDetail->numseq_hundred_thirty_four; } else { $orderItemsDetail->numseq_hundred_thirty_four = "";}
                    if ($copiedItemDetail->numseq_hundred_thirty_five != ""){ $orderItemsDetail->numseq_hundred_thirty_five = $copiedItemDetail->numseq_hundred_thirty_five; } else { $orderItemsDetail->numseq_hundred_thirty_five = "";}
                    if ($copiedItemDetail->numseq_hundred_thirty_six != ""){ $orderItemsDetail->numseq_hundred_thirty_six = $copiedItemDetail->numseq_hundred_thirty_six; } else { $orderItemsDetail->numseq_hundred_thirty_six = "";}
                    if ($copiedItemDetail->numseq_hundred_thirty_seven != ""){ $orderItemsDetail->numseq_hundred_thirty_seven = $copiedItemDetail->numseq_hundred_thirty_seven; } else { $orderItemsDetail->numseq_hundred_thirty_seven = "";}
                    if ($copiedItemDetail->numseq_hundred_thirty_eight != ""){ $orderItemsDetail->numseq_hundred_thirty_eight = $copiedItemDetail->numseq_hundred_thirty_eight; } else { $orderItemsDetail->numseq_hundred_thirty_eight = "";}
                    if ($copiedItemDetail->numseq_hundred_thirty_nine != ""){ $orderItemsDetail->numseq_hundred_thirty_nine = $copiedItemDetail->numseq_hundred_thirty_nine; } else { $orderItemsDetail->numseq_hundred_thirty_nine = "";}
                    if ($copiedItemDetail->numseq_hundred_forty != ""){ $orderItemsDetail->numseq_hundred_forty = $copiedItemDetail->numseq_hundred_forty; } else { $orderItemsDetail->numseq_hundred_forty = "";}

                    if ($copiedItemDetail->numseq_hundred_forty_one != ""){ $orderItemsDetail->numseq_hundred_forty_one = $copiedItemDetail->numseq_hundred_forty_one; } else { $orderItemsDetail->numseq_hundred_forty_one = "";}
                    if ($copiedItemDetail->numseq_hundred_forty_two != ""){ $orderItemsDetail->numseq_hundred_forty_two = $copiedItemDetail->numseq_hundred_forty_two; } else { $orderItemsDetail->numseq_hundred_forty_two = "";}
                    if ($copiedItemDetail->numseq_hundred_forty_three != ""){ $orderItemsDetail->numseq_hundred_forty_three = $copiedItemDetail->numseq_hundred_forty_three; } else { $orderItemsDetail->numseq_hundred_forty_three = "";}
                    if ($copiedItemDetail->numseq_hundred_forty_four != ""){ $orderItemsDetail->numseq_hundred_forty_four = $copiedItemDetail->numseq_hundred_forty_four; } else { $orderItemsDetail->numseq_hundred_forty_four = "";}
                    if ($copiedItemDetail->numseq_hundred_forty_five != ""){ $orderItemsDetail->numseq_hundred_forty_five = $copiedItemDetail->numseq_hundred_forty_five; } else { $orderItemsDetail->numseq_hundred_forty_five = "";}
                    if ($copiedItemDetail->numseq_hundred_forty_six != ""){ $orderItemsDetail->numseq_hundred_forty_six = $copiedItemDetail->numseq_hundred_forty_six; } else { $orderItemsDetail->numseq_hundred_forty_six = "";}
                    if ($copiedItemDetail->numseq_hundred_forty_seven != ""){ $orderItemsDetail->numseq_hundred_forty_seven = $copiedItemDetail->numseq_hundred_forty_seven; } else { $orderItemsDetail->numseq_hundred_forty_seven = "";}
                    if ($copiedItemDetail->numseq_hundred_forty_eight != ""){ $orderItemsDetail->numseq_hundred_forty_eight = $copiedItemDetail->numseq_hundred_forty_eight; } else { $orderItemsDetail->numseq_hundred_forty_eight = "";}
                    if ($copiedItemDetail->numseq_hundred_forty_nine != ""){ $orderItemsDetail->numseq_hundred_forty_nine = $copiedItemDetail->numseq_hundred_forty_nine; } else { $orderItemsDetail->numseq_hundred_forty_nine = "";}
                    if ($copiedItemDetail->numseq_hundred_fifty != ""){ $orderItemsDetail->numseq_hundred_fifty = $copiedItemDetail->numseq_hundred_fifty; } else { $orderItemsDetail->numseq_hundred_fifty = "";}
                    $orderItemsDetail->save();

                    // Paste player names
                    $copiedItemPlayers = OrderItemsDetailPlayerName::where('order_items_detail_id', $copiedItemDetail->id)->first();

                    if ($copiedItemPlayers) {
                        $orderItemPlayers = new OrderItemsDetailPlayerName();
                        $orderItemPlayers->order_items_detail_id = $orderItemsDetail->id;

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

                        if(isset($copiedItemPlayers->player_hundred_one) && $copiedItemPlayers->player_hundred_one != ""){$orderItemPlayers->player_hundred_one = $copiedItemPlayers->player_hundred_one;}else{$orderItemPlayers->player_hundred_one = "";}
                        if(isset($copiedItemPlayers->player_hundred_two) && $copiedItemPlayers->player_hundred_two != ""){$orderItemPlayers->player_hundred_two = $copiedItemPlayers->player_hundred_two;}else{$orderItemPlayers->player_hundred_two = "";}
                        if(isset($copiedItemPlayers->player_hundred_three) && $copiedItemPlayers->player_hundred_three != ""){$orderItemPlayers->player_hundred_three = $copiedItemPlayers->player_hundred_three;}else{$orderItemPlayers->player_hundred_three = "";}
                        if(isset($copiedItemPlayers->player_hundred_four) && $copiedItemPlayers->player_hundred_four != ""){$orderItemPlayers->player_hundred_four = $copiedItemPlayers->player_hundred_four;}else{$orderItemPlayers->player_hundred_four = "";}
                        if(isset($copiedItemPlayers->player_hundred_five) && $copiedItemPlayers->player_hundred_five != ""){$orderItemPlayers->player_hundred_five = $copiedItemPlayers->player_hundred_five;}else{$orderItemPlayers->player_hundred_five = "";}
                        if(isset($copiedItemPlayers->player_hundred_six) && $copiedItemPlayers->player_hundred_six != ""){$orderItemPlayers->player_hundred_six = $copiedItemPlayers->player_hundred_six;}else{$orderItemPlayers->player_hundred_six = "";}
                        if(isset($copiedItemPlayers->player_hundred_seven) && $copiedItemPlayers->player_hundred_seven != ""){$orderItemPlayers->player_hundred_seven = $copiedItemPlayers->player_hundred_seven;}else{$orderItemPlayers->player_hundred_seven = "";}
                        if(isset($copiedItemPlayers->player_hundred_eight) && $copiedItemPlayers->player_hundred_eight != ""){$orderItemPlayers->player_hundred_eight = $copiedItemPlayers->player_hundred_eight;}else{$orderItemPlayers->player_hundred_eight = "";}
                        if(isset($copiedItemPlayers->player_hundred_nine) && $copiedItemPlayers->player_hundred_nine != ""){$orderItemPlayers->player_hundred_nine = $copiedItemPlayers->player_hundred_nine;}else{$orderItemPlayers->player_hundred_nine = "";}
                        if(isset($copiedItemPlayers->player_hundred_ten) && $copiedItemPlayers->player_hundred_ten != ""){$orderItemPlayers->player_hundred_ten = $copiedItemPlayers->player_hundred_ten;}else{$orderItemPlayers->player_hundred_ten = "";}

                        if(isset($copiedItemPlayers->player_hundred_eleven) && $copiedItemPlayers->player_hundred_eleven != ""){$orderItemPlayers->player_hundred_eleven = $copiedItemPlayers->player_hundred_eleven;}else{$orderItemPlayers->player_hundred_eleven = "";}
                        if(isset($copiedItemPlayers->player_hundred_twelve) && $copiedItemPlayers->player_hundred_twelve != ""){$orderItemPlayers->player_hundred_twelve = $copiedItemPlayers->player_hundred_twelve;}else{$orderItemPlayers->player_hundred_twelve = "";}
                        if(isset($copiedItemPlayers->player_hundred_thirteen) && $copiedItemPlayers->player_hundred_thirteen != ""){$orderItemPlayers->player_hundred_thirteen = $copiedItemPlayers->player_hundred_thirteen;}else{$orderItemPlayers->player_hundred_thirteen = "";}
                        if(isset($copiedItemPlayers->player_hundred_fourteen) && $copiedItemPlayers->player_hundred_fourteen != ""){$orderItemPlayers->player_hundred_fourteen = $copiedItemPlayers->player_hundred_fourteen;}else{$orderItemPlayers->player_hundred_fourteen = "";}
                        if(isset($copiedItemPlayers->player_hundred_fifteen) && $copiedItemPlayers->player_hundred_fifteen != ""){$orderItemPlayers->player_hundred_fifteen = $copiedItemPlayers->player_hundred_fifteen;}else{$orderItemPlayers->player_hundred_fifteen = "";}
                        if(isset($copiedItemPlayers->player_hundred_sixteen) && $copiedItemPlayers->player_hundred_sixteen != ""){$orderItemPlayers->player_hundred_sixteen = $copiedItemPlayers->player_hundred_sixteen;}else{$orderItemPlayers->player_hundred_sixteen = "";}
                        if(isset($copiedItemPlayers->player_hundred_seventeen) && $copiedItemPlayers->player_hundred_seventeen != ""){$orderItemPlayers->player_hundred_seventeen = $copiedItemPlayers->player_hundred_seventeen;}else{$orderItemPlayers->player_hundred_seventeen = "";}
                        if(isset($copiedItemPlayers->player_hundred_eighteen) && $copiedItemPlayers->player_hundred_eighteen != ""){$orderItemPlayers->player_hundred_eighteen = $copiedItemPlayers->player_hundred_eighteen;}else{$orderItemPlayers->player_hundred_eighteen = "";}
                        if(isset($copiedItemPlayers->player_hundred_nineteen) && $copiedItemPlayers->player_hundred_nineteen != ""){$orderItemPlayers->player_hundred_nineteen = $copiedItemPlayers->player_hundred_nineteen;}else{$orderItemPlayers->player_hundred_nineteen = "";}
                        if(isset($copiedItemPlayers->player_hundred_twenty) && $copiedItemPlayers->player_hundred_twenty != ""){$orderItemPlayers->player_hundred_twenty = $copiedItemPlayers->player_hundred_twenty;}else{$orderItemPlayers->player_hundred_twenty = "";}

                        if(isset($copiedItemPlayers->player_hundred_twenty_one) && $copiedItemPlayers->player_hundred_twenty_one != ""){$orderItemPlayers->player_hundred_twenty_one = $copiedItemPlayers->player_hundred_twenty_one;}else{$orderItemPlayers->player_hundred_twenty_one = "";}
                        if(isset($copiedItemPlayers->player_hundred_twenty_two) && $copiedItemPlayers->player_hundred_twenty_two != ""){$orderItemPlayers->player_hundred_twenty_two = $copiedItemPlayers->player_hundred_twenty_two;}else{$orderItemPlayers->player_hundred_twenty_two = "";}
                        if(isset($copiedItemPlayers->player_hundred_twenty_three) && $copiedItemPlayers->player_hundred_twenty_three != ""){$orderItemPlayers->player_hundred_twenty_three = $copiedItemPlayers->player_hundred_twenty_three;}else{$orderItemPlayers->player_hundred_twenty_three = "";}
                        if(isset($copiedItemPlayers->player_hundred_twenty_four) && $copiedItemPlayers->player_hundred_twenty_four != ""){$orderItemPlayers->player_hundred_twenty_four = $copiedItemPlayers->player_hundred_twenty_four;}else{$orderItemPlayers->player_hundred_twenty_four = "";}
                        if(isset($copiedItemPlayers->player_hundred_twenty_five) && $copiedItemPlayers->player_hundred_twenty_five != ""){$orderItemPlayers->player_hundred_twenty_five = $copiedItemPlayers->player_hundred_twenty_five;}else{$orderItemPlayers->player_hundred_twenty_five = "";}
                        if(isset($copiedItemPlayers->player_hundred_twenty_six) && $copiedItemPlayers->player_hundred_twenty_six != ""){$orderItemPlayers->player_hundred_twenty_six = $copiedItemPlayers->player_hundred_twenty_six;}else{$orderItemPlayers->player_hundred_twenty_six = "";}
                        if(isset($copiedItemPlayers->player_hundred_twenty_seven) && $copiedItemPlayers->player_hundred_twenty_seven != ""){$orderItemPlayers->player_hundred_twenty_seven = $copiedItemPlayers->player_hundred_twenty_seven;}else{$orderItemPlayers->player_hundred_twenty_seven = "";}
                        if(isset($copiedItemPlayers->player_hundred_twenty_eight) && $copiedItemPlayers->player_hundred_twenty_eight != ""){$orderItemPlayers->player_hundred_twenty_eight = $copiedItemPlayers->player_hundred_twenty_eight;}else{$orderItemPlayers->player_hundred_twenty_eight = "";}
                        if(isset($copiedItemPlayers->player_hundred_twenty_nine) && $copiedItemPlayers->player_hundred_twenty_nine != ""){$orderItemPlayers->player_hundred_twenty_nine = $copiedItemPlayers->player_hundred_twenty_nine;}else{$orderItemPlayers->player_hundred_twenty_nine = "";}
                        if(isset($copiedItemPlayers->player_hundred_thirty) && $copiedItemPlayers->player_hundred_thirty != ""){$orderItemPlayers->player_hundred_thirty = $copiedItemPlayers->player_hundred_thirty;}else{$orderItemPlayers->player_hundred_thirty = "";}

                        if(isset($copiedItemPlayers->player_hundred_thirty_one) && $copiedItemPlayers->player_hundred_thirty_one != ""){$orderItemPlayers->player_hundred_thirty_one = $copiedItemPlayers->player_hundred_thirty_one;}else{$orderItemPlayers->player_hundred_thirty_one = "";}
                        if(isset($copiedItemPlayers->player_hundred_thirty_two) && $copiedItemPlayers->player_hundred_thirty_two != ""){$orderItemPlayers->player_hundred_thirty_two = $copiedItemPlayers->player_hundred_thirty_two;}else{$orderItemPlayers->player_hundred_thirty_two = "";}
                        if(isset($copiedItemPlayers->player_hundred_thirty_three) && $copiedItemPlayers->player_hundred_thirty_three != ""){$orderItemPlayers->player_hundred_thirty_three = $copiedItemPlayers->player_hundred_thirty_three;}else{$orderItemPlayers->player_hundred_thirty_three = "";}
                        if(isset($copiedItemPlayers->player_hundred_thirty_four) && $copiedItemPlayers->player_hundred_thirty_four != ""){$orderItemPlayers->player_hundred_thirty_four = $copiedItemPlayers->player_hundred_thirty_four;}else{$orderItemPlayers->player_hundred_thirty_four = "";}
                        if(isset($copiedItemPlayers->player_hundred_thirty_five) && $copiedItemPlayers->player_hundred_thirty_five != ""){$orderItemPlayers->player_hundred_thirty_five = $copiedItemPlayers->player_hundred_thirty_five;}else{$orderItemPlayers->player_hundred_thirty_five = "";}
                        if(isset($copiedItemPlayers->player_hundred_thirty_six) && $copiedItemPlayers->player_hundred_thirty_six != ""){$orderItemPlayers->player_hundred_thirty_six = $copiedItemPlayers->player_hundred_thirty_six;}else{$orderItemPlayers->player_hundred_thirty_six = "";}
                        if(isset($copiedItemPlayers->player_hundred_thirty_seven) && $copiedItemPlayers->player_hundred_thirty_seven != ""){$orderItemPlayers->player_hundred_thirty_seven = $copiedItemPlayers->player_hundred_thirty_seven;}else{$orderItemPlayers->player_hundred_thirty_seven = "";}
                        if(isset($copiedItemPlayers->player_hundred_thirty_eight) && $copiedItemPlayers->player_hundred_thirty_eight != ""){$orderItemPlayers->player_hundred_thirty_eight = $copiedItemPlayers->player_hundred_thirty_eight;}else{$orderItemPlayers->player_hundred_thirty_eight = "";}
                        if(isset($copiedItemPlayers->player_hundred_thirty_nine) && $copiedItemPlayers->player_hundred_thirty_nine != ""){$orderItemPlayers->player_hundred_thirty_nine = $copiedItemPlayers->player_hundred_thirty_nine;}else{$orderItemPlayers->player_hundred_thirty_nine = "";}
                        if(isset($copiedItemPlayers->player_hundred_forty) && $copiedItemPlayers->player_hundred_forty != ""){$orderItemPlayers->player_hundred_forty = $copiedItemPlayers->player_hundred_forty;}else{$orderItemPlayers->player_hundred_forty = "";}

                        if(isset($copiedItemPlayers->player_hundred_forty_one) && $copiedItemPlayers->player_hundred_forty_one != ""){$orderItemPlayers->player_hundred_forty_one = $copiedItemPlayers->player_hundred_forty_one;}else{$orderItemPlayers->player_hundred_forty_one = "";}
                        if(isset($copiedItemPlayers->player_hundred_forty_two) && $copiedItemPlayers->player_hundred_forty_two != ""){$orderItemPlayers->player_hundred_forty_two = $copiedItemPlayers->player_hundred_forty_two;}else{$orderItemPlayers->player_hundred_forty_two = "";}
                        if(isset($copiedItemPlayers->player_hundred_forty_three) && $copiedItemPlayers->player_hundred_forty_three != ""){$orderItemPlayers->player_hundred_forty_three = $copiedItemPlayers->player_hundred_forty_three;}else{$orderItemPlayers->player_hundred_forty_three = "";}
                        if(isset($copiedItemPlayers->player_hundred_forty_four) && $copiedItemPlayers->player_hundred_forty_four != ""){$orderItemPlayers->player_hundred_forty_four = $copiedItemPlayers->player_hundred_forty_four;}else{$orderItemPlayers->player_hundred_forty_four = "";}
                        if(isset($copiedItemPlayers->player_hundred_forty_five) && $copiedItemPlayers->player_hundred_forty_five != ""){$orderItemPlayers->player_hundred_forty_five = $copiedItemPlayers->player_hundred_forty_five;}else{$orderItemPlayers->player_hundred_forty_five = "";}
                        if(isset($copiedItemPlayers->player_hundred_forty_six) && $copiedItemPlayers->player_hundred_forty_six != ""){$orderItemPlayers->player_hundred_forty_six = $copiedItemPlayers->player_hundred_forty_six;}else{$orderItemPlayers->player_hundred_forty_six = "";}
                        if(isset($copiedItemPlayers->player_hundred_forty_seven) && $copiedItemPlayers->player_hundred_forty_seven != ""){$orderItemPlayers->player_hundred_forty_seven = $copiedItemPlayers->player_hundred_forty_seven;}else{$orderItemPlayers->player_hundred_forty_seven = "";}
                        if(isset($copiedItemPlayers->player_hundred_forty_eight) && $copiedItemPlayers->player_hundred_forty_eight != ""){$orderItemPlayers->player_hundred_forty_eight = $copiedItemPlayers->player_hundred_forty_eight;}else{$orderItemPlayers->player_hundred_forty_eight = "";}
                        if(isset($copiedItemPlayers->player_hundred_forty_nine) && $copiedItemPlayers->player_hundred_forty_nine != ""){$orderItemPlayers->player_hundred_forty_nine = $copiedItemPlayers->player_hundred_forty_nine;}else{$orderItemPlayers->player_hundred_forty_nine = "";}
                        if(isset($copiedItemPlayers->player_hundred_fifty) && $copiedItemPlayers->player_hundred_fifty != ""){$orderItemPlayers->player_hundred_fifty = $copiedItemPlayers->player_hundred_fifty;}else{$orderItemPlayers->player_hundred_fifty = "";}

                        if(isset($blankProductArray[$copiedItemPlayers->order_items_detail_id]) && $blankProductArray[$copiedItemPlayers->order_items_detail_id] > 0){ $orderItemPlayers->blank_qty = $blankProductArray[$copiedItemPlayers->order_items_detail_id];}else{$orderItemPlayers->blank_qty = 0;}
                        if(isset($copiedItemPlayers->blank_players)){ $orderItemPlayers->blank_player_names = json_encode($copiedItemPlayers->blank_players);}else{$orderItemPlayers->blank_player_names = "";}

                        $orderItemPlayers->save();
                    }
                }
            }

        } else {
            $isSizeExist = 'no_size';
        }

        if ($isSizeExist == 'size_exist') {
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
            // $orderProcessingFee = $order->processing_fee ?? '';
            // $orderFeesTotal = $orderSalesTax + $orderShipping + $orderArtwork + $orderProcessingFee;
            $orderFeesTotal = $orderSalesTax + $orderShipping + $orderArtwork;

            $order->sub_total = $orderSubTotal;
            $order->order_total = $orderSubTotal + $orderFeesTotal;
            $order->sales_tax = $orderSalesTax;
            $order->update();
        }

        return json_encode($isSizeExist);
    }

    function commentFileUpload(Request $request){
        $file = $request->file('upload_file');
        $filename = str_replace("'", " ", $request->upload_file_name);
        $destinationPath = 'uploads/uploaded_files/'.$request->order_id;
        $file->move($destinationPath, $filename);

        return json_encode("done");
    }
    function getitem_ExFactoryDatelog(Request $request){
        $ItemexfactoryLogs = ItemExFactoryDateFacade::get($request->itemID);

        return json_encode($ItemexfactoryLogs);
    }
    function additem_ExFactoryDatelog(Request $request){
        $newExLog = ItemExFactoryDateFacade::create($request->itemID, Auth::id(), $request->pre_ex_factory_date, $request->new_ex_factory_date, $request->reason);

        return json_encode($newExLog);
    }
    function getItemProductDetails(Request $request){

        $sub_product = SubProduct::where('sub_product_no' , $request->sub_productID)->first();

        if($sub_product->parent_product_id == 228){
            $is_hat = true;
        }else{
            $is_hat = false;
        }

        $order_item = OrderItem::where('id' , $request->itemID)->first();

        if(empty($sub_product->fabric_id)){

            $fabric_text = "<option value='0' selected>No fabric</option>";

        }else{

            $fabric_text = "<option value=".$sub_product->fabric_id." selected>".$sub_product->standard_fabric."</option>";

        }

        $trimmed_types = array_map('trim', explode('/', $sub_product->type_of_embellishment));
        $embellishments = EmbellishmentType::whereIn('embellishment_name', $trimmed_types)->get();

        $embellishment_text = "<option>Select Embellishment</option>";

        foreach($embellishments as $embellishment){
            if($embellishment->id == $request->selectedEmbellishmentID){
                $embellishment_text .= "<option value=".$embellishment->id." selected>".$embellishment->embellishment_name."</option>";
            }else{
                $embellishment_text .= "<option value=".$embellishment->id.">".$embellishment->embellishment_name."</option>";
            }
        }

        $attributes_text = "";
        $attributes_output_array = array();

        $attributes_array = array();
        $selected_attributes_array = array();

        $productAttributes = ProductAttribute::where('product_id',$request->productID)
                            ->with('attributes')->get();

        foreach($productAttributes as $productAttribute){
            $attributes_array[] = $productAttribute->attribute_id;
        }

        foreach(json_decode($request->selectedAttributeIDs) as $selectedAttribute){
            $selected_attributes_array[] = $selectedAttribute->attribute_id;
        }

        if(count($attributes_array)!=0){

            foreach($selected_attributes_array as $attributeID){
                if(!in_array($attributeID, $attributes_array)){
                    $attributes_array[] = $attributeID;
                }
            }

            foreach($attributes_array as $attributeID){
                $attribute = Attribute::where('id',$attributeID)->first();

                if(in_array($attribute->id,$selected_attributes_array)){
                    $attributes_output_array[] = "<td>
                                                    <div class='custom-control custom-checkbox'>
                                                        <input type='checkbox' class='custom-control-input' onchange='attribute_select(this)' id='attribute_".$request->itemID."_".$attribute->id."' name='' checked>
                                                        <label name='' class='custom-control-label' for='attribute_".$request->itemID."_".$attribute->id."'>&nbsp;".$attribute->attribute_name."&nbsp;</label>
                                                    </div>
                                                </td>";

                }else{
                    $attributes_output_array[] = "<td>
                                                    <div class='custom-control custom-checkbox'>
                                                        <input type='checkbox' class='custom-control-input' onchange='attribute_select(this)' id='attribute_".$request->itemID."_".$attribute->id."' name=''>
                                                        <label name='' class='custom-control-label' for='attribute_".$request->itemID."_".$attribute->id."'>&nbsp;".$attribute->attribute_name."&nbsp;</label>
                                                    </div>
                                                </td>";
                }
            }

        }else{

            $attributes = Attribute::where('active',1)->get();

            foreach($attributes as $attribute){

                if(in_array($attribute->id,$selected_attributes_array)){
                    $attributes_output_array[] = "<td>
                                                    <div class='custom-control custom-checkbox'>
                                                        <input type='checkbox' class='custom-control-input' onchange='attribute_select(this)' id='attribute_".$request->itemID."_".$attribute->id."' name='' checked>
                                                        <label name='' class='custom-control-label' for='attribute_".$request->itemID."_".$attribute->id."'>&nbsp;".$attribute->attribute_name."&nbsp;</label>
                                                    </div>
                                                </td>";

                }else{
                    $attributes_output_array[] = "<td>
                                                    <div class='custom-control custom-checkbox'>
                                                        <input type='checkbox' class='custom-control-input' onchange='attribute_select(this)' id='attribute_".$request->itemID."_".$attribute->id."' name=''>
                                                        <label name='' class='custom-control-label' for='attribute_".$request->itemID."_".$attribute->id."'>&nbsp;".$attribute->attribute_name."&nbsp;</label>
                                                    </div>
                                                </td>";

                }
            }

        }

        $td_count=0;
        $array_count=0;
        $td_mod= count($attributes_output_array)%2;

        foreach($attributes_output_array as $output){
            $array_count+=1;
            if($td_count == 0){
                $attributes_text .= "<tr>".$output;
                $td_count=1;

                if($td_mod==1 && count($attributes_output_array)==$array_count){
                    $attributes_text .= "<td></td></tr>";
                }
            }else if($td_count == 1){
                $attributes_text .= $output."</tr>";
                $td_count=0;
            }
        }

        return json_encode([$fabric_text,$embellishment_text,$attributes_text,$is_hat,$order_item]);


    }

    function getProductMockupImages(Request $request){
        $product = Product::where('id',$request->productID)->first();
        return json_encode([$product->mockup_img_1,$product->mockup_img_2,$product->mockup_img_3]);
    }

    function updateItemAttributes(Request $request){

        OrderItemAttribute::where('order_item_id', $request->itemID)
                            ->where('attribute_id', $request->attrID)
                            ->delete();

        if($request->isChecked == "true"){
            $orderItemAttribute = new OrderItemAttribute();
            $orderItemAttribute->order_item_id = $request->itemID;
            $orderItemAttribute->attribute_id = $request->attrID;
            $orderItemAttribute->save();
        }

        return json_encode('success');
    }

    public function authenticate(Request $request){
        $email = $request->login_details[0];
        $password = $request->login_details[1];
        $reason = $request->login_details[2];

        $user = User::where('email', $email)->first();

        if($user == null){
            return json_encode(['email_error','']);
        } elseif ($user != null){
            if($user->hasRole('Super Admin')){
                if(Hash::check($password, $user->password)){
                    return json_encode(['success', $reason]);
                } else {
                    return json_encode(['password_error','']);
                }
            } else {
                return json_encode(['user_error','']);
            }
        }
    }

    public function exFactoryAuthenticate(Request $request){
        $reason = $request->reason;

        if(Auth::user()->can('edit exfactory')){
            return json_encode(['success', $reason]);
        } else {
            return json_encode(['error','']);
        }
    }

    // Order items design download at once +++ Heshan Namal +++





    public function auto_update_fullfill_status(Request $request){

        $shipping_records = $request->shipping_records;

        $fullfill_status = [];

        $order_id = null;

        $not_fullfilled_count = 0;
        $fullfilled_count = 0;

        foreach ($shipping_records as $key => $shipping_record) {
            $is_sent = true;
            foreach ($shipping_record as $item_record) {
                if ($item_record['notifyStatus'] == 0) {
                    $is_sent = false;
                    break;
                }
            }

            if ($is_sent) {
                $order_item = OrderItem::find($key);
                $order_item->order_status_id = 4;
                $order_item->save();

                $fullfilled_count += 1 ;

            }else{
                $not_fullfilled_count += 1 ;
            }

            $fullfill_status[$key] = $is_sent ? 'sent' : 'not-sent';
        }

        $is_order_fullfilled = !OrderItem::where('order_id', $request->orderID)->whereNotIn('order_status_id', [7,4])->exists();

        if ($is_order_fullfilled) {
            $order = Order::find($request->orderID);
            $order->order_status_id = 4;
            $order->save();
        }else{
            if($fullfilled_count > 0 && $not_fullfilled_count > 0){
                $order = Order::find($request->orderID);
                $order->order_status_id = 8;
                $order->save();
            }
        }

        return response((['data' => $not_fullfilled_count.' to '.$fullfilled_count, 'success' => true, 'message' => 'Data received successfully']));

    }
    public function update_credentials(Request $request) {

        $org = $request->input('org');
        $pwd = $request->input('pwd');

        $organization = Organization::find($org);
        if($organization){
            $organization->password_text = $pwd;
            $organization->unique_password = Hash::make($pwd);
            $organization->save();
        }

        return response((['success' => 'Credential updated successfully']));
    }
    public function new_payment_summary_update() {

        $orders = Order::orderBy('id', 'desc')->get();

        $ordersCount = $orders->count();

        foreach ($orders as $key => $order) {

            $OrderPaymentUpdateLog = new OrderPaymentUpdateLog();
            $OrderPaymentUpdateLog->order_id = $order->id;
            $OrderPaymentUpdateLog->invoice_amount = $order->sub_total;
            $OrderPaymentUpdateLog->artwork = $order->artwork ?? 0.00;

            $OrderPaymentUpdateLog->discount_availability = $order->discount_hidation == 1 ? 1 : 0;
            $OrderPaymentUpdateLog->discount_type = $order->discountType ?? 0;
            $OrderPaymentUpdateLog->discount_value = $order->discount ?? 0.00;

            $old_total = $order->sub_total + $order->artwork + $order->shipping ?? 0.00;

            if($order->discount_hidation == 1 ){

                if($order->discountType == 1){

                    $old_discount_amount = ($old_total / 100) * $order->discount;

                } elseif($order->discountType == 2) {

                    $old_discount_amount = $order->discount;
                }

            }else{
                $old_discount_amount = 0.00;
            }

            $OrderPaymentUpdateLog->discount_amount = $old_discount_amount;

            $OrderPaymentUpdateLog->sales_tax = $order->sales_tax ?? 0.00;
            $OrderPaymentUpdateLog->shipping_fee = $order->shipping ?? 0.00;
            $OrderPaymentUpdateLog->total = $order->order_total ?? 0.00;

            $cardPayment = PaymentLog::where('order_id', $order->id)->sum('amount') ?? 0.00;
            $checkPayment = CheckPayment::where('order_id', $order->id)->where('is_approved' , 1)->sum('amount') ?? 0.00;
            $otherPayment = OtherPayment::where('order_id', $order->id)->where('is_approved' , 1)->sum('amount') ?? 0.00;
            $paypalPayement = PaypalPayment::where('order_id', $order->id)->where('is_approved' , 1)->sum('amount') ?? 0.00;
            $venmoPayment = VenmoPayment::where('order_id', $order->id)->where('is_approved' , 1)->sum('amount') ?? 0.00;
            $poPayment = PurchaseorderReceipt::where('order_id', $order->id)->where('is_approved' , 1)->sum('amount') ?? 0.00;

            $processingFee = round(($cardPayment + $paypalPayement)*3/103 , 2);

            $payment = 0;

            if($cardPayment > 0 && $paypalPayement > 0){
                $payment = round(((($cardPayment + $paypalPayement) * 100)/103),2) + $checkPayment + $venmoPayment + $otherPayment + $poPayment;

            } else if ($cardPayment > 0 && $paypalPayement == 0) {
                $payment = round(($cardPayment * 100)/103,2) + $checkPayment + $venmoPayment + $otherPayment + $poPayment;

            } else if ($cardPayment == 0 && $paypalPayement > 0) {
                $payment = $checkPayment + round((($paypalPayement * 100)/103),2) + $venmoPayment + $otherPayment + $poPayment;

            } else {
                $payment = round(($cardPayment + $checkPayment + $paypalPayement + $venmoPayment + $otherPayment + $poPayment),2);
            }

            $OrderPaymentUpdateLog->card_amount = $cardPayment ?? 0.00;
            $OrderPaymentUpdateLog->check_amount = $checkPayment ?? 0.00;
            $OrderPaymentUpdateLog->venmo_amount = $venmoPayment ?? 0.00;
            $OrderPaymentUpdateLog->paypal_amount = $paypalPayement ?? 0.00;
            $OrderPaymentUpdateLog->po_amount = $poPayment ?? 0.00;
            $OrderPaymentUpdateLog->other_amount = $otherPayment ?? 0.00;

            $OrderPaymentUpdateLog->paid_amount = $payment ?? 0.00;
            $OrderPaymentUpdateLog->paid_processing_fee = $processingFee ?? 0.00;
            $OrderPaymentUpdateLog->total_paid_amount = round(($cardPayment + $checkPayment + $paypalPayement + $venmoPayment + $otherPayment + $poPayment),2) ?? 0.00;

            $subtotal = $order->sub_total;
            $orderSalesTax = $order->sales_tax ?? 0.00;

            $organization = Organization::find($order->organization_id);
            if ($organization->sales_tax_active == 1) {
                $salesTax = $organization->sales_tax;
            } else {
                $salesTax = 0;
            }

            $OrderPaymentUpdateLog->tax_rate = $salesTax ?? 0.00;
            $OrderPaymentUpdateLog->save();

            $orderShipping = $order->shipping ?? 0.00;
            $orderArtwork = $order->artwork ?? 0.00;

            $order_total_amount = $subtotal + $orderArtwork;

            if($order->discount_hidation == 1 ){

                if($order->discountType == 1){

                    $discountAmount = ($order_total_amount / 100) * $order->discount;

                } elseif($order->discountType == 2) {

                    $discountAmount = $order->discount;
                }

            }else{
                $discountAmount = 0.00;
            }

            $orderSalesTax = (($order_total_amount - $discountAmount) / 100) * $salesTax;

            $order->sub_total = $subtotal;
            $order->order_total = $order_total_amount + $orderSalesTax - $discountAmount + $orderShipping;
            $order->sales_tax = $orderSalesTax;
            $order->save();

            dump('Order ID : '.$order->id.' - Order Total : '.$order->order_total.' - Order Sales Tax : '.$order->sales_tax.' - Order Sub Total : '.$order->sub_total.' - Order Artwork : '.$order->artwork.' - Order Shipping : '.$order->shipping);
            dump(($key + 1).' of '.$ordersCount.' updated!');
        }
    }

    public function downloadTrackingReport($orderId)
    {
        $order = Order::with('organizationDetails')->find($orderId);

        if (!$order) {
            abort(404, 'Order not found.');
        }

        $shippingDetailsAll = ShippingOrderDetails::with('orderItems.productDetails')
            ->where('order_id', $orderId)
            ->get();

        $pdf = new SimplePdfBuilder();
        $pdf->setHeader($order->order_no, $order->organizationDetails->organization_name ?? '');

        $pdf->setColumns([
            ['label' => 'Product',         'key' => 'product',       'width' => 170],
            ['label' => 'Size',            'key' => 'size',          'width' => 70],
            ['label' => 'Player',          'key' => 'player',        'width' => 80],
            ['label' => 'Tracking Number', 'key' => 'tracking_no',   'width' => 110],
            ['label' => 'Tracking Link',   'key' => 'tracking_link', 'width' => 85],
        ]);

        foreach ($shippingDetailsAll as $shippingDetail) {
            $orderItem = $shippingDetail->orderItems;

            if ($orderItem && (!empty($shippingDetail->tracking_no) || !empty($shippingDetail->tracking_link))) {
                $productName = optional($orderItem->productDetails)->product_name
                    ?? $orderItem->display_name
                    ?? '-';
                $sizeName = $shippingDetail->size_name ?? '-';
                $player   = trim(($shippingDetail->player_name ?? '') . ' ' .
                    ($shippingDetail->player_number !== null && $shippingDetail->player_number !== '' ? '#' . $shippingDetail->player_number : ''));

                $pdf->addRow([
                    'product'            => $productName,
                    'size'               => $sizeName,
                    'player'             => $player !== '' ? $player : '-',
                    'tracking_no'        => $shippingDetail->tracking_no ?? '-',
                    'tracking_link_url'  => $shippingDetail->tracking_link ?? '',
                ]);
            }
        }

        $fileName = 'Tracking_numbers_order_' . $orderId . '.pdf';
        $content  = $pdf->output();

        return response($content, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Content-Length'      => strlen($content),
        ]);
    }

}
