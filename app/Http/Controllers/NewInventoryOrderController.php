<?php
namespace App\Http\Controllers;

require 'vendor/Carbon/autoload.php';

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\EmbellishmentType;
use App\Models\ExFactory;
use App\Models\Fabric;
use App\Models\Factory;
use App\Models\Holiday;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderFolder;
use App\Models\OrderItem;
use App\Models\OrderItemFile;
use App\Models\OrderItemsDetail;
use App\Models\OrderItemsDetailPlayerName;
use App\Models\OrderStatus;
use App\Models\Organization;
use App\Models\Product;
use App\Models\SubProduct;
use App\Models\ProductSize;
use App\Models\Sport;
use App\Models\User;
use App\Models\ProductFabric;
use App\Models\ProductCategoryList;
use App\Models\ProductCategory;
use App\Models\ProductSport;
use App\Models\ProductEmbellishmentType;
use App\Models\ProductAttribute;
use App\Models\OrderItemAttribute;
use App\Models\Attribute;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use domainencore\Facades\OrdersCommenFacade\OrdersCommenFacade;
use App\Services\NotificationBuilderService;

class NewInventoryOrderController extends Controller
{
    protected $inventoryOrgIds;

    public function __construct()
    {
        $this->inventoryOrgIds = OrdersCommenFacade::getEncoreOrgIds()->toArray();
    }

    public function index(){
        $organizations = Organization::select('id', 'organization_name')->whereIn('id', $this->inventoryOrgIds)->where('active', 1)->orderBy('organization_name')->get();

        $maxId = Order::max('id');
        $orderNo = str_pad(($maxId+1), 6, "0", STR_PAD_LEFT);

        $factories = Factory::select('id', 'factory_name', 'factory_code')->where('active', 1)->orderBy('factory_name')->get();

        $orderStatuses = OrderStatus::select('id', 'status_name')->where('active', 1)->orderBy('id')->get();

        $users = User::select('id', 'name', 'user_role_id')->orderBy('name')->get();

        $products = Product::where('active', [1, 0])->orderBy('product_name')->get();
        $subProducts = SubProduct::orderBy('product_name')->get();

        $product_sports = ProductSport::where('deleted_at', NULL)->orderBy('product_id')->get();
        $product_category = ProductCategoryList::where('deleted_at', NULL)->orderBy('product_id')->get();
        $categories = ProductCategory::where('active', 1)->orderBy('id')->get();

        $fabrics = Fabric::select('id','fabric_name')->where('active',1)->get();

        $embellishments = EmbellishmentType::select('id','embellishment_name')->where('active',1)->get();

        $exFactories = ExFactory::where('active', 1)->orderBy('ex_factory_name')->get();

        $sports = Sport::where('active', 1)->orderBy('sport_name')->get();

        // $directories = Storage::disk('google')->directories(env('OMS_ID'));

        $nowYear = Carbon::now()->format('Y');

        // if ($directories) {
        //     $folders = [];
        //     foreach($directories as $directory){
        //         $folder = Storage::disk('google')->getMetadata($directory);

        //         array_push($folders, $folder['name']);
        //     }

        //     if (!in_array($nowYear, $folders)) {
        //         Storage::disk('google')->makeDirectory(env('OMS_ID').'/'.$nowYear);
        //     }

        // } else {
        //     Storage::disk('google')->makeDirectory(env('OMS_ID').'/'.$nowYear);
        // }

        return view('pages.order_management.new_inventory_order.index', [
                    'organizations'=>$organizations, 'orderNo'=>$orderNo, 'factories'=>$factories,
                    'orderStatuses'=>$orderStatuses, 'users'=>$users, 'products'=>$products, 'fabrics'=>$fabrics,
                    'embellishments'=>$embellishments, 'exFactories'=>$exFactories, 'sports'=>$sports , 'subProducts'=>$subProducts,
                    'product_sports'=>$product_sports, 'product_category'=>$product_category, 'categories'=>$categories
        ]);
    }

    public function subDays($noOfDays){
        return $ex_factory_date;
    }

    public function newOrdersFromOrganization($id){
        $organizations = Organization::where('id', $id)->orderBy('organization_name')->get();

        $maxId = Order::max('id');
        $orderNo = str_pad(($maxId+1), 6, "0", STR_PAD_LEFT);

        $factories = Factory::select('id', 'factory_name', 'factory_code')->where('active', 1)->orderBy('factory_name')->get();

        $orderStatuses = OrderStatus::select('id', 'status_name')->where('active', 1)->orderBy('id')->get();

        $users = User::select('id', 'name')->orderBy('name')->get();

        $products = Product::select('id','product_name')->where('active',1)->get();

        $fabrics = Fabric::select('id','fabric_name')->where('active',1)->get();

        $embellishments = EmbellishmentType::select('id','embellishment_name')->where('active',1)->get();

        return view('pages.order_management.new_order.organization_new_order', [
                    'organizations'=>$organizations, 'orderNo'=>$orderNo, 'factories'=>$factories,
                    'orderStatuses'=>$orderStatuses, 'users'=>$users, 'products'=>$products, 'fabrics'=>$fabrics,
                    'embellishments'=>$embellishments
        ]);
    }

    public function address($customerId){
        // $address = Contact::select('contacts.shipping_street', 'contacts.shipping_po_box', 'contacts.shipping_city', 'contacts.shipping_state',
        //                             'contacts.shipping_zip', 'contacts.shipping_country', 'organizations.sales_tax',
        //                             'organizations.sales_tax_active', 'organizations.user_id', 'contacts.first_name', 'contacts.last_name',
        //                             'contacts.phone_no', 'contacts.email')
        //                        ->leftjoin('organizations', 'contacts.organization_id', '=', 'organizations.id')
        //                        ->where('contacts.id', $customerId)->get();

        $address = Contact::select('id', 'shipping_street', 'shipping_po_box', 'shipping_city', 'shipping_state', 'shipping_zip', 'shipping_country', 'first_name', 'last_name', 'phone_no', 'email')
                          ->where('id', $customerId)
                          ->first();

        return json_encode($address);
    }

    public function product($productId){
        $product = Product::select('products.product_no', 'products.product_name', 'products.default_price', 'products.pattern_code')
                          ->where('products.id', $productId)->get();

        // $product_fabric = ProductFabric::where('product_id', $productId)
        //                   ->with('fabrics')->get();

        // $product_embellishment_type = ProductEmbellishmentType::where('product_id', $productId)
        //                               ->with('embellishmentTypes')->get();

        // $product_attribute = ProductAttribute::where('product_id', $productId)
        //                     ->with('attributes')->get();


        $product_fabric = null;
        $fabric_array = array();

        $productFabrics_primary = ProductFabric::where('product_id',$productId)
                            ->with('fabrics')->get();
        $productFabrics_secondary = Product::where('id',$productId)->get();

        foreach($productFabrics_primary as $productFabric){
            $fabric_array[] = $productFabric->fabrics[0]->id;
        }
        foreach($productFabrics_secondary as $productFabric){
            if($productFabric->fabric_id != ""){
                $fabric_array[] = $productFabric->fabric_id;
            }
        }

        if(count($fabric_array)!=0){
            $fabric_array = array_unique($fabric_array);
            $product_fabric = Fabric::whereIn('id', $fabric_array)->get();
        }else{
            $product_fabric = Fabric::where('active', 1)->get();
        }
        ////////////////////////////////////////////////////////////////////////////

        $product_embellishment_type = null;
        $embellishment_array = array();

        $productEmbellishmentTypes = ProductEmbellishmentType::where('product_id',$productId)
                         ->with('embellishmentTypes')->get();

        foreach($productEmbellishmentTypes as $productEmbellishmentType){
            $embellishment_array[] = $productEmbellishmentType->embellishmentTypes[0]->id;
        }

        if(count($embellishment_array)!=0){
            $product_embellishment_type = EmbellishmentType::whereIn('id',$embellishment_array)->get();
        }else{
            $product_embellishment_type = EmbellishmentType::where('active',1)->get();
        }
        ///////////////////////////////////////////////////////////////////////////////////

        $product_attribute = null;
        $attributes_array = array();

        $productAttributes = ProductAttribute::where('product_id',$productId)
                            ->with('attributes')->get();

        foreach($productAttributes as $productAttribute){
            $attributes_array[] = $productAttribute->attribute_id;
        }

        if(count($attributes_array)!=0){
            $product_attribute = Attribute::whereIn('id',$attributes_array)->get();
        }else{
            $product_attribute = Attribute::where('active',1)->get();
        }

        echo json_encode([$product,$product_fabric,$product_embellishment_type,$product_attribute]);
    }

    public function status($statusId){
        $status = OrderStatus::select('status_name')->where('active', 1)->where('id', $statusId)->get();

        echo json_encode($status);
    }

    public function create(Request $request){
        if(auth()->user()->can('create order')){
            $contact = Contact::with('organizationDetails')->find($request->customer_id);
            $orgnization = Organization::find($request->organization_id);

            $userArray = [];

            $maxId = Order::max('id');
            $orderNo = str_pad(($maxId+1), 6, "0", STR_PAD_LEFT);

            $newOrder = new Order();
            $newOrder->organization_id = $request->organization_id;
            $newOrder->contact_id = $request->customer_id;
            $newOrder->order_no = $orderNo;
            $newOrder->order_status_id = $request->order_status_id;
            $newOrder->user_id = $request->user_id;
            // $newOrder->sub_total = $request->sub_total;
            // $newOrder->sales_tax = $request->sales_tax;
            // $newOrder->shipping = $request->shipping;
            // $newOrder->order_description = $request->order_description;
            // $newOrder->artwork = $request->artwork;
            // $newOrder->processing_fee = $request->processing_fee;
            // $newOrder->order_total = $request->order_total;
            $newOrder->open_date = Carbon::now()->format('m/d/Y');
            // $newOrder->encore_packing_date = $request->encore_packing_date;
            $newOrder->due_date = $request->due_date;
            $newOrder->ex_factory_date = $request->ex_factory_date;
            $newOrder->active = 1;

            $originalDueDate = Carbon::parse($request->due_date);
            $ex_factory_date = $originalDueDate->subDays(7)->format('m/d/Y');
            $newOrder->ex_factory_date = $ex_factory_date;

            $originalDueDate1 = Carbon::parse($request->due_date);
            $est_delivery_date = $originalDueDate1->subDays(2)->format('m/d/Y');
            $newOrder->est_delivery_date = $est_delivery_date;

            if($request->new_shipping_address == 1){
                $newOrder->is_new_shipping_address = 1;
                $newOrder->street = $request->new_street;
                $newOrder->city = $request->new_city;
                $newOrder->state = $request->new_state;
                $newOrder->postal_code = $request->new_postal_code;
                $newOrder->country = $request->new_country;
                $newOrder->phone_no = $request->new_phone_no;
                $newOrder->email = $request->new_email;
            } else {
                $newOrder->is_new_shipping_address = 0;
                $newOrder->street = $contact->shipping_street;
                $newOrder->city = $contact->shipping_city;
                $newOrder->state = $contact->shipping_state;
                $newOrder->postal_code = $contact->shipping_zip;
                $newOrder->country = $contact->shipping_country;
                $newOrder->phone_no = $contact->phone_no;
                $newOrder->email = $contact->email;
            }

            $newOrder->save();

            array_push($userArray, $request->user_id);

            if(isset($request->item)){
                foreach($request->item as $key => $itemsDetails){
                    $orderItem = new OrderItem();
                    $orderItem->item_no = $orderNo.'-'.$key;
                    $orderItem->order_id = $newOrder->id;
                    // $orderItem->product_id = $itemsDetails['product_id'];
                    $orderItem->organization_id = $itemsDetails['organization_id'];
                    $orderItem->factory_id = $itemsDetails['factory_id'];

                    $orderItem->display_name = $itemsDetails['item_name'];

                    $sub_product = SubProduct::where('id', $itemsDetails['product_id'])->first();

                    // dd($sub_product->fabric_id);

                    $orderItem->product_id = $sub_product->parent_product_id;
                    $orderItem->sub_product_no = $sub_product->sub_product_no;
                    if(empty($sub_product->fabric_id)){
                        $orderItem->fabric_id = $itemsDetails['fabric_id'];
                    }else{
                        $orderItem->fabric_id = $sub_product->fabric_id;
                    }
                    $orderItem->unit_price = $sub_product->default_price;

                    $orderItem->support_agent_id = $itemsDetails['support_agent_id'];
                    $orderItem->designer_id = $itemsDetails['designer_id'];
                    $orderItem->shipping_method = $itemsDetails['shipping_method'];
                    $orderItem->ex_factory_id = $itemsDetails['ex_factory_id'];
                    $orderItem->open_date = Carbon::now()->format('m/d/Y');
                    $orderItem->ex_factory_date = $itemsDetails['est_delivery_date'];
                    // $orderItem->encore_packing_date = $itemsDetails['encore_packing_date'];
                    $orderItem->in_hand_due_date = $itemsDetails['in_hand_due_date'];
                    $orderItem->est_delivery_date = $itemsDetails['est_delivery_date'];
                    $orderItem->order_status_id = $itemsDetails['status_id'];
                    // $orderItem->fabric_id = $itemsDetails['fabric_id'];
                    $orderItem->secondary_fabric_id = $itemsDetails['secondary_fabric_id'];
                    $orderItem->embellishment_type_id = $itemsDetails['embellishment_id'];
                    $orderItem->sport = $itemsDetails['sport'];
                    $orderItem->gender = $itemsDetails['gender'];
                    $orderItem->qty = $itemsDetails['qty'];
                    // $orderItem->unit_price = $itemsDetails['unit_price'];
                    // $orderItem->total = $itemsDetails['total'];

                    $orderItem->double_sided = isset($itemsDetails['double_sided']) ? 1 : 0;
                    $orderItem->individual_no = isset($itemsDetails['individual_no']) ? 1 : 0;
                    $orderItem->individual_name = isset($itemsDetails['individual_name']) ? 1 : 0;
                    $orderItem->pockets = isset($itemsDetails['pockets']) ? 1 : 0;
                    $orderItem->zipper_pockets = isset($itemsDetails['zipper_pockets']) ? 1 : 0;
                    $orderItem->dynamic_details = isset($itemsDetails['dynamic_details']) ? 1 : 0;
                    $orderItem->contrast_stratching = isset($itemsDetails['contrast_stratching']) ? 1 : 0;
                    $orderItem->printing_over_sems = isset($itemsDetails['printing_over_sems']) ? 1 : 0;

                    $orderItem->save();

                    // if(isset($itemsDetails['itemAttribute_ids'])){
                    //     $attribute_ids = explode(',', $itemsDetails['itemAttribute_ids']);
                    //     foreach($attribute_ids as $attribute_id){
                    //         $orderItemAttribute = new OrderItemAttribute();
                    //         $orderItemAttribute->order_item_id = $orderItem->id;
                    //         $orderItemAttribute->attribute_id = $attribute_id;
                    //         $orderItemAttribute->save();
                    //     }
                    // }

                    array_push($userArray, $itemsDetails['designer_id']);

                    $productSizes = [1, 2, 3, 4, 5, 6, 7, 8, 9,26,17,18,19,11,12,13,14,15,20,21,22,23,24,25,16,28,29];

                    $productSizes = ProductSize::select('size_id')->where('product_id', $sub_product->parent_product_id)->get()
                    ->sortBy(function ($size) use ($productSizes) {
                        return array_search($size->size_id, $productSizes);
                    });
                    foreach($productSizes as $sizes){
                        $orderItemsDetails = new OrderItemsDetail();
                        $orderItemsDetails->order_item_id = $orderItem->id;
                        $orderItemsDetails->size_id = $sizes['size_id'];
                        $orderItemsDetails->save();
                    }
                }
            }

            // array_push($userArray, Auth::user()->id);

            // foreach(array_unique($userArray) as $user){
            //     if(Auth::user()->id != $user){
            //         $notification = new Notification();
            //         $notification->notification_title = 'New Order - #'.$request->order_no;
            //         // $notification->notification_message = $contact['organizationDetails']['organization_name'].' - '.$request->order_description;
            //         $notification->notification_message = $orgnization['organization_name'].' - '.$request->order_description;
            //         $notification->is_read = 0;
            //         $notification->user_id = $user;
            //         $notification->order_id = $newOrder->id;
            //         $notification->save();
            //     }
            // }


            // Google Drive Folder Creation
            // $directories = Storage::disk('google')->directories();

            // $nowYear = Carbon::now()->format('Y');

            // $yearPath = '';
            // foreach($directories as $directory){
            //     $folder = Storage::disk('google')->getMetadata($directory);

            //     if ($folder['name'] == $nowYear) {
            //         $yearPath = $folder['path'];


            //         Storage::disk('google')->makeDirectory($yearPath.'/Order '.$newOrder->id);
            //     }
            // }

            // $orderDirectories = Storage::disk('google')->directories($yearPath);

            // $orderPath = '';
            // foreach($orderDirectories as $orderDirectory){
            //     $folder = Storage::disk('google')->getMetadata($orderDirectory);

            //     if ($folder['name'] == ('Order '.$newOrder->id)) {
            //         $orderPath = $folder['path'];

            //         $orderFolder = new OrderFolder();
            //         $orderFolder->order_id = $newOrder->id;
            //         $orderFolder->order_folder_id = $orderPath;
            //         $orderFolder->save();

            //         Storage::disk('google')->makeDirectory($orderPath.'/Tech Pack');
            //         Storage::disk('google')->makeDirectory($orderPath.'/Mockups');
            //         Storage::disk('google')->makeDirectory($orderPath.'/Production Layouts');
            //         Storage::disk('google')->makeDirectory($orderPath.'/Production Pics');
            //         Storage::disk('google')->makeDirectory($orderPath.'/Discussions');
            //         Storage::disk('google')->makeDirectory($orderPath.'/Test Print');
            //     }
            // }

            // $fileDirectories = Storage::disk('google')->directories($orderPath);

            // $techPackFolderId = '';
            // $mockupsFolderId = '';
            // $productionLayoutsFolderId = '';
            // $productionPicsFolderId = '';
            // $discussionsFolderId = '';
            // $testPrintFolderId = '';
            // foreach($fileDirectories as $fileDirectory){
            //     $folder = Storage::disk('google')->getMetadata($fileDirectory);

            //     if ($folder['name'] == 'Tech Pack') {
            //         $techPackFolderId = $folder['path'];

            //     } else if ($folder['name'] == 'Mockups') {
            //         $mockupsFolderId = $folder['path'];

            //     } else if ($folder['name'] == 'Production Layouts') {
            //         $productionLayoutsFolderId = $folder['path'];

            //     } else if ($folder['name'] == 'Production Pics') {
            //         $productionPicsFolderId = $folder['path'];

            //     } else if ($folder['name'] == 'Discussions') {
            //         $discussionsFolderId = $folder['path'];

            //     } else if ($folder['name'] == 'Test Print') {
            //         $testPrintFolderId = $folder['path'];
            //     }
            // }

            // $orderFolder = OrderFolder::where('order_id', $newOrder->id)->first();
            // $orderFolder->tech_pack_folder_id = $techPackFolderId;
            // $orderFolder->mockups_folder_id = $mockupsFolderId;
            // $orderFolder->production_layouts_folder_id = $productionLayoutsFolderId;
            // $orderFolder->production_pics_folder_id = $productionPicsFolderId;
            // $orderFolder->discussions_folder_id = $discussionsFolderId;
            // $orderFolder->test_print_folder_id = $testPrintFolderId;
            // $orderFolder->update();

            $this->sendNewOrderNotification($newOrder, $newOrder, $orgnization, $newOrder->order_description);

            return redirect()->to('order_details/edit/'.$newOrder->id.'/order?active_tab=order')->withSuccess('Order Submitted Successfully!');
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function createReOrder(Request $request){
        if(auth()->user()->can('re order')){
            $nowDate = Carbon::now()->format('m/d/Y');
            $orderId = $request->exs_order_id;

            $exsOrder = Order::find($orderId);
            $orgnization = Organization::find($exsOrder->organization_id);

            $maxId = Order::max('id');
            if ($exsOrder->order_type == 1) {
                $orderNo = "TSR".str_pad(($maxId+1), 6, "0", STR_PAD_LEFT);
            } else {
                $orderNo = str_pad(($maxId+1), 6, "0", STR_PAD_LEFT);
            }

            $userArray = [];

            $newOrder = new Order();
            $newOrder->organization_id = $exsOrder->organization_id;
            $newOrder->contact_id = $exsOrder->contact_id;
            $newOrder->order_no = $orderNo;
            $newOrder->order_status_id = 1;
            $newOrder->user_id = $exsOrder->user_id;
            if(isset($request->roster) && $request->roster == 'yes'){
                $newOrder->sub_total = $exsOrder->sub_total;
                $newOrder->sales_tax = $exsOrder->sales_tax;
                $newOrder->shipping = $exsOrder->shipping;
                $newOrder->artwork =$exsOrder->artwork;
                $newOrder->processing_fee = $exsOrder->processing_fee;
                $newOrder->order_total = $exsOrder->order_total;
            } else {
                $newOrder->sub_total = 0;
                $newOrder->sales_tax = 0;
                $newOrder->shipping = 0;
                $newOrder->artwork = 0;
                $newOrder->processing_fee = 0;
                $newOrder->order_total = 0;
            }

            $newOrder->order_description = $exsOrder->order_description;
            $newOrder->open_date = $nowDate;
            $newOrder->due_date = null;
            $newOrder->encore_packing_date = $exsOrder->encore_packing_date;
            $newOrder->ex_factory_date = null;
            $newOrder->active = 1;

            $newOrder->order_type = $exsOrder->order_type;
            $newOrder->address_type = $exsOrder->address_type;
            $newOrder->is_new_shipping_address = $exsOrder->is_new_shipping_address;
            $newOrder->street = $exsOrder->street;
            $newOrder->city = $exsOrder->city;
            $newOrder->state = $exsOrder->state;
            $newOrder->postal_code = $exsOrder->postal_code;
            $newOrder->country = $exsOrder->country;
            $newOrder->phone_no = $exsOrder->phone_no;
            $newOrder->email = $exsOrder->email;

            $newOrder->is_reordered = 1;
            $newOrder->order_id = $exsOrder->id;
            $newOrder->order_ref_no = $exsOrder->order_no;

            $newOrder->save();

            array_push($userArray, $exsOrder->user_id);

            $exsOrderItems = OrderItem::where('order_id', $orderId)->get();
            if( count($exsOrderItems) > 0 ){
                $itemCount = 1;
                foreach($exsOrderItems as $itemsDetails){
                    $orderItem = new OrderItem();
                    $orderItem->item_no = $newOrder->order_no.'-'.$itemCount;
                    $orderItem->order_id = $newOrder->id;
                    $orderItem->product_id = $itemsDetails['product_id'];
                    $orderItem->sub_product_no = $itemsDetails['sub_product_no'];
                    $orderItem->display_name = $itemsDetails['display_name'];
                    $orderItem->organization_id = $itemsDetails['organization_id'];
                    $orderItem->factory_id = $itemsDetails['factory_id'];
                    $orderItem->support_agent_id = $itemsDetails['support_agent_id'];
                    $orderItem->designer_id = $itemsDetails['designer_id'];
                    $orderItem->shipping_method = $itemsDetails['shipping_method'];
                    $orderItem->ex_factory_id = $itemsDetails['ex_factory_id'];
                    $orderItem->open_date = $nowDate;
                    $orderItem->ex_factory_date = $itemsDetails['ex_factory_date'];
                    $orderItem->encore_packing_date = $itemsDetails['encore_packing_date'];
                    $orderItem->in_hand_due_date = $itemsDetails['in_hand_due_date'];
                    // $orderItem->est_delivery_date = $itemsDetails['ex_factory_date'];
                    $orderItem->order_status_id = 1;
                    $orderItem->fabric_id = $itemsDetails['fabric_id'];
                    $orderItem->secondary_fabric_id = $itemsDetails['secondary_fabric_id'];
                    $orderItem->embellishment_type_id = $itemsDetails['embellishment_type_id'];

                    $orderItem->double_sided = $itemsDetails['double_sided'];
                    $orderItem->individual_no = $itemsDetails['individual_no'];
                    $orderItem->individual_name = $itemsDetails['individual_name'];
                    $orderItem->pockets = $itemsDetails['pockets'];
                    $orderItem->zipper_pockets = $itemsDetails['zipper_pockets'];
                    $orderItem->dynamic_details = $itemsDetails['dynamic_details'];
                    $orderItem->contrast_stratching = $itemsDetails['contrast_stratching'];
                    $orderItem->printing_over_sems = $itemsDetails['printing_over_sems'];

                    $orderItem->sport = $itemsDetails['sport'];
                    $orderItem->gender = $itemsDetails['gender'];

                    $reorderQty = 0;
                    $reorderTotal = 0;
                    if(isset($request->roster) && $request->roster == 'yes'){
                        $reorderQty = $itemsDetails['qty'];
                        $reorderTotal = $itemsDetails['total'];
                    }

                    $orderItem->qty = $reorderQty;
                    $orderItem->unit_price = $itemsDetails['unit_price'];
                    $orderItem->total = $reorderTotal;
                    $orderItem->save();

                    array_push($userArray, $itemsDetails['designer_id']);



                    $orderItemFiles = OrderItemFile::where('order_item_id', $itemsDetails['id'])->get();

                    foreach($orderItemFiles as $orderItemFile){
                        $newOrderItemFile = new OrderItemFile();
                        $newOrderItemFile->organization_id = $orderItem->organization_id;
                        $newOrderItemFile->contact_id = $newOrder->contact_id;
                        $newOrderItemFile->order_id = $newOrder->id;
                        $newOrderItemFile->order_item_id = $orderItem->id;

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

                    if(isset($request->roster) && $request->roster == 'yes'){
                        $exsOrderItemDetails = OrderItemsDetail::where('order_item_id', $itemsDetails['id'])->get();
                        foreach($exsOrderItemDetails as $exsOrderItemDetail){
                            $orderItemsDetails = new OrderItemsDetail();
                            $orderItemsDetails->order_item_id = $orderItem->id;
                            $orderItemsDetails->qty = $exsOrderItemDetail->qty;
                            $orderItemsDetails->size_id = $exsOrderItemDetail->size_id;
                            $orderItemsDetails->blanks = $exsOrderItemDetail->blanks;

                            $orderItemsDetails->numseq_one = $exsOrderItemDetail->numseq_one;
                            $orderItemsDetails->numseq_two = $exsOrderItemDetail->numseq_two;
                            $orderItemsDetails->numseq_three = $exsOrderItemDetail->numseq_three;
                            $orderItemsDetails->numseq_four = $exsOrderItemDetail->numseq_four;
                            $orderItemsDetails->numseq_five = $exsOrderItemDetail->numseq_five;
                            $orderItemsDetails->numseq_six = $exsOrderItemDetail->numseq_six;
                            $orderItemsDetails->numseq_seven = $exsOrderItemDetail->numseq_seven;
                            $orderItemsDetails->numseq_eight = $exsOrderItemDetail->numseq_eight;
                            $orderItemsDetails->numseq_nine = $exsOrderItemDetail->numseq_nine;
                            $orderItemsDetails->numseq_ten = $exsOrderItemDetail->numseq_ten;

                            $orderItemsDetails->numseq_eleven = $exsOrderItemDetail->numseq_eleven;
                            $orderItemsDetails->numseq_twelve = $exsOrderItemDetail->numseq_twelve;
                            $orderItemsDetails->numseq_thirteen = $exsOrderItemDetail->numseq_thirteen;
                            $orderItemsDetails->numseq_fourteen = $exsOrderItemDetail->numseq_fourteen;
                            $orderItemsDetails->numseq_fifteen = $exsOrderItemDetail->numseq_fifteen;
                            $orderItemsDetails->numseq_sixteen = $exsOrderItemDetail->numseq_sixteen;
                            $orderItemsDetails->numseq_seventeen = $exsOrderItemDetail->numseq_seventeen;
                            $orderItemsDetails->numseq_eighteen = $exsOrderItemDetail->numseq_eighteen;
                            $orderItemsDetails->numseq_nineteen = $exsOrderItemDetail->numseq_nineteen;
                            $orderItemsDetails->numseq_twenty = $exsOrderItemDetail->numseq_twenty;

                            $orderItemsDetails->numseq_twenty_one = $exsOrderItemDetail->numseq_twenty_one;
                            $orderItemsDetails->numseq_twenty_two = $exsOrderItemDetail->numseq_twenty_two;
                            $orderItemsDetails->numseq_twenty_three = $exsOrderItemDetail->numseq_twenty_three;
                            $orderItemsDetails->numseq_twenty_four = $exsOrderItemDetail->numseq_twenty_four;
                            $orderItemsDetails->numseq_twenty_five = $exsOrderItemDetail->numseq_twenty_five;
                            $orderItemsDetails->numseq_twenty_six = $exsOrderItemDetail->numseq_twenty_six;
                            $orderItemsDetails->numseq_twenty_seven = $exsOrderItemDetail->numseq_twenty_seven;
                            $orderItemsDetails->numseq_twenty_eight = $exsOrderItemDetail->numseq_twenty_eight;
                            $orderItemsDetails->numseq_twenty_nine = $exsOrderItemDetail->numseq_twenty_nine;
                            $orderItemsDetails->numseq_thirty = $exsOrderItemDetail->numseq_thirty;

                            $orderItemsDetails->numseq_thirty_one = $exsOrderItemDetail->numseq_thirty_one;
                            $orderItemsDetails->numseq_thirty_two = $exsOrderItemDetail->numseq_thirty_two;
                            $orderItemsDetails->numseq_thirty_three = $exsOrderItemDetail->numseq_thirty_three;
                            $orderItemsDetails->numseq_thirty_four = $exsOrderItemDetail->numseq_thirty_four;
                            $orderItemsDetails->numseq_thirty_five = $exsOrderItemDetail->numseq_thirty_five;
                            $orderItemsDetails->numseq_thirty_six = $exsOrderItemDetail->numseq_thirty_six;
                            $orderItemsDetails->numseq_thirty_seven = $exsOrderItemDetail->numseq_thirty_seven;
                            $orderItemsDetails->numseq_thirty_eight = $exsOrderItemDetail->numseq_thirty_eight;
                            $orderItemsDetails->numseq_thirty_nine = $exsOrderItemDetail->numseq_thirty_nine;
                            $orderItemsDetails->numseq_forty = $exsOrderItemDetail->numseq_forty;

                            $orderItemsDetails->numseq_forty_one = $exsOrderItemDetail->numseq_forty_one;
                            $orderItemsDetails->numseq_forty_two = $exsOrderItemDetail->numseq_forty_two;
                            $orderItemsDetails->numseq_forty_three = $exsOrderItemDetail->numseq_forty_three;
                            $orderItemsDetails->numseq_forty_four = $exsOrderItemDetail->numseq_forty_four;
                            $orderItemsDetails->numseq_forty_five = $exsOrderItemDetail->numseq_forty_five;
                            $orderItemsDetails->numseq_forty_six = $exsOrderItemDetail->numseq_forty_six;
                            $orderItemsDetails->numseq_forty_seven = $exsOrderItemDetail->numseq_forty_seven;
                            $orderItemsDetails->numseq_forty_eight = $exsOrderItemDetail->numseq_forty_eight;
                            $orderItemsDetails->numseq_forty_nine = $exsOrderItemDetail->numseq_forty_nine;
                            $orderItemsDetails->numseq_fifty = $exsOrderItemDetail->numseq_fifty;

                            $orderItemsDetails->numseq_fifty_one = $exsOrderItemDetail->numseq_fifty_one;
                            $orderItemsDetails->numseq_fifty_two = $exsOrderItemDetail->numseq_fifty_two;
                            $orderItemsDetails->numseq_fifty_three = $exsOrderItemDetail->numseq_fifty_three;
                            $orderItemsDetails->numseq_fifty_four = $exsOrderItemDetail->numseq_fifty_four;
                            $orderItemsDetails->numseq_fifty_five = $exsOrderItemDetail->numseq_fifty_five;
                            $orderItemsDetails->numseq_fifty_six = $exsOrderItemDetail->numseq_fifty_six;
                            $orderItemsDetails->numseq_fifty_seven = $exsOrderItemDetail->numseq_fifty_seven;
                            $orderItemsDetails->numseq_fifty_eight = $exsOrderItemDetail->numseq_fifty_eight;
                            $orderItemsDetails->numseq_fifty_nine = $exsOrderItemDetail->numseq_fifty_nine;
                            $orderItemsDetails->numseq_sixty = $exsOrderItemDetail->numseq_sixty;

                            $orderItemsDetails->numseq_sixty_one = $exsOrderItemDetail->numseq_sixty_one;
                            $orderItemsDetails->numseq_sixty_two = $exsOrderItemDetail->numseq_sixty_two;
                            $orderItemsDetails->numseq_sixty_three = $exsOrderItemDetail->numseq_sixty_three;
                            $orderItemsDetails->numseq_sixty_four = $exsOrderItemDetail->numseq_sixty_four;
                            $orderItemsDetails->numseq_sixty_five = $exsOrderItemDetail->numseq_sixty_five;
                            $orderItemsDetails->numseq_sixty_six = $exsOrderItemDetail->numseq_sixty_six;
                            $orderItemsDetails->numseq_sixty_seven = $exsOrderItemDetail->numseq_sixty_seven;
                            $orderItemsDetails->numseq_sixty_eight = $exsOrderItemDetail->numseq_sixty_eight;
                            $orderItemsDetails->numseq_sixty_nine = $exsOrderItemDetail->numseq_sixty_nine;
                            $orderItemsDetails->numseq_seventy = $exsOrderItemDetail->numseq_seventy;

                            $orderItemsDetails->numseq_seventy_one = $exsOrderItemDetail->numseq_seventy_one;
                            $orderItemsDetails->numseq_seventy_two = $exsOrderItemDetail->numseq_seventy_two;
                            $orderItemsDetails->numseq_seventy_three = $exsOrderItemDetail->numseq_seventy_three;
                            $orderItemsDetails->numseq_seventy_four = $exsOrderItemDetail->numseq_seventy_four;
                            $orderItemsDetails->numseq_seventy_five = $exsOrderItemDetail->numseq_seventy_five;
                            $orderItemsDetails->numseq_seventy_six = $exsOrderItemDetail->numseq_seventy_six;
                            $orderItemsDetails->numseq_seventy_seven = $exsOrderItemDetail->numseq_seventy_seven;
                            $orderItemsDetails->numseq_seventy_eight = $exsOrderItemDetail->numseq_seventy_eight;
                            $orderItemsDetails->numseq_seventy_nine = $exsOrderItemDetail->numseq_seventy_nine;
                            $orderItemsDetails->numseq_seventy = $exsOrderItemDetail->numseq_seventy;

                            $orderItemsDetails->numseq_eighty_one = $exsOrderItemDetail->numseq_eighty_one;
                            $orderItemsDetails->numseq_eighty_two = $exsOrderItemDetail->numseq_eighty_two;
                            $orderItemsDetails->numseq_eighty_three = $exsOrderItemDetail->numseq_eighty_three;
                            $orderItemsDetails->numseq_eighty_four = $exsOrderItemDetail->numseq_eighty_four;
                            $orderItemsDetails->numseq_eighty_five = $exsOrderItemDetail->numseq_eighty_five;
                            $orderItemsDetails->numseq_eighty_six = $exsOrderItemDetail->numseq_eighty_six;
                            $orderItemsDetails->numseq_eighty_seven = $exsOrderItemDetail->numseq_eighty_seven;
                            $orderItemsDetails->numseq_eighty_eight = $exsOrderItemDetail->numseq_eighty_eight;
                            $orderItemsDetails->numseq_eighty_nine = $exsOrderItemDetail->numseq_eighty_nine;
                            $orderItemsDetails->numseq_ninety = $exsOrderItemDetail->numseq_ninety;

                            $orderItemsDetails->numseq_ninety_one = $exsOrderItemDetail->numseq_ninety_one;
                            $orderItemsDetails->numseq_ninety_two = $exsOrderItemDetail->numseq_ninety_two;
                            $orderItemsDetails->numseq_ninety_three = $exsOrderItemDetail->numseq_ninety_three;
                            $orderItemsDetails->numseq_ninety_four = $exsOrderItemDetail->numseq_ninety_four;
                            $orderItemsDetails->numseq_ninety_five = $exsOrderItemDetail->numseq_ninety_five;
                            $orderItemsDetails->numseq_ninety_six = $exsOrderItemDetail->numseq_ninety_six;
                            $orderItemsDetails->numseq_ninety_seven = $exsOrderItemDetail->numseq_ninety_seven;
                            $orderItemsDetails->numseq_ninety_eight = $exsOrderItemDetail->numseq_ninety_eight;
                            $orderItemsDetails->numseq_ninety_nine = $exsOrderItemDetail->numseq_ninety_nine;
                            $orderItemsDetails->numseq_hundred = $exsOrderItemDetail->numseq_hundred;

                            $orderItemsDetails->show_extra = $exsOrderItemDetail->show_extra;
                            $orderItemsDetails->save();

                            $exsOrderItemDetailPlayerName = OrderItemsDetailPlayerName::where('order_items_detail_id', $exsOrderItemDetail->id)->first();
                            if($exsOrderItemDetailPlayerName){
                                $playerNameDetails = new OrderItemsDetailPlayerName();
                                $playerNameDetails->order_items_detail_id = $orderItemsDetails->id;

                                $playerNameDetails->player_one = $exsOrderItemDetailPlayerName->player_one;
                                $playerNameDetails->player_two = $exsOrderItemDetailPlayerName->player_two;
                                $playerNameDetails->player_three = $exsOrderItemDetailPlayerName->player_three;
                                $playerNameDetails->player_four = $exsOrderItemDetailPlayerName->player_four;
                                $playerNameDetails->player_five = $exsOrderItemDetailPlayerName->player_five;
                                $playerNameDetails->player_six = $exsOrderItemDetailPlayerName->player_six;
                                $playerNameDetails->player_seven = $exsOrderItemDetailPlayerName->player_seven;
                                $playerNameDetails->player_eight = $exsOrderItemDetailPlayerName->player_eight;
                                $playerNameDetails->player_nine = $exsOrderItemDetailPlayerName->player_nine;
                                $playerNameDetails->player_ten = $exsOrderItemDetailPlayerName->player_ten;

                                $playerNameDetails->player_eleven = $exsOrderItemDetailPlayerName->player_eleven;
                                $playerNameDetails->player_twelve = $exsOrderItemDetailPlayerName->player_twelve;
                                $playerNameDetails->player_thirteen = $exsOrderItemDetailPlayerName->player_thirteen;
                                $playerNameDetails->player_fourteen = $exsOrderItemDetailPlayerName->player_fourteen;
                                $playerNameDetails->player_fifteen = $exsOrderItemDetailPlayerName->player_fifteen;
                                $playerNameDetails->player_sixteen = $exsOrderItemDetailPlayerName->player_sixteen;
                                $playerNameDetails->player_seventeen = $exsOrderItemDetailPlayerName->player_seventeen;
                                $playerNameDetails->player_eighteen = $exsOrderItemDetailPlayerName->player_eighteen;
                                $playerNameDetails->player_nineteen = $exsOrderItemDetailPlayerName->player_nineteen;
                                $playerNameDetails->player_twenty = $exsOrderItemDetailPlayerName->player_twenty;

                                $playerNameDetails->player_twenty_one = $exsOrderItemDetailPlayerName->player_twenty_one;
                                $playerNameDetails->player_twenty_two = $exsOrderItemDetailPlayerName->player_twenty_two;
                                $playerNameDetails->player_twenty_three = $exsOrderItemDetailPlayerName->player_twenty_three;
                                $playerNameDetails->player_twenty_four = $exsOrderItemDetailPlayerName->player_twenty_four;
                                $playerNameDetails->player_twenty_five = $exsOrderItemDetailPlayerName->player_twenty_five;
                                $playerNameDetails->player_twenty_six = $exsOrderItemDetailPlayerName->player_twenty_six;
                                $playerNameDetails->player_twenty_seven = $exsOrderItemDetailPlayerName->player_twenty_seven;
                                $playerNameDetails->player_twenty_eight = $exsOrderItemDetailPlayerName->player_twenty_eight;
                                $playerNameDetails->player_twenty_nine = $exsOrderItemDetailPlayerName->player_twenty_nine;
                                $playerNameDetails->player_thirty = $exsOrderItemDetailPlayerName->player_thirty;

                                $playerNameDetails->player_thirty_one = $exsOrderItemDetailPlayerName->player_thirty_one;
                                $playerNameDetails->player_thirty_two = $exsOrderItemDetailPlayerName->player_thirty_two;
                                $playerNameDetails->player_thirty_three = $exsOrderItemDetailPlayerName->player_thirty_three;
                                $playerNameDetails->player_thirty_four = $exsOrderItemDetailPlayerName->player_thirty_four;
                                $playerNameDetails->player_thirty_five = $exsOrderItemDetailPlayerName->player_thirty_five;
                                $playerNameDetails->player_thirty_six = $exsOrderItemDetailPlayerName->player_thirty_six;
                                $playerNameDetails->player_thirty_seven = $exsOrderItemDetailPlayerName->player_thirty_seven;
                                $playerNameDetails->player_thirty_eight = $exsOrderItemDetailPlayerName->player_thirty_eight;
                                $playerNameDetails->player_thirty_nine = $exsOrderItemDetailPlayerName->player_thirty_nine;
                                $playerNameDetails->player_forty = $exsOrderItemDetailPlayerName->player_forty;

                                $playerNameDetails->player_forty_one = $exsOrderItemDetailPlayerName->player_forty_one;
                                $playerNameDetails->player_forty_two = $exsOrderItemDetailPlayerName->player_forty_two;
                                $playerNameDetails->player_forty_three = $exsOrderItemDetailPlayerName->player_forty_three;
                                $playerNameDetails->player_forty_four = $exsOrderItemDetailPlayerName->player_forty_four;
                                $playerNameDetails->player_forty_five = $exsOrderItemDetailPlayerName->player_forty_five;
                                $playerNameDetails->player_forty_six = $exsOrderItemDetailPlayerName->player_forty_six;
                                $playerNameDetails->player_forty_seven = $exsOrderItemDetailPlayerName->player_forty_seven;
                                $playerNameDetails->player_forty_eight = $exsOrderItemDetailPlayerName->player_forty_eight;
                                $playerNameDetails->player_forty_nine = $exsOrderItemDetailPlayerName->player_forty_nine;
                                $playerNameDetails->player_fifty = $exsOrderItemDetailPlayerName->player_fifty;

                                $playerNameDetails->player_fifty_one = $exsOrderItemDetailPlayerName->player_fifty_one;
                                $playerNameDetails->player_fifty_two = $exsOrderItemDetailPlayerName->player_fifty_two;
                                $playerNameDetails->player_fifty_three = $exsOrderItemDetailPlayerName->player_fifty_three;
                                $playerNameDetails->player_fifty_four = $exsOrderItemDetailPlayerName->player_fifty_four;
                                $playerNameDetails->player_fifty_five = $exsOrderItemDetailPlayerName->player_fifty_five;
                                $playerNameDetails->player_fifty_six = $exsOrderItemDetailPlayerName->player_fifty_six;
                                $playerNameDetails->player_fifty_seven = $exsOrderItemDetailPlayerName->player_fifty_seven;
                                $playerNameDetails->player_fifty_eight = $exsOrderItemDetailPlayerName->player_fifty_eight;
                                $playerNameDetails->player_fifty_nine = $exsOrderItemDetailPlayerName->player_fifty_nine;
                                $playerNameDetails->player_sixty = $exsOrderItemDetailPlayerName->player_sixty;

                                $playerNameDetails->player_sixty_one = $exsOrderItemDetailPlayerName->player_sixty_one;
                                $playerNameDetails->player_sixty_two = $exsOrderItemDetailPlayerName->player_sixty_two;
                                $playerNameDetails->player_sixty_three = $exsOrderItemDetailPlayerName->player_sixty_three;
                                $playerNameDetails->player_sixty_four = $exsOrderItemDetailPlayerName->player_sixty_four;
                                $playerNameDetails->player_sixty_five = $exsOrderItemDetailPlayerName->player_sixty_five;
                                $playerNameDetails->player_sixty_six = $exsOrderItemDetailPlayerName->player_sixty_six;
                                $playerNameDetails->player_sixty_seven = $exsOrderItemDetailPlayerName->player_sixty_seven;
                                $playerNameDetails->player_sixty_eight = $exsOrderItemDetailPlayerName->player_sixty_eight;
                                $playerNameDetails->player_sixty_nine = $exsOrderItemDetailPlayerName->player_sixty_nine;
                                $playerNameDetails->player_seventy = $exsOrderItemDetailPlayerName->player_seventy;

                                $playerNameDetails->player_seventy_one = $exsOrderItemDetailPlayerName->player_seventy_one;
                                $playerNameDetails->player_seventy_two = $exsOrderItemDetailPlayerName->player_seventy_two;
                                $playerNameDetails->player_seventy_three = $exsOrderItemDetailPlayerName->player_seventy_three;
                                $playerNameDetails->player_seventy_four = $exsOrderItemDetailPlayerName->player_seventy_four;
                                $playerNameDetails->player_seventy_five = $exsOrderItemDetailPlayerName->player_seventy_five;
                                $playerNameDetails->player_seventy_six = $exsOrderItemDetailPlayerName->player_seventy_six;
                                $playerNameDetails->player_seventy_seven = $exsOrderItemDetailPlayerName->player_seventy_seven;
                                $playerNameDetails->player_seventy_eight = $exsOrderItemDetailPlayerName->player_seventy_eight;
                                $playerNameDetails->player_seventy_nine = $exsOrderItemDetailPlayerName->player_seventy_nine;
                                $playerNameDetails->player_seventy = $exsOrderItemDetailPlayerName->player_seventy;

                                $playerNameDetails->player_eighty_one = $exsOrderItemDetailPlayerName->player_eighty_one;
                                $playerNameDetails->player_eighty_two = $exsOrderItemDetailPlayerName->player_eighty_two;
                                $playerNameDetails->player_eighty_three = $exsOrderItemDetailPlayerName->player_eighty_three;
                                $playerNameDetails->player_eighty_four = $exsOrderItemDetailPlayerName->player_eighty_four;
                                $playerNameDetails->player_eighty_five = $exsOrderItemDetailPlayerName->player_eighty_five;
                                $playerNameDetails->player_eighty_six = $exsOrderItemDetailPlayerName->player_eighty_six;
                                $playerNameDetails->player_eighty_seven = $exsOrderItemDetailPlayerName->player_eighty_seven;
                                $playerNameDetails->player_eighty_eight = $exsOrderItemDetailPlayerName->player_eighty_eight;
                                $playerNameDetails->player_eighty_nine = $exsOrderItemDetailPlayerName->player_eighty_nine;
                                $playerNameDetails->player_ninety = $exsOrderItemDetailPlayerName->player_ninety;

                                $playerNameDetails->player_ninety_one = $exsOrderItemDetailPlayerName->player_ninety_one;
                                $playerNameDetails->player_ninety_two = $exsOrderItemDetailPlayerName->player_ninety_two;
                                $playerNameDetails->player_ninety_three = $exsOrderItemDetailPlayerName->player_ninety_three;
                                $playerNameDetails->player_ninety_four = $exsOrderItemDetailPlayerName->player_ninety_four;
                                $playerNameDetails->player_ninety_five = $exsOrderItemDetailPlayerName->player_ninety_five;
                                $playerNameDetails->player_ninety_six = $exsOrderItemDetailPlayerName->player_ninety_six;
                                $playerNameDetails->player_ninety_seven = $exsOrderItemDetailPlayerName->player_ninety_seven;
                                $playerNameDetails->player_ninety_eight = $exsOrderItemDetailPlayerName->player_ninety_eight;
                                $playerNameDetails->player_ninety_nine = $exsOrderItemDetailPlayerName->player_ninety_nine;
                                $playerNameDetails->player_hundred = $exsOrderItemDetailPlayerName->player_hundred;

                                $playerNameDetails->blank_qty = $exsOrderItemDetailPlayerName->blank_qty;
                                $playerNameDetails->blank_player_names = $exsOrderItemDetailPlayerName->blank_player_names;
                                $playerNameDetails->name = $exsOrderItemDetailPlayerName->name;
                                $playerNameDetails->active = $exsOrderItemDetailPlayerName->active;

                                $playerNameDetails->save();
                            }
                        }
                    } else {
                        $productSizes = ProductSize::select('size_id')->where('product_id', $itemsDetails['product_id'])->get();

                        foreach($productSizes as $sizes){
                            $orderItemsDetails = new OrderItemsDetail();
                            $orderItemsDetails->order_item_id = $orderItem->id;
                            $orderItemsDetails->size_id = $sizes['size_id'];
                            $orderItemsDetails->save();
                        }
                    }

                    $itemCount += 1;
                }
            }

            // array_push($userArray, Auth::user()->id);

            // foreach(array_unique($userArray) as $user){
            //     if(Auth::user()->id != $user){
            //         $notification = new Notification();
            //         $notification->notification_title = 'New Order - #'.$orderNo;
            //         // $notification->notification_message = $contact['organizationDetails']['organization_name'].' - '.$newOrder->order_description;
            //         $notification->notification_message = $orgnization['organization_name'].' - '.$request->order_description;
            //         $notification->is_read = 0;
            //         $notification->user_id = $user;
            //         $notification->order_id = $newOrder->id;
            //         $notification->save();
            //     }
            // }

            // Google Drive Folder Creation
            $directories = Storage::disk('google')->directories();

            $nowYear = Carbon::now()->format('Y');

            $yearPath = '';
            foreach($directories as $directory){
                $folder = Storage::disk('google')->getMetadata($directory);

                if ($folder['name'] == $nowYear) {
                    $yearPath = $folder['path'];


                    Storage::disk('google')->makeDirectory($yearPath.'/Order '.$newOrder->id);
                }
            }

            $orderDirectories = Storage::disk('google')->directories($yearPath);

            $orderPath = '';
            foreach($orderDirectories as $orderDirectory){
                $folder = Storage::disk('google')->getMetadata($orderDirectory);

                if ($folder['name'] == ('Order '.$newOrder->id)) {
                    $orderPath = $folder['path'];

                    $orderFolder = new OrderFolder();
                    $orderFolder->order_id = $newOrder->id;
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

                } else if ($folder['name'] == 'Test Print') {
                    $testPrintFolderId = $folder['path'];
                }
            }

            $orderFolder = OrderFolder::where('order_id', $newOrder->id)->first();
            $orderFolder->tech_pack_folder_id = $techPackFolderId;
            $orderFolder->mockups_folder_id = $mockupsFolderId;
            $orderFolder->production_layouts_folder_id = $productionLayoutsFolderId;
            $orderFolder->production_pics_folder_id = $productionPicsFolderId;
            $orderFolder->discussions_folder_id = $discussionsFolderId;
            $orderFolder->test_print_folder_id = $testPrintFolderId;
            $orderFolder->update();

            $this->sendReOrderNotification($newOrder, $exsOrder, $orgnization, $newOrder->order_description);

            return redirect()->to('order_details/edit/'.$newOrder->id.'/order?active_tab=order')->withSuccess('Order Submitted Successfully!');
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function getOrders($orderId){
        if(isset($orderId)){
            $orderValues = OrderItem::select('id','description')->where('order_id',$orderId)->get();
            echo json_encode($orderValues);
        }

    }

    public function getChildOrderItems($orderId){
        if(isset($orderId)){
            $orderValues = OrderItem::select('id','description')->where('order_id',$orderId)->get();
            echo json_encode($orderValues);
        }
    }

    public function viewInvoice(){
            $products = Product::select('id','product_name')->where('active',1)->get();
            $Fabric = Fabric::select('id','fabric_name')->where('active',1)->get();
            $Embellishment = EmbellishmentType::select('id','embellishments_code')->where('active',1)->get();
            return view('profile.edit',['products'=>$products,'Fabric'=>$Fabric,'Embellishment'=>$Embellishment]);
    }

    public function productFilter($sport, $gender, $category){
        if($sport != 'all' && $gender != 'all' && $category != 'all'){
            $products = Product::where('sport', 'LIKE', '%'.$sport.'%')
                               ->where('gender', 'LIKE', '%'.$gender.'%')
                               ->where('product_category_id', 'LIKE', '%'.$category.'%')
                               ->where('active', 1)
                               ->orderBy('product_name')
                               ->get();

        } else if($sport != 'all' && $gender != 'all' && $category == 'all'){
            $products = Product::where('sport', 'LIKE', '%'.$sport.'%')
                               ->where('gender', 'LIKE', '%'.$gender.'%')
                               ->where('active', 1)
                               ->orderBy('product_name')
                               ->get();

        } else if($sport != 'all' && $gender == 'all' && $category != 'all'){
            $products = Product::where('sport', 'LIKE', '%'.$sport.'%')
                               ->where('product_category_id', 'LIKE', '%'.$category.'%')
                               ->where('active', 1)
                               ->orderBy('product_name')
                               ->get();

        } else if($sport != 'all' && $gender == 'all' && $category == 'all'){
            $products = Product::where('sport', 'LIKE', '%'.$sport.'%')
                               ->where('active', 1)
                               ->orderBy('product_name')
                               ->get();

        } else if($sport == 'all' && $gender != 'all' && $category != 'all'){
            $products = Product::where('gender', 'LIKE', '%'.$gender.'%')
                               ->where('product_category_id', 'LIKE', '%'.$category.'%')
                               ->where('active', 1)
                               ->orderBy('product_name')
                               ->get();

        } else if($sport == 'all' && $gender != 'all' && $category == 'all'){
            $products = Product::where('gender', 'LIKE', '%'.$gender.'%')
                               ->where('active', 1)
                               ->orderBy('product_name')
                               ->get();

        } else if($sport == 'all' && $gender == 'all' && $category != 'all'){
            $products = Product::where('product_category_id', 'LIKE', '%'.$category.'%')
                               ->where('active', 1)
                               ->orderBy('product_name')
                               ->get();

        } else {
            $products = Product::orderBy('product_name')->get();

        }

        echo json_encode($products);
    }

    public function customers($organizationId){
        $customers = Organization::with('contactOrganizations.contacts')->with('contactOrganizations.organizations')->where('id', $organizationId)->first();
        return json_encode($customers);
    }

    public function exFactoryDate(Request $request){
        if($request->typeID == 1){
            $exFactoryDate = Carbon::parse($request->due_date)->subDays(7)->format('m/d/Y');
            return json_encode($exFactoryDate);
        }else if($request->typeID == 2){
            $exFactoryDate = Carbon::parse($request->due_date)->subDays(14)->format('m/d/Y');
            $encoreDate = Carbon::parse($request->due_date)->subDays(7)->format('m/d/Y');
            return json_encode([$exFactoryDate,$encoreDate]);
        }
    }

    public function encorePackingDate(Request $request){
        $exFactoryDate = Carbon::parse($request->encore_packing_date)->subDays(7)->format('m/d/Y');
        $dueDate = Carbon::parse($request->encore_packing_date)->addDays(7)->format('m/d/Y');
        return json_encode([$exFactoryDate,$dueDate]);
    }

    public function dueDate(Request $request){
        if($request->typeID == 1){
            $dueDate = Carbon::parse($request->ex_factory_date)->addDays(7)->format('m/d/Y');
            return json_encode($dueDate);
        }else if($request->typeID == 2){
            $encoreDate = Carbon::parse($request->ex_factory_date)->addDays(7)->format('m/d/Y');
            $dueDate = Carbon::parse($request->ex_factory_date)->addDays(14)->format('m/d/Y');
            return json_encode([$encoreDate,$dueDate]);
        }
    }

    // public function getProductStyleDetails(Request $request){
    //     $product = Product::find($request->item_style_id);
    //     return json_encode($product);
    // }

    public function getProductStyleDetails(Request $request){
        $sub_product = SubProduct::where('sub_product_no' , $request->item_style_id)->first();
        if($sub_product->parent_product_id == 228){
            $is_hat = true;
        }else{
            $is_hat = false;
        }
        return response()->json(['data' => $sub_product , 'is_hat'=>$is_hat ]);
    }


    private function sendReOrderNotification(Order $newOrder, Order $exsOrder, Organization $orgnization, $orderDescription)
    {
        $orderItems = OrderItem::where('order_id', $newOrder->id)->get();

        $itemsListHtml = '';
        foreach ($orderItems as $orderItem) {
            $itemsListHtml .= '<div style="display:grid;grid-template-columns:1fr 70px 110px;gap:8px;align-items:center;padding:10px 14px;font-size:12px;color:#1f2937;border-bottom:1px solid #f3f4f6;width:max-content;min-width:100%;box-sizing:border-box">
                <div style="color:#374151">' . e($orderItem->display_name) . '</div>
                <div style="color:#374151">' . e($orderItem->qty ?? 0) . '</div>
                <div style="color:#374151">' . ($orderItem->ex_factory_date ? e($orderItem->ex_factory_date) : '-') . '</div>
            </div>';
        }

        $orderLink = url("order_details/edit/{$newOrder->id}/order") . '?active_tab=order';

        $builder = new NotificationBuilderService();

        $builder->sendNotification(
            'key_create_new_reorder',
            [
                '{order_no}'           => $newOrder->order_no,
                '{original_order_no}'  => $exsOrder->order_no,
                '{order_link}'         => $orderLink,
                '{organization_name}'  => $orgnization->organization_name ?? '',
                '{order_description}'  => $orderDescription ?? '',
                '{order_items_list}'   => $itemsListHtml,
            ],
            [
                'order_id'                   => $newOrder->id,
                'target_notification_field'  => 'key_create_new_reorder',
                'new_notification'           => 1,
            ]
        );
    }

    private function sendNewOrderNotification(Order $newOrder, Order $exsOrder, Organization $orgnization, $orderDescription)
    {
        $orderItems = OrderItem::where('order_id', $newOrder->id)->get();

        $itemsListHtml = '';
        foreach ($orderItems as $orderItem) {
            $itemsListHtml .= '<div style="display:grid;grid-template-columns:1fr 70px 110px;gap:8px;align-items:center;padding:10px 14px;font-size:12px;color:#1f2937;border-bottom:1px solid #f3f4f6;width:max-content;min-width:100%;box-sizing:border-box">
                <div style="color:#374151">' . e($orderItem->display_name) . '</div>
                <div style="color:#374151">' . e($orderItem->qty ?? 0) . '</div>
                <div style="color:#374151">' . ($orderItem->ex_factory_date ? e($orderItem->ex_factory_date) : '-') . '</div>
            </div>';
        }

        $orderLink = url("order_details/edit/{$newOrder->id}/order") . '?active_tab=order';

        $builder = new NotificationBuilderService();

        $builder->sendNotification(
            'key_create_new_order',
            [
                '{order_no}'           => $newOrder->order_no,
                '{original_order_no}'  => $exsOrder->order_no,
                '{order_link}'         => $orderLink,
                '{organization_name}'  => $orgnization->organization_name ?? '',
                '{order_description}'  => $orderDescription ?? '',
                '{order_items_list}'   => $itemsListHtml,
            ],
            [
                'order_id'                   => $newOrder->id,
                'target_notification_field'  => 'key_create_new_order',
                'new_notification'           => 1,
            ]
        );
    }
}
