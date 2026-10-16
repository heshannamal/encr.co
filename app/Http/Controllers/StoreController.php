<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Sport;
use App\Models\User;
use App\Models\Contact;
use App\Models\Product;
use App\Models\SubProduct;
use App\Models\ProductCategory;
use App\Models\Store;
use App\Models\StoreType;
use App\Models\StoreTax;
use App\Models\StoreCustomInformation;
use App\Models\StoreAddedCoupon;
use App\Models\StoreAddedCustomInformation;
use App\Models\StoreCoupon;
use App\Models\StoreTemplate;
use App\Models\StoreProduct;
use App\Models\StoreProductImage;
use App\Models\StoreProductSize;
use App\Models\StoreProductCategory;
use App\Models\StoreProductVariant;
use App\Models\StoreProductAddedVariant;
use App\Models\StoreProductDefaultCategory;
use App\Models\StoreProductCategoryList;
use App\Models\ProductCategoryList;
use App\Models\StoreProductEditedCategory;
use App\Models\StoreTheme;
use App\Models\Size;
use App\Models\StoreIndividualName;
use App\Models\StoreIndividualNumber;
use App\Models\StoreFlyer;
use App\Models\StoreOrderPlayerDetail;
use App\Models\StoreOrder;
use App\Models\StoreOrderItem;
use App\Models\StoreGroupAccess;
use App\Models\StoreShipment;
use App\Models\StoreOrderStatus;
use App\Models\StoreCategoryOrder;
use App\Models\StoreProductBundle;
use App\Models\StoreCustomer;
use App\Models\StoreProductPriceAddition;
use App\Models\Notification;
use App\Models\Attribute;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemsDetail;
use App\Models\OrderItemsDetailPlayerName;
use App\Models\OrderItemAttribute;
use App\Models\StoreOrderReceipt;
use App\Models\StoreShippingMethod;
use App\Models\StoreAddedShippingMethod;
use App\Models\StoreCardPayment;
use App\Models\StoreEmailTemplate;
use App\Models\StoreCustomInformationTemplate;
use App\Models\StoreTaxCategory;
use App\Models\StoreAddedTaxCategory;
use App\Models\StoreProductExtraSize;
use App\Models\StorePaymentLog;
use App\Models\PaymentLog;
use App\Services\EmailNotificationBuilderService;
use App\Services\NotificationBuilderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;
use Dompdf\Options;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    private $smptEncryption = 'SSL';
    private $smptPort = '465';
    private $smptHost = 'mail.encr.co';
    private $mailUsername = 'info@encr.co';
    private $mailPassword = 'Encr.co@ec123';

    // private $mailUsername = 'teamstore@encr.co';
    // private $mailPassword = 'Umudh@@13134';

    // private $timezone = 'America/Los_Angeles';
    private $timezone = 'PST';

    public function index(Request $request)
    {
        $query = Store::with(['organizationDetails', 'StoreOrders', 'userDetails'])
            ->where('active', 1);

        // Filter by user
        if ($request->filled('user_filter') && $request->user_filter !== 'all') {
            $query->where('salese_person', $request->user_filter);
        }

        // Filter by store status
        if ($request->filled('store_status_filter') && $request->store_status_filter !== 'all') {
            $status = (int) $request->store_status_filter;
            $query->whereIn('store_status', [$status, 3]); // 3 included as special case
        }

        // Sort: open_date null/empty last, new open_date first, then created_at
        $query->orderByRaw("
            CASE
                WHEN open_date IS NULL OR open_date = '' THEN 1
                ELSE 0
            END ASC
        ")
        ->orderByRaw("
            CASE
                WHEN open_date IS NOT NULL AND open_date != ''
                THEN STR_TO_DATE(open_date, '%Y-%m-%d %H:%i')
            END DESC
        ")
        ->orderBy('created_at', 'desc');

        $stores = $query->get();

        foreach ($stores as $store) {
            $this->updateStoreStatus($store->id);
        }

        $stores = $query->get();

        $users = User::where('active', 1)->get();

        return view('pages.stores.index', [
            'stores' => $stores,
            'users' => $users,
        ]);
    }

    public function get_all_stores(Request $request){
        if($request->text){

        }
        $stores = Store::with('organizationDetails')->with('userDetails')->where('active', 1)->orderBy('created_at', 'desc')->get();
        return response()->json($stores);
    }
    public function get_all_urls(Request $request){
        $stores = Store::pluck('direct_access_url')->toArray();
        return response()->json($stores);
    }
    public function messaging() {

        $store = Store::with('StoreAddedCoupons')->with('StoreAddedCustomInformations')->first();
        return view('pages.stores.store_master.messaging');

    }
    public function taxes_and_fees() {

        $store = Store::with('StoreAddedCoupons')->with('StoreAddedCustomInformations')->first();
        return view('pages.stores.store_master.taxes_and_fees', ['store'=>$store]);

    }
    public function create_store(Request $request)
    {
        $storeNew = new Store();
        $storeNew->store_name = '';
        $storeNew->active = 0;
        $storeNew->save();

        $store_tax = new StoreAddedTaxCategory();
        $store_tax->store_id = $storeNew->id;
        $store_tax->tax_category_id = 1;
        $store_tax->save();

        $store = Store::with('StoreAddedCoupons')->with('StoreAddedCustomInformations')->where('id' , $storeNew->id)->first();
        $organizations = Organization::with('contactOrganizations')->where('active' , 1)->get();
        $sports = Sport::where('active' , 1)->get();
        $users = User::where('active' , 1)->get();
        $store_types = StoreType::where('active' , 1)->get();
        $store_shipping_methods = StoreShippingMethod::where('active', 1)->get();
        $contacts = Contact::where('active' , 1)->get();
        $store_custom_information_templates = StoreCustomInformationTemplate::where('active', 1)->get();
        $store_tax_categories = StoreTaxCategory::where('active', 1)->get();

        return view('pages.stores.edit_store', [ 'organizations'=>$organizations , 'sports'=>$sports , 'users'=>$users , 'store_types'=>$store_types , 'store'=>$store , 'contacts'=>$contacts, 'is_new' => 1, 'store_shipping_methods'=>$store_shipping_methods, 'store_custom_information_templates'=>$store_custom_information_templates, 'store_tax_categories'=>$store_tax_categories]);
    }


    public function create(Request $request){
        if(Store::where('id', $request->store_id)->exists()){
            $store = Store::where('id' , $request->store_id)->first();
        }else{
            $store = new Store();
        }

        $store->organization_id = $request->organization_id;
        $store->sport_id = $request->sport_id;
        $store->store_name = $request->store_name;
        $store->salese_person = $request->sales_person;
        $store->direct_access_url = $request->url;
        $store->product_prefix = $request->store_prefix_for_products;
        $store->set_store_deadline = $request->has('set_store_deadline') ? 1 : 0;
        $store->open_date = $request->open_date;
        $store->close_date = $request->has('set_store_deadline') ? $request->close_date : null;
        $store->contact_coach_id = $request->contact_coach_id;
        $store->coach_name = $request->coach_name;
        $store->store_status = 1;
        $store->coach_email = $request->coach_email;
        $store->sales_assistant = $request->sales_assistant;
        $store->service_phone = $request->service_phone;

        $store->service_website = $request->service_website ?? 'www.encorecustom.com';
        $store->service_email = $request->service_email ?? 'info@encr.co';

        // $store->shipping_method = $request->shipping_method;
        $store->active = 1;

        $taxCategories = $request->tax_category ?? [];

        $store->sales_tax = in_array('1', $taxCategories) ? ($request->sales_tax ?? 0) : 0;
        $store->handling_fee = in_array('2', $taxCategories) ? ($request->handling_fee ?? 0) : 0;
        $store->service_charge = in_array('3', $taxCategories) ? ($request->service_charge ?? 0) : 0;
        $store->other = in_array('4', $taxCategories) ? ($request->other ?? 0) : 0;

        $store->save();

        $store_shipping = StoreAddedShippingMethod::where('store_id', $store->id)->delete();

        if($request->has('shipping_method') && !empty($request->shipping_method)){

            foreach ($request->shipping_method as $shipping) {
                $store_shipping = new StoreAddedShippingMethod();
                $store_shipping->store_id = $store->id;
                $store_shipping->shipping_method = $shipping;
                $store_shipping->save();
            }
        }

        if($request->has('tax_category') && !empty($request->tax_category)){
            $store_tax = StoreAddedTaxCategory::where('store_id', $store->id)->delete();

            foreach ($taxCategories as $tax) {
                $store_tax = new StoreAddedTaxCategory();
                $store_tax->store_id = $store->id;
                $store_tax->tax_category_id = $tax;
                $store_tax->save();
            }
        }

        $store_theme = StoreTheme::where('store_id', $store->id)->first();

        if (!$store_theme) {
            $store_theme = new StoreTheme();
            $store_theme->store_id = $store->id;
            $store_theme->event_name = 'Event Name';
            $store_theme->theme = 0;
            $store_theme->save();
        }
        $flyer = StoreFlyer::where('store_id', $store->id)->first();
        if(!$flyer){
            $flyer = new StoreFlyer();
            $flyer->store_id = $store->id;
            $flyer->flyer_name = ($store->store_name ?? 'Store Name').' - Flyer';
            $flyer->email = $store->service_email ?? 'info@encr.co';
            $flyer->phone_number = $store->service_phone ?? '+1 888-501-4999';
            $flyer->website = $store->service_website ?? 'www.encorecustom.com';
            $flyer->flyer_url = '';
            $flyer->layout_type = 1;
            $flyer->logo_size = 1;
            $flyer->flyer_message = '';
            $flyer->show_instructions = 1;
            $flyer->show_prices = 0;
            $flyer->show_description = 0;
            $flyer->include_ship_date = 1;
            $flyer->include_store_deadline = 1;
            $flyer->include_qr_code = 1;
            $flyer->save();
        }

        $this->updateStoreStatus($store->id);

        return redirect()->route('store.edit', ['id' => $store->id]);

    }

    public function delete(Request $request){
        $store = Store::where('id', $request->store_id)->first();
        if($store){
            $store->active = 0;
            $store->save();
            return response()->json(['status' => 'success', 'message' => 'Store deleted successfully']);
        }else{
            return response()->json(['status' => 'error', 'message' => 'Store not found'], 404);
        }
    }

    public function edit($id){

        $this->updateStoreStatus($id);

        $store = Store::with('StoreAddedCoupons', 'StoreAddedShippingMethods', 'StoreAddedCustomInformations', 'StoreAddedTaxCategories')->where('id' , $id)->first();
        $organizations = Organization::with('contactOrganizations')->where('active' , 1)->get();
        $sports = Sport::where('active' , 1)->get();
        $users = User::where('active' , 1)->get();
        $store_types = StoreType::where('active' , 1)->get();
        $contacts = Contact::where('active' , 1)->get();
        $store_shipping_methods = StoreShippingMethod::where('active', 1)->get();
        $store_custom_information_templates = StoreCustomInformationTemplate::where('active', 1)->get();
        $store_tax_categories = StoreTaxCategory::where('active', 1)->get();

        return view('pages.stores.edit_store', [ 'organizations'=>$organizations , 'sports'=>$sports , 'users'=>$users , 'store_types'=>$store_types , 'store'=>$store , 'contacts'=>$contacts, 'store_shipping_methods'=>$store_shipping_methods, 'is_new' => 0, 'store_custom_information_templates'=>$store_custom_information_templates, 'store_tax_categories'=>$store_tax_categories]);
    }
    public function copy($id)
    {
        $originalStore = Store::with([
            'StoreAddedCoupons',
            'StoreCustomInformations',
            'StoreAddedCustomInformations',
            'StoreAddedProducts',
            'StoreAddedShippingMethods',
            'flyerDetails',
            'themeDetails',
            'groupAccessDetails',
            'StoreEditedCategory',
            'categoryOrder',
            'StoreAddedTaxCategories'
        ])->find($id);

        if (!$originalStore) {
            return redirect()->back()->with('error', 'Store not found');
        }

        $clonedStore = $originalStore->replicate();
        $clonedStore->store_name = $originalStore->store_name . ' - Copy';
        $clonedStore->direct_access_url = $originalStore->direct_access_url . 'Copy';
        $clonedStore->save();

        $this->cloneStoreRelations($originalStore, $clonedStore);

        return redirect()->route('store.edit', ['id' => $clonedStore->id])->with('success', 'Store copied successfully!');
    }
    private function cloneStoreRelations($originalStore, $clonedStore)
    {
        $categoryMap = [];
        $productMap  = [];

        $storeProductCategory = StoreProductCategory::where('store_id', $originalStore->id)->get();
        foreach ($storeProductCategory as $category) {
            $clonedCategory = $category->replicate();
            $clonedCategory->store_id = $clonedStore->id;
            $clonedCategory->save();

            $categoryMap[$category->id] = $clonedCategory->id;

            // $storeProducts = StoreProduct::where('store_id', $originalStore->id)->where('category_id', $category->id)->get();
            // foreach ($storeProducts as $product) {
            //     $product->category_id = $clonedCategory->id;
            //     $product->save();
            // }
        }

        foreach ($originalStore->StoreAddedProducts ?? [] as $product) {
            $this->cloneStoreProduct($product, $clonedStore->id, $categoryMap, $productMap);
        }

        foreach ($originalStore->StoreAddedCoupons ?? [] as $coupon) {

            $relatedCoupon = StoreCoupon::where('id', $coupon->coupon_id)->first();

            $newCoupon = $relatedCoupon->replicate();
            $newCoupon->store_id = $clonedStore->id;
            $newCoupon->save();

            $clonedCoupon = $coupon->replicate();
            $clonedCoupon->coupon_id = $newCoupon->id;
            $clonedCoupon->store_id = $clonedStore->id;
            $clonedCoupon->save();
        }

        foreach ($originalStore->StoreAddedShippingMethods ?? [] as $shippingMethod) {
            $clonedShippingMethod = $shippingMethod->replicate();
            $clonedShippingMethod->store_id = $clonedStore->id;
            $clonedShippingMethod->save();
        }

        foreach ($originalStore->StoreCustomInformations ?? [] as $customInfo) {
            $clonedCustomInfo = $customInfo->replicate();
            $clonedCustomInfo->store_id = $clonedStore->id;
            $clonedCustomInfo->save();
        }

        foreach ($originalStore->StoreAddedTaxCategories ?? [] as $TaxCategory) {
            $clonedTaxCategory = $TaxCategory->replicate();
            $clonedTaxCategory->store_id = $clonedStore->id;
            $clonedTaxCategory->save();
        }

        foreach ($originalStore->StoreAddedCustomInformations ?? [] as $AddedcustomInfo) {
            $clonedAddedcustomInfo = $AddedcustomInfo->replicate();
            $clonedAddedcustomInfo->store_id = $clonedStore->id;
            $clonedAddedcustomInfo->save();
        }

        foreach ($originalStore->StoreEditedCategory ?? [] as $editedCategory) {
            $clonedCategory = $editedCategory->replicate();
            $clonedCategory->store_id = $clonedStore->id;
            $clonedCategory->save();
        }

        if ($originalStore->flyerDetails) {
            StoreFlyer::where('store_id', $clonedStore->id)->delete();
            $clonedFlyer = $originalStore->flyerDetails->replicate();
            $clonedFlyer->store_id = $clonedStore->id;
            $clonedFlyer->save();
        }

        if ($originalStore->themeDetails) {
            StoreTheme::where('store_id', $clonedStore->id)->delete();
            $clonedTheme = $originalStore->themeDetails->replicate();
            $clonedTheme->store_id = $clonedStore->id;
            $clonedTheme->save();
        }

        foreach ($originalStore->groupAccessDetails ?? [] as $groupAccess) {
            $clonedGroupAccess = $groupAccess->replicate();
            $clonedGroupAccess->store_id = $clonedStore->id;
            $clonedGroupAccess->save();
        }

        $storeProductBundles = StoreProductBundle::where('store_id', $originalStore->id)->get();
        foreach ($storeProductBundles as $bundle) {
            $clonedBundle = $bundle->replicate();
            $clonedBundle->store_id = $clonedStore->id;
            $clonedBundle->save();
        }

        $storeProductEditedCategories = StoreProductEditedCategory::where('store_id', $originalStore->id)->get();
        foreach ($storeProductEditedCategories as $editedCategory) {
            $clonedEditedCategory = $editedCategory->replicate();
            $clonedEditedCategory->store_id = $clonedStore->id;
            $clonedEditedCategory->save();
        }

        if ($originalStore->categoryOrder) {
            $originalOrder = $originalStore->categoryOrder;
            $clonedCategoryOrder = $originalOrder->replicate();
            $clonedCategoryOrder->store_id = $clonedStore->id;

            $orderArray = is_string($originalOrder->order_array)
                ? json_decode($originalOrder->order_array, true)
                : $originalOrder->order_array;

            $allCatProd = is_string($originalOrder->all_category_product_order)
                ? json_decode($originalOrder->all_category_product_order, true)
                : $originalOrder->all_category_product_order;

            // Remap and re-encode
            $newOrderArray = [];
            foreach ($orderArray ?? [] as $oldCategoryId) {
                if (isset($categoryMap[$oldCategoryId])) {
                    $newOrderArray[] = $categoryMap[$oldCategoryId];
                }
            }
            $clonedCategoryOrder->order_array = json_encode($newOrderArray);

            $newAllCatProd = [];
            foreach ($allCatProd ?? [] as $categoryBlock) {
                $oldCatId = $categoryBlock['category_id'] ?? null;
                if (!$oldCatId || !isset($categoryMap[$oldCatId])) continue;

                $newCatBlock = [
                    'category_id' => (string)$categoryMap[$oldCatId],
                    'products' => [],
                ];

                foreach ($categoryBlock['products'] ?? [] as $productEntry) {
                    $oldProductId = $productEntry['product_id'] ?? null;
                    if ($oldProductId && isset($productMap[$oldProductId])) {
                        $productEntry['product_id'] = (string)$productMap[$oldProductId];
                        $newCatBlock['products'][] = $productEntry;
                    }
                }

                $newAllCatProd[] = $newCatBlock;
            }
            $clonedCategoryOrder->all_category_product_order = json_encode($newAllCatProd);

            $clonedCategoryOrder->save();
        }
    }
    private function cloneStoreProduct($product, $newStoreId, $categoryMap, $productMap)
    {
        $originalProduct = StoreProduct::with([
            'images',
            'sizes',
            'StoreProductAddedVariant',
            'storeProductCategoryList',
            'priceAdditions',
            'IndividualNameDetails',
            'IndividualNumberDetails'
        ])->find($product->id);

        if (!$originalProduct) {
            return;
        }

        $clonedProduct = $originalProduct->replicate();
        if (isset($categoryMap[$originalProduct->category_id])) {
            $clonedProduct->category_id = $categoryMap[$originalProduct->category_id];
            $productMap[$originalProduct->id] = $clonedProduct->id;
        }
        $clonedProduct->store_id = $newStoreId;
        $clonedProduct->product_name = $originalProduct->product_name;
        $clonedProduct->save();

        // Clone related individual name details
        if ($originalProduct->IndividualNameDetails) {
            StoreIndividualName::where('store_product_id', $clonedProduct->id)->delete();
            $clonedNameDetails = $originalProduct->IndividualNameDetails->replicate();
            $clonedNameDetails->store_id = $newStoreId;
            $clonedNameDetails->store_product_id = $clonedProduct->id;
            $clonedNameDetails->save();
        }
        // Clone related individual number details
        if ($originalProduct->IndividualNumberDetails) {
            StoreIndividualNumber::where('store_product_id', $clonedProduct->id)->delete();
            $clonedNumberDetails = $originalProduct->IndividualNumberDetails->replicate();
            $clonedNumberDetails->store_id = $newStoreId;
            $clonedNumberDetails->store_product_id = $clonedProduct->id;
            $clonedNumberDetails->save();
        }

        // Clone related images
        foreach ($originalProduct->images ?? [] as $image) {
            $clonedImage = $image->replicate();
            $clonedImage->store_id = $newStoreId;
            $clonedImage->store_product_id = $clonedProduct->id;
            $clonedImage->save();
        }

        // Clone related sizes
        foreach ($originalProduct->sizes ?? [] as $size) {
            $clonedSize = $size->replicate();
            $clonedSize->store_product_id = $clonedProduct->id;
            $clonedSize->save();
        }

        // Clone related variants
        foreach ($originalProduct->StoreProductAddedVariant ?? [] as $variant) {
            $clonedVariant = $variant->replicate();
            $clonedVariant->store_product_id = $clonedProduct->id;
            $clonedVariant->save();
        }

        // Clone related price additions
        foreach ($originalProduct->priceAdditions ?? [] as $addition) {
            $clonedAddition = $addition->replicate();
            $clonedAddition->store_product_id = $clonedProduct->id;
            $clonedAddition->save();
        }

        // Clone related category list
        foreach ($originalProduct->storeProductCategoryList ?? [] as $category) {
            $clonedCategory = $category->replicate();
            $clonedCategory->product_id = $clonedProduct->id;
            $clonedCategory->store_id = $newStoreId;
            $clonedCategory->save();
        }

        $storeProductExtraSizes = StoreProductExtraSize::where('store_product_id', $originalProduct->id)->get();
        foreach ($storeProductExtraSizes as $extraSize) {
            $clonedExtraSize = $extraSize->replicate();
            $clonedExtraSize->store_product_id = $clonedProduct->id;
            $clonedExtraSize->save();
        }
    }
    public function get_store_product_by_id(Request $request){
        $store_product = StoreProduct::where('id', $request->id)->with('IndividualNameDetails', 'IndividualNumberDetails', 'priceAdditions', 'products')->first();
        return response()->json($store_product);
    }
    public function get_products_with_category($store_id)
    {
        $products = Product::where('active', 1)->get();

        foreach ($products as $product) {
            $edited_category = StoreProductCategoryList::where('product_id',$product->id)->where('store_id',$store_id)->first();
            $sub_product = SubProduct::where('parent_product_id', $product->id)->first();
            if($sub_product){
                $product->product_name = $sub_product->product_name;
                $product->product_no = $sub_product->sub_product_no;
            }
            if($edited_category){
                $product->store_product_category = $edited_category->category_id;
            }else{
                $category = StoreProductDefaultCategory::where('product_id', $product->id)->first();

                $product->store_product_category = $category ? $category->category_id : 1;
            }
        }

        return $products;
    }
    public function get_store_edited_category($store_id){
        $categories = StoreProductCategory::where('active', 1)
            ->where(function ($query) use ($store_id) {
                $query->where('is_default', 1)
                    ->orWhere('store_id', $store_id);
            })
            ->orderBy('updated_at', 'desc')
            ->get();


        foreach ($categories as $category) {
            $edited_category = StoreProductEditedCategory::where('category_id', $category->id)->where('store_id',$store_id)->first();
            if($edited_category){
                $category->category_name = $edited_category->edited_name;
            }
        }

        return $categories;
    }
    public function get_store_product_images(Request $request){
        $store_product_images = StoreProductImage::where('store_product_id', $request->id)->orderByRaw("CASE WHEN order_index IS NULL THEN 1 ELSE 0 END, order_index ASC")->where('active', 1)->get();
        return response()->json($store_product_images);
    }
    public function get_store_products(Request $request){
        $srore_products = StoreProduct::with('images', 'products', 'priceAdditions')->where('store_id', $request->store_id)->where('active', 1)->get();
        $product_bundles = StoreProductBundle::where('store_id', $request->store_id)->get();
        $all_category_product_order = StoreCategoryOrder::where('store_id', $request->store_id)->first();
        $response = [
            'srore_products' => $srore_products,
            'product_bundles' => $product_bundles,
            'all_category_product_order' => $all_category_product_order ? json_decode($all_category_product_order->all_category_product_order, true) : []
        ];

        return response()->json($response);
    }
    public function get_store_search_products(Request $request){
        $products = SubProduct::with('productDetails')->where('product_name', 'LIKE', '%'.$request->text.'%')->where('active', 1)->get();
        $response = [
            'products' => $products,
        ];

        return response()->json($response);
    }
    public function get_store_sub_products(Request $request){
        $products = SubProduct::with('productDetails')->where('active', 1)->get();
        $response = [
            'products' => $products,
        ];

        return response()->json($response);
    }
    public function get_store_coupons(Request $request){
        $store_coupons_all = StoreCoupon::where('store_id', $request->id)->where('active', 1)->get();
        $store_coupons = StoreAddedCoupon::where('store_id', $request->id)->pluck('coupon_id')->toArray();

        $response = [
            'store_coupons_all' => $store_coupons_all,
            'store_coupons' => $store_coupons
        ];

        return response()->json($response);
    }
    public function save_custom_information_template(Request $request){

        if(StoreCustomInformationTemplate::where('template_name', $request->template_name)->where('active', 1)->exists()){
            return response()->json(['status' => 'error', 'message' => 'Template name already exists'], 400);
        }

        $custom_information_ids = StoreAddedCustomInformation::where('store_id', $request->store_id)->pluck('custom_information_id')->toArray();

        $template = new StoreCustomInformationTemplate();
        $template->template_name = $request->template_name;
        $template->custom_information_ids = json_encode($custom_information_ids);
        $template->active = 1;
        $template->save();

        return response()->json(['status' => 'success', 'message' => 'Template saved successfully']);
    }
    public function load_custom_information_template(Request $request){

        $template = StoreCustomInformationTemplate::where('id', $request->template_id)->where('active', 1)->first();

        if(!$template){
            return response()->json(['status' => 'error', 'message' => 'Template not found'], 404);
        }

        $custom_information_ids = json_decode($template->custom_information_ids, true);

        StoreAddedCustomInformation::where('store_id', $request->store_id)->delete();

        $store_custom_informations = StoreCustomInformation::whereIn('id', $custom_information_ids)->get();

        foreach ($store_custom_informations as $info) {
            $newCustomInfo = $info->replicate();
            $newCustomInfo->store_id = $request->store_id;
            $newCustomInfo->save();
        }

        foreach ($custom_information_ids as $id) {
            $store_custom_info = new StoreAddedCustomInformation();
            $store_custom_info->store_id = $request->store_id;
            $store_custom_info->custom_information_id = $id;
            $store_custom_info->save();
        }

        return response()->json(['status' => 'success', 'message' => 'Template loaded successfully']);
    }
    public function get_store_custom_informations(Request $request){
        $store_custom_informations_all = StoreCustomInformation::where('store_id', $request->id)->where('active', 1)->get();
        $store_custom_informations = StoreAddedCustomInformation::where('store_id', $request->id)->pluck('custom_information_id')->toArray();

        $response = [
            'store_custom_informations_all' => $store_custom_informations_all,
            'store_custom_informations' => $store_custom_informations
        ];

        return response()->json($response);
    }
    public function get_sizes(Request $request){
        $store_sizes_all = Size::where('size_type', $request->size_type_id)->where('active', 1)->get();
        $store_sizes = StoreProductSize::where('store_product_id', $request->store_product_id)->pluck('size_id')->toArray();
        $extra_size_details = StoreProductExtraSize::where('store_product_id', $request->store_product_id)->get();

        $response = [
            'store_sizes_all' => $store_sizes_all,
            'store_sizes' => $store_sizes,
            'extra_size_details' => $extra_size_details
        ];

        return response()->json($response);
    }
    public function update_extra_size_name(Request $request){
        $size = Size::where('id', $request->size_id)->first();
        if($size){
            StoreProductExtraSize::where('store_product_id', $request->store_product_id)->where('size_id', $request->size_id)->delete();
            if($request->extra_size_name != ''){
                $store_extra_size = new StoreProductExtraSize();
                $store_extra_size->store_product_id = $request->store_product_id;
                $store_extra_size->size_id = $request->size_id;
                $store_extra_size->size_name = $request->extra_size_name;
                $store_extra_size->save();

                return response()->json(['status' => 'success', 'message' => 'Extra size name updated successfully']);
            }
        }
        return response()->json(['status' => 'error', 'message' => 'Size not found'], 404);
    }
    public function get_product_categories(Request $request)
    {
        // Get the store's edited categories
        $product_categories = $this->get_store_edited_category($request->store_id);

        // Get the category order for the store
        $categoryOrder = StoreCategoryOrder::where('store_id', $request->store_id)->first();

        // If no category order exists, return the categories as is
        if (!$categoryOrder || empty($categoryOrder->order_array)) {
            $response = [
                'product_categories' => $product_categories
            ];
            return response()->json($response);
        }

        // Decode the order (JSON string) to get an array of category IDs
        $orderedCategoryIds = json_decode($categoryOrder->order_array);

        // Reorder the categories based on the order string
        $orderedCategories = [];
        $remainingCategories = [];

        // Reorder categories based on the order in categoryOrder
        foreach ($orderedCategoryIds as $id) {
            $category = $product_categories->firstWhere('id', $id);
            if ($category) {
                $orderedCategories[] = $category;
            }
        }

        // Categories that are not in the order, append them at the end
        foreach ($product_categories as $category) {
            if (!in_array($category->id, $orderedCategoryIds)) {
                $remainingCategories[] = $category;
            }
        }

        // Merge the ordered categories with the remaining ones
        $product_categories = array_merge($orderedCategories, $remainingCategories);

        // Return the reordered categories
        $response = [
            'product_categories' => $product_categories
        ];

        return response()->json($response);
    }

    public function update_store_category_order(Request $request)
    {
        $orderedCategories = json_decode($request->order_text);

        $orderText = json_encode($orderedCategories);

        $categoryOrder = StoreCategoryOrder::where('store_id', $request->store_id)->first();

        if ($categoryOrder) {
            $categoryOrder->order_array = $orderText;
            $categoryOrder->save();
        } else {
            StoreCategoryOrder::create([
                'store_id' => $request->store_id,
                'order_array' => $orderText,
            ]);
        }

        return response()->json(['message' => 'Category order updated successfully','text' => $orderText]);
    }

    public function get_product_variants(Request $request){
        $product_variants = StoreProductVariant::get();
        $store_product_images = StoreProductImage::where('store_product_id', $request->store_product_id)->get();
        $store_added_variant = StoreProductAddedVariant::where('store_product_id', $request->store_product_id)->pluck('variant_id')->toArray();

        $response = [
            'product_variants' => $product_variants,
            'store_added_variant' => $store_added_variant,
            'store_product_images' => $store_product_images
        ];

        return response()->json($response);
    }
    public function get_product_embellishment_options(Request $request){

        if ($request->has('product_id')) {

            $sub_product = SubProduct::with('embellishmentTypes')->find($request->product_id);
            $embellishment_options = $sub_product->embellishmentTypes->map(function ($item) {return $item->EmbellishmentDetails;})->toArray();

            return response()->json($embellishment_options);
        }

    }
    public function get_store_product_price_additions(Request $request){

        $store_product_price_additions = StoreProductPriceAddition::where('store_product_id', $request->store_product_id)->get();

        return response()->json($store_product_price_additions);
    }
    public function product_price_addition(Request $request){

        $price_addition = StoreProductPriceAddition::find($request->addition_id);
        if (!$price_addition) {
            return response()->json(['status' => 'error', 'message' => 'Price addition not found'], 404);
        }

        return response()->json($price_addition);
    }
    public function save_price_addition(Request $request){

        $store_product = StoreProduct::find($request->store_product_id);
        if (!$store_product) {
            return response()->json(['status' => 'error', 'message' => 'Store product not found'], 404);
        }

        $price_addition = empty($request->price_addition_id)
            ? new StoreProductPriceAddition()
            : StoreProductPriceAddition::find($request->price_addition_id);

        if (!$price_addition) {
            return response()->json(['status' => 'error', 'message' => 'Price addition not found'], 404);
        }

        $price_addition->store_product_id = $request->store_product_id;
        $price_addition->price_addition_name = $request->price_addition_name;
        $price_addition->is_addition_value = $request->is_addition_value;
        $price_addition->addition_value = $request->addition_value;
        $price_addition->hide_from_customer = $request->hide_from_customer ?? 0;
        $price_addition->is_fundraising = $request->is_fundraising ?? 0;
        $price_addition->addition_description = $request->addition_description ?? '';

        $price_addition->addition_amount = ($request->is_addition_value == 1)
            ? $request->addition_value
            : ($request->addition_value * $store_product->default_price / 100);

        $price_addition->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Price addition saved successfully',
        ]);
    }
    public function save_bulk_price_addition(Request $request){

        if (!(count($request->store_product_id) > 0)) {
            return response()->json(['status' => 'error', 'message' => 'Store products not found'], 404);
        }

        foreach ($request->store_product_id as $product_id) {

            $store_product = StoreProduct::find($product_id);
            if (!$store_product) {
                continue;
            }

            $price_addition =  new StoreProductPriceAddition();
            $price_addition->store_product_id = $product_id;
            $price_addition->price_addition_name = $request->price_addition_name;
            $price_addition->is_addition_value = $request->is_addition_value;
            $price_addition->addition_value = $request->addition_value;
            $price_addition->hide_from_customer = $request->hide_from_customer ?? 0;
            $price_addition->addition_description = $request->addition_description ?? '';

            $price_addition->addition_amount = ($request->is_addition_value == 1)
                ? $request->addition_value
                : ($request->addition_value * $store_product->default_price / 100);

            $price_addition->save();

        }


        return response()->json([
            'status' => 'success',
            'message' => 'Price addition saved successfully',
        ]);
    }
    public function delete_price_addition(Request $request)
    {
        try {
            $addition = StoreProductPriceAddition::find($request->addition_id);

            if (!$addition) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Price addition not found.'
                ], 404);
            }

            $addition->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Price addition deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete price addition. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function add_new_product_category(Request $request){

        if($request->category_id){
            StoreProductEditedCategory::where('category_id', $request->category_id)->where('store_id', $request->store_id)->delete();

            $category_exist = StoreProductCategoryList::find($request->category_id);

            $category_edit = new StoreProductEditedCategory();
            $category_edit->category_id = $request->category_id;
            $category_edit->store_id = $request->store_id;
            $category_edit->edited_name = $request->category_name;
            $category_edit->save();

            return response()->json($category_exist);
        }else{
            $product_category = new StoreProductCategory();
            $product_category->category_name = $request->category_name;
            $product_category->store_id = $request->store_id;
            $product_category->save();

            return response()->json($product_category);
        }
    }
    public function delete_product_category(Request $request){

        if($request->has('category_id') && $request->has('store_id')){
            if(StoreProductCategory::where('category_id', $request->category_id)->where('store_id', $request->store_id)->where('is_default', 0)->exists()){
                StoreProductCategory::where('category_id', $request->category_id)->where('store_id', $request->store_id)->where('is_default', 0)->delete();
            }

            $categoryProducts = StoreProduct::where('category_id', $request->category_id)->where('store_id', $request->store_id)->update(['active' => 0]);

            StoreProductCategoryList::where('category_id', $request->category_id)->where('store_id', $request->store_id)->forceDelete();

            return response()->json($request->category_id);
        }
    }
    public function clone_store_product(Request $request)
    {
        if ($request->has('product_id')) {
            $originalProduct = StoreProduct::with([
                'images',
                'sizes',
                'StoreProductAddedVariant',
                'storeProductCategoryList',
                'priceAdditions'
            ])->find($request->product_id);

            if (!$originalProduct) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not found'
                ]);
            }

            // Clone the main product
            $clonedProduct = $originalProduct->replicate();
            $clonedProduct->product_name = $originalProduct->product_name . ' - Copy';
            $clonedProduct->save();

            // Clone related images (ensure iterable with ?? [])
            foreach ($originalProduct->images ?? [] as $image) {
                $clonedImage = $image->replicate();
                $clonedImage->store_product_id = $clonedProduct->id;
                $clonedImage->save();
            }

            // Clone related sizes
            foreach ($originalProduct->sizes ?? [] as $size) {
                $clonedSize = $size->replicate();
                $clonedSize->store_product_id = $clonedProduct->id;
                $clonedSize->save();
            }

            // Clone related variants
            foreach ($originalProduct->StoreProductAddedVariant ?? [] as $variant) {
                $clonedVariant = $variant->replicate();
                $clonedVariant->store_product_id = $clonedProduct->id;
                $clonedVariant->save();
            }

            // Clone related price additions
            foreach ($originalProduct->priceAdditions ?? [] as $addition) {
                $clonedAddition = $addition->replicate();
                $clonedAddition->store_product_id = $clonedProduct->id;
                $clonedAddition->save();
            }

            // Clone related category list
            foreach ($originalProduct->storeProductCategoryList ?? [] as $category) {
                $clonedCategory = $category->replicate();
                $clonedCategory->product_id = $clonedProduct->id;
                $clonedCategory->save();
            }

            $storeProductExtraSizes = StoreProductExtraSize::where('store_product_id', $originalProduct->id)->get();
            foreach ($storeProductExtraSizes as $extraSize) {
                $clonedExtraSize = $extraSize->replicate();
                $clonedExtraSize->store_product_id = $clonedProduct->id;
                $clonedExtraSize->save();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Product cloned successfully'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Product ID is missing'
        ]);
    }


    public function delete_store_product(Request $request)
    {
        if (!$request->has('product_id')) {
            return response()->json(['status' => 'error', 'message' => 'Product ID is required.']);
        }

        $product = StoreProduct::find($request->product_id);

        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Product not found.']);
        }

        $product->active = 0;
        $product->save();

        return response()->json(['status' => 'success', 'message' => 'Product deleted successfully.']);
    }

    public function bulk_clone_store_product(Request $request)
    {
        if ($request->has('product_ids') && is_array($request->product_ids)) {
            $clonedProducts = [];

            foreach ($request->product_ids as $product_id) {
                $originalProduct = StoreProduct::with([
                    'images',
                    'sizes',
                    'StoreProductAddedVariant',
                    'storeProductCategoryList',
                    'priceAdditions'
                ])->find($product_id);

                if (!$originalProduct) {
                    continue; // Skip if product not found
                }

                // Clone the main product
                $clonedProduct = $originalProduct->replicate();
                $clonedProduct->product_name = $originalProduct->product_name . ' - Copy';
                if($request->has('selected_category_id')){
                    $clonedProduct->category_id = $request->selected_category_id;
                }
                $clonedProduct->save();

                // Clone related images
                foreach ($originalProduct->images ?? [] as $image) {
                    $clonedImage = $image->replicate();
                    $clonedImage->store_product_id = $clonedProduct->id;
                    $clonedImage->save();
                }

                // Clone related sizes
                foreach ($originalProduct->sizes ?? [] as $size) {
                    $clonedSize = $size->replicate();
                    $clonedSize->store_product_id = $clonedProduct->id;
                    $clonedSize->save();
                }

                // Clone related variants
                foreach ($originalProduct->StoreProductAddedVariant ?? [] as $variant) {
                    $clonedVariant = $variant->replicate();
                    $clonedVariant->store_product_id = $clonedProduct->id;
                    $clonedVariant->save();
                }

                // Clone related price additions
                foreach ($originalProduct->priceAdditions ?? [] as $addition) {
                    $clonedAddition = $addition->replicate();
                    $clonedAddition->store_product_id = $clonedProduct->id;
                    $clonedAddition->save();
                }

                // Clone related category list
                foreach ($originalProduct->storeProductCategoryList ?? [] as $category) {
                    $clonedCategory = $category->replicate();
                    $clonedCategory->product_id = $clonedProduct->id;
                    $clonedCategory->save();
                }

                $storeProductExtraSizes = StoreProductExtraSize::where('store_product_id', $originalProduct->id)->get();
                foreach ($storeProductExtraSizes as $extraSize) {
                    $clonedExtraSize = $extraSize->replicate();
                    $clonedExtraSize->store_product_id = $clonedProduct->id;
                    $clonedExtraSize->save();
                }

                $clonedProducts[] = $clonedProduct->id;
            }

            if (count($clonedProducts) > 0) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Products cloned successfully',
                    'cloned_product_ids' => $clonedProducts
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No products cloned. Some or all products were not found.'
                ]);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Product IDs are missing or invalid'
        ]);
    }

    public function bulk_delete_store_product(Request $request)
    {
        if ($request->has('product_ids') && is_array($request->product_ids)) {
            $deletedProducts = StoreProduct::whereIn('id', $request->product_ids)->get();

            foreach ($deletedProducts as $deletedProduct) {
                $deletedProduct->active = 0;
                $deletedProduct->save();
            }

            if ($deletedProducts->count() > 0) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Products deleted successfully'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No matching products found'
                ]);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Product IDs are missing or invalid'
        ]);
    }

    public function bulk_change_category_action(Request $request)
    {
        if ($request->has('product_ids') && $request->has('category_id') && is_array($request->product_ids)) {

            $updatedCount = StoreProduct::whereIn('id', $request->product_ids)
                ->update(['category_id' => $request->category_id]);

            if ($updatedCount > 0) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'The selected products have been successfully moved to the new category.'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No products were found matching the provided IDs or already in the selected category.'
                ]);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Please provide valid product IDs and category ID.'
        ]);
    }
    public function bulk_active_product(Request $request)
    {
        if ($request->has('product_ids') && is_array($request->product_ids)) {

            $updatedCount = StoreProduct::whereIn('id', $request->product_ids)
                ->update(['product_availability' => $request->active ?? 1]);

            if ($updatedCount > 0) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'The selected products have been successfully moved to the new category.'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No products were found matching the provided IDs or already in the selected category.'
                ]);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Please provide valid product IDs and category ID.'
        ]);
    }
    public function update_product_order(Request $request)
    {
        if ($request->has('sorted_products') && is_array($request->sorted_products)) {
            foreach ($request->sorted_products as $product) {
                if (isset($product['product_id']) && isset($product['index'])) {
                    $storeProductImage = StoreProductImage::find($product['product_id']);

                    if ($storeProductImage) {
                        $storeProductImage->order_index = $product['index'];
                        $storeProductImage->save();
                    }
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Product order updated successfully'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Product IDs are missing or invalid'
        ]);
    }

    public function make_bundle(Request $request){

        if($request->has('category_id') && $request->has('category_id')) {

            StoreProductBundle::where('store_id', $request->store_id)->where('category_id', $request->category_id)->delete();

            $bundle = new StoreProductBundle();
            $bundle->store_id = $request->store_id;
            $bundle->category_id = $request->category_id;
            $bundle->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Bundle created successfully'
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong'
        ]);

    }

    public function remove_bundle(Request $request){

        if($request->has('category_id') && $request->has('category_id')) {

            StoreProductBundle::where('store_id', $request->store_id)->where('category_id', $request->category_id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Bundle removed successfully'
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong'
        ]);

    }
    public function required_bundle(Request $request){

        if($request->has('category_id') && $request->has('category_id')) {

            StoreProductBundle::where('store_id', $request->store_id)->where('category_id', $request->category_id)->update(['is_required' => 1]);

            return response()->json([
                'status' => 'success',
                'message' => 'Bundle make required successfully'
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong'
        ]);

    }
    public function not_required_bundle(Request $request){

        if($request->has('category_id') && $request->has('category_id')) {

            StoreProductBundle::where('store_id', $request->store_id)->where('category_id', $request->category_id)->update(['is_required' => 0]);

            return response()->json([
                'status' => 'success',
                'message' => 'Bundle removed required successfully'
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong'
        ]);

    }

    public function dragging_product(Request $request){

        if ($request->category_id == "delete" && $request->is_save == 1) {
            StoreProduct::find($request->product_id)->forceDelete();

            return response()->json(['status' => 'success', 'message' => 'product deleted successfully']);
        }

        if ($request->is_save == 1) {
            $store_product = StoreProduct::find($request->product_id);
            $store_product->category_id = $request->category_id;
            $store_product->save();
        }
        if ($request->is_save == 0) {
            $sub_product = SubProduct::find($request->product_id);

            $main_product = Product::find($sub_product->parent_product_id);

            $store = Store::find($request->store_id);

            $store_product = new StoreProduct();
            $store_product->store_id = $request->store_id;
            $store_product->product_default_name = $sub_product->product_name;
            $store_product->product_name = $store->product_prefix.' - '.($sub_product->show_in_catalog_name ?? $sub_product->product_name);
            $store_product->default_price = $sub_product->default_price;
            $store_product->shipping_weight = $sub_product->weight;
            $store_product->size_type_id = $main_product->size_id;
            $store_product->product_id = $request->product_id;
            $store_product->category_id = $request->category_id;
            $store_product->style = $sub_product->description ? $sub_product->description : $main_product->description;
            $store_product->save();

            if ($main_product->size_id) {
                $sizes = Size::where('size_type', $main_product->size_id)->where('size_name', 'NOT LIKE', 'Extra%')->get();
                foreach ($sizes as $size) {
                    $product_size = new StoreProductSize();
                    $product_size->store_id = $request->store_id;
                    $product_size->store_product_id = $store_product->id;
                    $product_size->size_id = $size->id;
                    $product_size->save();
                }
            }

        }
        if($request->has('all_category_order')){
            $categoryOrder = StoreCategoryOrder::where('store_id', $request->store_id)->first();

            $encodedOrder = json_encode($request->all_category_order);

            if ($categoryOrder) {
                $categoryOrder->all_category_product_order = $encodedOrder;
                $categoryOrder->save();
            } else {
                StoreCategoryOrder::create([
                    'store_id' => $request->store_id,
                    'all_category_product_order' => $encodedOrder,
                ]);
            }

        }
        return response()->json(['status' => 'success', 'message' => 'product updated successfully']);

    }
    public function product_category_onchange(Request $request){

        StoreProductCategoryList::where('product_id', $request->product_id)->where('category_id', $request->category_id)->where('store_id', $request->store_id)->delete();

        $category_edit = new StoreProductCategoryList();
        $category_edit->product_id = $request->product_id;
        $category_edit->store_id = $request->store_id;
        $category_edit->category_id = $request->category_id;
        $category_edit->save();

        return response()->json($request->category_id);

    }
    public function edit_product_image(Request $request)
    {
        $product_image_found = StoreProductImage::find($request->editing_product_image_id);

        if (!$product_image_found) {
            return response()->json(['status' => 'error', 'message' => 'Product image not found']);
        }

        $file = $request->file('product_image_edit');
        $storeId = $product_image_found->store_id;
        $storeProductId = $product_image_found->store_product_id;

        if ($file) {
            $targetDir = base_path('assets/team_store_images/Store ' . $storeId . '/Store product ' . $storeProductId);

            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $uniqueToken = uniqid();
            $originalName = $file->getClientOriginalName();
            $name = $uniqueToken . '_' . $originalName;
            $targetFile = $targetDir . '/' . $name;

            if ($file->move($targetDir, $name)) {
                $new_product_image = new StoreProductImage();
                $new_product_image->store_id = $storeId;
                $new_product_image->store_product_id = $storeProductId;
                $new_product_image->url = $product_image_found->url;
                $new_product_image->active = 0;
                $new_product_image->save();

                $product_image_found->url = 'assets/team_store_images/Store ' . $storeId . '/Store product ' . $storeProductId . '/' . $name;
                $product_image_found->save();

                return response()->json(['status' => 'success', 'data' => $product_image_found]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to move uploaded file: ' . $name]);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'No file uploaded']);
        }
    }
    public function copy_product_image(Request $request)
    {
        $product_image_found = StoreProductImage::find($request->product_image_id);

        if (!$product_image_found) {
            return response()->json(['status' => 'error', 'message' => 'Image not found'], 404);
        }

        $new_product_image = new StoreProductImage();

        $new_product_image->store_id = $product_image_found->store_id;
        $new_product_image->store_product_id = $product_image_found->store_product_id;
        $new_product_image->url = $product_image_found->url;
        $new_product_image->image_caption = $product_image_found->image_caption;
        $new_product_image->variant = $product_image_found->variant;
        $new_product_image->type = $product_image_found->variant;

        $new_product_image->save();

        return response()->json(['status' => 'success', 'data' => $new_product_image]);
    }
    public function delete_product_image(Request $request)
    {
        $product_image_found = StoreProductImage::find($request->product_image_id);

        if (!$product_image_found) {
            return response()->json(['status' => 'error', 'message' => 'Image not found'], 404);
        }

        $product_image_found->active = 0;

        $product_image_found->save();

        return response()->json(['status' => 'success', 'data' => $product_image_found]);
    }
    public function add_new_product_variant(Request $request){

        $product_variant = new StoreProductVariant();
        $product_variant->variant_name = $request->variant_name;
        $product_variant->variant_value = $request->variant_value;
        $product_variant->save();

        $store_product_variant = new StoreProductAddedVariant();
        $store_product_variant->store_product_id = $request->store_product_id;
        $store_product_variant->variant_id = $product_variant->id;
        $store_product_variant->save();

        return response()->json(['status' => 'success', 'message' => 'Varient added successfully']);
    }

    public function save_store_products(Request $request)
    {
        $store_product_id = $request->store_product_id;

        if (empty($store_product_id)) {
            $store_product = new StoreProduct();
        } else {
            $store_product = StoreProduct::find($store_product_id);
        }

        $store_product->store_id = $request->store_id;
        $store_product->product_id = $request->product_id;
        $store_product->product_name = $request->store_product_name;
        $store_product->category_id = $request->store_product_category;
        $store_product->mandotary = $request->has('mandotary') ? 1 : 0;
        $store_product->size_type_id = $request->size_type_id;
        $store_product->embellishment_option = $request->store_product_embellishment ?? NULL;
        $store_product->default_price = $request->store_product_default_price;
        $store_product->style = $request->store_product_style;
        $store_product->set_individual_name = $request->has('set_individual_name') ? 1 : 0;
        $store_product->set_individual_number = $request->has('set_individual_number') ? 1 : 0;
        $store_product->product_availability = $request->store_product_availability;
        // $store_product->tax_category = $request->store_product_tax_category;
        $store_product->moq = $request->store_product_moq ?? 1;
        $store_product->maxoq = $request->store_product_maxoq ?? NULL;
        $store_product->shipping_weight = $request->store_product_shipping_weight;
        $store_product->save();

        StoreProductPriceAddition::where('store_product_id', $store_product->id)
            ->where('is_addition_value', 0)
            ->each(function ($addition) use ($request) {
                $addition->update([
                    'addition_amount' => $request->store_product_default_price * $addition->addition_value / 100
                ]);
            });

        $store_product_id = $store_product->id;

        if($request->has('set_individual_name')) {
            StoreIndividualName::updateOrCreate(
                ['store_product_id' => $store_product_id],
                [
                    'store_id' => $request->store_id,
                    'name_required' => $request->has('name_required') ? 1 : 0,
                    'name_exlusive' => $request->has('name_exlusive') ? 1 : 0,
                    'name_not_for_printing' => $request->has('name_not_for_printing') ? 1 : 0,
                    'name_extra_price' => $request->name_extra_price,
                    'name_character_limit' => $request->name_character_limit,
                ]
            );
        } else {
            StoreIndividualName::where('store_product_id', $store_product_id)->delete();
        }

        if($request->has('set_individual_number')) {

            $number_list = ($request->has('exclude_numbers') && count($request->exclude_numbers) > 0) ? json_encode($request->exclude_numbers) : NULL;

            StoreIndividualNumber::where('store_product_id', $store_product_id)->delete();

            $newNameRecord = new StoreIndividualNumber();
            $newNameRecord->store_id = $request->store_id;
            $newNameRecord->store_product_id = $request->store_product_id;
            $newNameRecord->number_required = $request->has('number_required') ? 1 : 0;
            $newNameRecord->number_exlusive = $request->has('number_exlusive') ? 1 : 0;
            $newNameRecord->number_extra_price = $request->number_extra_price;
            $newNameRecord->exclude_numbers = $number_list;
            $newNameRecord->number_type = $request->number_type ?? "0-99";
            $newNameRecord->min_number = $request->has('min_number') ? $request->min_number : 0;
            $newNameRecord->max_number = $request->has('max_number') ? $request->max_number : ($request->number_type === "0-99" ? 99 : ($request->number_type === "3-digits" ? 999 : 99999));
            $newNameRecord->min_number_count = $request->has('min_number_count') ? $request->min_number_count : 1;
            $newNameRecord->max_number_count = $request->has('max_number_count') ? $request->max_number_count : ($request->number_type === "0-99" ? 2 : ($request->number_type === "3-digits" ? 3 : 10));
            $newNameRecord->save();

        } else {
            StoreIndividualNumber::where('store_product_id', $store_product_id)->delete();
        }

        StoreProductSize::where('store_product_id', $store_product_id)->delete();

        if(isset($request->size)){
            foreach ($request->size as $size_id) {
                $product_size = new StoreProductSize();
                $product_size->store_id = $request->store_id;
                $product_size->store_product_id = $store_product_id;
                $product_size->	size_id = $size_id;
                $product_size->save();
            }
        }

        if(!empty($request->product_images)){

            foreach ($request->product_images as $key => $product_image) {
                $image = StoreProductImage::find($key);
                $image->image_caption = $product_image['caption'];
                if(!empty($product_image['variant'])){
                    $image->variant = $product_image['variant'];
                }else{
                    $image->variant = null;
                }
                $image->save();
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Store product saved successfully']);
    }

    public function upload_product_images(Request $request)
    {
        $files = $request->file('product_images');
        $storeId = $request->store_id;
        $storeProductId = $request->store_product_id;

        if (empty($storeProductId)) {
            $new_store_product = new StoreProduct();
            $new_store_product->store_id = $storeId;
            $new_store_product->save();

            $storeProductId = $new_store_product->id;
        }

        $uploadedFiles = [];

        if ($files) {
            foreach ($files as $file) {
                $targetDir = base_path('assets/team_store_images/store_' . $storeId . '/store_product_' . $storeProductId);

                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                $uniqueToken = uniqid();
                $originalName = $file->getClientOriginalName();
                $name = $uniqueToken . '_' . $originalName;
                $targetFile = $targetDir . '/' . $name;

                if ($file->move($targetDir, $name)) {
                    $product_image = new StoreProductImage();
                    $product_image->store_id = $storeId;
                    $product_image->store_product_id = $storeProductId;
                    $product_image->url = 'assets/team_store_images/store_' . $storeId . '/store_product_' . $storeProductId . '/' . $name;
                    $product_image->save();

                    $uploadedFiles[] = $product_image;
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Failed to move uploaded file: ' . $name]);
                }
            }
        }

        return response()->json(['status' => 'success', 'uploaded_files' => $uploadedFiles, 'store_product_id' => $storeProductId]);
    }


    public function save_store_products_all(Request $request){

        dd($request);

    }
    public function add_coupon(Request $request){

        $store_added_coupon = new StoreAddedCoupon();
        $store_added_coupon->store_id = $request->store_id;
        $store_added_coupon->coupon_id = $request->coupon_id;
        $store_added_coupon->save();

        return response()->json(['status' => 'success', 'message' => 'Coupon removed successfully.']);
    }
    public function remove_coupon(Request $request) {

        $deleted = StoreAddedCoupon::where('store_id', $request->store_id)->where('coupon_id', $request->coupon_id)->delete();

        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => 'Coupon removed successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Coupon not found or already removed.']);
        }
    }
    public function delete_coupon(Request $request) {

        $deleted1 = StoreAddedCoupon::where('coupon_id', $request->coupon_id)->delete();
        $deleted2 = StoreCoupon::where('id', $request->coupon_id)->where('store_id', $request->store_id)->delete();

        if ($deleted1 || $deleted2) {
            return response()->json(['status' => 'success', 'message' => 'Coupon deleted successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Coupon not found or already removed.']);
        }
    }
    public function add_tax(Request $request){

        $store_added_tax = new StoreAddedTaxCategory();
        $store_added_tax->store_id = $request->store_id;
        $store_added_tax->tax_id = $request->tax_id;
        $store_added_tax->save();

        return response()->json(['status' => 'success', 'message' => 'Tax removed successfully.']);
    }
    public function remove_tax(Request $request) {

        $deleted = StoreAddedTaxCategory::where('store_id', $request->store_id)->where('tax_id', $request->tax_id)->delete();

        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => 'Tax removed successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Tax not found or already removed.']);
        }
    }
    public function add_variant(Request $request){

        $store_product_variant = new StoreProductAddedVariant();
        $store_product_variant->store_product_id = $request->store_product_id;
        $store_product_variant->variant_id = $request->variant_id;
        $store_product_variant->save();

        return response()->json(['status' => 'success', 'message' => 'Variant removed successfully.']);
    }
    public function remove_variant(Request $request) {

        $deleted = StoreProductAddedVariant::where('store_product_id', $request->store_product_id)->where('variant_id', $request->variant_id)->delete();

        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => 'Variant removed successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Variant not found or already removed.']);
        }
    }
    public function add_new_custom_information(Request $request){

        if ($request->has('custom_information_id') && !empty($request->custom_information_id)) {
            $custom_information = StoreCustomInformation::where('id', $request->custom_information_id)->first();
        }else{
            $custom_information = new StoreCustomInformation();
        }

        $custom_information->store_id = $request->store_id;
        $custom_information->make_as_sub_team = $request->has('make_as_sub_team') ? 1 : 0;

        $custom_information->custom_name = $request->has('make_as_sub_team') ? 'Sub Team' : $request->custom_input_name;
        $custom_information->type = $request->custom_input_type;
        if ($request->input('custom_input_type') == 2) {
            $options = json_encode(json_decode($request->input('custom_input_options')));
            $custom_information->options = $options;
        }else {
            $custom_information->options = null;
        }
        $custom_information->save();

        return response()->json(['status' => 'success', 'message' => 'Custom Information saved successfully.']);
    }
    public function add_custom_information(Request $request){

        $is_sub_team_added = StoreAddedCustomInformation::with('storeCustomInformationsDetails')->where('store_id', $request->store_id)->get()->pluck('storeCustomInformationsDetails')->flatten()->contains('make_as_sub_team', 1);

        $customInfoDetails = StoreCustomInformation::find($request->custom_information_id);

        if($customInfoDetails && $is_sub_team_added && $customInfoDetails->make_as_sub_team == 1){
            return response()->json(['status' => 'error', 'message' => 'Alredy added sub team before.']);
        }
        $store_added_custom_information = new StoreAddedCustomInformation();
        $store_added_custom_information->store_id = $request->store_id;
        $store_added_custom_information->custom_information_id = $request->custom_information_id;
        $store_added_custom_information->save();

        return response()->json(['status' => 'success', 'message' => 'Custom Information removed successfully.']);
    }
    public function delete_custom_information(Request $request) {

        $deleted1 = StoreAddedCustomInformation::where('custom_information_id', $request->custom_information_id)->delete();
        $deleted2 = StoreCustomInformation::where('id', $request->custom_information_id)->delete();

        if ($deleted1 || $deleted2) {
            return response()->json(['status' => 'success', 'message' => 'Custom Information deleted successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Custom Information not found or already removed.']);
        }
    }
    public function remove_custom_information(Request $request) {

        $deleted = StoreAddedCustomInformation::where('store_id', $request->store_id)->where('custom_information_id', $request->custom_information_id)->delete();

        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => 'Custom Information removed successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Custom Information not found or already removed.']);
        }
    }

    public function add_new_coupon(Request $request){

        if ($request->has('coupon_id') && !empty($request->coupon_id)) {
            $coupon = StoreCoupon::where('id', $request->coupon_id)->where('store_id', $request->store_id)->first();
        }else{
            $coupon = new StoreCoupon();
        }

        $coupon->store_id = $request->store_id;
        $coupon->coupon_name = $request->coupon_name ?? '';
        $coupon->type = $request->coupon_type ?? '';
        $coupon->amount = $request->coupon_amount ?? 0;
        $coupon->coupon_code = $request->coupon_code ?? '';
        $coupon->limit_coupon_usage = $request->has('limit_coupon_usage') ? 1 : 0;
        $coupon->expire_date = $request->has('expire_date') ? $request->expire_date : null;
        $coupon->coupon_valid_times = $request->coupon_valid_times ?? 1;
        $coupon->active = 1;

        $coupon->save();

        return response()->json(['status' => 'success', 'message' => 'Coupon saved successfully.']);
    }

    public function update_store_theme(Request $request)
    {
        $targetDir = base_path('assets/team_store_images/Store ' . $request->store_id . '/design_images');

        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $primaryLogoPath = null;
        $secondaryLogoPath = null;
        $storeBannerPath = null;
        $fundraisingPath = null;

        if ($request->hasFile('primary_logo_image')) {
            $file = $request->file('primary_logo_image');
            $uniqueToken = uniqid();
            $originalName = $file->getClientOriginalName();
            $name = $uniqueToken . '_' . $originalName;
            $targetFile = $targetDir . '/' . $name;
            $file->move($targetDir, $name);

            $primaryLogoPath = 'assets/team_store_images/Store ' . $request->store_id . '/design_images/' . $name;
        }

        if ($request->hasFile('secondary_logo_image')) {
            $file = $request->file('secondary_logo_image');
            $uniqueToken = uniqid();
            $originalName = $file->getClientOriginalName();
            $name = $uniqueToken . '_' . $originalName;
            $targetFile = $targetDir . '/' . $name;
            $file->move($targetDir, $name);

            $secondaryLogoPath = 'assets/team_store_images/Store ' . $request->store_id . '/design_images/' . $name;
        }

        if ($request->hasFile('fundraising_image')) {
            $file = $request->file('fundraising_image');
            $uniqueToken = uniqid();
            $originalName = $file->getClientOriginalName();
            $name = $uniqueToken . '_' . $originalName;
            $targetFile = $targetDir . '/' . $name;
            $file->move($targetDir, $name);

            $fundraisingPath = 'assets/team_store_images/Store ' . $request->store_id . '/design_images/' . $name;
        }

        if ($request->hasFile('banner_image')) {
            $file = $request->file('banner_image');
            $uniqueToken = uniqid();
            $originalName = $file->getClientOriginalName();
            $name = $uniqueToken . '_' . $originalName;
            $targetFile = $targetDir . '/' . $name;
            $file->move($targetDir, $name);

            $storeBannerPath = 'assets/team_store_images/Store ' . $request->store_id . '/design_images/' . $name;
        }

        $themes = StoreTheme::where('store_id', $request->store_id)->orderBy('id')->get();

        if ($themes->count() === 0) {
            $store_theme = new StoreTheme();
            $store_theme->store_id = $request->store_id;

        } elseif ($themes->count() === 1) {
            $store_theme = $themes->first();

        } else {
            $latestTheme = $themes->last();
            $themesToDelete = $themes->except($latestTheme->id);

            StoreTheme::whereIn('id', $themesToDelete->pluck('id'))->delete();

            $store_theme = $latestTheme;
        }
        $store_theme->primary_logo = $primaryLogoPath ?: $store_theme->primary_logo;
        $store_theme->secondary_logo = $secondaryLogoPath ?: $store_theme->secondary_logo;
        $store_theme->fundraising = $fundraisingPath ?: $store_theme->fundraising;
        $store_theme->fundraising_text = $request->fundraising_text ?: $store_theme->fundraising_text;
        $store_theme->fundraising_font_color = $request->color_picker_fundraising ?: $store_theme->fundraising_font_color;
        $store_theme->store_banner = $storeBannerPath ?: $store_theme->store_banner;
        $store_theme->primary_color = $request->color_picker_primary ?: $store_theme->primary_color;
        $store_theme->secondary_color = $request->color_picker_secondary ?: $store_theme->secondary_color;
        $store_theme->header_text_color = $request->color_picker_header ?: $store_theme->header_text_color;
        $store_theme->footer_text_color = $request->color_picker_footer ?: $store_theme->footer_text_color;
        $store_theme->button_text_color = $request->color_picker_buttons ?: $store_theme->button_text_color;
        $store_theme->event_name = $request->event_name ?: $store_theme->event_name;
        $store_theme->theme = $request->selected_theme ?: 0;
        $store_theme->store_id = $request->store_id ?: $store_theme->store_id;
        $store_theme->save();


        return response()->json(['message' => 'Theme settings updated successfully!',  'theme' => $store_theme]);
    }

    public function get_theme_settings(Request $request){
        $store_theme = StoreTheme::where('store_id', $request->store_id)->first();
        return response()->json($store_theme);
    }

    public function updateStoreStatus($id)
    {
        $store = Store::find($id);
        if (!$store) return;

        $now = Carbon::now($this->timezone);

        $openDate  = $store->open_date  ? Carbon::parse($store->open_date,  $this->timezone) : null;
        $closeDate = $store->close_date ? Carbon::parse($store->close_date, $this->timezone) : null;

        if ($store->store_status == 3) {
            return;
        }

        if (!$openDate) {
            $store->store_status = 2; // Closed
            $store->save();
            return;
        }

        if ($openDate->isFuture()) {
            $store->store_status = 2; // Closed
            $store->save();
            return;
        }

        if (!$closeDate) {
            // RULE 3: If no close date = never auto-close
            $store->store_status = 1; // Open
            $store->save();
            return;
        }

        if ($closeDate->isPast()) {

            // Store already closed → send notification only once
            if ($store->store_status != 2) {

                $store->store_status = 2; // Closed
                $store->save();

                // Send notifications if deadline logic enabled
                if ($store->set_store_deadline == 1 && !empty($store->close_date) && $store->store_closed_notification_sent == 0) {

                    $store_link = makeStoreDomainRoute($store->direct_access_url);
                    $created_on = $store->created_at ? Carbon::parse($store->created_at, $this->timezone)->toDateString() : '';
                    $closed_on = $store->close_date ? Carbon::parse($store->close_date, $this->timezone)->format('F j, Y') : '';

                    $builder = new NotificationBuilderService();

                    $builder->sendNotification('store_closed', [
                        '{store_name}' => $store->store_name,
                        '{store_link}' => $store_link,
                        '{created_by_avatar}' => asset('assets/img/user/default_muted.png'),
                        '{created_by_name}' => 'N/A',
                        '{created_on}' => $created_on,
                        '{closed_by_name}' => 'N/A',
                        '{closed_by_avatar}' => asset('assets/img/user/default_muted.png'),
                        '{closed_on}' => $closed_on,
                    ], [
                        'sales_assign_store_id' => $store->id,
                        'new_notification'          => 1,
                    ]);

                    $this->send_store_closed_email($id);

                    $store->store_closed_notification_sent = 1;
                    $store->save();

                }

                // $store_link = makeStoreDomainRoute($store->direct_access_url.'?view-only=true');
                // $created_on = $store->created_at ? Carbon::parse($store->created_at, $this->timezone)->toDateString() : '';
                // $closed_on = $store->closed_at ? Carbon::parse($store->closed_at, $this->timezone)->toDateString() : '';

                // $builder = new NotificationBuilderService();

                // $builder->sendNotification('store_closed', [
                //     '{store_name}' => $store->store_name,
                //     '{store_link}' => $store_link,
                //     '{created_by_avatar}' => asset('assets/img/user/default_muted.png'),
                //     '{created_by_name}' => 'N/A',
                //     '{created_on}' => $created_on,
                //     '{closed_by_name}' => 'N/A',
                //     '{closed_by_avatar}' => asset('assets/img/user/default_muted.png'),
                //     '{closed_on}' => $closed_on,
                // ], [
                //     'store_id' => $store->id,
                // ]);

                // $this->send_store_closed_email($id);
            }

        } else {

            // Store is OPEN until close date
            $store->store_status = 1;
            $store->save();

            $closeDate = Carbon::parse($store->close_date, $this->timezone);

            // Send "closing soon" if within 3 days
            if ($store->set_store_deadline == 1 && !empty($store->close_date) && $closeDate->diffInDays($now) <= 3 && $store->store_closing_soon_notification_sent == 0) {

                $store_link = makeStoreDomainRoute($store->direct_access_url);
                $created_on = $store->created_at ? Carbon::parse($store->created_at, $this->timezone)->toDateString() : '';
                $closed_on = $store->close_date ? Carbon::parse($store->close_date, $this->timezone)->format('F j, Y') : '';

                $builder = new NotificationBuilderService();

                $builder->sendNotification('store_closing_soon', [
                    '{store_name}' => $store->store_name,
                    '{store_link}' => $store_link,
                    '{created_by_avatar}' => asset('assets/img/user/default_muted.png'),
                    '{created_by_name}' => 'N/A',
                    '{created_on}' => $created_on,
                    '{closing_on}' => $closed_on,
                ], [
                    'store_id' => $store->id,
                    'sales_assign_store_id' => $store->id,
                    'new_notification'          => 1,
                ]);

                // $this->send_store_closed_soon_email($id);

                $store->store_closing_soon_notification_sent = 1;
                $store->save();
            }
        }

    }

    public function testStoreNotification(){

        $store = Store::find(105);

        $store_link = makeStoreDomainRoute($store->direct_access_url);
        $created_on = $store->created_at ? Carbon::parse($store->created_at, $this->timezone)->toDateString() : '';
        $closed_on = $store->close_date ? Carbon::parse($store->close_date, $this->timezone)->format('F j, Y') : '';

        $builder = new NotificationBuilderService();

        $builder->sendNotification('store_closed', [
            '{store_name}' => $store->store_name,
            '{store_link}' => $store_link,
            '{created_by_avatar}' => asset('assets/img/user/default_muted.png'),
            '{created_by_name}' => 'Prasad Gunasekara',
            '{created_on}' => $created_on,
            '{closed_by_name}' => 'Prasad Gunasekara',
            '{closed_by_avatar}' => asset('assets/img/user/default_muted.png'),
            '{closed_on}' => $closed_on,
        ], [
            'sales_assign_store_id' => $store->id,
            'new_notification'          => 1,
        ]);

        $builder = new NotificationBuilderService();

        $builder->sendNotification('store_closing_soon', [
            '{store_name}' => $store->store_name,
            '{store_link}' => $store_link,
            '{created_by_avatar}' => asset('assets/img/user/default_muted.png'),
            '{created_by_name}' => 'Prasad Gunasekara',
            '{created_on}' => $created_on,
            '{closing_on}' => $closed_on,
        ], [
            'sales_assign_store_id' => $store->id,
            'new_notification'          => 1,
        ]);

    }

    public function send_store_closed_email($id)
    {
        $store = Store::with(['StoreOrders.storeCustomer','themeDetails', 'userDetails'])->find($id);
        if (!$store) {
            return response()->json(['error' => 'Store not found'], 404);
        }
        if ($store->send_store_close_email == 0){
            return response()->json(['error' => 'Store close email not enabled'], 400);
        }
        $emailArray = [];

        foreach ($store->StoreOrders as $order) {
            if ($order->send_store_closed_email == 0) {
                $customer = $order->storeCustomer;

                if ($customer && !empty($customer->email)) {
                    $exists = collect($emailArray)->contains(function ($c) use ($customer) {
                        return $c['email'] === $customer->email;
                    });

                    if (!$exists) {
                        $emailArray[] = [
                            'email' => $customer->email,
                            'name'  => trim($customer->first_name),
                        ];
                    }
                }

                $order->send_store_closed_email = 1;
                $order->save();
            }
        }


        $primary_logo = asset($store->themeDetails->primary_logo);
        $direct_access_url = makeStoreDomainRoute($store->direct_access_url.'?view-only=true');


        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_send_store_closed_email', [
            'store_id'          => $store->id,
            'primary_logo'      => $primary_logo,
            'store_name'        => $store->store_name,
            'sales_rep' => optional($store->userDetails)->name ?? '—',
            'store_link'        => $direct_access_url
        ]);
           


        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_send_admin_store_closed_email', [
            'store_id' => $store->id,
            'primary_logo' => $primary_logo,
            'store' => $store,
            'store_name' => $store->store_name,
            'store_link' => $direct_access_url,
            'closed_on' => Carbon::parse($store->close_date)->format('m/d/Y'),
            'sales_rep' => optional($store->userDetails)->name ?? '—',
            'order_count' => $store->StoreOrders->count(),
            'subject' => 'Store Closed: ' . $store->store_name,
        ]);
        

        return response()->json(['success' => true]);
    }

    public function send_store_closed_soon_email($id)
    {
        $store = Store::with(['StoreOrders.storeCustomer','themeDetails'])->find($id);

        if (!$store) {
            return response()->json(['error' => 'Store not found'], 404);
        }

        if ($store->send_closing_soon_email == 0){
            return response()->json(['error' => 'Store close soon email not enabled'], 400);
        }

        $emailArray = [];

        foreach ($store->StoreOrders as $order) {
            if ($order->send_store_close_soon_email == 0) {
                $customer = $order->storeCustomer;

                if ($customer && !empty($customer->email)) {
                    $exists = collect($emailArray)->contains(function ($c) use ($customer) {
                        return $c['email'] === $customer->email;
                    });

                    if (!$exists) {
                        $emailArray[] = [
                            'email' => $customer->email,
                            'name'  => trim($customer->first_name),
                        ];
                    }
                }

                $order->send_store_close_soon_email = 1;
                $order->save();
            }
        }

        if (count($emailArray)) {
            config(['mail.host' => $this->smptHost]);
            config(['mail.port' => $this->smptPort]);
            config(['mail.encryption' => $this->smptEncryption]);
            config(['mail.username' => $this->mailUsername]);
            config(['mail.password' => $this->mailPassword]);

            config(['mail.from' => [
                'address' => $this->mailUsername,
                'name' => 'Encore Custom',
            ]]);

            $data = [
                'store' => $store,
                'subject' => 'Your Team Store is Closing Soon - Last Chance to Place Orders!',
            ];

            foreach ($emailArray as $recipient) {
                $data['customer_name'] = $recipient['name'];

                Mail::send('pages.stores.email_customer.store_closing_soon_email', $data, function ($message) use ($recipient, $data) {
                    $message->to($recipient['email'], $recipient['name'])
                            ->subject($data['subject']);
                });
            }
        }

        return response()->json(['success' => true]);
    }
    public function send_store_tracking_email($order_no)
    {
        $storeOrder = StoreOrder::with('CustomerDetails')->where('order_no', $order_no)->first();
        if (!$storeOrder) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $storeShipment = StoreShipment::where('store_order_no', $order_no)->first();
        if (!$storeShipment) {
            return response()->json(['error' => 'Shipment not found for this order'], 404);
        }

        $store = Store::with('themeDetails')->find($storeOrder->store_id);
        if (!$store) {
            return response()->json(['error' => 'Store not found'], 404);
        }

        $customer = $storeOrder->CustomerDetails;

        if (!$customer || empty($customer->email)) {
            return response()->json(['error' => 'Customer email not found'], 404);
        }

        config(['mail.host' => $this->smptHost]);
        config(['mail.port' => $this->smptPort]);
        config(['mail.encryption' => $this->smptEncryption]);
        config(['mail.username' => $this->mailUsername]);
        config(['mail.password' => $this->mailPassword]);

        config(['mail.from' => [
            'address' => $this->mailUsername,
            'name' => 'Encore Custom',
        ]]);

        $data = [
            'customer_name' => trim($customer->first_name),
            'subject' => 'Your Order #' . $storeOrder->order_no . ' has been shipped!',
            'store' => $store,
            'shipment' => $storeShipment,
            'order' => $storeOrder
        ];

        Mail::send('pages.stores.email_customer.production_completed', $data, function ($message) use ($customer, $data) {
            $message->to($customer->email, $data['customer_name'])
                    ->subject($data['subject']);
        });

        return response()->json(['success' => true]);
    }


    public function archive_store(Request $request)
    {
        $store = Store::find($request->store_id);

        if (!$store) {
            return response()->json([
                'status' => 'error',
                'message' => 'Store not found.',
            ], 404);
        }

        $store->store_status = 3;
        $store->close_date = Carbon::now()->format('Y-m-d H:i:s');
        $store->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Store archived successfully.',
        ]);
    }

    public function unarchive_store(Request $request)
    {
        $store = Store::find($request->store_id);

        if (!$store) {
            return response()->json([
                'status' => 'error',
                'message' => 'Store not found.',
            ], 404);
        }

        $store->store_status = 2;
        $store->close_date = Carbon::now($this->timezone)->format('Y-m-d H:i:s');
        $store->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Store unarchived successfully.',
        ]);
    }
    public function close_store(Request $request)
    {
        $store = Store::find($request->store_id);

        if (!$store) {
            return response()->json([
                'status' => 'error',
                'message' => 'Store not found.',
            ], 404);
        }

        $store->set_store_deadline = 1;
        $store->store_status = 2;
        $store->close_date = Carbon::now($this->timezone)->format('Y-m-d H:i:s');
        $store->save();

        $this->send_store_closed_email($store->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Store closed successfully.',
        ]);
    }

    public function overview($id){

        $this->updateStoreStatus($id);

        $store = Store::with('StoreAddedCoupons', 'StoreAddedCustomInformations', 'StoreAddedProducts')->where('id' , $id)->first();
        $qrCodeUrl = "https://encr.shop/{$store->direct_access_url}";
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($qrCodeUrl)
            ->encoding(new Encoding('UTF-8'))
            ->size(200)
            ->margin(10)
            ->build();

        $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($result->getString());

        return view('pages.stores.info.index', ['store'=>$store, 'qrCodeBase64'=>$qrCodeBase64]);
    }
    public function email_customer($id){

        $this->updateStoreStatus($id);

        $store = Store::with('StoreAddedCoupons')->with('StoreAddedCustomInformations')->where('id' , $id)->first();
        $customers = StoreCustomer::where('store_id', $id)->get();

        return view('pages.stores.email_customer.index', ['store'=>$store, 'customers'=>$customers]);
    }

    public function emailToCucstomer(Request $request)
    {
        $emails = $request->input('emails') ?? [];
        $subject = $request->input('subject');
        $message = $request->input('message');
        $ccEmail = $request->input('cc_emails') ?? [];

        // Clean TO emails
        $emails = array_values(array_filter($emails, function ($email) {
            $email = trim($email);
            return $email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL);
        }));

        // Clean CC emails
        $ccEmail = array_values(array_filter($ccEmail, function ($email) {
            $email = trim($email);
            return $email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL);
        }));

        if (empty($emails) || empty($subject) || empty($message)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Missing required fields.'
            ], 422);
        }

        config(['mail.host' => $this->smptHost]);
        config(['mail.port' => $this->smptPort]);
        config(['mail.encryption' => $this->smptEncryption]);
        config(['mail.username' => $this->mailUsername]);
        config(['mail.password' => $this->mailPassword]);

        config(['mail.from' => [
            'address' => $this->mailUsername,
            'name' => 'Encore Custom',
        ]]);

        foreach ($emails as $email) {
            Mail::send([], [], function ($mail) use ($email, $subject, $message, $ccEmail) {
                $mail->to($email)
                    ->subject($subject)
                    ->setBody($message, 'text/html');

                // Add CC only if CC emails exist
                if (!empty($ccEmail)) {
                    $mail->cc($ccEmail);
                }
            });
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Emails sent successfully.'
        ]);
    }
    public function getEmailTemplates()
    {
        $emailTemplates = StoreEmailTemplate::where('active', 1)->get();
        return response()->json($emailTemplates);
    }
    public function saveEmailTemplate(Request $request)
    {
        $template = StoreEmailTemplate::find($request->id) ?? new StoreEmailTemplate();
        $template->template_name = $request->template_name;
        $template->subject = $request->subject;
        $template->body = urldecode($request->input('body'));
        $template->active = 1;
        $template->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Email template saved successfully.',
        ]);
    }
    public function createTSR(Request $request){

        if(!StorePaymentLog::where('store_id', $request->store_id)->exists()){
            $paymentLog = new StorePaymentLog();
            $paymentLog->store_id = $request->store_id;
            $paymentLog->save();
        }


        $sequences =
            [ 'one' ,'two' ,'three' ,'four' ,'five', 'six' ,'seven' ,'eight' ,'nine' ,'ten',

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

        $maxId = Order::max('id');
        $orderNo = "TSR".str_pad(($maxId+1), 6, "0", STR_PAD_LEFT);

        $notForPrintingProductIDs = StoreIndividualName::where('store_id', $request->store_id)->where('name_not_for_printing', 1)->pluck('store_product_id')->toArray();
        $nameNotForPrintingProducts = StoreProduct::whereIn('id', $notForPrintingProductIDs)->get();

        foreach ($nameNotForPrintingProducts as $product) {
            $product->set_individual_number = 1;
            $product->set_individual_name = 0;
            $product->save();
        }

        $storeOrderPlayerDetails = StoreOrderPlayerDetail::whereIn('store_product_id', $notForPrintingProductIDs)->get();
        foreach ($storeOrderPlayerDetails as $detail) {
            $detail->is_name_available = 0;
            $detail->is_number_available = 1;
            $detail->save();
        }

        $store = Store::where('id', $request->store_id)->first();
        $store_orders = StoreOrder::with('OrderItems')->where('store_id', $request->store_id)->where('active', 1)->where('is_payment_success', 1)->whereNull('system_order_no')->get();

        if ($store_orders->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No active orders found for this store.'
            ], 404);
        }

        if (!empty($request->input('tsr_order_no'))) {

            $newOrder = Order::where('order_no', $request->tsr_order_no)->first();

            $contact = Contact::where('id', $newOrder->contact_id)->first();

        }else{

            $contact = Contact::where('id', $request->customer_id)->first();

            $newOrder = new Order();
            $newOrder->organization_id = $store->organization_id;
            $newOrder->contact_id = $request->customer_id;
            $newOrder->order_no = $orderNo;
            $newOrder->order_status_id = 1;
            $newOrder->user_id = $request->sales_rep_id;
            $newOrder->order_procesing_user_id = $request->sales_rep_id;
            $newOrder->open_date = Carbon::now()->format('m/d/Y');

            $newOrder->active = 1;
            $newOrder->is_new_shipping_address = 0;

            $newOrder->address_type = 2;

            $dueDate = Carbon::createFromFormat('m/d/Y', $request->input('due_date'));

            if($store->shipping_method == 2){
                $newOrder->ex_factory_date = $dueDate->copy()->subDays(7)->format('m/d/Y');
                $newOrder->due_date = $dueDate->format('m/d/Y');
            }else{
                $newOrder->ex_factory_date = $dueDate->copy()->subDays(14)->format('m/d/Y');
                $newOrder->encore_packing_date = $dueDate->copy()->subDays(7)->format('m/d/Y');
                $newOrder->due_date = $dueDate->format('m/d/Y');
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

            if(!PaymentLog::where('store_id', $request->store_id)->exists()){
                $paymentLog = new PaymentLog();
                $paymentLog->store_id = $request->store_id;
                $paymentLog->order_id = $newOrder->id;
                $paymentLog->save();
            }
        }


        $store_orders->each(function ($order) use ($newOrder) {
            $order->system_order_no = $newOrder->order_no;
            $order->order_status = 2;
            $order->save();
        });

        $groupedItems = [];

        foreach ($store_orders as $order) {
            foreach ($order->OrderItems as $orderItem) {
                $productId = $orderItem->productDetails->id ?? null;

                if ($productId) {
                    if (!isset($groupedItems[$productId])) {
                        $groupedItems[$productId] = [];
                    }

                    $groupedItems[$productId][] = $orderItem;
                }
            }
        }

        $indexNo = OrderItem::where('order_id', $newOrder->id)->count();

        foreach ($groupedItems as $productItemStore) {

            $firstOrderItemStore = $productItemStore[0];

            $storeProduct = $firstOrderItemStore->productDetails;
            $sub_product = SubProduct::find($storeProduct->product_id);
            $product = Product::with('productFactories')->find($sub_product->parent_product_id);

            $totalQty = 0;
            $totalPrice = 0;

            foreach ($productItemStore as $orderItemStore) {
                $qty = $orderItemStore->qty ?? 1;
                $price = $storeProduct->default_price;
                $totalQty += $qty;
                $totalPrice += $qty * $price;
            }

            $orderItem = new OrderItem();
            $orderItem->item_no = $orderNo . '-' . ($indexNo + 1);
            $orderItem->order_id = $newOrder->id;
            $orderItem->product_id = $product->id;
            $orderItem->display_name = $storeProduct->product_name;
            $orderItem->organization_id = $store->organization_id;

            $factory = $product->productFactories->firstWhere('product_factory_id', 1)?? $product->productFactories->first();
            $orderItem->factory_id = $factory ? $factory->product_factory_id : NULL;

            $orderItem->support_agent_id = $contact->id;
            $orderItem->ex_factory_id = 0;
            $orderItem->open_date = Carbon::now()->format('m/d/Y');
            $orderItem->embellishment_type_id = $storeProduct->embellishment_option ?? NULL;

            $dueDate = Carbon::createFromFormat('m/d/Y', $request->input('due_date'));
            if ($store->shipping_method == 2) {
                $orderItem->ex_factory_date = $dueDate->copy()->subDays(7)->format('m/d/Y');
                $orderItem->in_hand_due_date = $dueDate;
            } else {
                $orderItem->ex_factory_date = $dueDate->copy()->subDays(14)->format('m/d/Y');
                $orderItem->encore_packing_date = $dueDate->copy()->subDays(7)->format('m/d/Y');
                $orderItem->in_hand_due_date = $dueDate;
            }

            $orderItem->order_status_id = 1;
            $orderItem->fabric_id = $sub_product->fabric_id;
            $orderItem->sport = $product->sport;
            $orderItem->gender = $product->gender;

            $orderItem->qty = $totalQty;
            $orderItem->unit_price = $storeProduct->default_price;
            $orderItem->total = $totalPrice;
            $orderItem->sub_product_no = $sub_product->sub_product_no;
            $orderItem->active = 1;

            $orderItem->save();

            if($orderItemStore->productDetails->set_individual_name == 1){

                $attributeRecord = new OrderItemAttribute();
                $attributeRecord->order_item_id = $orderItem->id;
                $attributeRecord->attribute_id = 2;
                $attributeRecord->save();

            }
            if($orderItemStore->productDetails->set_individual_number == 1){

                $attributeRecord = new OrderItemAttribute();
                $attributeRecord->order_item_id = $orderItem->id;
                $attributeRecord->attribute_id = 1;
                $attributeRecord->save();

            }

            // Collect all unique sizes across all product items
            $allSizes = collect();

            foreach ($productItemStore as $orderItemStore) {
                $sizes = $orderItemStore->productDetails->sizes->pluck('size_id')->toArray();
                $allSizes = $allSizes->merge($sizes);
            }

            // Unique size IDs
            $uniqueSizes = $allSizes->unique()->values();

            // Loop through each unique size once
            foreach ($uniqueSizes as $productSize) {
                // Create one order item detail for this size
                $orderItemsDetails = new OrderItemsDetail();
                $orderItemsDetails->order_item_id = $orderItem->id;
                $orderItemsDetails->size_id = $productSize;
                $orderItemsDetails->save();

                // Create corresponding player name detail
                $playerNameDetails = new OrderItemsDetailPlayerName();
                $playerNameDetails->order_items_detail_id = $orderItemsDetails->id;

                $occupiedSequences = [];

                // Loop through all product item stores for this size
                foreach ($productItemStore as $orderItemStore) {
                    // Update store order reference
                    StoreOrderItem::where('id', $orderItemStore->id)->update([
                        'system_order_reference' => $orderItem->item_no,
                        'system_order_item_id' => $orderItem->id,
                        'system_order_item_detail_id' => $orderItemsDetails->id,
                    ]);

                    $detailRecords = $orderItemStore->OrderItemDetails->where('size', $productSize);

                        foreach ($detailRecords as $detailRecord) {
                            if ($orderItemStore->productDetails->set_individual_name == 1 && $orderItemStore->productDetails->set_individual_number == 1) {
                                $tempKey1 = 0;
                                foreach ($sequences as $sequence) {
                                    if (!isset($occupiedSequences[$sequence])) {
                                        if ($tempKey1 < $detailRecord->qty) {
                                            $playerNameDetails->{'player_' . $sequence} = $detailRecord->player_name ?? '';
                                            $orderItemsDetails->{'numseq_' . $sequence} = $detailRecord->player_number ?? null;
                                            $occupiedSequences[$sequence] = true;

                                            $tempKey1 ++;
                                        }else{
                                            break;
                                        }
                                    }
                                }

                                $orderItemsDetails->qty = ($orderItemsDetails->qty ?? 0) + $detailRecord->qty;

                            } elseif ($orderItemStore->productDetails->set_individual_name == 1) {
                                $blankNames = array_fill(0, $detailRecord->qty, $detailRecord->player_name);
                                $playerNameDetails->blank_player_names = json_encode(
                                    array_merge(json_decode($playerNameDetails->blank_player_names ?? '[]', true), $blankNames)
                                );
                                $playerNameDetails->blank_qty = ($playerNameDetails->blank_qty ?? 0) + $detailRecord->qty;
                                $orderItemsDetails->blanks = ($orderItemsDetails->blanks ?? 0) + $detailRecord->qty;

                            } elseif ($orderItemStore->productDetails->set_individual_number == 1) {
                                $tempKey2 = 0;
                                foreach ($sequences as $sequence) {
                                    if (!isset($occupiedSequences[$sequence])) {
                                        if ($tempKey2 < $detailRecord->qty) {
                                            $orderItemsDetails->{'numseq_' . $sequence} = $detailRecord->player_number ?? null;
                                            $occupiedSequences[$sequence] = true;
                                            $tempKey2 ++;
                                        }else{
                                            break;
                                        }
                                    }
                                }
                                $orderItemsDetails->qty = ($orderItemsDetails->qty ?? 0) + $detailRecord->qty;

                            } else {
                                $orderItemsDetails->blanks = ($orderItemsDetails->blanks ?? 0) + $detailRecord->qty;
                            }

                            // Mark original detail record as processed
                            $detailRecord->item_status = 2;
                            $detailRecord->save();
                        }

                }

                // Save combined records once per size
                $orderItemsDetails->save();
                $playerNameDetails->save();
            }

            $indexNo++;
        }

        $this->update_store_payment_record($request->store_id);

        return redirect()->to('order_details/edit/'.$newOrder->id.'/order?active_tab=order')->withSuccess('Order Submitted Successfully!');

    }
    public function updateTSR(Request $request){

        $sequences =
            [ 'one' ,'two' ,'three' ,'four' ,'five', 'six' ,'seven' ,'eight' ,'nine' ,'ten',

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

        if($request->has('tsr_order_no')){
            $tsrOrder = Order::where('order_no', $request->tsr_order_no)->first();
            if($tsrOrder){

                $store = Store::where('id', $request->store_id)->first();
                $store_orders = StoreOrder::with('OrderItems')->where('store_id', $request->store_id)->where('active', 1)->where('is_payment_success', 1)->get();

                if ($store_orders->isEmpty()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'No active orders found for this store.'
                    ], 404);
                }

                $groupedItems = [];

                foreach ($store_orders as $order) {
                    foreach ($order->OrderItems as $orderItem) {
                        $productId = $orderItem->productDetails->id ?? null;

                        if ($productId) {
                            if (!isset($groupedItems[$productId])) {
                                $groupedItems[$productId] = [];
                            }

                            $groupedItems[$productId][] = $orderItem;
                        }
                    }
                }

                $orderItemIdsNotToDelete = [];
                $orderItemNotFound = [];

                foreach ($groupedItems as $productItemStore) {

                    $firstOrderItemStore = $productItemStore[0];

                    $storeProduct = $firstOrderItemStore->productDetails;
                    $sub_product = SubProduct::find($storeProduct->product_id);
                    $product = Product::with('productFactories')->find($sub_product->parent_product_id);

                    $totalQty = 0;
                    $totalPrice = 0;

                    foreach ($productItemStore as $orderItemStore) {
                        $qty = $orderItemStore->qty ?? 1;
                        $price = $storeProduct->default_price;
                        $totalQty += $qty;
                        $totalPrice += $qty * $price;
                    }

                    $orderItem = OrderItem::where('order_id', $tsrOrder->id)->where('item_no', $firstOrderItemStore->system_order_reference)->where('sub_product_no', $sub_product->sub_product_no)->first();
                    //if product not found by sub product no, try without it
                    if(!$orderItem){
                        $itemsWithReference = OrderItem::where('order_id', $tsrOrder->id)->where('item_no', $firstOrderItemStore->system_order_reference)->get();
                        if($itemsWithReference->count() == 1){
                            $orderItem = $itemsWithReference->first();
                        }
                    }
                    if($orderItem){

                        $orderItemIdsNotToDelete[] = $orderItem->id;

                        $orderItem->qty = $totalQty;
                        $orderItem->unit_price = $storeProduct->default_price;
                        $orderItem->total = $totalPrice;
                        $orderItem->save();

                        if($orderItemStore->productDetails->set_individual_name == 1 && !OrderItemAttribute::where('order_item_id', $orderItem->id)->where('attribute_id', 2)->exists()){

                            $attributeRecord = new OrderItemAttribute();
                            $attributeRecord->order_item_id = $orderItem->id;
                            $attributeRecord->attribute_id = 2;
                            $attributeRecord->save();

                        }elseif($orderItemStore->productDetails->set_individual_name == 0){
                            OrderItemAttribute::where('order_item_id', $orderItem->id)->where('attribute_id', 2)->delete();
                        }

                        if($orderItemStore->productDetails->set_individual_number == 1 && !OrderItemAttribute::where('order_item_id', $orderItem->id)->where('attribute_id', 1)->exists()){

                            $attributeRecord = new OrderItemAttribute();
                            $attributeRecord->order_item_id = $orderItem->id;
                            $attributeRecord->attribute_id = 1;
                            $attributeRecord->save();

                        }elseif($orderItemStore->productDetails->set_individual_number == 0){
                            OrderItemAttribute::where('order_item_id', $orderItem->id)->where('attribute_id', 1)->delete();
                        }

                        // Collect all unique sizes across all product items
                        $allSizes = collect();

                        foreach ($productItemStore as $orderItemStore) {
                            $sizes = $orderItemStore->productDetails->sizes->pluck('size_id')->toArray();
                            $allSizes = $allSizes->merge($sizes);
                        }

                        // Unique size IDs
                        $uniqueSizes = $allSizes->unique()->values();

                        $itemDetailIdsNotToDelete = [];

                        // Loop through each unique size once
                        foreach ($uniqueSizes as $productSize) {
                            // Create one order item detail for this size
                            $orderItemsDetails = OrderItemsDetail::where('order_item_id', $orderItem->id)->where('size_id', $productSize)->first();

                            // Create corresponding player name detail
                            $playerNameDetails = OrderItemsDetailPlayerName::where('order_items_detail_id', $orderItemsDetails->id)->first();

                            foreach ($sequences as $sequence) {
                                $orderItemsDetails->{'numseq_' . $sequence} = NULL;
                                $playerNameDetails->{'player_' . $sequence} = NULL;
                            }

                            $orderItemsDetails->qty = NULL;
                            $orderItemsDetails->blanks = NULL;

                            $occupiedSequences = [];

                            // Loop through all product item stores for this size
                            foreach ($productItemStore as $orderItemStore) {

                                $detailRecords = $orderItemStore->OrderItemDetails->where('size', $productSize);

                                    foreach ($detailRecords as $detailRecord) {
                                        if ($orderItemStore->productDetails->set_individual_name == 1 && $orderItemStore->productDetails->set_individual_number == 1) {
                                            $tempKey1 = 0;
                                            foreach ($sequences as $sequence) {
                                                if (!isset($occupiedSequences[$sequence])) {
                                                    if ($tempKey1 < $detailRecord->qty) {
                                                        $playerNameDetails->{'player_' . $sequence} = $detailRecord->player_name ?? '';
                                                        $orderItemsDetails->{'numseq_' . $sequence} = $detailRecord->player_number ?? null;
                                                        $occupiedSequences[$sequence] = true;

                                                        $tempKey1 ++;
                                                    }else{
                                                        break;
                                                    }
                                                }
                                            }

                                            $orderItemsDetails->qty = ($orderItemsDetails->qty ?? 0) + $detailRecord->qty;
                                            $orderItemsDetails->blanks = NULL;

                                        } elseif ($orderItemStore->productDetails->set_individual_name == 1) {
                                            $blankNames = array_fill(0, $detailRecord->qty, $detailRecord->player_name);
                                            $playerNameDetails->blank_player_names = json_encode(
                                                array_merge(json_decode($playerNameDetails->blank_player_names ?? '[]', true), $blankNames)
                                            );
                                            $playerNameDetails->blank_qty = ($playerNameDetails->blank_qty ?? 0) + $detailRecord->qty;
                                            $orderItemsDetails->blanks = ($orderItemsDetails->blanks ?? 0) + $detailRecord->qty;
                                            $orderItemsDetails->qty = NULL;

                                        } elseif ($orderItemStore->productDetails->set_individual_number == 1) {
                                            $tempKey2 = 0;
                                            foreach ($sequences as $sequence) {
                                                if (!isset($occupiedSequences[$sequence])) {
                                                    if ($tempKey2 < $detailRecord->qty) {
                                                        $orderItemsDetails->{'numseq_' . $sequence} = $detailRecord->player_number ?? null;
                                                        $occupiedSequences[$sequence] = true;
                                                        $tempKey2 ++;
                                                    }else{
                                                        break;
                                                    }
                                                }
                                            }
                                            $orderItemsDetails->qty = ($orderItemsDetails->qty ?? 0) + $detailRecord->qty;
                                            $orderItemsDetails->blanks = NULL;

                                        } else {
                                            $orderItemsDetails->blanks = ($orderItemsDetails->blanks ?? 0) + $detailRecord->qty;
                                            $orderItemsDetails->qty = NULL;
                                        }
                                    }

                            }

                            // Save combined records once per size
                            $orderItemsDetails->save();
                            $playerNameDetails->save();

                            $itemDetailIdsNotToDelete[] = $orderItemsDetails->id;
                        }
                        // Delete item details that were not updated
                        if(!empty($itemDetailIdsNotToDelete)){
                            $deletedItemDetails = OrderItemsDetail::where('order_item_id', $orderItem->id)->whereNotIn('id', $itemDetailIdsNotToDelete)->get();
                            foreach ($deletedItemDetails as $deletedItemDetail) {
                                OrderItemsDetail::where('id', $deletedItemDetail->id)->delete();
                                OrderItemsDetailPlayerName::where('order_items_detail_id', $deletedItemDetail->id)->delete();
                            }
                        }
                    }

                }

                // Delete order items that were not updated
                // if(!empty($orderItemIdsNotToDelete)){
                //     OrderItem::where('order_id', $tsrOrder->id)->whereNotIn('id', $orderItemIdsNotToDelete)->delete();
                // }

                $this->update_store_payment_record($request->store_id);

                return redirect()->back()->with('success', 'TSR order updated successfully!');
            }else{
                return redirect()->back()->with('error', 'TSR order not found!');
            }
        }else{
            return redirect()->back()->with('error', 'TSR order no not found!');
        }

    }
    public function updateStoreRecords(){
        $OrderNoS = StoreOrder::whereNotNull('system_order_no')->distinct()->pluck('system_order_no')->toArray();
        foreach($OrderNoS as $orderNo){
            $storeOrder = StoreOrder::where('system_order_no', $orderNo)->first();
            if($storeOrder){
                $ECorder = Order::where('order_no', $storeOrder->system_order_no)->first();
                if(!$ECorder){
                    continue;
                }else{

                    if(!StorePaymentLog::where('store_id', $storeOrder->store_id)->where('order_id', $ECorder->id)->exists()){
                        $storePaymentLog = new StorePaymentLog();
                        $storePaymentLog->store_id = $storeOrder->store_id;
                        $storePaymentLog->order_id = $ECorder->id;
                        $storePaymentLog->save();
                    }

                    if(!PaymentLog::where('store_id', $storeOrder->store_id)->where('order_id', $ECorder->id)->exists()){
                        $paymentLog = new PaymentLog();
                        $paymentLog->store_id = $storeOrder->store_id;
                        $paymentLog->order_id = $ECorder->id;
                        $paymentLog->save();
                    }

                    $this->update_store_payment_record($storeOrder->store_id);
                }

            }
        }
        return "Store Records Updated Successfully!";
    }
    public function update_store_payment_record($store_id){

        $StorePaymentLog = StorePaymentLog::where('store_id', $store_id)->first();

        if($StorePaymentLog){

            $ECorder = NULL;

            $storeCardPayment = StoreCardPayment::where('store_id', $store_id)->where('is_success', 1)->get();
            $storeOrders = StoreOrder::where('store_id', $store_id)->where('active', 1)->where('is_payment_success', 1)->get();
            $sumsOfOrders = [];
            $paymentSum = 0;
            foreach($storeCardPayment as $payment){
                if($payment->is_refund == 1){
                    $paymentSum -= $payment->payment_amount;
                }else{
                    $paymentSum += $payment->total_amount;
                }
            }
            foreach($storeOrders as $order){
                $sumsOfOrders['sub_total'] = ($sumsOfOrders['sub_total'] ?? 0) + $order->sub_total;
                $sumsOfOrders['shipping'] = ($sumsOfOrders['shipping'] ?? 0) + $order->shipping;
                $sumsOfOrders['sales_tax'] = ($sumsOfOrders['sales_tax'] ?? 0) + $order->sales_tax;
                $sumsOfOrders['other_fee'] = ($sumsOfOrders['other_fee'] ?? 0) + $order->handling_fee;
                $sumsOfOrders['total'] = ($sumsOfOrders['total'] ?? 0) + $order->total;
            }

            if($storeOrders->first()->system_order_no){
                $ECorder = Order::where('order_no', $storeOrders->first()->system_order_no)->first();
                if(!empty($ECorder)){
                    $ECPaymentRecord = PaymentLog::where('order_id', $ECorder->id)->where('store_id', $store_id)->first();
                    if($ECPaymentRecord){
                        $ECPaymentRecord->transaction_id = 'TSRM'. str_pad($store_id, 6, '0', STR_PAD_LEFT);
                        $ECPaymentRecord->name_on_card = 'TSR MODULE';
                        $ECPaymentRecord->response_code = 1;
                        $ECPaymentRecord->quantity = 1;
                        $ECPaymentRecord->auto_generated = 1;
                        $ECPaymentRecord->amount = $paymentSum;
                        $ECPaymentRecord->save();
                    }else{
                        $ECPaymentRecord = new PaymentLog();
                        $ECPaymentRecord->transaction_id = 'TSRM'. str_pad($store_id, 6, '0', STR_PAD_LEFT);
                        $ECPaymentRecord->store_id = $store_id;
                        $ECPaymentRecord->order_id = $ECorder->id;
                        $ECPaymentRecord->name_on_card = 'TSR MODULE';
                        $ECPaymentRecord->response_code = 1;
                        $ECPaymentRecord->quantity = 1;
                        $ECPaymentRecord->auto_generated = 1;
                        $ECPaymentRecord->amount = $paymentSum;
                        $ECPaymentRecord->save();}
                }
            }

            $StorePaymentLog->store_id = $store_id;
            $StorePaymentLog->order_id = $ECorder ? $ECorder->id : NULL;
            $StorePaymentLog->sum_of_sub_total = $sumsOfOrders['sub_total'] ?? 0;
            $StorePaymentLog->sum_of_shipping = $sumsOfOrders['shipping'] ?? 0;
            $StorePaymentLog->sum_of_sales_tax = $sumsOfOrders['sales_tax'] ?? 0;
            $StorePaymentLog->sum_of_other = $sumsOfOrders['other_fee'] ?? 0;
            $StorePaymentLog->sum_of_total = $sumsOfOrders['total'] ?? 0;
            $StorePaymentLog->amount = $paymentSum;
            $StorePaymentLog->save();
        }
    }
    public function flyer($id){

        $this->updateStoreStatus($id);

        $store = Store::with('flyerDetails')->where('id' , $id)->first();

        return view('pages.stores.flyer.index', ['store'=>$store]);
    }
    public function manage_group($id){

        $this->updateStoreStatus($id);

        $store = Store::with('groupAccessDetails')->where('id' , $id)->first();

        return view('pages.stores.manage_group.index', ['store'=>$store]);
    }
    public function manage_orders($id){

        $this->updateStoreStatus($id);

        $store = Store::with('StoreAddedCustomInformations', 'organizationDetails', 'StoreAddedCoupons','StoreAddedShippingMethods')->where('id' , $id)->first();
        $orders = StoreOrder::with('StatusDetails', 'ShipmentDetails', 'paymentDetails', 'OrderItems')->where('store_id', $id)->where('active', 1)->where('is_payment_success', 1)->get();
        $store_order_statuses = StoreOrderStatus::where('active', 1)->get();
        $attributes = Attribute::where('active', 1)->get();
        $users = User::where('active', 1)->get();
        $contacts = Contact::where('active', 1)->get();

        $tsr_order_no = NULL;
        $TSRorderCanUpdate = true;
        $TSRorderID = NULL;

        if ($orders->where('system_order_no', '!=', NULL)->count() > 0) {
            $tsr_order_no = $orders->where('system_order_no', '!=', NULL)->first()->system_order_no;

            $TSRorder = Order::where('order_no', $tsr_order_no)->first();
            if ($TSRorder) {
                $TSRorderID = $TSRorder->id;
                $TSRorderItems = OrderItem::where('order_id', $TSRorder->id)->get();
                if ($TSRorderItems->count() > 0) {
                    foreach ($TSRorderItems as $item) {
                        if ($item->order_status_id != 1) {
                            $TSRorderCanUpdate = false;
                            break;
                        }
                    }
                }
            }
        }

        if(request()->has('shipping_method')){
            $orders = $orders->where('shipping_method', request()->input('shipping_method'));
        }

        $pendingOrdersCount = $orders->whereNull('system_order_no')->where('active', 1)->count();
        $updatedCount = StoreOrderItem::where('store_id', $id)->where('is_updated', 1)->count();

        $lastOrder = StoreOrder::latest('id')->first();
        $nextId = $lastOrder ? $lastOrder->id + 1 : 1;
        $storePrefix = strtoupper(substr(str_replace(' ', '', $store->store_name), 0, 4));
        $nextOrderNo = $storePrefix . str_pad($nextId, 6, '0', STR_PAD_LEFT);

        return view('pages.stores.manage_order.index', ['store'=>$store, 'orders'=>$orders, 'store_order_statuses'=>$store_order_statuses, 'attributes'=>$attributes, 'users'=>$users, 'contacts'=>$contacts, 'tsr_order_no'=>$tsr_order_no, 'pendingOrdersCount'=>$pendingOrdersCount, 'updatedCount'=>$updatedCount, 'TSRorderCanUpdate'=>$TSRorderCanUpdate, 'nextOrderNo'=>$nextOrderNo, 'tsr_order_no'=>$tsr_order_no, 'TSRorderID'=>$TSRorderID]);
    }
    public function globalSearch(Request $request)
    {
        $keyword = trim($request->input('keyword', ''));

        if ($keyword === '') {
            return response()->json([
                'all' => [],
                'orders' => [],
                'customers' => []
            ]);
        }

        $orders = StoreOrder::with('CustomerDetails')
            ->where(function ($query) use ($keyword) {
                $query->where('order_no', 'like', '%' . $keyword . '%')
                    ->orWhere('system_order_no', 'like', '%' . $keyword . '%')
                    ->orWhereHas('CustomerDetails', function ($q) use ($keyword) {
                        $q->where('first_name', 'like', '%' . $keyword . '%')
                            ->orWhere('last_name', 'like', '%' . $keyword . '%')
                            ->orWhere('email', 'like', '%' . $keyword . '%');
                    });
            })
            ->latest()
            ->get();

        $customers = StoreCustomer::where(function ($query) use ($keyword) {
                $query->where('first_name', 'like', '%' . $keyword . '%')
                    ->orWhere('last_name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            })
            ->latest()
            ->get();

        $stores = Store::with('userDetails')->where('store_name', 'like', '%' . $keyword . '%')
            ->latest()
            ->get();

        $results = [
            'all' => [],
            'orders' => [],
            'customers' => [],
            'stores' => []
        ];

        foreach ($stores as $store) {
            $results['all'][] = [
                'title' => $store->store_name,
                'subtitle' => 'Store • ' . ($store->userDetails->name ?? ''),
                'url' => route('store.manage_orders', ['id' => $store->id]),
            ];

            $results['stores'][] = [
                'title' => $store->store_name,
                'subtitle' => $store->userDetails->name ?? '',
                'url' => route('store.manage_orders', ['id' => $store->id]),
            ];
        }

        foreach ($orders as $order) {
            $customer = $order->CustomerDetails;

            $customerName = $customer
                ? trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? ''))
                : 'No customer';

            $customerEmail = $customer->email ?? 'No email';

            $results['all'][] = [
                'title' => 'Order #' . $order->order_no,
                'subtitle' => $customerName . ' • ' . $customerEmail,
                'url' => route('store.individual_player', ['id' => $order->order_no]),
            ];

            $results['orders'][] = [
                'title' => 'Order #' . $order->order_no,
                'subtitle' => $customerName . ' • $' . number_format((float) $order->total, 2),
                'url' => route('store.individual_player', ['id' => $order->order_no]),
            ];
        }

        foreach ($customers as $customer) {
            $fullName = trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? ''));

            $results['all'][] = [
                'title' => $fullName,
                'subtitle' => 'Customer • ' . ($customer->email ?? ''),
                'url' => '#',
            ];

            $results['customers'][] = [
                'title' => $fullName,
                'subtitle' => $customer->email ?? '',
                'url' => '#',
            ];
        }

        return response()->json($results);
    }
    public function product_report($id){

        $this->updateStoreStatus($id);

        $store = Store::with('StoreAddedCoupons', 'StoreOrders', 'StoreAddedCustomInformations')->where('id' , $id)->first();

        return view('pages.stores.product_report.index', ['store'=>$store]);
    }
    public function player_report($id){

        $this->updateStoreStatus($id);

        $store = Store::with('StoreAddedCoupons','StoreOrders','StoreAddedCustomInformations')->where('id' , $id)->first();
        return view('pages.stores.player_report.index', ['store'=>$store]);
    }
    public function individual_player($id){

        $order = StoreOrder::where('order_no', $id)->with('StatusDetails', 'ShipmentDetails', 'paymentDetails', 'OrderItems', 'CustomerDetails', 'OrderReceipts', 'couponDetails')->first();
        $store = Store::where('id' , $order->store_id)->first();
        $sizes = Size::where('active', 1)->get();
        $store_order_statuses = StoreOrderStatus::where('active', 1)->get();
        $storeProducts = StoreProduct::with('images')->where('store_id', $order->store_id)->where('active', 1)->get();
        $addedShippingMethods = StoreAddedShippingMethod::where('store_id', $order->store_id)->pluck('shipping_method')->toArray();
        $shippingMethods = StoreShippingMethod::whereIn('id', $addedShippingMethods)->get();
        if (!empty($order->system_order_no)) {
            $TSRorder = Order::where('order_no', $order->system_order_no)->first() ?? null;
        }else{
            $TSRorder = null;
        }

        $is_sub_team_added = false;
        $subTeamArray = [];

        $customInfoDetails = StoreAddedCustomInformation::with('storeCustomInformationsDetails')
            ->where('store_id', $order->store_id)
            ->get();

        foreach ($customInfoDetails as $customInfo) {
            if ($customInfo->storeCustomInformationsDetails->make_as_sub_team == 1) {
                $is_sub_team_added = true;
                $subTeamArray = json_decode($customInfo->storeCustomInformationsDetails->options, true);
                break;
            }
        }

        return view('pages.stores.player_report.individual_player', ['order'=>$order, 'store'=>$store, 'sizes'=>$sizes, 'store_order_statuses'=>$store_order_statuses, 'storeProducts'=>$storeProducts, 'TSRorder'=>$TSRorder, 'shippingMethods'=>$shippingMethods, 'is_sub_team_added'=>$is_sub_team_added, 'subTeamArray'=>$subTeamArray]);
    }
    public function customer_order_view($id){

        $order = StoreOrder::where('order_no', $id)->with('StatusDetails', 'ShipmentDetails', 'paymentDetails', 'OrderItems', 'CustomerDetails', 'OrderReceipts', 'couponDetails')->first();
        $store = Store::where('id' , $order->store_id)->first();
        $sizes = Size::where('active', 1)->get();
        $store_order_statuses = StoreOrderStatus::where('active', 1)->get();
        $storeProducts = StoreProduct::with('images')->where('store_id', $order->store_id)->where('active', 1)->get();
        $addedShippingMethods = StoreAddedShippingMethod::where('store_id', $order->store_id)->pluck('shipping_method')->toArray();
        $shippingMethods = StoreShippingMethod::whereIn('id', $addedShippingMethods)->get();
        if (!empty($order->system_order_no)) {
            $TSRorder = Order::where('order_no', $order->system_order_no)->first() ?? null;
        }else{
            $TSRorder = null;
        }

        return view('pages.stores.player_report.customer_order_view', ['order'=>$order, 'store'=>$store, 'sizes'=>$sizes, 'store_order_statuses'=>$store_order_statuses, 'storeProducts'=>$storeProducts, 'TSRorder'=>$TSRorder, 'shippingMethods'=>$shippingMethods]);
    }
    public function individual_item($id){

        $this->updateStoreStatus($id);

        $orders = StoreOrderPlayerDetail::where('id', $id)->with('StatusDetails', 'ShipmentDetails', 'paymentDetails', 'OrderItems')->get();
        $store = Store::where('id' , $orders->first()->store_id)->first();
        $sizes = Size::where('active', 1)->get();
        $store_order_statuses = StoreOrderStatus::where('active', 1)->get();

        return view('pages.stores.product_report.individual_player', ['orders'=>$orders, 'store'=>$store, 'sizes'=>$sizes, 'store_order_statuses'=>$store_order_statuses]);
    }
    public function packing_slip($id){

        $this->updateStoreStatus($id);

        $store = Store::with('StoreAddedShippingMethods')->where('id' , $id)->first();
        $order_start_date = StoreOrder::where('store_id', $id)->where('active', 1)->where('is_payment_success', 1)->min('created_at');
        $order_end_date = Carbon::now();

        return view('pages.stores.packing_slip.index', ['store'=>$store, 'order_start_date'=>$order_start_date, 'order_end_date'=>$order_end_date]);
    }
    public function store_shipping($id){

        $this->updateStoreStatus($id);

        $store = Store::where('id' , $id)->first();

        $shipments = StoreShipment::where('store_id' , $id)->get();

        return view('pages.stores.shipping.index', ['store'=>$store, 'shipments'=>$shipments]);
    }
    public function name_not_for_printing($id){

        $this->updateStoreStatus($id);

        $store = Store::where('id' , $id)->first();

        $notForPrintingProductIDs = StoreIndividualName::where('store_id', $id)->where('name_not_for_printing', 1)->pluck('store_product_id')->toArray();
        $orderItems = StoreOrderItem::with('productDetails', 'OrderItemDetails', 'orderDetails')
            ->where('store_id', $id)
            ->whereIn('store_product_id', $notForPrintingProductIDs)
            ->get();

        return view('pages.stores.name_not_for_printing.index', ['store'=>$store, 'orderItems'=>$orderItems]);
    }
    public function save_name_not_for_printing(Request $request)
    {
        $detailId = $request->input('detail_id');
        $custom_number = $request->input('custom_number');

        $storeOrderItemDetail = StoreOrderPlayerDetail::find($detailId);
        if (!$storeOrderItemDetail) {
            return response()->json(['success' => false, 'message' => 'Order item detail not found.']);
        }

        $storeOrderItemDetail->player_number = $custom_number;
        $storeOrderItemDetail->save();

        return response()->json(['success' => true, 'message' => 'Custom number updated successfully.']);
    }
    public function accounting_report($id){

        $this->updateStoreStatus($id);

        $store = Store::where('id' , $id)->first();

        $store_orders = StoreOrder::with('OrderItems')
            ->where('store_id', $id)
            ->where('active', 1)
            ->where('is_payment_success', 1)
            ->get();

        $orderItems = $store_orders->pluck('OrderItems')->flatten();

        $FundraisingSumArray = $orderItems->map(function ($item) {
            $fundraisingSum = 0;

            if (!empty($item->productDetails->priceAdditions)) {
                foreach ($item->productDetails->priceAdditions as $addition) {
                    if (!empty($addition['is_fundraising']) && $addition['is_fundraising'] == 1) {
                        $fundraisingSum += (float)$addition['addition_amount'];
                    }
                }
            }

            return [
                'order_item_id'      => $item['id'],
                'qty'                => $item['qty'],
                'sum_of_fundraising' => $fundraisingSum,
                'total_fundraising' => $fundraisingSum * $item['qty'],
            ];
        })->toArray();

        $totalFundraising = collect($FundraisingSumArray)->sum('total_fundraising');

        return view('pages.stores.accounting_report.index', ['store'=>$store, 'totalFundraising' => $totalFundraising,]);
    }
    public function fundraising_report($id)
    {
        $this->updateStoreStatus($id);

        $store = Store::with('themeDetails', 'StoreOrders')
            ->where('id', $id)
            ->first();

        $store_orders = StoreOrder::with('OrderItems')
            ->where('store_id', $id)
            ->where('active', 1)
            ->where('is_payment_success', 1)
            ->get();

        $orderItems = $store_orders->pluck('OrderItems')->flatten();

        $FundraisingSumArray = $orderItems->map(function ($item) {
            $fundraisingSum = 0;

            if (!empty($item->productDetails->priceAdditions)) {
                foreach ($item->productDetails->priceAdditions as $addition) {
                    if (!empty($addition['is_fundraising']) && $addition['is_fundraising'] == 1) {
                        $fundraisingSum += (float)$addition['addition_amount'];
                    }
                }
            }

            return [
                'order_item_id'      => $item['id'],
                'qty'                => $item['qty'],
                'sum_of_fundraising' => $fundraisingSum,
                'total_fundraising' => $fundraisingSum * $item['qty'],
            ];
        })->toArray();

        $totalFundraising = collect($FundraisingSumArray)->sum('total_fundraising');

        return view('pages.stores.fundraising_report.index', [
            'store' => $store,
            'totalFundraising' => $totalFundraising,
        ]);
    }
    public function receipts($id){

        $this->updateStoreStatus($id);

        $store = Store::with('themeDetails')->where('id' , $id)->first();

        return view('pages.stores.receipts.index', ['store'=>$store]);
    }
    public function save_store_flyer(Request $request){

        $flyer_saved = StoreFlyer::where('store_id', $request->store_id)->first();

        if($flyer_saved){
            $flyer = $flyer_saved;
        }else{
            $flyer = new StoreFlyer();
        }

        $flyer->store_id = $request->store_id;
        $flyer->flyer_name = $request->name;
        $flyer->email = $request->email;
        $flyer->phone_number = $request->phoneNumber;
        $flyer->website = $request->website;
        // $flyer->flyer_url = $request->flyerUrl;
        $flyer->layout_type = $request->layoutType;
        $flyer->logo_size = $request->logoSize;
        $flyer->flyer_message = $request->flyerMsg;
        $flyer->show_instructions = 1;
        $flyer->show_prices = $request->has('price') ? 1 : 0;
        $flyer->show_description = $request->has('description') ? 1 : 0;
        $flyer->include_ship_date = $request->has('shipDate') ? 1 : 0;
        $flyer->include_store_deadline = $request->has('storeDeadline') ? 1 : 0;
        $flyer->include_qr_code = $request->has('qrCode') ? 1 : 0;
        $flyer->save();

        return redirect()->back();

    }

    public function download_store_flyer(Request $request)
    {
        $store = Store::with('flyerDetails', 'themeDetails', 'StoreAddedProducts')
            ->where('id', $request->store_id)
            ->first();

        // Convert logos and banners to base64 (so Dompdf can render them)
        $store->themeDetails->primary_logo = $this->encodeToBase64($store->themeDetails->primary_logo ?? 'assets/img/teamStore/logo_dark.png');
        $store->themeDetails->store_banner = $this->encodeToBase64($store->themeDetails->store_banner ?? 'assets/img/teamStore/banner_img_2.jpg');

        foreach ($store->StoreAddedProducts as $product) {
            $img = $product->images->first();

            if ($img) {
                $img->url = $this->encodeToBase64($img->url);
            } else {
                $product->images = collect([
                    (object)['url' => $this->encodeToBase64('assets/img/products/default-loading.gif')]
                ]);
            }
        }

        // Generate QR code
        $qrCodeUrl = "https://encr.shop/{$store->direct_access_url}";
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($qrCodeUrl)
            ->encoding(new Encoding('UTF-8'))
            ->size(200)
            ->margin(10)
            ->build();

        $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($result->getString());

        // Determine whether to download
        $is_download = $request->has('is_download');

        if ($is_download) {
            // ✅ Pass array instead of object
            $pdf = Pdf::loadView('pages.stores.flyer.flyer_pdf', [
                'store' => $store,
                'qrCodeBase64' => $qrCodeBase64,
            ])->setOptions([
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
            ]);

            $pdf->setPaper('A4', 'portrait');

            $fileName = 'store_flyer_' . $store->id . '.pdf';
            return $pdf->download($fileName);
        }

        return view('pages.stores.flyer.flyer_pdf', [
            'store' => $store,
            'qrCodeBase64' => $qrCodeBase64,
        ]);
    }


    public function encodeToBase64($url){
        $imagePath = base_path($url);

        if (file_exists($imagePath)) {
            $imageData = file_get_contents($imagePath);
            $imageData64 = 'data:image/' . pathinfo($imagePath, PATHINFO_EXTENSION) . ';base64,' . base64_encode($imageData);
        } else {
            $imageData64 = null;
        }
        return $imageData64;
    }

    public function add_user_group_access(Request $request)
    {
        $accessToken = Str::random(60);

        $store = Store::find($request->group_access_store_id);

        if (empty($store)) {
            return redirect()->back()->with('error', 'Store not found');
        }

        $mailSent = true;

        if (isset($request->group_access_id)) {
            $isUpdated = false;
            $group_access = StoreGroupAccess::find($request->group_access_id);
            $group_access->email = $request->email;
            $group_access->store_id = $request->group_access_store_id;
            $group_access->name = $request->name;

            if (empty($group_access->token)) {
                $group_access->token = $accessToken;
                $isUpdated = true;
            }

            $group_access->active = $request->has('denied_access') ? 0 : 1;
            $group_access->save();

            if ($isUpdated) {
                $mailSent = $this->sendMailForManageGroup($request->email, $group_access->token, $store->store_name);
            }
        } else {
            $group_access = StoreGroupAccess::where('store_id', $request->group_access_store_id)
                ->where('email', $request->email)
                ->first();

            if (!$group_access) {
                $new_access = new StoreGroupAccess();
                $new_access->email = $request->email;
                $new_access->store_id = $request->group_access_store_id;
                $new_access->name = $request->name;
                $new_access->token = $accessToken;
                $new_access->active = $request->has('denied_access') ? 0 : 1;
                $new_access->save();

                $mailSent = $this->sendMailForManageGroup($request->email, $new_access->token, $store->store_name);
            }
        }

        if ($mailSent) {
            return redirect()->back()->with('success', 'Group access updated and email sent!');
        } else {
            return redirect()->back()->with('error', 'Group access updated, but failed to send email.');
        }
    }


    public function remove_user_group_access(Request $request){

        $group_access = StoreGroupAccess::find($request->group_access_id);

        if($group_access){
            $group_access->delete();
            return response()->json(['status' => 'success', 'message' => 'User access removed successfully.']);
        }else{
            return response()->json(['status' => 'error', 'message' => 'User access not found.'], 404);
        }

    }
    public function save_shipping_details(Request $request){

        $order = StoreOrder::where('order_no',$request->order_no)->first();

        $orderChangeNotes = [];
        $itemChangeLog = []; // ==== NEW: unified list of item-level changes for the email table ====

        if($order){
            $originalShipping = (float) $order->shipping;
            $originalIsShippingRemoved = (int) $order->is_shipping_removed;

            $order->email= $request->email;
            $order->phone= $request->phone;
            $order->first_name= $request->first_name;
            $order->last_name= $request->last_name;
            $order->street= $request->street;
            $order->city= $request->city;
            $order->state= $request->state;
            $order->postal_code= $request->postal_code;
            $order->country= $request->country;
            $order->tracking_no= $request->tracking_no;
            $order->tracking_link= $request->tracking_link;
            $order->notes= $request->note;
            $order->shipping_method = $request->shipping_method;
            if($request->has('order')){
                $order->sub_total= $request->input('order')['sub_total'];
                $order->shipping= $request->input('order')['shipping'];
                $order->handling_fee= $request->input('order')['handling_fee'];
                $order->sales_tax= $request->input('order')['sales_tax'];
                $order->total= $request->input('order')['grand_total'];
            }
            $order->is_shipping_removed = $request->input('is_shipping_removed');
            $order->save();

            $newIsShippingRemoved = (int) $order->is_shipping_removed;
            $newShipping = (float) $order->shipping;

            if ($originalIsShippingRemoved !== $newIsShippingRemoved) {
                if ($newIsShippingRemoved === 1) {
                    $orderChangeNotes[] = 'Shipping fee removed (was $' . number_format($originalShipping, 2) . ').';
                } else {
                    $orderChangeNotes[] = 'Shipping fee added ($' . number_format($newShipping, 2) . ').';
                }
            } elseif (round($originalShipping, 2) !== round($newShipping, 2)) {
                $orderChangeNotes[] = 'Shipping fee changed from $' . number_format($originalShipping, 2) . ' to $' . number_format($newShipping, 2) . '.';
            }
        }

        $removedItemsLog = [];

        if($request->has('deleted_items') && count($request->input('deleted_items')) > 0){

            $recordsForDelete = StoreOrderPlayerDetail::with('SizeDetails')->whereIn('id', $request->deleted_items)->get();
            if ($recordsForDelete->count() > 0) {
                foreach ($recordsForDelete as $record) {

                    $storeOrderItem = StoreOrderItem::with('productDetails.images')->find($record->store_order_item_id);
                    $product = $storeOrderItem ? $storeOrderItem->productDetails : null;
                    $productName = $product->product_name ?? 'Unknown Product';

                    $imageUrl = ($product && $product->images->first())
                        ? asset($product->images->first()->url)
                        : asset('public/images/default.png');

                    $removedItemsLog[] = [
                        'product_name'  => $productName,
                        'image_url'     => $imageUrl,
                        'size'          => optional($record->SizeDetails)->size_name,
                        'qty'           => $record->qty,
                        'player_name'   => $record->player_name,
                        'player_number' => $record->player_number,
                    ];

                    // ==== NEW ====
                    $itemChangeLog[] = [
                        'type' => 'removed',
                        'product_name' => $productName,
                        'qty' => $record->qty,
                    ];
                    // ==== END NEW ====

                    $record->delete();
                }
            }
        }

        $changedItemIds = [];

        if ($request->has('players') && count($request->input('players')) > 0) {
            foreach ($request->input('players') as $key => $value) {

                    $player_details = StoreOrderPlayerDetail::find($key);
                    $storeOrderItem = StoreOrderItem::with('productDetails')->where('id', $player_details->store_order_item_id)->first();

                    $tsrOrderItemFound = false;
                    if ($storeOrderItem && !empty($storeOrderItem->system_order_reference)) {
                        $tsrOrderItemFound = true;
                    }

                    if ($player_details) {

                        // ==== NEW: snapshot the old qty before it gets overwritten ====
                        $oldQty = (int) $player_details->qty;
                        // ==== END NEW ====

                        $player_details->size = $value['size'];
                        $player_details->item_status = $value['status'];

                        $player_details->player_name = (isset($value['name']) && $value['name'] !== 'null') ? $value['name'] : NULL;
                        $player_details->player_number = isset($value['number']) ? $value['number'] : NULL;

                        $player_details->sub_team = isset($value['sub_team']) ? $value['sub_team'] : NULL;

                        $player_details->is_name_available = isset($value['name']) ? 1 : 0;
                        $player_details->is_number_available = isset($value['number']) ? 1 : 0;

                        $player_details->qty = $value['qty'];
                        if(isset($value['unit_price'])){
                            $player_details->unit_price = $value['unit_price'];
                        }
                        $player_details->total_amount = $value['total'];
                        $player_details->save();

                        $changes = $player_details->getChanges();
                        unset($changes['updated_at']);

                        if (!empty($changes)) {
                            $changedItemIds[$player_details->store_order_item_id] = true;

                            // ==== NEW: ====
                            $newQty = (int) $player_details->qty;
                            if ($oldQty !== $newQty) {
                                $itemChangeLog[] = [
                                    'type' => 'updated',
                                    'product_name' => $storeOrderItem->productDetails->product_name ?? 'Unknown Product',
                                    'old_qty' => $oldQty,
                                    'new_qty' => $newQty,
                                ];
                            }
                            // ==== END NEW ====
                        }

                        StoreOrderItem::where('id', $player_details->store_order_item_id)->update([
                            'store_product_id' => $value['product_id'],
                            'is_updated' => $tsrOrderItemFound ? 1 : 0,
                        ]);
                    }
            }

        }

        $addedItemIds = [];

        if ($request->has('new_players') && count($request->input('new_players')) > 0) {
            foreach ($request->input('new_players') as $key => $value) {

                $store_order_item = new StoreOrderItem();
                $store_order_item->store_order_id = $order->id;
                $store_order_item->store_product_id = $value['product_id'];
                $store_order_item->store_id = $order->store_id;
                $store_order_item->qty = $value['qty'];
                $store_order_item->save();

                if ($store_order_item->wasRecentlyCreated) {
                    $addedItemIds[$store_order_item->id] = true;

                    // ==== NEW ====
                    $addedProduct = StoreProduct::find($value['product_id']);
                    $itemChangeLog[] = [
                        'type' => 'added',
                        'product_name' => $addedProduct->product_name ?? 'Unknown Product',
                        'qty' => $value['qty'],
                    ];
                    // ==== END NEW ====
                }

                $store_order_item_id = $store_order_item->id;

                $player_details = new StoreOrderPlayerDetail();
                $player_details->store_order_item_id = $store_order_item_id;
                $player_details->store_id = $order->store_id;
                $player_details->store_product_id = $value['product_id'];
                $player_details->is_name_available = isset($value['name']) ? 1 : 0;
                $player_details->is_number_available = isset($value['number']) ? 1 : 0;
                $player_details->size = $value['size'];
                $player_details->item_status = $value['status'];
                if (isset($value['name']) && $value['name'] !== 'null') {
                    $player_details->player_name = $value['name'] ?? NULL;
                }
                if (isset($value['number']) && $value['number'] !== 'null') {
                    $player_details->player_number = $value['number'] ?? NULL;
                }
                if(isset($value['sub_team']) && $value['sub_team'] !== 'null'){
                    $player_details->sub_team = $value['sub_team'] ?? NULL;
                }
                $player_details->qty = $value['qty'];
                $player_details->total_amount = $value['total'];
                $player_details->unit_price = $value['unit_price'];
                $player_details->paid_amount = 0.00;
                $player_details->save();
            }

        }

        $storeOrderItems = StoreOrderItem::where('store_order_id', $order->id)->get();

        foreach ($storeOrderItems as $storeOrderItem) {
            $qty = StoreOrderPlayerDetail::where('store_order_item_id', $storeOrderItem->id)->sum('qty');
            $storeOrderItem->qty = $qty;
            $storeOrderItem->save();

            if($qty == 0){
                $storeOrderItem->delete();
            }
        }

        $storeOrder = StoreOrder::with('OrderItems', 'CustomerDetails', 'paymentDetails')->where('order_no',$request->order_no)->first();

        $orderData = [];

        foreach ($storeOrder->OrderItems as $orderItem) {
            $product = $orderItem->productDetails;

            $qty = $orderItem->qty;
            $price = $product->default_price;
            $total_price = $qty * $price;

            $itemSizes = [];
            $itemDetails = StoreOrderPlayerDetail::with('SizeDetails')->where('store_order_item_id', $orderItem->id)->get();
            foreach ($itemDetails as $detail) {
                $itemSizes[$detail->id]['size'] = $detail->SizeDetails->size_name;
                $itemSizes[$detail->id]['qty'] = $detail->qty;
                $itemSizes[$detail->id]['player_name'] = $detail->player_name ?? '';
                $itemSizes[$detail->id]['player_number'] = $detail->player_number ?? '';
                $itemSizes[$detail->id]['sub_team'] = $detail->sub_team ?? '';
            }

            $image_url = $product->images->first()
                ? asset($product->images->first()->url)
                : asset('public/images/default.png');

            $orderData['order_items'][] = [
                'qty' => $qty,
                'product_name' => $product->product_name,
                'image_url' => $image_url,
                'price' => $price,
                'total_price' => $total_price,
                'item_sizes' => $itemSizes,
            ];
        }

        $pending = $this->getPendingChanges($storeOrder->store_id, $storeOrder->order_no);

        $orderChangeNotes = array_merge($pending['order_change_notes'], $orderChangeNotes);
        $itemChangeLog    = array_merge($pending['item_change_log'], $itemChangeLog);
        $removedItemsLog  = array_merge($pending['removed_items'], $removedItemsLog);

        $orderData['order_details'] = [
                'sub_total' => $order->sub_total,
                'shipping' => $order->shipping,
                'handling_fee' => $order->handling_fee,
                'sales_tax' => $order->sales_tax,
                'total' => $order->total,
                'paid_invoice_amount' => $order->paid_invoice_amount,
                'paid_processing_fee' => $order->paid_processing_fee,
                'paid_amount' => $order->paid_amount,
                'is_shipping_removed' => (bool) $order->is_shipping_removed,
                'removed_items' => $removedItemsLog,
                'order_change_notes' => $orderChangeNotes,
                'item_change_log' => $itemChangeLog, // ==== NEW: unified add/remove/update list ====
                'notes' => $order->notes,
                'tracking_no' => $order->tracking_no,
                'tracking_link' => $order->tracking_link,
                'order_discount' => $order->discount,
                'coupon_code' => $order->coupon_code,
                'coupon_details' => $order->coupon_code ? StoreCoupon::where('store_id', $order->store_id)->where('coupon_code', $order->coupon_code)->first() : null,
            ];

        $orderData['shipping_details'] = [
                'first_name' => $order->first_name,
                'last_name' => $order->last_name,
                'street' => $order->street,
                'city' => $order->city,
                'state' => $order->state,
                'postal_code' => $order->postal_code,
                'country' => $order->country,
                'phone' => $order->phone,
                'email' => $order->email,
                'shipping_method' => $order->shippingMethodDetails ? $order->shippingMethodDetails->shipping_method_name : 'Direct Ship to Customers',
            ];

        if(!empty($order->CustomerDetails)){

            $orderData['customer_details'] = [
                    'first_name' => $order->CustomerDetails->first_name,
                    'last_name' => $order->CustomerDetails->last_name,
                    'street' => $order->CustomerDetails->street,
                    'city' => $order->CustomerDetails->city,
                    'state' => $order->CustomerDetails->state,
                    'postal_code' => $order->CustomerDetails->postal_code,
                    'country' => $order->CustomerDetails->country,
                    'phone' => $order->CustomerDetails->phone_number,
                    'email' => $order->CustomerDetails->email,
                ];

        }

        $receipt = new StoreOrderReceipt();
        $receipt->store_id = $storeOrder->store_id;
        $receipt->store_order_no = $storeOrder->order_no;
        $receipt->order_items = isset($orderData['order_items']) ? json_encode($orderData['order_items']) : NULL;
        $receipt->order_details = json_encode($orderData['order_details']);
        $receipt->shipping_details = json_encode($orderData['shipping_details']);
        $receipt->customer_details = isset($orderData['customer_details']) ? json_encode($orderData['customer_details']) : null;
        $receipt->save();


        if($request->has('send_email_notification') && $request->input('send_email_notification') == 1){
            $this->emailEditOrderReceipt([
                'order_id' => $storeOrder->id,
                'store_id' => $storeOrder->store_id,
                'customer_id' => $storeOrder->CustomerDetails->id ?? null,
                'receipt_id' => $receipt->id,
            ]);
        }
        

        return redirect()->back();

    }

    public function emailEditOrderReceipt($receiptData)
    {
        $storeOrder = StoreOrder::find($receiptData['order_id']);
        $store = Store::with('themeDetails')->find($receiptData['store_id']);
        $customer = StoreCustomer::find($receiptData['customer_id']);

        if (!$storeOrder || !$store || !$customer) {
            return false;
        }

        $receipt = StoreOrderReceipt::find($receiptData['receipt_id']);

        if (!$receipt) {
            return false;
        }

        $receipt->order_items = $receipt->order_items ? json_decode($receipt->order_items, true) : [];
        $receipt->order_details = json_decode($receipt->order_details, true);
        $receipt->shipping_details = json_decode($receipt->shipping_details, true);
        $receipt->customer_details = $receipt->customer_details ? json_decode($receipt->customer_details, true) : null;

        $removedItems = $receipt->order_details['removed_items'] ?? [];
        $orderChangeNotes = $receipt->order_details['order_change_notes'] ?? [];
        $itemChangeLog = $receipt->order_details['item_change_log'] ?? [];

        $paymentCard = StoreCardPayment::where('store_order_no', $receipt->store_order_no)->latest('id')->first();

        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_edit_order_receipt', [
            'custom_email' => $customer->email,
            'store' => $store,
            'order_no' => $receipt->store_order_no,
            'receipt' => $receipt,
            'removed_items' => $removedItems,
            'paymentCard' => $paymentCard,
            'order_change_notes' => $orderChangeNotes,
            'item_change_log' => $itemChangeLog,
        ]);

        
        StoreOrderReceipt::where('id', $receipt->id)->update(['is_sent' => 1]);

        return true;
    }

    public function download_order_receipt(Request $request)
    {
        if (!$request->has('receipt_id')) {
            return response()->json(['error' => 'No receipt ID provided.'], 400);
        }

        $receipts = [];

        $receipt = StoreOrderReceipt::where('id', $request->receipt_id)->first();

        if (!$receipt) {
            return response()->json(['error' => 'Receipt not found.'], 404);
        }

        $receipt->order_items = json_decode($receipt->order_items, true);
        $receipt->order_details = json_decode($receipt->order_details, true);
        $receipt->shipping_details = json_decode($receipt->shipping_details, true);
        $receipt->customer_details = $receipt->customer_details ? json_decode($receipt->customer_details, true) : null;

        // ==== NEW: attach the payment card that was current for this receipt, matching the email templates ====
        $receipt->paymentCard = StoreCardPayment::where('store_order_no', $receipt->store_order_no)
            ->where('created_at', '<=', $receipt->created_at)
            ->latest('id')
            ->first();
        // ==== END NEW ====

        $receipts[] = $receipt;

        $store = Store::with('themeDetails', 'StoreOrders.OrderItems.OrderItemDetails.SizeDetails.storeExtraSizeDetails', 'StoreOrders.OrderItems.productDetails.images')
            ->where('id', $request->store_id)
            ->first();

        if (!$store) {
            return response()->json(['error' => 'Store not found.'], 404);
        }

        $pdf = Pdf::loadView('pages.stores.receipts.order_receipts', compact('store', 'receipts'));

        $pdfOutput = $pdf->output();
        $fileName = 'receipt_' . $receipt->id . '.pdf';

        return response($pdfOutput, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "attachment; filename=\"$fileName\"");
    }

    public function get_store_orders(Request $request)
    {
        $storeOrders = StoreOrder::with('receipts')->where('store_id', $request->store_id)
            ->where('active', 1)
            ->where('is_payment_success', 1)
            ->get();

        return response()->json($storeOrders);
    }
    public function get_filtered_store_orders(Request $request)
    {

        $query = StoreOrder::where('store_id', $request->store_id)
            ->where('active', 1)
            ->where('is_payment_success', 1);

        if ($request->has('from_date') && $request->has('to_date')) {
            $fromDate = \Carbon\Carbon::createFromFormat('m/d/Y', $request->from_date)->startOfDay();
            $toDate   = \Carbon\Carbon::createFromFormat('m/d/Y', $request->to_date)->endOfDay();

            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }

        if ($request->has('sort_by')) {
            $query->orderBy($request->sort_by, 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $storeOrders = $query->get();

        return response()->json($storeOrders);
    }

    public function get_store_payments(Request $request)
    {
        if (!$request->has('store_id')) {
            return response()->json(['error' => 'Store ID is required'], 400);
        }
        if ($request->has('payment_type') && $request->payment_type != 'all') {
            if($request->payment_type == 'payment'){
                $storePayments = StoreCardPayment::with('OrderDetails')->where('store_id', $request->store_id)->where('is_refund', 0)->get();
            }elseif($request->payment_type == 'refund'){
                $storePayments = StoreCardPayment::with('OrderDetails')->where('store_id', $request->store_id)->where('is_refund', 1)->get();
            }
        }else{
            $storePayments = StoreCardPayment::with('OrderDetails')->where('store_id', $request->store_id)->get();
        }

        return response()->json($storePayments);
    }

    public function download_order_receipt_all(Request $request)
    {
        $order_nos = $request->input('order_numbers', []);

        if (empty($order_nos)) {
            return redirect()->back()->withErrors(['No receipts selected for download.']);
        }

        $store = Store::with('themeDetails')->findOrFail($request->store_id);

        $receipts = [];

        foreach ($order_nos as $order_no) {
            $receipt = StoreOrderReceipt::where('store_order_no', $order_no)->last();

            if ($receipt) {
                $receipt->order_items = json_decode($receipt->order_items, true);
                $receipt->order_details = json_decode($receipt->order_details, true);
                $receipt->shipping_details = json_decode($receipt->shipping_details, true);
                $receipt->customer_details = $receipt->customer_details ? json_decode($receipt->customer_details, true) : null;

                // ==== NEW: ====
                $receipt->paymentCard = StoreCardPayment::where('store_order_no', $receipt->store_order_no)
                    ->where('created_at', '<=', $receipt->created_at)
                    ->latest('id')
                    ->first();
                // ==== END NEW ====

                $receipts[] = $receipt;
            }
        }

        $store = Store::with('themeDetails', 'StoreOrders.OrderItems.OrderItemDetails.SizeDetails.storeExtraSizeDetails', 'StoreOrders.OrderItems.productDetails.images')
            ->where('id', $request->store_id)
            ->first();

        if (!$store) {
            abort(404, 'Store not found');
        }

        $pdf = Pdf::loadView('pages.stores.receipts.order_receipts', compact('store','receipts'));

        $fileName = 'receipts' . $store->id . '.pdf';

        return $pdf->download($fileName);
    }

    public function get_store_orders_for_packing_slip(Request $request)
    {
        $start_date = \Carbon\Carbon::parse($request->start_date)->startOfDay();
        $end_date   = \Carbon\Carbon::parse($request->end_date)->endOfDay();
        $filterBy = $request->filter_by ?? 1;
        $shippingMethod = $request->shipping_method ?? 0;

        $storeOrdersQuery = StoreOrder::with('OrderItems', 'CustomerDetails', 'ShipmentDetails', 'StatusDetails')
            ->where('store_id', $request->store_id)
            ->where('active', 1)
            ->where('is_payment_success', 1)
            ->whereBetween('created_at', [$start_date, $end_date]);

        if (isset($shippingMethod) && $shippingMethod != 0) {
            $storeOrdersQuery->where('shipping_method', $shippingMethod);
        }

        if (isset($filterBy) && $filterBy != 0) {
            if ($filterBy == 1) {
                $storeOrdersQuery->orderBy('id', 'asc');
            } elseif ($filterBy == 2) {
                $storeOrdersQuery->orderBy('id', 'desc');
            } elseif ($filterBy == 3) {
                $storeOrdersQuery->orderBy('created_at', 'asc');
            } elseif ($filterBy == 4) {
                $storeOrdersQuery->orderBy('created_at', 'desc');
            }
            // elseif ($filterBy == 5) {
            //     $storeOrdersQuery->orderBy(
            //         StoreCustomer::select('first_name')
            //             ->whereColumn('customers.id', 'store_orders.customer_id'),
            //         'desc'
            //     );
            // }
        }

        $storeOrders = $storeOrdersQuery->get();

        return response()->json($storeOrders);
    }
    public function manage_your_group(Request $request)
    {
        $group_user = StoreGroupAccess::where('token', $request->token)->first();

        if (!$group_user) {
            return view('pages.stores.manage_group.not_found');
        }

        $store = Store::with('themeDetails')->find($group_user->store_id);

        if ($group_user->active == 0) {
            return view('pages.stores.manage_group.not_found', [
                'store' => $store,
                'teamStore' => $store->themeDetails,]);
        }
        $store_orders = StoreOrder::with('OrderItems')
            ->where('store_id', $store->id)
            ->where('active', 1)
            ->where('is_payment_success', 1)
            ->get();

        $orderItems = $store_orders->pluck('OrderItems')->flatten();

        $FundraisingSumArray = $orderItems->map(function ($item) {
            $fundraisingSum = 0;

            if (!empty($item->productDetails->priceAdditions)) {
                foreach ($item->productDetails->priceAdditions as $addition) {
                    if (!empty($addition['is_fundraising']) && $addition['is_fundraising'] == 1) {
                        $fundraisingSum += (float)$addition['addition_amount'];
                    }
                }
            }

            return [
                'order_item_id'      => $item['id'],
                'qty'                => $item['qty'],
                'sum_of_fundraising' => $fundraisingSum,
                'total_fundraising' => $fundraisingSum * $item['qty'],
            ];
        })->toArray();

        $totalFundraising = collect($FundraisingSumArray)->sum('total_fundraising');

        $customerOrders = StoreOrder::with('OrderItems', 'shippingMethodDetails')->get();

        $memberCount = StoreGroupAccess::where('store_id', $group_user->store_id)->where('active', 1)->count();

        $customerOrders = $customerOrders->where('store_id', $group_user->store_id)->where('active', 1)->where('is_payment_success', 1);

        $is_sub_team_added = false;
        $subTeamArray = [];

        $customInfoDetails = StoreAddedCustomInformation::with('storeCustomInformationsDetails')
            ->where('store_id', $group_user->store_id)
            ->get();

        foreach ($customInfoDetails as $customInfo) {
            if ($customInfo->storeCustomInformationsDetails->make_as_sub_team == 1) {
                $is_sub_team_added = true;
                $subTeamArray = json_decode($customInfo->storeCustomInformationsDetails->options, true);
                break;
            }
        }

        return view('pages.stores.manage_group.customer_view', [ 'group_user' => $group_user, 'store' => $store, 'customerOrders' => $customerOrders, 'memberCount' => $memberCount, 'totalFundraising' => $totalFundraising, 'is_sub_team_added' => $is_sub_team_added, 'subTeamArray' => $subTeamArray]);

    }
    public function sendMailForManageGroup($email, $token, $store_name)
    {
        if (empty($email) || empty($token)) {
            return false;
        }

   
        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_manage_group_access', [
            'custom_email' => $email,
            'store_name'   => $store_name,
            'manage_link'  => route('store.manage_your_group', ['token' => $token]) . '#orders',
        ]);

        return true;
       
    }

    public function get_coupon_details(Request $request)
    {
        $coupons = StoreCoupon::where('coupon_code', $request->coupon_code)->where('active', 1)->get();

        if($coupons->count() > 0){
            $couponOnStore = $coupons->where('store_id', $request->store_id)->first();
            if($couponOnStore){
                $couponUsedCount = StoreOrder::where('store_id', $request->store_id)->where('coupon_code', $couponOnStore->coupon_code)->where('active', 1)->where('is_payment_success', 1)->count();
                if($couponOnStore->limit_coupon_usage == 1 && $couponOnStore->coupon_valid_times > 0 && $couponUsedCount >= $couponOnStore->coupon_valid_times){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Coupon usage limit exceeded'
                    ], 404);
                }else if($couponOnStore->expire_date && Carbon::now()->greaterThan(Carbon::parse($couponOnStore->expire_date))){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Coupon has expired'
                    ], 404);
                }else{
                    return response()->json([
                        'status' => 'success',
                        'data' => $couponOnStore
                    ]);
                }


            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Coupon not valid in this store'
                ], 404);
            }
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Coupon not found'
            ], 404);
        }
    }

    public function updateStoreStatusEmailSettings(Request $request)
    {
        $store = Store::find($request->store_id);

        if (!$store) {
            return redirect()->back()->withErrors(['Store not found.']);
        }

        $store->send_closing_soon_email = $request->has('send_closing_soon_email') ? 1 : 0;
        $store->send_store_close_email = $request->has('send_store_close_email') ? 1 : 0;
        $store->send_order_production_completed_email = $request->has('send_order_production_completed_email') ? 1 : 0;
        $store->send_final_update_email = $request->has('send_final_update_email') ? 1 : 0;
        $store->save();

        return redirect()->back()->with('success', 'Store email notification settings updated successfully.');
    }
    public function downloadProductReport(Request $request)
    {
        $store = Store::with('StoreOrders.OrderItems.OrderItemDetails.SizeDetails.storeExtraSizeDetails', 'StoreOrders.OrderItems.productDetails.images', 'themeDetails')
            ->where('id', $request->store_id)
            ->first();

        if (!$store) {
            return response()->json(['error' => 'Store not found'], 404);
        }

        $csvContent = "PRODUCT NAME,NAME,NUMBER,SIZE,QUANTITY,TOTAL AMOUNT,PAID\n";

        foreach ($store->StoreOrders as $order) {
            foreach ($order->OrderItems as $item) {
                $productName = isset($item->productDetails->product_name) ? $item->productDetails->product_name : 'N/A';

                foreach ($item->OrderItemDetails as $detail) {
                    $playerName = isset($detail->player_name) ? $detail->player_name : 'N/A';
                    $playerNumber = isset($detail->player_number) ? $detail->player_number : 'N/A';
                    $sizeName = isset($detail->SizeDetails->storeExtraSizeDetails->size_name) ? $detail->SizeDetails->storeExtraSizeDetails->size_name : (isset($detail->SizeDetails->size_name) ? $detail->SizeDetails->size_name : 'N/A');
                    $qty = isset($detail->qty) ? $detail->qty : 0;
                    $totalAmount = isset($detail->total_amount) ? $detail->total_amount : 0;
                    $paidAmount = isset($detail->paid_amount) ? $detail->paid_amount : 0;

                    $csvContent .= "\"{$productName}\",\"{$playerName}\",\"{$playerNumber}\",\"{$sizeName}\",{$qty},{$totalAmount},{$paidAmount}\n";
                }
            }
        }

        $fileName = 'product_report_' . $store->id . '.csv';
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$fileName}",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        return response($csvContent, 200, $headers);
    }
    public function downloadProductReportPDF(Request $request)
    {
        $store = Store::with('StoreOrders.OrderItems.OrderItemDetails.SizeDetails.storeExtraSizeDetails', 'StoreOrders.OrderItems.productDetails.images')
            ->where('id', $request->store_id)
            ->first();

        if (!$store) {
            abort(404, 'Store not found');
        }

        $pdf = Pdf::loadView('pages.stores.product_report.pdf', compact('store'));

        $fileName = 'product_report_' . $store->id . '.pdf';

        return $pdf->download($fileName);
    }
    public function generateStoreCSV($id)
    {
        $orderEC = Order::find($id);

        $OrderStore = StoreOrder::where('system_order_no', $orderEC->order_no)->first();

        if (!$OrderStore) {
            return redirect()->back()->with(['error' => 'This order not from TEAM STORE module.']);
        }

        $storeOrders = StoreOrder::with(
            'OrderItems.productDetails.products',
            'CustomerDetails',
            'OrderItems.OrderItemDetails.SizeDetails.storeExtraSizeDetails'
        )
        ->where('store_id', $OrderStore->store_id)
        ->where('active', 1)
        ->where('is_payment_success', 1)
        ->get();

        $playerReportData = [];
        $productReportData = [];

        $allOrderItems = $storeOrders->pluck('OrderItems')->flatten();
        $productIDs = $allOrderItems->pluck('store_product_id')->unique()->toArray();

        foreach ($productIDs as $productID) {
            $allOrderItemsForProduct = $allOrderItems->where('store_product_id', $productID);

            foreach ($allOrderItemsForProduct as $orderItem) {
                $storeOrderDetail = $storeOrders->find($orderItem->store_order_id);

                foreach ($orderItem->OrderItemDetails as $detail) {
                    $playerReportData[$productID][$detail->id] = [
                        'Billing Name'  => $storeOrderDetail->CustomerDetails->first_name . ' ' . $storeOrderDetail->CustomerDetails->last_name,
                        'Shipping Name' => $storeOrderDetail->first_name . ' ' . $storeOrderDetail->last_name,
                        'Order No'      => $storeOrderDetail->order_no,
                        'Product Name'  => $orderItem->productDetails->product_name ?? 'N/A',
                        'Player Name'   => $detail->is_name_available == 1 ? ($detail->player_name ?? '-') : '',
                        'Player Number' => $detail->is_number_available == 1 ? ($detail->player_number ?? '-') : '',
                        'Size'          => $detail->SizeDetails->storeExtraSizeDetails->size_name ?? ($detail->SizeDetails->size_name ?? 'N/A'),
                        'Quantity'      => $detail->qty ?? 0,
                    ];

                    $productReportData[$productID][$detail->id] = [
                        'Product Code'   => $orderItem->productDetails->products->sub_product_no ?? 'N/A',
                        'Product Name'   => $orderItem->productDetails->product_name ?? 'N/A',
                        'Fabric'         => $orderItem->productDetails->products->standard_fabric ?? 'N/A',
                        'Quantity'       => $detail->qty ?? 0,
                        'Size'           => $detail->SizeDetails->storeExtraSizeDetails->size_name ?? ($detail->SizeDetails->size_name ?? 'N/A'),
                        'Factory'        => 'DWC',
                    ];
                }
            }
        }

        $playerReportFlat = collect($playerReportData)->flatMap(fn($d) => $d)->values()->toArray();
        $productReportFlat = collect($productReportData)->flatMap(fn($d) => $d)->values()->toArray();

        return \Maatwebsite\Excel\Facades\Excel::download(
            new class($playerReportFlat, $productReportFlat) implements \Maatwebsite\Excel\Concerns\WithMultipleSheets {
                protected $playerReport;
                protected $productReport;

                public function __construct($playerReport, $productReport)
                {
                    $this->playerReport = $playerReport;
                    $this->productReport = $productReport;
                }

                public function sheets(): array
                {
                    return [
                        new class($this->playerReport) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithTitle, \Maatwebsite\Excel\Concerns\WithHeadings {
                            protected $data;
                            public function __construct($data) { $this->data = $data; }
                            public function array(): array { return is_array($this->data) ? $this->data : collect($this->data)->toArray(); }
                            public function title(): string { return 'PLAYER REPORT'; }
                            public function headings(): array {
                                return ['Billing Name','Shipping Name','Order No','Product Name','Player Name','Player Number','Size','Quantity'];
                            }
                        },
                        new class($this->productReport) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithTitle, \Maatwebsite\Excel\Concerns\WithHeadings {
                            protected $data;
                            public function __construct($data) { $this->data = $data; }
                            public function array(): array { return is_array($this->data) ? $this->data : collect($this->data)->toArray(); }
                            public function title(): string { return 'PRODUCT REPORT'; }
                            public function headings(): array {
                                return ['Product Code','Product Name','Fabric','Quantity','Size','Factory'];
                            }
                        },
                    ];
                }
            },
            'Store_Report_' . now()->format('Y_m_d_His') . '.xlsx'
        );
    }
    public function generateStorePlayerReportCSV(Request $request)
    {
        $id = $request->store_id;
        $storeOrders = StoreOrder::with(
            'OrderItems.productDetails.products',
            'CustomerDetails',
            'shippingMethodDetails',
            'OrderItems.OrderItemDetails.SizeDetails.storeExtraSizeDetails'
        )
        ->where('store_id', $id)
        ->where('active', 1)
        ->where('is_payment_success', 1)
        ->get();

        $playerReportData = [];

        $allOrderItems = $storeOrders->pluck('OrderItems')->flatten();

        foreach ($allOrderItems as $orderItem) {

            $storeOrderDetail = $storeOrders->find($orderItem->store_order_id);

            foreach ($orderItem->OrderItemDetails as $detail) {

                $price = $orderItem->productDetails->default_price ?? 0;
                $qty   = $detail->qty ?? 0;

                $playerReportData[] = [
                    'Order Date'        => $storeOrderDetail->created_at,
                    'Billing Name'      => $storeOrderDetail->CustomerDetails->first_name . ' ' . $storeOrderDetail->CustomerDetails->last_name,
                    'Order No'          => $storeOrderDetail->order_no,
                    'Product Name'      => $orderItem->productDetails->product_name ?? 'N/A',
                    'Size'              => $detail->SizeDetails->storeExtraSizeDetails->size_name
                                            ?? ($detail->SizeDetails->size_name ?? 'N/A'),
                    'Player Name'       => $orderItem->productDetails->set_individual_name == 1 ? ($detail->player_name ?? '-') : '',
                    'Player Number'     => $orderItem->productDetails->set_individual_number == 1 ? ($detail->player_number ?? '-') : '',
                    'Quantity'          => $qty,
                    'Order Total'       => $price * $qty,
                    'Shipping Method'   => $storeOrderDetail->shippingMethodDetails->shipping_method_name ?? 'N/A',
                    'Shipping Address'  => trim("{$storeOrderDetail->street}, {$storeOrderDetail->city}, {$storeOrderDetail->state}, {$storeOrderDetail->postal_code}, {$storeOrderDetail->country}", ", "),
                    'Payment Method'    => $storeOrderDetail->payment_method ?? 'N/A',
                    'Paid Amount'       => $price * $qty,
                ];
            }
        }

        return \Maatwebsite\Excel\Facades\Excel::download(
            new class($playerReportData) implements
                \Maatwebsite\Excel\Concerns\FromArray,
                \Maatwebsite\Excel\Concerns\WithHeadings,
                \Maatwebsite\Excel\Concerns\WithTitle
            {
                protected $data;

                public function __construct($data)
                {
                    $this->data = $data;
                }

                public function array(): array
                {
                    return $this->data;
                }

                public function headings(): array
                {
                    return [
                        'Order Date',
                        'Billing Name',
                        'Order No',
                        'Product Name',
                        'Size',
                        'Player Name',
                        'Player Number',
                        'Quantity',
                        'Order Total',
                        'Shipping Method',
                        'Shipping Address',
                        'Payment Method',
                        'Paid Amount',
                    ];
                }

                public function title(): string
                {
                    return 'PLAYER REPORT';
                }
            },
            'Player_Report_' . now()->format('Y_m_d_His') . '.csv'
        );
    }
    public function downloadPlayerCSV(Store $store)
    {
        $id = $store->id;

        $storeOrders = StoreOrder::with(
            'OrderItems.productDetails.products',
            'CustomerDetails',
            'shippingMethodDetails',
            'OrderItems.OrderItemDetails.SizeDetails.storeExtraSizeDetails'
        )
        ->where('store_id', $id)
        ->where('active', 1)
        ->where('is_payment_success', 1)
        ->get();

        $allOrderItems = $storeOrders
            ->pluck('OrderItems')
            ->flatten()
            ->sortBy('store_product_id')
            ->values();

        $playerReportData = [];

        // Map product_id => color for row backgrounds
        $productColorMap = [];
        $colorIndex = 0;
        $colorPalette = [
            'FFFF99', // yellow
            'CCFFCC', // green
            'FFCCCC', // red
            'CCE5FF', // blue
            'E0CCFF', // purple
            'FFE6CC', // orange
            'D9D9D9', // grey
        ];

        foreach ($allOrderItems as $orderItem) {
            $storeOrderDetail = $storeOrders->find($orderItem->store_order_id);
            $productId = $orderItem->store_product_id;

            if (!isset($productColorMap[$productId])) {
                $productColorMap[$productId] = $colorPalette[$colorIndex % count($colorPalette)];
                $colorIndex++;
            }

            foreach ($orderItem->OrderItemDetails as $detail) {
                $price = $orderItem->productDetails->default_price ?? 0;

                $playerReportData[] = [
                    'Detail ID'        => $detail->id,
                    'Order Date'       => $storeOrderDetail->created_at,
                    'Billing Name'     => $storeOrderDetail->CustomerDetails->first_name . ' ' . $storeOrderDetail->CustomerDetails->last_name,
                    'Order No'         => $storeOrderDetail->order_no,
                    'Product Name'     => $orderItem->productDetails->product_name ?? 'N/A',
                    'Size'             => $detail->SizeDetails->storeExtraSizeDetails->size_name
                                            ?? ($detail->SizeDetails->size_name ?? 'N/A'),
                    'Player Name'      => $orderItem->productDetails->set_individual_name == 1 ? ($detail->player_name ?? '') : '',
                    'Player Number'    => $orderItem->productDetails->set_individual_number == 1 ? ($detail->player_number ?? '') : '',
                    'Quantity'         => $detail->qty ?? 0,
                    'Order Total'      => $price * ($detail->qty ?? 0),
                    'Shipping Method'  => $storeOrderDetail->shippingMethodDetails->shipping_method_name ?? 'N/A',
                    'Shipping Address' => trim("{$storeOrderDetail->street}, {$storeOrderDetail->city}, {$storeOrderDetail->state}, {$storeOrderDetail->postal_code}, {$storeOrderDetail->country}", ", "),
                    'Payment Method'   => $storeOrderDetail->payment_method ?? 'N/A',
                    'Paid Amount'      => $price * ($detail->qty ?? 0),
                    'Product ID'       => $productId, // Used internally to map color
                ];
            }
        }

        return \Maatwebsite\Excel\Facades\Excel::download(
            new class($playerReportData, $productColorMap) implements
                \Maatwebsite\Excel\Concerns\FromArray,
                \Maatwebsite\Excel\Concerns\WithHeadings,
                \Maatwebsite\Excel\Concerns\WithTitle,
                \Maatwebsite\Excel\Concerns\WithStyles
            {
                protected $data;
                protected $rowColors;
                protected $productColorMap;

                public function __construct($data, $productColorMap)
                {
                    $this->data = $data;
                    $this->productColorMap = $productColorMap;

                    // Build rowColors by product_id
                    $this->rowColors = [];
                    foreach ($data as $i => $row) {
                        $this->rowColors[$i + 2] = $productColorMap[$row['Product ID']];
                    }
                }

                public function array(): array
                {
                    // Remove Product ID from output
                    return array_map(function ($row) {
                        unset($row['Product ID']);
                        return $row;
                    }, $this->data);
                }

                public function headings(): array
                {
                    return [
                        'Detail ID',
                        'Order Date',
                        'Billing Name',
                        'Order No',
                        'Product Name',
                        'Size',
                        'Player Name',
                        'Player Number',
                        'Quantity',
                        'Order Total',
                        'Shipping Method',
                        'Shipping Address',
                        'Payment Method',
                        'Paid Amount',
                    ];
                }

                public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
                {
                    foreach ($this->rowColors as $row => $color) {
                        $sheet->getStyle("A{$row}:N{$row}")
                            ->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB($color);
                    }

                    // Bold header
                    $sheet->getStyle('A1:N1')->getFont()->setBold(true);
                }

                public function title(): string { return 'PLAYER REPORT'; }
            },
            'Player_Report_' . now()->format('Y_m_d_His') . '.csv'
        );
    }



    public function uploadPlayerCSV(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'Please upload a valid CSV file only.');
        }

        $file = fopen($request->file('csv_file'), 'r');
        $header = fgetcsv($file);

        $updated = 0;
        $errors = [];

        while (($row = fgetcsv($file)) !== false) {

            $detailId      = $row[0];
            $playerName    = trim($row[6]);
            $playerNumber  = trim($row[7]);
            $productName  = trim($row[4]);
            $quantity     = $row[8];

            $detail = StoreOrderPlayerDetail::find($detailId);

            if (!$detail) {
                $errors[] = "Detail ID {$detailId} not found.";
                continue;
            }

            $storeOrderItem = StoreOrderItem::with('productDetails')->where('id', $detail->store_order_item_id)->first();

            if (!$storeOrderItem) {
                $errors[] = "Detail ID {$detailId} - Associated order item not found.";
                continue;
            }

            $product = $storeOrderItem->productDetails;

            if(!$product) {
                $errors[] = "Detail ID {$detailId} - Associated product not found.";
                continue;
            }

            if(trim($product->product_name) != $productName) {
                $errors[] = "Detail ID {$detailId} - Product name mismatch.";
                continue;
            }

            if($detail->qty != $quantity) {
                $errors[] = "Detail ID {$detailId} - Quantity mismatch.";
                continue;
            }

            if($product->set_individual_name == 1 && !empty($playerName)){
                $detail->player_name = $playerName ?? NULL;
                $detail->is_name_available = 1;
                $detail->save();
                $updated++;
            }

            if($product->set_individual_number == 1 && $playerNumber !== ''){
                $detail->player_number = $playerNumber ?? NULL;
                $detail->is_number_available = 1;
                $detail->save();
                $updated++;
            }
        }

        fclose($file);

        return back()->with([
            'success' => "Roster updated. {$updated} rows updated.",
            'errors'  => $errors
        ]);
    }

    public function save_new_order(Request $request)
    {
        $formData = $request->all();

        $uniqueSessionId = Str::random(20);

        $StoreCustomer = StoreCustomer::Where('email', $formData['email'])->first();
        $store = Store::with('contactCoachesDetails')->find($formData['store_id']);

        if (!$StoreCustomer) {
            $StoreCustomer = new StoreCustomer();
        }

        $StoreCustomer->session_id = $uniqueSessionId;

        $StoreCustomer->store_id = $formData['store_id'] ?? NULL;
        $StoreCustomer->first_name = $formData['first_name'] ?? NULL;
        $StoreCustomer->last_name = $formData['last_name'] ?? NULL;
        $StoreCustomer->country = $formData['country'] ?? NULL;
        $StoreCustomer->state = $formData['state'] ?? NULL;
        $StoreCustomer->city = $formData['city'] ?? NULL;
        $StoreCustomer->email = $formData['email'] ?? NULL;
        $StoreCustomer->phone_number = $formData['phone'] ?? NULL;
        $StoreCustomer->postal_code = $formData['zip_code'] ?? NULL;
        $StoreCustomer->street = $formData['street'] ?? NULL;

        if(!isset($formData['use_same_as_billing_address']) && isset($formData['selected_shipping_method']) && $formData['selected_shipping_method'] == 1){
            $StoreCustomer->is_shipping_address_available = 1;
            $StoreCustomer->shipping_first_name = $formData['shipping_first_name'] ?? NULL;
            $StoreCustomer->shipping_last_name = $formData['shipping_last_name'] ?? NULL;
            $StoreCustomer->shipping_country = $formData['shipping_country'] ?? NULL;
            $StoreCustomer->shipping_state = $formData['shipping_state'] ?? NULL;
            $StoreCustomer->shipping_city = $formData['shipping_city'] ?? NULL;
            $StoreCustomer->shipping_email = $formData['shipping_email'] ?? NULL;
            $StoreCustomer->shipping_phone = $formData['shipping_phone'] ?? NULL;
            $StoreCustomer->shipping_postal_code = $formData['shipping_zip_code'] ?? NULL;
            $StoreCustomer->shipping_street = $formData['shipping_street'] ?? NULL;
        }else{
            $StoreCustomer->is_shipping_address_available = 0;
            $StoreCustomer->shipping_first_name = NULL;
            $StoreCustomer->shipping_last_name = NULL;
            $StoreCustomer->shipping_country = NULL;
            $StoreCustomer->shipping_state = NULL;
            $StoreCustomer->shipping_city = NULL;
            $StoreCustomer->shipping_email = NULL;
            $StoreCustomer->shipping_phone = NULL;
            $StoreCustomer->shipping_postal_code = NULL;
            $StoreCustomer->shipping_street = NULL;
        }

        $StoreCustomer->save();

        $shippingDetails = [];

        if($formData['selected_shipping_method'] == 2){
            $shippingDetails = [
                'fname' => $store->contactCoachesDetails->first_name,
                'lname' => $store->contactCoachesDetails->last_name,
                'street1' => $store->contactCoachesDetails->shipping_street ?? '',
                'city' => $store->contactCoachesDetails->shipping_city ?? '',
                'state' => $store->contactCoachesDetails->shipping_state ?? '',
                'zip' => $store->contactCoachesDetails->shipping_zip ?? '',
                'country' => $store->contactCoachesDetails->shipping_country ?? '',
                'phone' => $store->contactCoachesDetails->phone_no ?? '',
                'email' => $store->coach_email ?? $store->contactCoachesDetails->email,
            ];
        }else if($formData['selected_shipping_method'] == 3){
            $shippingDetails = [
                    'fname' => 'Encore',
                    'lname' => 'Custom',
                    'company' => 'Encore Custom',
                    'street1' => '891 4th St.',
                    'city' => 'San Rafael',
                    'state' => 'CA',
                    'zip' => '94901',
                    'country' => 'USA',
                    'phone' => '+1 888-501-4999',
                    'email' => 'info@encorecustom.com',
                ];
        }else{
            if ($StoreCustomer->is_shipping_address_available == 1) {
                $shippingDetails = [
                    'fname' => $StoreCustomer->shipping_first_name,
                    'lname' => $StoreCustomer->shipping_last_name,
                    'street1' => $StoreCustomer->shipping_street ?? '',
                    'city' => $StoreCustomer->shipping_city ?? '',
                    'state' => $StoreCustomer->state ?? '',
                    'zip' => $StoreCustomer->shipping_postal_code ?? '',
                    'country' => $StoreCustomer->country ?? '',
                    'phone' => $StoreCustomer->shipping_phone ?? '',
                    'email' => $StoreCustomer->shipping_email ?? '',
                ];
            }else{
                $shippingDetails = [
                    'fname' => $StoreCustomer->first_name,
                    'lname' => $StoreCustomer->last_name,
                    'street1' => $StoreCustomer->street ?? '',
                    'city' => $StoreCustomer->city ?? '',
                    'state' => $StoreCustomer->state ?? '',
                    'zip' => $StoreCustomer->postal_code ?? '',
                    'country' => $StoreCustomer->country ?? '',
                    'phone' => $StoreCustomer->phone_number ?? '',
                    'email' => $StoreCustomer->email ?? '',
                ];
            }
        }

        $StoreOrder = new StoreOrder();
        $StoreOrder->store_id = $formData['store_id'];
        $StoreOrder->store_customer_id = $StoreCustomer->id;
        $StoreOrder->sub_total = 0.00;
        $StoreOrder->sales_tax = 0.00;
        $StoreOrder->handling_fee = 0.00;
        $StoreOrder->shipping = 0.00;
        $StoreOrder->total = 0.00;
        $StoreOrder->discount = 0.00;
        $StoreOrder->coupon_code = NULL;
        $StoreOrder->payment_method = 'CARD';
        $StoreOrder->shipping_method = $formData['selected_shipping_method'] ?? 1;
        $StoreOrder->carrier = 'USPS';
        $StoreOrder->email = $shippingDetails['email'] ?? $StoreCustomer->email ?? '';
        $StoreOrder->phone = $shippingDetails['phone'] ?? $StoreCustomer->phone_number ?? '';
        $StoreOrder->first_name = $shippingDetails['fname'] ?? "";
        $StoreOrder->last_name = $shippingDetails['lname'] ?? "";
        $StoreOrder->street = $shippingDetails['street1'] ?? "";
        $StoreOrder->city = $shippingDetails['city'] ?? "";
        $StoreOrder->state = $shippingDetails['state'] ?? "";
        $StoreOrder->postal_code = $shippingDetails['zip'] ?? "";
        $StoreOrder->country = $shippingDetails['country'] ?? "";
        $StoreOrder->is_payment_success = 1;
        $StoreOrder->active = 1;
        $StoreOrder->save();

        $storePrefix = strtoupper(substr(str_replace(' ', '', $store->store_name), 0, 4));
        $StoreOrder->order_no = $storePrefix.str_pad($StoreOrder->id, 6, '0', STR_PAD_LEFT);

        $StoreOrder->save();

        return redirect()->back()->with('success', 'Order '.$StoreOrder->order_no.' created successfully.');
    }

    public function export_shippo_csv(Request $request)
    {
        if (!$request->filled('order_nos')) {
            return response()->json(['error' => 'No orders selected'], 422);
        }

        $headers = [
            'Reference ID',
            'Reference ID 2',
            'Shipping Date',
            'Item Description',
            'Item Quantity',
            'Item Weight (lb)',
            'Item Weight (oz)',
            'Item Value',
            'HS Tariff #',
            'Country of Origin',

            'Sender First Name',
            'Sender Middle Initial',
            'Sender Last Name',
            'Sender Company/Org Name',
            'Sender Address Line 1',
            'Sender Address Line 2',
            'Sender Address Line 3',
            'Sender Address Town/City',
            'Sender State',
            'Sender Country',
            'Sender ZIP Code',
            'Sender Urbanization Code',
            'Ship From Another ZIP Code',
            'Sender Email',
            'Sender Cell Phone',

            'Recipient Country',
            'Recipient First Name',
            'Recipient Middle Initial',
            'Recipient Last Name',
            'Recipient Company/Org Name',
            'Recipient Address Line 1',
            'Recipient Address Line 2',
            'Recipient Address Line 3',
            'Recipient Address Town/City',
            'Recipient Province',
            'Recipient State',
            'Recipient ZIP Code',
            'Recipient Urbanization Code',
            'Recipient Phone',
            'Recipient Email',

            'Service Type',
            'Package Type',
            'Package Weight (lb)',
            'Package Weight (oz)',
            'Length',
            'Width',
            'Height',
            'Girth',
            'Insured Value',
            'Contents',
            'Contents Description',
            'Package Comments',
            'Customs Form Reference #',
            'License #',
            'Certificate #',
            'Invoice #',
            'Customs Form Reference # Type'
        ];

        $rows = [];
        $rows[] = $headers;

        foreach ($request->order_nos as $orderNo) {

            $order = StoreOrder::with(['OrderItems.productDetails'])
                ->where('order_no', $orderNo)
                ->first();

            if (!$order) {
                continue;
            }

            $totalWeightOz = 0;
            $totalQty = 0;
            $contents = [];

            foreach ($order->OrderItems as $item) {
                $weight = $item->productDetails->shipping_weight ?? 0;
                $qty = $item->qty ?? 0;

                $totalWeightOz += ($weight * $qty);
                $totalQty += $qty;

                if (!empty($item->productDetails->product_name)) {
                    $contents[] = $item->productDetails->product_name . ' x ' . $qty;
                }
            }

            $rows[] = [
                $order->order_no,
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                'US',

                'Neil',
                '',
                'Butterfield',
                'Encore Custom',
                '891 4th St.',
                '',
                '',
                'San Rafael',
                'CA',
                'US',
                '94901',
                '',
                '',
                'info@encorecustom.com',
                '8885014999',

                $order->country ?? '',
                $order->first_name ?? '',
                '',
                $order->last_name ?? '',
                '',
                $order->street ?? '',
                '',
                '',
                $order->city ?? '',
                '',
                $order->state ?? '',
                $order->postal_code ?? '',
                '',
                '',
                '',

                'USPS Ground Advantage',
                'my own package',
                1,
                5,
                10,
                10,
                1,
                22,
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                ''
            ];
        }

        $handle = fopen('php://temp', 'r+');
        foreach ($rows as $row) {
            fputcsv($handle, $row);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response()->json([
            'csv_content' => $csv
        ]);
    }
    public function get_order_no(Request $request)
    {
        $store_order_item_id = $request->store_order_item_id;

        $orderItem = StoreOrderItem::with('orderDetails')->where('id', $store_order_item_id)->first();
        if (!$orderItem) {
            return response()->json(['error' => 'Order item not found'], 404);
        }

        $orderNo = $orderItem->orderDetails->order_no;

        return response()->json([
            'order_no' => $orderNo
        ]);

    }

    public function update_store_order_no(){
        $stores = Store::whereIn('id', [88,62])->get();
        foreach ($stores as $store){
            $storeOrders = StoreOrder::where('store_id', $store->id)->get();
            foreach ($storeOrders as $order){

                $existingOrderNo = $order->order_no;
                $cleanName = preg_replace('/[^A-Za-z]/', '', $store->store_name);
                $storePrefix = strtoupper(substr($cleanName, 0, 4));
                $newStoreOrderNo = $storePrefix.str_pad($order->id, 6, '0', STR_PAD_LEFT);

                if ($existingOrderNo !== $newStoreOrderNo) {

                    $order->order_no = $newStoreOrderNo;
                    $order->save();

                    $cardPayments = StoreCardPayment::where('store_order_no', $existingOrderNo)->get();

                    if ($cardPayments->count() > 0) {
                        foreach ($cardPayments as $payment) {
                            $payment->store_order_no = $newStoreOrderNo;
                            $payment->save();
                        }
                    }

                    $orderReceipts = StoreOrderReceipt::where('store_order_no', $existingOrderNo)->get();
                    if ($orderReceipts->count() > 0) {
                        foreach ($orderReceipts as $receipt) {
                            $receipt->store_order_no = $newStoreOrderNo;
                            $receipt->save();
                        }
                    }

                    $storeShipments = StoreShipment::where('store_order_no', $existingOrderNo)->get();
                    if ($storeShipments->count() > 0) {
                        foreach ($storeShipments as $shipment) {
                            $shipment->store_order_no = $newStoreOrderNo;
                            $shipment->save();
                        }
                    }
                    dump("Updated Order ID {$order->id}: {$existingOrderNo} -> {$newStoreOrderNo}");
                } else {
                    dump("Order ID {$order->id} already has correct order number: {$existingOrderNo}");
                }

            }

            dump("Completed store: {$store->store_name}");

        }

        dd('All stores done');
    }
    public function downlod_store_refunds()
    {
        $refundList = StoreCardPayment::with('OrderDetails')
            ->where('is_refund', 1)
            ->where('is_success', 1)
            ->get();

        $csvContent = "TRANSACTION ID,STORE ORDER NO,SYSTEM ORDER NO,CARD OWNER,PAYMENT AMOUNT,PROCESSING FEE,TOTAL AMOUNT,CUSTOMER NAME,EMAIL,PHONE,CREATED DATE\n";

        foreach ($refundList as $refund) {

            $order = $refund->OrderDetails;

            $customerName = $order
                ? trim($order->first_name . ' ' . $order->last_name)
                : 'N/A';

            $email = $order->email ?? 'N/A';
            $phone = $order->phone ?? 'N/A';
            $systemOrderNo = $order->system_order_no ?? 'N/A';

            $transactionId = $refund->transaction_id ?? 'N/A';
            $storeOrderNo = $refund->store_order_no ?? 'N/A';
            $cardOwner = $refund->card_owner ?? 'N/A';
            $paymentAmount = $refund->payment_amount ?? 0;
            $processingFee = $refund->processing_fee ?? 0;
            $totalAmount = $refund->total_amount ?? 0;
            $createdDate = $refund->created_at ?? 'N/A';

            $csvContent .= "\"{$transactionId}\","
                . "\"{$storeOrderNo}\","
                . "\"{$systemOrderNo}\","
                . "\"{$cardOwner}\","
                . "\"{$paymentAmount}\","
                . "\"{$processingFee}\","
                . "\"{$totalAmount}\","
                . "\"{$customerName}\","
                . "\"{$email}\","
                . "\"{$phone}\","
                . "\"{$createdDate}\"\n";
        }

        $fileName = 'store_refunds_report_' . date('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$fileName}",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        return response($csvContent, 200, $headers);
    }

    private function getPendingChanges($storeId, $orderNo)
    {
        $empty = [
            'order_change_notes' => [],
            'item_change_log'    => [],
            'removed_items'      => [],
        ];

        $lastReceipt = StoreOrderReceipt::where('store_id', $storeId)
            ->where('store_order_no', $orderNo)
            ->latest('id')
            ->first();

        // No receipt, or the last one was already emailed → nothing pending
        if (!$lastReceipt || (int) $lastReceipt->is_sent === 1) {
            return $empty;
        }

        $details = json_decode($lastReceipt->getRawOriginal('order_details'), true) ?: [];

        return [
            'order_change_notes' => $details['order_change_notes'] ?? [],
            'item_change_log'    => $details['item_change_log'] ?? [],
            'removed_items'      => $details['removed_items'] ?? [],
        ];
    }
}
