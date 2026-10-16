<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\StoreTheme;
use App\Models\Product;
use App\Models\Size;
use App\Models\Store;
use App\Models\StoreCart;
use App\Models\StoreProductCategory;
use App\Models\StoreProductImage;
use App\Models\StoreProduct;
use App\Models\StoreProductSize;
use App\Models\StoreCartItems;
use App\Models\StoreProductEditedCategory;
use App\Models\StoreProductAddedVariant;
use App\Models\StoreAddedCustomInformation;
use App\Models\StoreCustomInformation;
use App\Models\StoreCustomer;
use App\Models\StoreOrderItem;
use App\Models\StoreOrderPlayerDetail;
use App\Models\StoreOrder;
use App\Models\StoreCategoryOrder;
use App\Models\StoreProductVariant;
use App\Models\StoreProductBundle;
use App\Models\Notification;
use App\Models\StoreOrderReceipt;
use App\Models\StoreCoupon;
use App\Models\StoreCustomerCustomInformation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ShippoController;
use App\Models\StoreCardPayment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Services\EmailNotificationBuilderService;

class CustomerTeamStoreController extends Controller
{
    private $smptEncryption = 'SSL';
    private $smptPort = '465';
    private $smptHost = 'mail.encr.co';

    private $mailUsername = 'info@encr.co';
    private $mailPassword = 'Encr.co@ec123';

    // private $mailUsername = 'teamstore@encr.co';
    // private $mailPassword = 'Umudh@@13134';

    // private $timezone = 'America/Los_Angeles';
    private $timezone = 'America/Los_Angeles';

    public function getAppAuthStatus()
    {
        if (request()->has('is-authenticated') && request()->get('is-authenticated') == 'true') {
            return true;
        }elseif(request()->has('view-only') && request()->get('view-only') == 'true'){
            return true;
        }else{
            return false;
        }
    }

    public function customerTeamStore($store_url)
    {
        $this->ensureTeamStoreSessionId();

        $storeBackup = Store::where('direct_access_url', $store_url)
            ->where('active', 1)
            ->first();

        if (!$storeBackup) {
            abort(404, 'Store not found');
        }

        $this->updateStoreStatus($storeBackup->id);

        $store = Store::with([
            'StoreAddedProducts' => function ($query) {
                $query->where('active', 1)
                    ->where('product_availability', 1);
            },
            'themeDetails',
        ])
            ->where('direct_access_url', $store_url)
            ->where('active', 1)
            ->first();

        if (!$store) {
            abort(404, 'Store not found');
        }

        $storeProducts = StoreProduct::with(['images', 'priceAdditions'])
            ->where('store_id', $store->id)
            ->where('active', 1)
            ->where('product_availability', 1)
            ->get()
            ->groupBy('category_id');

        $teamStore = StoreTheme::where('store_id', $store->id)
            ->where('active', 1)
            ->first();

        if (!$teamStore) {
            abort(404, 'Store theme not found');
        }

        $categoryOrder = StoreCategoryOrder::where('store_id', $store->id)->first();

        $decodedOrder = $categoryOrder
            ? (json_decode($categoryOrder->all_category_product_order, true) ?: [])
            : [];

        $storeProducts = $this->sortTeamStoreProducts($storeProducts, $decodedOrder);

        $storeProductCategories = $this->prepareTeamStoreCategories($store->id);

        /*
        * This list is deliberately independent from $storeProducts.
        * The header needs all categories that have products, even on filtered pages.
        */
        $navbarCategoryIds = $this->getTeamStoreNavbarCategoryIds($store->id);

        $subTeamInfo = $this->getTeamStoreSubTeamInfo($store->id);

        $isSessionAvailable = $this->getAppAuthStatus();

        if ($store->store_status != 1 && !$isSessionAvailable) {
            return view('pages.customer_team_store.home.closed', [
                'store' => $store,
                'teamStore' => $teamStore,
            ]);
        }

        return view('pages.customer_team_store.home.index', [
            'teamStore' => $teamStore,
            'store' => $store,
            'storeProductCategories' => $storeProductCategories,
            'store_products' => $storeProducts,
            'isSessionAvailable' => $isSessionAvailable,
            'all_category_product_order' => $decodedOrder,
            'sub_team_info' => $subTeamInfo,
            'navbarCategoryIds' => $navbarCategoryIds,
        ]);
    }

    // public function updateStoreStatus($id)
    // {
    //     $store = Store::find($id);
    //     if (!$store) return;

    //     $now = Carbon::now($this->timezone);

    //     $openDate  = $store->open_date  ? Carbon::parse($store->open_date,  $this->timezone) : null;
    //     $closeDate = $store->close_date ? Carbon::parse($store->close_date, $this->timezone) : null;

    //     if ($store->store_status == 3) {
    //         return;
    //     }

    //     if (!$openDate) {
    //         $store->store_status = 2; // Closed
    //         $store->save();
    //         return;
    //     }

    //     if ($openDate->isFuture()) {
    //         $store->store_status = 2; // Closed
    //         $store->save();
    //         return;
    //     }

    //     if (!$closeDate) {
    //         // RULE 3: If no close date = never auto-close
    //         $store->store_status = 1; // Open
    //         $store->save();
    //         return;
    //     }

    //     if ($closeDate->isPast()) {

    //         // Store already closed → send notification only once
    //         if ($store->store_status != 2) {

    //             $store->store_status = 2; // Closed
    //             $store->save();

    //             // Send notifications if deadline logic enabled
    //             if ($store->set_store_deadline == 1 && !Notification::where('user_id', $store->salese_person)->where('notification_title', 'Store Closed: ' . $store->store_name)->exists()) {

    //                 $notification = new Notification();
    //                 $notification->notification_title = 'Store Closed: ' . $store->store_name;
    //                 $notification->notification_message =
    //                     'The store "' . $store->store_name . '" closed on ' . $closeDate->toDateString() . '.';
    //                 $notification->user_id = $store->salese_person;
    //                 $notification->save();

    //                 $this->send_store_closed_email($id);
    //             }
    //         }

    //     } else {

    //         // Store is OPEN until close date
    //         $store->store_status = 1;
    //         $store->save();

    //         // Send "closing soon" if within 3 days
    //         if ($store->set_store_deadline == 1 && $closeDate->diffInDays($now) <= 3 && !Notification::where('user_id', $store->salese_person)->where('notification_title', 'Store Closing Soon: ' . $store->store_name)->exists()) {

    //             $notification = new Notification();
    //             $notification->notification_title = 'Store Closing Soon: ' . $store->store_name;
    //             $notification->notification_message =
    //                 'The store "' . $store->store_name . '" will close on ' . $closeDate->toDateString() . '.';
    //             $notification->user_id = $store->salese_person;
    //             $notification->save();

    //             $this->send_store_closed_soon_email($id);
    //         }
    //     }

    // }

    public function updateStoreStatus($id)
{
    $store = Store::find($id);

    if (!$store) {
        return;
    }

    // Archived store - don't automatically change it
    if ((int) $store->store_status === 3) {
        return;
    }

    $now = Carbon::now($this->timezone);

    $openDate = $store->open_date
        ? Carbon::parse($store->open_date, $this->timezone)
        : null;

    $closeDate = $store->close_date
        ? Carbon::parse($store->close_date, $this->timezone)
        : null;

    /*
    |--------------------------------------------------------------------------
    | No open date
    |--------------------------------------------------------------------------
    */
    if (!$openDate) {

        if ((int) $store->store_status !== 2) {
            $store->store_status = 2;
            $store->save();
        }

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Store has not opened yet
    |--------------------------------------------------------------------------
    */
    if ($now->lt($openDate)) {

        if ((int) $store->store_status !== 2) {
            $store->store_status = 2;
            $store->save();
        }

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | No close date = keep open
    |--------------------------------------------------------------------------
    */
    if (!$closeDate) {

        if ((int) $store->store_status !== 1) {
            $store->store_status = 1;
            $store->save();
        }

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Close exact date + time passed
    |--------------------------------------------------------------------------
    */
    if ($now->gte($closeDate)) {

        if ((int) $store->store_status !== 2) {

            $store->store_status = 2;
            $store->save();

            /*
            |--------------------------------------------------------------------------
            | Store Closed Notification
            |--------------------------------------------------------------------------
            */
            if (
                (int) $store->set_store_deadline === 1 &&
                !Notification::where('user_id', $store->salese_person)
                    ->where(
                        'notification_title',
                        'Store Closed: ' . $store->store_name
                    )
                    ->exists()
            ) {

                $notification = new Notification();

                $notification->notification_title =
                    'Store Closed: ' . $store->store_name;

                $notification->notification_message =
                    'The store "' . $store->store_name .
                    '" closed on ' .
                    $closeDate->format('m/d/Y h:i A') . '.';

                $notification->user_id = $store->salese_person;

                $notification->save();

                $this->send_store_closed_email($id);
            }
        }

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Store currently open
    |--------------------------------------------------------------------------
    */
    if ((int) $store->store_status !== 1) {
        $store->store_status = 1;
        $store->save();
    }

    /*
    |--------------------------------------------------------------------------
    | Closing soon notification
    |--------------------------------------------------------------------------
    */
    $hoursUntilClose = $now->diffInHours($closeDate, false);

    if (
        (int) $store->set_store_deadline === 1 &&
        $hoursUntilClose >= 0 &&
        $hoursUntilClose <= 72 &&
        !Notification::where('user_id', $store->salese_person)
            ->where(
                'notification_title',
                'Store Closing Soon: ' . $store->store_name
            )
            ->exists()
    ) {

        $notification = new Notification();

        $notification->notification_title =
            'Store Closing Soon: ' . $store->store_name;

        $notification->notification_message =
            'The store "' . $store->store_name .
            '" will close on ' .
            $closeDate->format('m/d/Y h:i A') . '.';

        $notification->user_id = $store->salese_person;

        $notification->save();

        $this->send_store_closed_soon_email($id);
    }
}

    public function customerTeamStoreproductDetails($id){

        if (!session()->has('unique_session_id')) {
            $uniqueSessionId = Str::random(20);
            session()->put('unique_session_id', $uniqueSessionId);
        }

        $product = StoreProduct::where('id',$id)->with('products', 'images', 'sizes', 'IndividualNumberDetails', 'IndividualNameDetails', 'priceAdditions')->first();

        $store = Store::find($product->store_id);

        $teamStore = StoreTheme::where('store_id' , $store->id)->where('active', 1)->first();

        $sub_team_info = null;
        $storeAddedCustomInfo = StoreAddedCustomInformation::with('storeCustomInformationsDetails')->where('store_id', $product->store_id)->get();
        foreach ($storeAddedCustomInfo as $storeCustomInfo){
            if($storeCustomInfo->storeCustomInformationsDetails->make_as_sub_team == 1){
                $sub_team_info = $storeCustomInfo->storeCustomInformationsDetails;
            }
        }

        $productVariants = StoreProductAddedVariant::where('store_product_id', $id)
            ->with('variant')
            ->get();

        $storeProductCategories = $this->get_store_edited_category($store->id);

        $isSessionAvailable = $this->getAppAuthStatus();

        if ($store->store_status != 1 && !$isSessionAvailable) {

            return view('pages.customer_team_store.home.closed', [
                'store' => $store,
                'teamStore' => $teamStore,]);
        }

        return view('pages.customer_team_store.home.product_view', ['teamStore'=>$teamStore, 'product'=>$product, 'storeProductCategories'=>$storeProductCategories, 'store'=>$store,  'productVariants'=>$productVariants, 'isSessionAvailable' => $isSessionAvailable, 'sub_team_info' => $sub_team_info]);

    }

    public function customerTeamStoreCart($id)
    {
        $storeId = (int) $id;

        /*
        |--------------------------------------------------------------------------
        | Ensure customer session exists
        |--------------------------------------------------------------------------
        */
        if (!session()->has('unique_session_id')) {
            session()->put(
                'unique_session_id',
                \Illuminate\Support\Str::uuid()->toString()
            );
        }

        $sessionId = session()->get('unique_session_id');

        /*
        |--------------------------------------------------------------------------
        | Store + Theme
        |--------------------------------------------------------------------------
        */
        $store = Store::with([
            'StoreAddedProducts'
        ])->findOrFail($storeId);

        $teamStore = StoreTheme::where('store_id', $storeId)
            ->where('active', 1)
            ->first();

        if (!$teamStore) {
            abort(404, 'Store theme not found.');
        }

        /*
        |--------------------------------------------------------------------------
        | Check store status
        |--------------------------------------------------------------------------
        */
        $this->updateStoreStatus($storeId);

        // Reload because updateStoreStatus() may have changed store_status
        $store->refresh();

        /*
        |--------------------------------------------------------------------------
        | Current Store Customer
        |--------------------------------------------------------------------------
        */
        $storeCustomer = StoreCustomer::where('store_id', $storeId)
            ->where('session_id', $sessionId)
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Store Categories
        |--------------------------------------------------------------------------
        */
        $storeProductCategories = $this->get_store_edited_category($storeId);

        /*
        |--------------------------------------------------------------------------
        | IMPORTANT FOR HEADER
        |--------------------------------------------------------------------------
        | Header must know ALL categories which contain active + available products.
        | Do NOT determine navbar links from cart products.
        */
        $navbarCategoryIds = StoreProduct::where('store_id', $storeId)
            ->where('active', 1)
            ->where('product_availability', 1)
            ->whereNotNull('category_id')
            ->distinct()
            ->pluck('category_id')
            ->map(function ($categoryId) {
                return (int) $categoryId;
            })
            ->values()
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | Cart Items
        |--------------------------------------------------------------------------
        */
        $cartItems = StoreCart::where('session_id', $sessionId)
            ->where('store_id', $storeId)
            ->with([
                'storeProduct.images',
                'storeProduct.priceAdditions',
                'StoreCartItems',
            ])
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Bundles
        |--------------------------------------------------------------------------
        */
        $productBundles = StoreProductBundle::where('store_id', $storeId)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Get all bundle products once
        |--------------------------------------------------------------------------
        */
        $bundleCategoryIds = $productBundles
            ->pluck('category_id')
            ->filter()
            ->unique()
            ->values();

        $bundleProductsByCategory = StoreProduct::where('store_id', $storeId)
            ->where('active', 1)
            ->where('product_availability', 1)
            ->whereIn('category_id', $bundleCategoryIds)
            ->get()
            ->groupBy('category_id');

        /*
        |--------------------------------------------------------------------------
        | Products already in cart
        |--------------------------------------------------------------------------
        */
        $cartProductIDs = $cartItems
            ->pluck('store_product_id')
            ->filter()
            ->map(function ($productId) {
                return (int) $productId;
            })
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | Missing Bundle Validation
        |--------------------------------------------------------------------------
        */
        $missingBundles = [];

        foreach ($productBundles as $productBundle) {

            $bundleProducts = $bundleProductsByCategory
                ->get($productBundle->category_id, collect());

            $bundleProductIDs = $bundleProducts
                ->pluck('id')
                ->map(function ($productId) {
                    return (int) $productId;
                })
                ->toArray();

            /*
            * No active/available products in this bundle category.
            * Do not create a missing-bundle warning.
            */
            if (empty($bundleProductIDs)) {
                continue;
            }

            $intersection = array_intersect(
                $bundleProductIDs,
                $cartProductIDs
            );

            $availableCount = count($intersection);
            $totalCount = count($bundleProductIDs);

            /*
            * Use already-loaded category collection instead of querying
            * get_store_edited_category() again inside every loop.
            */
            $category = $storeProductCategories
                ->firstWhere('id', $productBundle->category_id);

            /*
            * Some bundle items have been added, but bundle is incomplete.
            */
            if (
                $availableCount > 0 &&
                $availableCount < $totalCount
            ) {
                $missingBundles[] = [
                    'category' => $category,
                    'available_count' => $availableCount,
                    'total_count' => $totalCount,
                    'is_required' => $productBundle->is_required,
                ];

                continue;
            }

            /*
            * Required bundle has no products in cart.
            */
            if (
                (int) $productBundle->is_required === 1 &&
                $availableCount === 0
            ) {
                $missingBundles[] = [
                    'category' => $category,
                    'available_count' => 0,
                    'total_count' => $totalCount,
                    'is_required' => $productBundle->is_required,
                ];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Session / Admin View-Only Status
        |--------------------------------------------------------------------------
        */
        $isSessionAvailable = $this->getAppAuthStatus();

        /*
        |--------------------------------------------------------------------------
        | Closed Store
        |--------------------------------------------------------------------------
        */
        if (
            (int) $store->store_status !== 1 &&
            !$isSessionAvailable
        ) {
            return view('pages.customer_team_store.home.closed', [
                'store' => $store,
                'teamStore' => $teamStore,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Cart Page
        |--------------------------------------------------------------------------
        */
        return view('pages.customer_team_store.home.cart', [
            'teamStore' => $teamStore,
            'store' => $store,

            // Header
            'storeProductCategories' => $storeProductCategories,
            'navbarCategoryIds' => $navbarCategoryIds,

            // Cart
            'cartItems' => $cartItems,
            'missingBundles' => $missingBundles,
            'storeCustomer' => $storeCustomer,

            // Access / view-only
            'isSessionAvailable' => $isSessionAvailable,
        ]);
    }

    public function get_available_numbers(Request $request){

        $sub_team = trim($request->sub_team) ?? null;

        $store_product_details = StoreProduct::with('IndividualNameDetails', 'IndividualNumberDetails')->find($request->store_product_id);

        if ($store_product_details) {
            if ($store_product_details->IndividualNumberDetails->number_exlusive == 1) {
                if(!empty($sub_team)){
                    $orderNumbers = StoreOrderPlayerDetail::where('store_product_id', $request->store_product_id)->where('sub_team', $sub_team)->pluck('player_number')->toArray();
                    $orderedNumbers = $orderNumbers;
                }else{
                    $orderNumbers = StoreOrderPlayerDetail::where('store_product_id', $request->store_product_id)->pluck('player_number')->toArray();
                    $orderedNumbers = $orderNumbers;
                }
            }else{
                $orderedNumbers = [];
            }

            $exclusiveNumbers = json_decode($store_product_details->IndividualNumberDetails->exclude_numbers, true) ?? [];

            if ($store_product_details->IndividualNumberDetails->number_type == "0-99") {
                $min_number = $store_product_details->IndividualNumberDetails->min_number ?? 0; $max_number = $store_product_details->IndividualNumberDetails->max_number ?? 99;
                $min_number_count = $store_product_details->IndividualNumberDetails->min_number_count ?? 1; $max_number_count = $store_product_details->IndividualNumberDetails->max_number_count ?? 2;
                $number_list = range($min_number, $max_number);
            }elseif($store_product_details->IndividualNumberDetails->number_type == "3-digits"){
                $min_number = $store_product_details->IndividualNumberDetails->min_number ?? 0; $max_number = $store_product_details->IndividualNumberDetails->max_number ?? 999;
                $min_number_count = $store_product_details->IndividualNumberDetails->min_number_count ?? 1; $max_number_count = $store_product_details->IndividualNumberDetails->max_number_count ?? 3;
                $number_list = range($min_number, $max_number);
            }else{
                $min_number = $store_product_details->IndividualNumberDetails->min_number ?? 0; $max_number = $store_product_details->IndividualNumberDetails->max_number ?? 9999;
                $min_number_count = $store_product_details->IndividualNumberDetails->min_number_count ?? 1; $max_number_count = $store_product_details->IndividualNumberDetails->max_number_count ?? 5;
                $number_list = [];
            }
        }

        $number_validation_array = [
            'numberExlusive' => $store_product_details->IndividualNumberDetails->number_exlusive,
            'orderedNumbers' => $orderedNumbers,
            'exclusiveNumbers' => $exclusiveNumbers,
            'min_number' => $min_number,
            'max_number' => $max_number,
            'min_number_count' => $min_number_count,
            'max_number_count' => $max_number_count,
            'number_list' => $number_list,
            'store_product_details' => $store_product_details
        ];

        return response()->json($number_validation_array);

    }
    public function validateCustomerInputNumber(Request $request)
    {
        $store_product_details = StoreProduct::with('IndividualNumberDetails')
            ->find($request->store_product_id);

        if (!$store_product_details || !$store_product_details->IndividualNumberDetails) {
            return response()->json(['error' => 'Invalid product details'], 400);
        }

        $sub_team = trim($request->team_name) ?? null;

        $individualDetails = $store_product_details->IndividualNumberDetails;

        $min_number = $individualDetails->min_number ?? 0;
        $max_number = $individualDetails->max_number ?? ($individualDetails->number_type == "3-digits" ? 999 : 9999);
        if(!empty($sub_team)){
            $orderNumbers = $individualDetails->number_exlusive == 1
                                ? StoreOrderPlayerDetail::where('store_product_id', $request->store_product_id)->where('sub_team', $sub_team)->pluck('player_number')->toArray()
                                : [];

            // $storeCartWithSubTeam = StoreCart::where('store_product_id', $request->store_product_id)->where('sub_team', $sub_team)->pluck('id')->toArray();
            // $cartNumbers = StoreCartItems::whereIn('store_cart_id', $storeCartWithSubTeam)->pluck('custom_number')->toArray();

            $orderedNumbers = $orderNumbers;

        }else{

            $orderNumbers = $individualDetails->number_exlusive == 1
                                ? StoreOrderPlayerDetail::where('store_product_id', $request->store_product_id)->pluck('player_number')->toArray()
                                : [];
            // $cartNumbers = StoreCartItems::where('store_product_id', $request->store_product_id)->pluck('custom_number')->toArray();

            $orderedNumbers = $orderNumbers;
        }
        $exclusiveNumbers = json_decode($individualDetails->exclude_numbers, true) ?? [];

        $inputNumber = trim((string) $request->customNumber);

        if (is_numeric($inputNumber) && ($inputNumber < $min_number || $inputNumber > $max_number)) {
            return response()->json(['error' => 'Number is out of valid range'], 422);
        }

        if ($this->containsPlayerNumber($inputNumber, $exclusiveNumbers)) {
            return response()->json(['error' => 'Number is exclusive and cannot be used'], 422);
        }

        if ($this->containsPlayerNumber($inputNumber, $orderedNumbers)) {
            return response()->json(['error' => 'Number has already been ordered'], 422);
        }

        return response()->json(['success' => 'Number is valid']);
    }

    protected function containsPlayerNumber($number, array $numbers): bool
    {
        return in_array((string) $number, array_map('strval', $numbers), true);
    }

    public function validateCustomerInputName(Request $request)
    {
        $store_product_details = StoreProduct::with('IndividualNameDetails')
            ->find($request->store_product_id);

        if (!$store_product_details || !$store_product_details->IndividualNameDetails) {
            return response()->json(['error' => 'Invalid product details'], 400);
        }

        $individualDetails = $store_product_details->IndividualNameDetails;

        if(!empty($request->sub_team)){
            $orderNames = $individualDetails->name_exlusive == 1
                            ? StoreOrderPlayerDetail::where('store_product_id', $request->store_product_id)->where('sub_team', $request->sub_team)->pluck('player_name')->toArray()
                            : [];

            $storeCartWithSubTeam = StoreCart::where('store_product_id', $request->store_product_id)->where('sub_team', $request->sub_team)->pluck('id')->toArray();
            // $cartNames = StoreCartItems::whereIn('store_cart_id', $storeCartWithSubTeam)->pluck('custom_name')->toArray();

            $orderedNames = $orderNames;

        }else{
            $orderNames = $individualDetails->name_exlusive == 1
                                ? StoreOrderPlayerDetail::where('store_product_id', $request->store_product_id)->pluck('player_name')->toArray()
                                : [];
            // $cartNames = StoreCartItems::where('store_product_id', $request->store_product_id)->pluck('custom_name')->toArray();

            $orderedNames = $orderNames;
        }


        $inputName = $request->customName;

        if (in_array($inputName, $orderedNames)) {
            return response()->json(['error' => 'Name has already been ordered'], 422);
        }

        return response()->json(['success' => 'Name is valid']);
    }



    public function GetCustomerTeamStoreCart(Request $request){

        $cartItems = StoreCart::where('session_id', $request->session()->get('unique_session_id'))
            ->where('store_id', $request->input('store_id'))->with('storeProduct', 'StoreCartItems')
            ->get();

        return response()->json($cartItems);

    }

    public function cartAddStore(Request $request)
    {
        if (!session()->has('unique_session_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please refresh the page.'
            ], 401);
        }

        $uniqueSessionId = session()->get('unique_session_id');
        $productId = $request->input('product_id');
        $storeId = $request->input('store_id');
        $sizesData = $request->input('sizes', []);
        $bundleNames = $request->input('bundleNames', []);
        $bundleNumbers = $request->input('bundleNumbers', []);

        if (!$productId || !$storeId) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid request. Missing product or store ID.'
            ], 400);
        }

            $newCart = new StoreCart();
            $newCart->session_id = $uniqueSessionId;
            $newCart->store_product_id = $productId;
            $newCart->store_id = $storeId;
            $newCart->sub_team = $request->sub_team == null ? NULL : $request->sub_team;
            $newCart->qty = $sizesData ? array_sum($sizesData) : 1;
            $newCart->save();

            if (!empty($sizesData)) {
                foreach ($sizesData as $sizeId => $qty) {
                    if ($qty > 0) {
                        $newCartItem = new StoreCartItems();
                        $newCartItem->store_cart_id = $newCart->id;
                        $newCartItem->store_id = $storeId;
                        $newCartItem->store_product_id = $productId;
                        $newCartItem->size_id = $sizeId;
                        if (isset($bundleNames[$productId]) && !empty($bundleNames[$productId])) {
                            $newCartItem->custom_name = $bundleNames[$productId];
                        }
                        // if (isset($bundleNumbers[$productId]) && !empty($bundleNumbers[$productId])) {
                        //     $newCartItem->custom_number = $bundleNumbers[$productId];
                        // }
                        if (
                                array_key_exists($productId, $bundleNumbers) &&
                                $bundleNumbers[$productId] !== null &&
                                $bundleNumbers[$productId] !== ''
                            ) {
                                $newCartItem->custom_number = $bundleNumbers[$productId];
                            }
                        $newCartItem->qty = $qty;
                        $newCartItem->type = 1;
                        $newCartItem->save();
                    }
                }
            } else {
                $newCartItem = new StoreCartItems();
                $newCartItem->store_cart_id = $newCart->id;
                $newCartItem->store_id = $storeId;
                $newCartItem->store_product_id = $productId;
                $newCartItem->size_id = 1;
                if (isset($bundleNames[$productId]) && !empty($bundleNames[$productId])) {
                    $newCartItem->custom_name = $bundleNames[$productId];
                }
                // if (isset($bundleNumbers[$productId]) && !empty($bundleNumbers[$productId])) {
                //     $newCartItem->custom_number = $bundleNumbers[$productId];
                // }
                if (
                        array_key_exists($productId, $bundleNumbers) &&
                        $bundleNumbers[$productId] !== null &&
                        $bundleNumbers[$productId] !== ''
                    ) {
                        $newCartItem->custom_number = $bundleNumbers[$productId];
                    }
                $newCartItem->qty = 1;
                $newCartItem->type = 1;
                $newCartItem->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully.'
            ]);
    }

    public function cartAddBundleStore(Request $request)
    {
        if (!session()->has('unique_session_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please refresh the page.'
            ], 401);
        }

        $uniqueSessionId = session()->get('unique_session_id');
        $storeId = $request->input('store_id');
        $bundleSizes = $request->input('bundle_sizes', []);
        $bundleNames = $request->input('bundleNames', []);
        $bundleNumbers = $request->input('bundleNumbers', []);

        if (empty($bundleSizes) || !$storeId) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid request. Missing bundle sizes or store ID.'
            ], 400);
        }

        foreach ($bundleSizes as $productId => $sizes) {
            $totalQty = array_sum($sizes);

            $newCart = new StoreCart();
            $newCart->session_id = $uniqueSessionId;
            $newCart->store_product_id = $productId;
            $newCart->store_id = $storeId;
            $newCart->sub_team = $request->sub_team == null ? NULL : $request->sub_team;
            $newCart->qty = $totalQty;
            $newCart->save();

            foreach ($sizes as $sizeId => $qty) {
                $cartItem = new StoreCartItems();
                $cartItem->store_cart_id = $newCart->id;
                $cartItem->store_id = $storeId;
                $cartItem->store_product_id = $productId;
                $cartItem->size_id = $sizeId;
                $cartItem->qty = !empty($qty) && (int)$qty > 0 ? (int)$qty : 1;
                $cartItem->type = 1;
                if (isset($bundleNames[$productId]) && !empty($bundleNames[$productId])) {
                    $cartItem->custom_name = $bundleNames[$productId];
                }
                if (isset($bundleNumbers[$productId]) && $bundleNumbers[$productId] !== '') {
                    $cartItem->custom_number = $bundleNumbers[$productId];
                }
                $cartItem->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Bundle products added to cart successfully.'
        ]);
    }


    public function getProductSizes(Request $request)
    {
        $productId = $request->input('product_id');

        if (!$productId) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid request. Missing product ID.'
            ], 400);
        }

        $product = StoreProduct::with('sizes', 'images', 'IndividualNameDetails', 'IndividualNumberDetails')->find($productId);

        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }
    public function getBundleProductSizes(Request $request)
    {
        $productIds = $request->input('product_ids');

        if (!$productIds || !is_array($productIds)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid request. Missing product IDs.'
            ], 400);
        }

        $products = StoreProduct::with('sizes', 'images', 'IndividualNameDetails', 'IndividualNumberDetails')->whereIn('id', $productIds)->get();

        return response()->json([
            'success' => true,
            'products' => $products
        ]);
    }

    public function minusProductCart(Request $request)
    {
        $sessionId = $request->session()->get('unique_session_id');
        $productId = $request->input('product_id');
        $storeId = $request->input('store_id');


        $product = StoreCart::where('session_id', $sessionId)->where('store_product_id', $productId)->where('store_id', $storeId)->first();
        if ($product) {
            $product->qty -= 1;

            if ($product->qty <= 0) {
                // If quantity is 0 or less, delete the item from the cart
                $product->delete();
            } else {
                // Otherwise, save the updated quantity
                $product->save();
            }
        }

        // Calculate the total number of items in the cart
        $cartCount = $this->calculateCartCount($sessionId);

        //For Cart
        // Retrieve cart items
        $cartItems = StoreCart::where('store_id', $storeId)
            ->where('session_id', $sessionId)
            ->get();

        // Retrieve images related to the cart items
        $cartProductIds = $cartItems->pluck('store_product_id');
        $productImages = StoreProductImage::whereIn('store_product_id', $cartProductIds)
            ->where('active', 1)
            ->get()
            ->groupBy('store_product_id');

        // Retrieve product details for the cart items
        $storeProducts = StoreProduct::whereIn('id', $cartProductIds)->get()->keyBy('id');

        // Combine cart items with images and product details
        foreach ($cartItems as $cartItem) {
            $cartItem->images = isset($productImages[$cartItem->store_product_id])
                ? $productImages[$cartItem->store_product_id]
                : collect([]);

            $cartItem->product = isset($storeProducts[$cartItem->store_product_id])
                ? $storeProducts[$cartItem->store_product_id]
                : null;
        }
        //End For Cart

        return response()->json([
            'success' => true,
            'cart_count' => $cartCount,
            'cartItems' => $cartItems,
        ]);
    }

    public function plusProductCart(Request $request)
    {
        $sessionId = $request->session()->get('unique_session_id');
        $productId = $request->input('product_id');
        $storeId = $request->input('store_id');

        // Save the cart data to the database
        // Assuming you have a Cart model and related logic

        $product = StoreCart::where('session_id', $sessionId)->where('store_product_id', $productId)->where('store_id', $storeId)->first();
        if($product){
            $product->qty += 1;
            $product->save();
        } else {
        }

        // Calculate the total number of items in the cart
        $cartCount = $this->calculateCartCount($sessionId);

        //For Cart
        // Retrieve cart items
        $cartItems = StoreCart::where('store_id', $storeId)
            ->where('session_id', $sessionId)
            ->get();

        // Retrieve images related to the cart items
        $cartProductIds = $cartItems->pluck('store_product_id');
        $productImages = StoreProductImage::whereIn('store_product_id', $cartProductIds)
            ->where('active', 1)
            ->get()
            ->groupBy('store_product_id');

        // Retrieve product details for the cart items
        $storeProducts = StoreProduct::whereIn('id', $cartProductIds)->get()->keyBy('id');

        // Combine cart items with images and product details
        foreach ($cartItems as $cartItem) {
            $cartItem->images = isset($productImages[$cartItem->store_product_id])
                ? $productImages[$cartItem->store_product_id]
                : collect([]);

            $cartItem->product = isset($storeProducts[$cartItem->store_product_id])
                ? $storeProducts[$cartItem->store_product_id]
                : null;
        }
        //End For Cart

        return response()->json([
            'success' => true,
            'cart_count' => $cartCount,
            'cartItems' => $cartItems,
        ]);
    }

    public function calculateCartCount($sessionId)
    {
        return StoreCart::where('session_id', $sessionId)->sum('qty');
    }

    public function cartDeleteStore(Request $request)
    {
        if ($request->session()->has('unique_session_id')) {
            $uniqueSessionId = session()->get('unique_session_id');
            $productId = $request->input('product_id');
            $storeId = $request->input('store_id');
            $cartItemId = $request->input('cartItemId');

            StoreCart::find($cartItemId)->delete();

            return response()->json([ 'success' => true,]);
        }else{
            return response()->json([ 'success' => false,]);
        }
    }

    public function storeProductCategoryWise(Request $request)
    {
        $productCategoryId = (int) $request->input('product_category_id');
        $storeId = (int) $request->input('store_id');

        if ($productCategoryId <= 0 || $storeId <= 0) {
            abort(404, 'Store/category not found');
        }

        $this->updateStoreStatus($storeId);
        $this->ensureTeamStoreSessionId();

        $store = Store::with([
            'StoreAddedProducts' => function ($query) {
                $query->where('active', 1)
                    ->where('product_availability', 1);
            },
            'themeDetails',
        ])
            ->where('id', $storeId)
            ->where('active', 1)
            ->first();

        if (!$store) {
            abort(404, 'Store not found');
        }

        /*
        * Only the selected category is loaded for the page body.
        * This is fine because navbar visibility now comes from
        * $navbarCategoryIds, not this filtered collection.
        */
        $storeProducts = StoreProduct::with(['images', 'priceAdditions'])
            ->where('store_id', $store->id)
            ->where('category_id', $productCategoryId)
            ->where('active', 1)
            ->where('product_availability', 1)
            ->get()
            ->groupBy('category_id');

        $teamStore = StoreTheme::where('store_id', $store->id)
            ->where('active', 1)
            ->first();

        if (!$teamStore) {
            abort(404, 'Store theme not found');
        }

        $categoryOrder = StoreCategoryOrder::where('store_id', $store->id)->first();

        $decodedOrder = $categoryOrder
            ? (json_decode($categoryOrder->all_category_product_order, true) ?: [])
            : [];

        $storeProducts = $this->sortTeamStoreProducts($storeProducts, $decodedOrder);

        $storeProductCategories = $this->prepareTeamStoreCategories($store->id);

        $navbarCategoryIds = $this->getTeamStoreNavbarCategoryIds($store->id);

        /*
        * The new category-wise Blade uses the exact same UI/JS as the main page.
        * Therefore it also needs the sub-team data used by Quick Add / Bundle.
        */
        $subTeamInfo = $this->getTeamStoreSubTeamInfo($store->id);

        $isSessionAvailable = $this->getAppAuthStatus();

        if ($store->store_status != 1 && !$isSessionAvailable) {
            return view('pages.customer_team_store.home.closed', [
                'store' => $store,
                'teamStore' => $teamStore,
            ]);
        }

        return view('pages.customer_team_store.home.products_category_wise', [
            'teamStore' => $teamStore,
            'store' => $store,
            'storeProductCategories' => $storeProductCategories,
            'store_products' => $storeProducts,
            'isSessionAvailable' => $isSessionAvailable,
            'all_category_product_order' => $decodedOrder,
            'sub_team_info' => $subTeamInfo,
            'navbarCategoryIds' => $navbarCategoryIds,
        ]);
    }


    /**
     * Ensure one anonymous browser/session identifier exists.
     */
    private function ensureTeamStoreSessionId(): string
    {
        if (!session()->has('unique_session_id')) {
            session()->put('unique_session_id', Str::random(20));
        }

        return (string) session()->get('unique_session_id');
    }


    /**
     * Apply the saved product position for each category.
     */
    private function sortTeamStoreProducts($storeProducts, array $decodedOrder)
    {
        foreach ($storeProducts as $categoryId => $products) {
            $savedCategory = collect($decodedOrder)->first(function ($category) use ($categoryId) {
                return isset($category['category_id'])
                    && (int) $category['category_id'] === (int) $categoryId;
            });

            if (!$savedCategory || empty($savedCategory['products'])) {
                continue;
            }

            $positionMap = collect($savedCategory['products'])
                ->filter(function ($product) {
                    return isset($product['product_id'], $product['position']);
                })
                ->mapWithKeys(function ($product) {
                    return [
                        (int) $product['product_id'] => (int) $product['position'],
                    ];
                })
                ->toArray();

            $storeProducts[$categoryId] = $products
                ->sortBy(function ($product) use ($positionMap) {
                    return $positionMap[(int) $product->id] ?? 9999;
                })
                ->values();
        }

        return $storeProducts;
    }


    /**
     * Add bundle flags to categories and keep the same ordering on every page.
     */
    private function prepareTeamStoreCategories(int $storeId)
    {
        $storeProductCategories = $this->get_store_edited_category($storeId);

        $bundles = StoreProductBundle::where('store_id', $storeId)
            ->get()
            ->keyBy(function ($bundle) {
                return (int) $bundle->category_id;
            });

        foreach ($storeProductCategories as $category) {
            $bundle = $bundles->get((int) $category->id);

            $category->is_bundle = $bundle ? 1 : 0;
            $category->is_required = $bundle ? (int) $bundle->is_required : 0;
        }

        return $storeProductCategories
            // ->sortByDesc('is_bundle')
            ->values();
    }


    /**
     * Categories that should be shown in the shared navbar.
     *
     * This query is NOT category-filtered.
     */
    private function getTeamStoreNavbarCategoryIds(int $storeId): array
    {
        return StoreProduct::where('store_id', $storeId)
            ->where('active', 1)
            ->where('product_availability', 1)
            ->whereNotNull('category_id')
            ->distinct()
            ->pluck('category_id')
            ->map(function ($categoryId) {
                return (int) $categoryId;
            })
            ->values()
            ->toArray();
    }


    /**
     * Return the custom-information definition configured as the Sub Team field.
     */
    private function getTeamStoreSubTeamInfo(int $storeId)
    {
        $storeAddedCustomInfo = StoreAddedCustomInformation::with('storeCustomInformationsDetails')
            ->where('store_id', $storeId)
            ->get();

        foreach ($storeAddedCustomInfo as $storeCustomInfo) {
            $details = $storeCustomInfo->storeCustomInformationsDetails;

            if ($details && (int) $details->make_as_sub_team === 1) {
                return $details;
            }
        }

        return null;
    }

    public function addCartFromProduct(Request $request)
    {
        if (!$request->has('store_product_id')) {
            return response()->json(['status' => 'error', 'message' => 'Product ID is required.'], 400);
        }

        if (!session()->has('unique_session_id')) {
            return response()->json(['status' => 'error', 'message' => 'Session expired. Please refresh the page.'], 401);
        }

        if (!empty($request->saved_cart_item_id)) {
            $newCart = StoreCart::find($request->saved_cart_item_id);
            $newCart->sub_team = $request->sub_team;
        }else{
            $newCart = new StoreCart();
            $newCart->session_id = session()->get('unique_session_id');
            $newCart->store_product_id = $request->store_product_id;
            $newCart->store_id = $request->store_id;
            $newCart->sub_team = $request->sub_team;
            $newCart->qty = 1;
            $newCart->save();
        }

        if (!empty($request->sizes)) {
            $totalQty = 0;
            $backup_variant = StoreCartItems::where('store_cart_id', $newCart->id)->first()->product_variant ?? NULL;
            StoreCartItems::where('store_cart_id', $newCart->id)->delete();

            foreach ($request->sizes as $sizeId => $quantity) {
                if ($quantity > 0) {
                    $newCartItem = new StoreCartItems();
                    $newCartItem->store_cart_id = $newCart->id;
                    $newCartItem->store_id = $request->store_id;
                    $newCartItem->store_product_id = $request->store_product_id;
                    $newCartItem->size_id = $sizeId;
                    $newCartItem->custom_name = $request->customize_name ?? NULL;
                    $newCartItem->custom_number = $request->input('customize_number');
                    $newCartItem->qty = $quantity;
                    $newCartItem->type = 1;
                    $newCartItem->save();

                    $totalQty += $quantity;
                }
            }

            $newCart->qty = $totalQty;
            $newCart->save();

        }

        return response()->json(['status' => 'success', 'message' => 'Details added to cart successfully!']);
    }
    public function updateCartSize(Request $request)
    {
        if (!$request->has('saved_cart_item_id')) {
            return response()->json(['status' => 'error', 'message' => 'Cart ID is required.'], 400);
        }
        if (!$request->has('size')) {
            return response()->json(['status' => 'error', 'message' => 'Size is required.'], 400);
        }
        if (!$request->has('qty') && $request->qty !== 0) {
            return response()->json(['status' => 'error', 'message' => 'Quantity is required.'], 400);
        }
        $sizeId = $request->size;
        $quantity = $request->qty ?? 0;

        if (!empty($request->saved_cart_item_id)) {
            $newCart = StoreCart::find($request->saved_cart_item_id);
            if ($newCart) {
                $cartItem = StoreCartItems::where('store_cart_id', $newCart->id)->first();
                if($cartItem){
                    $cartItem->size_id = $sizeId;
                    $cartItem->qty = $quantity;
                    $cartItem->save();

                    $newCart->qty = $quantity;
                    $newCart->save();
                }
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Details added to cart successfully!']);
    }

    public function get_cart_items(Request $request){

        $cartItems = StoreCart::where('session_id', $request->session()->get('unique_session_id'))
            ->where('store_id', $request->input('store_id'))->with('storeProduct', 'StoreCartItems')
            ->get();

        return response()->json($cartItems);
    }
    public function getProductSize(Request $request){

        $sessionId = $request->session()->get('unique_session_id');
        $productId = $request->input('product_id');
        $storeId = $request->input('store_id');

        $storeProductCartItems = StoreCartItems::where('session_id', $sessionId)
            ->where('store_product_id', $productId)
            ->where('store_id', $storeId)
            ->get();

        return response()->json($storeProductCartItems);
    }

    public function addCartFromCart(Request $request)
    {
        $sizes = $request->input('sizes');
        $productId = $request->input('storeProductId');
        $storeId = $request->input('storeId');
        $sessionId = $request->session()->get('unique_session_id');

        $totalQuantity = 0;

        $product = StoreCart::where('session_id', $sessionId)
            ->where('store_product_id', $productId)
            ->where('store_id', $storeId)
            ->first();

        if ($product) {
            $product->qty = $totalQuantity;
            $product->save();

            $store_cart_id = $product->id;
        } else {
            $newCart = new StoreCart();
            $newCart->session_id = $sessionId;
            $newCart->store_product_id = $productId;
            $newCart->store_id = $storeId;
            $newCart->qty = $totalQuantity;
            $newCart->save();

            $store_cart_id = $newCart->id;
        }

        // Step 1: Delete existing records
        StoreCartItems::where('session_id', $sessionId)
            ->where('store_product_id', $productId)
            ->where('store_id', $storeId)
            ->delete();

        // Step 2: Filter sizes with a quantity greater than 0
        $validSizes = array_filter($sizes, function($size) {
            return isset($size['qty']) && $size['qty'] > 0;
        });

        // Step 3: Determine the type based on the number of valid sizes
        $type = count($validSizes) === 1 ? 1 : 2;

        // Step 4: Save the valid sizes data
        foreach ($validSizes as $size) {
            $storeCartItem = new StoreCartItems();
            $storeCartItem->store_cart_id = $store_cart_id;
            $storeCartItem->session_id = $sessionId;
            $storeCartItem->store_product_id = $productId;
            $storeCartItem->store_id = $storeId;
            $storeCartItem->qty = $size['qty'];
            $storeCartItem->size_id = $size['size_id'];
            $storeCartItem->type = $type;
            $storeCartItem->save();

            $totalQuantity += $size['qty'];
        }

        if ($product) {
            $product->qty = $totalQuantity;
            $product->save();
        } else {
            $newCart->qty = $totalQuantity;
            $newCart->save();
        }

        return response()->json(['sizes' => $sizes]);
    }

    public function addCartColorFromCart(Request $request)
    {
        $colorVariantId = $request->input('colorVariantId');
        $productId = $request->input('storeProductId');
        $storeId = $request->input('storeId');
        $sessionId = $request->session()->get('unique_session_id');


        $product = StoreCart::where('session_id', $sessionId)
            ->where('store_product_id', $productId)
            ->where('store_id', $storeId)
            ->first();

        if ($product) {
            $product->product_variant = $colorVariantId;
            $product->save();
        }

        return response()->json(['product' => $product, 'colorVariantId'=>$colorVariantId]);
    }

    public function get_store_edited_category($store_id) {

        $categories = StoreProductCategory::where('active', 1)->orderBy('category_name', 'asc')->get();


        $categories = $categories->map(function ($category) use ($store_id) {
            $edited_category = StoreProductEditedCategory::where('category_id', $category->id)
                                                          ->where('store_id', $store_id)
                                                          ->first();
            if ($edited_category) {
                $category->category_name = $edited_category->edited_name;
            }

            return $category;
        });

        $categories = $categories->filter(function ($category) use ($store_id) {
            return StoreProduct::where('store_id', $store_id)
                               ->where('product_availability', 1)
                               ->where('category_id', $category->id)
                               ->exists();
        });

        $categoryOrder = StoreCategoryOrder::where('store_id', $store_id)->first();

        if ($categoryOrder && !empty($categoryOrder->order_array)) {
            $orderedCategoryIds = json_decode($categoryOrder->order_array, true);

            $orderedCategories = $categories->whereIn('id', $orderedCategoryIds)
                                            ->sortBy(function ($category) use ($orderedCategoryIds) {
                                                return array_search($category->id, $orderedCategoryIds);
                                            });

            $remainingCategories = $categories->reject(function ($category) use ($orderedCategoryIds) {
                return in_array($category->id, $orderedCategoryIds);
            });

            $categories = $orderedCategories->merge($remainingCategories);
        }

        return $categories->values();
    }


    public function proceedToCheckout(Request $request)
    {
        $storeId = $request->query('store_id');

        $this->updateStoreStatus($request->store_id);

        if (session()->has('unique_session_id')) {

            $teamStore = StoreTheme::where('store_id', $storeId)->where('active', 1)->first();

            $store = Store::with('StoreAddedProducts', 'StoreAddedShippingMethods', 'StoreAddedCustomInformations', 'StoreAddedCoupons')->find($storeId);

            $storeProductCategories = $this->get_store_edited_category($store->id);

            $cartItemsCount = StoreCart::where('session_id', session()->get('unique_session_id'))
                ->where('store_id', $storeId)
                ->sum('qty');

            $cartItemSum = StoreCart::with('storeProduct')
                ->where('session_id', session()->get('unique_session_id'))
                ->where('store_id', $storeId)
                ->get()
                ->sum(fn($cart) => ($cart->storeProduct->default_price + $cart->storeProduct->priceAdditions->sum('addition_amount')) * $cart->qty);

            $cartItemSum = round($cartItemSum, 2);

            $storeCustomInformation = StoreAddedCustomInformation::where('store_id', $storeId)
                ->with('storeCustomInformationsDetails')
                ->get();

            $salesTaxRate = $store->sales_tax ?? 0.00;
            $salesTax = round($cartItemSum * ($salesTaxRate / 100), 2);
            $shippingFee = 0.00;

            $feeSum = ($store->handling_fee ?? 0) + ($store->service_charge ?? 0) + ($store->other ?? 0);

            $otherFee = round(($cartItemSum * $feeSum) / 100, 2);

            $newStoreCustomer = StoreCustomer::with('customInformation')->where('session_id', session()->get('unique_session_id'))->first();

            $months = [
                1 => '01', 2 => '02', 3 => '03', 4 => '04', 5 => '05', 6 => '06',
                7 => '07', 8 => '08', 9 => '09', 10 => '10', 11 => '11', 12 => '12'
            ];
        }

        $isSessionAvailable = $this->getAppAuthStatus();

        if ($store->store_status != 1 && !$isSessionAvailable) {

            return view('pages.customer_team_store.home.closed', [
                'store' => $store,
                'teamStore' => $teamStore,]);
        }

        return view('pages.customer_team_store.home.store_payment', [
            'cartItemSum' => round($cartItemSum, 2),
            'cartItemsCount' => $cartItemsCount,
            'teamStore' => $teamStore,
            'salesTax' => round($salesTax, 2),
            'salesTaxRate' => round($salesTaxRate, 2),
            'shippingFee' => round($shippingFee, 2),
            'store' => $store,
            'otherFee' => round($otherFee, 2),
            'storeProductCategories' => $storeProductCategories,
            'storeCustomInformation' => $storeCustomInformation,
            'newStoreCustomer' => $newStoreCustomer,
            'months' => $months,
            'isSessionAvailable' => $isSessionAvailable,
        ]);
    }


    public function customerTeamStorePersonalDetails(Request $request){

        $uniqueSessionId = $request->session()->get('unique_session_id');
        $formData = $request->all();

        $StoreCustomer = StoreCustomer::where('session_id', $uniqueSessionId)->orWhere('email', $formData['email'])->first();

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

        if( !empty($request->custom_info) && count($request->custom_info) > 0){
            StoreCustomerCustomInformation::where('customer_id', $StoreCustomer->id)->delete();
            foreach ($request->custom_info as $key => $value) {
                $customerInfo = new StoreCustomerCustomInformation();
                $customerInfo->customer_id = $StoreCustomer->id;
                $customerInfo->custom_information_id = $key;
                $customerInfo->value = $value;
                $customerInfo->save();
            }
        }


        return response()->json(['success' => true, 'formData'=>$formData]);
    }

    public function storePaymentOnline(Request $request){

        $uniqueSessionId = session()->get('unique_session_id');
        $formData = $request->all();

        $StoreCustomer = StoreCustomer::where('session_id', $uniqueSessionId)->first();
        $store = Store::with('contactCoachesDetails')->find($formData['storeId']);

        if (!$store) {
            return back()->withErrors(['message' => 'Store not found']);
        }

        if(!$StoreCustomer){
            return back()->withErrors(['message' => 'Customer not found']);
        }

        $cartItemsCount = StoreCart::where('session_id', $uniqueSessionId)
            ->where('store_id', $formData['storeId'])
            ->sum('qty');

        if($cartItemsCount <= 0){
            return back()->with([
                'status' => 'error',
                'message' => 'Cart is empty.',
            ]);
        }

        $cartItemSum = StoreCart::with('storeProduct')
            ->where('session_id', session()->get('unique_session_id'))
            ->where('store_id', $formData['storeId'])
            ->get()
            ->sum(fn($cart) => ($cart->storeProduct->default_price + $cart->storeProduct->priceAdditions->sum('addition_amount')) * $cart->qty);

        $shippingRequest = new Request();
        $shippingRequest->merge(['store_id' => $formData['storeId'], 'shipping_method' => $formData['selected_shipping_method'] ?? 1]);
        $response = app(USPSController::class)->get_shipping_fee($shippingRequest);
        $data = $response->getData(true);
        $shippingFee = $data['rate']['amount'] ?? 0.00;

        $otherFee = 0.00;
        $salesTaxRate = $store->sales_tax ?? 0.00;

        $salesTax  = round(($cartItemSum * $salesTaxRate) / 100, 2);
        $feeSum = ($store->handling_fee ?? 0) + ($store->service_charge ?? 0) + ($store->other ?? 0);
        $otherFee = round(($cartItemSum * $feeSum) / 100, 2);

        $invoiceAmount = $salesTax + $cartItemSum + $shippingFee + $otherFee;

        $couponCode = $formData['coupon_code_apply'] ?? null;
        $discountAmount = 0.00;

        if ($couponCode) {
            $couponFound = StoreCoupon::where('store_id', $formData['storeId'])->where('coupon_code', $couponCode)->where('active', 1)->first();

            if ($couponFound) {
                $type = $couponFound->type;
                $amount = (float) $couponFound->amount;

                switch ($type) {
                    case 'free_shipping':
                        $discountAmount = $shippingFee;
                        $shippingFee = 0;
                        $invoiceAmount = $salesTax + $cartItemSum + $shippingFee + $otherFee;
                        break;

                    case 'flat_from_sub':
                        $discountAmount = $amount;
                        $cartItemSum = max(0, $cartItemSum - $amount);
                        $salesTax = ($cartItemSum * $salesTaxRate) / 100;
                        $invoiceAmount = $salesTax + $cartItemSum + $shippingFee + $otherFee;
                        break;

                    case 'percentage_from_sub':
                        $discountAmount = ($cartItemSum * $amount) / 100;
                        $cartItemSum = $cartItemSum - ($cartItemSum * $amount / 100);
                        $salesTax = ($cartItemSum * $salesTaxRate) / 100;
                        $invoiceAmount = $salesTax + $cartItemSum + $shippingFee + $otherFee;
                        break;

                    case 'flat_from_grand':
                        $discountAmount = $amount;
                        $invoiceAmount = max(0, $invoiceAmount - $amount);
                        break;

                    case 'percentage_from_grand':
                        $discountAmount = ($invoiceAmount * $amount) / 100;
                        $invoiceAmount = $invoiceAmount - ($invoiceAmount * $amount / 100);
                        break;
                }
            }
        }else{
            $invoiceAmount = $cartItemSum + $shippingFee + $otherFee + ($cartItemSum * ($store->sales_tax / 100));
        }

        // if (round($invoiceAmount, 1) != round($formData['order_total'], 1)) {
        //     return back()->with([
        //         'status' => 'error',
        //         'message' => 'Total amount mismatch.',
        //     ]);
        // }

        // if ($formData['card_processing_fee'] < 0) {
        //     return back()->with([
        //         'status' => 'error',
        //         'message' => 'Card processing fee cannot be zero or negative.',
        //     ]);
        // }

        // if($shippingFee <= 0 && $formData['selected_shipping_method'] == 1){
        //     return back()->with([
        //         'status' => 'error',
        //         'message' => 'Shipping fee must be greater than zero.',
        //     ]);
        // }

        // if ($formData['order_total'] <= 0) {
        //     return back()->with([
        //         'status' => 'error',
        //         'message' => 'Order total must be greater than zero.',
        //     ]);
        // }

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
        $StoreOrder->store_id = $formData['storeId'];
        $StoreOrder->store_customer_id = $StoreCustomer->id;
        $StoreOrder->sub_total = $cartItemSum;
        $StoreOrder->sales_tax = $cartItemSum * ($store->sales_tax / 100);
        $StoreOrder->handling_fee = $otherFee;
        $StoreOrder->shipping = $shippingFee;
        $StoreOrder->total = $formData['order_total'];
        $StoreOrder->discount = $discountAmount;
        $StoreOrder->coupon_code = $couponCode ?? NULL;
        $StoreOrder->payment_method = 'CARD';
        $StoreOrder->shipping_method = $formData['selected_shipping_method'] ?? 1;
        $StoreOrder->carrier = 'USPS';
        $StoreOrder->email = $shippingDetails['email'] ?? '';
        $StoreOrder->phone = $shippingDetails['phone'] ?? '';
        $StoreOrder->first_name = $shippingDetails['fname'] ?? "";
        $StoreOrder->last_name = $shippingDetails['lname'] ?? "";
        $StoreOrder->street = $shippingDetails['street1'] ?? "";
        $StoreOrder->city = $shippingDetails['city'] ?? "";
        $StoreOrder->state = $shippingDetails['state'] ?? "";
        $StoreOrder->postal_code = $shippingDetails['zip'] ?? "";
        $StoreOrder->country = $shippingDetails['country'] ?? "";
        $StoreOrder->active = 0;
        $StoreOrder->save();

        $cleanName = preg_replace('/[^A-Za-z]/', '', $store->store_name);

        $storePrefix = strtoupper(substr($cleanName, 0, 4));

        $StoreOrder->order_no = $storePrefix.str_pad($StoreOrder->id, 6, '0', STR_PAD_LEFT);
        $StoreOrder->save();

        $storeCartItemsAll = StoreCart::where('store_id', $request->storeId)->with('StoreCartItems', 'storeProduct')
            ->where('session_id', $uniqueSessionId)
            ->get();

        $cleanOrderTotal = floatval(str_replace(',', '', $formData['order_total']));
        $cleanProcessingFee = floatval(str_replace(',', '', $formData['card_processing_fee']));
        $cleanAmount = floatval(str_replace(',', '', $formData['amount']));

        $payment_details = [
                'store_order_id' => $StoreOrder->id,
                'owner' => $formData['owner'] ?? $StoreCustomer->first_name.' '.$StoreCustomer->last_name,
                'card_number' => $formData['cardNumber'] ?? 'XXXX-XXXX-XXXX-XXXX',
                'expiration' => [
                    'month' => $formData['expiration-month'] ?? date('m'),
                    'year' => $formData['expiration-year'] ?? date('Y')
                ],
                'cvv' => $formData['cvv'] ?? 'XXX',
                'order_total' => $cleanOrderTotal,
                'card_processing_fee' => $cleanProcessingFee,
                'total_amount' => $cleanAmount,
                'is_zero_payment' => (round($invoiceAmount, 2) == 0 && $formData['is_zero_payment'] == 1)
            ];

        $paymentController = new TeamStorePaymentController();
        $response = app(TeamStorePaymentController::class)->CustomerOnlinePayment($payment_details);

        $responseData = json_decode($response->getContent(), true);

        $message_text = $responseData['message'] ?? 'Payment Successful';

        if ($responseData['status'] == 'error') {
            return redirect()->back()->with(['message' => $message_text, 'status' => 'error']);
        }

        foreach ($storeCartItemsAll as $storeCartItem) {

            $subTeam = (!empty($storeCartItem->sub_team)) ? $storeCartItem->sub_team : NULL;

            $storeOrderItem = new StoreOrderItem();
            $storeOrderItem->store_order_id = $StoreOrder->id;
            $storeOrderItem->store_product_id = $storeCartItem->store_product_id;
            $storeOrderItem->store_id = $storeCartItem->store_id;
            $storeOrderItem->qty = $storeCartItem->qty;
            $storeOrderItem->save();

            $storeProductDetails = $storeCartItem->storeProduct;

            StoreOrderPlayerDetail::where('store_order_item_id', $storeOrderItem->id)->delete();

            foreach ($storeCartItem->StoreCartItems as $cartItem) {

                $OrderPlayerDetail = new StoreOrderPlayerDetail();
                $OrderPlayerDetail->store_id = $cartItem->store_id;
                $OrderPlayerDetail->sub_team = $subTeam;
                $OrderPlayerDetail->store_order_item_id = $storeOrderItem->id;
                $OrderPlayerDetail->store_product_id = $storeOrderItem->store_product_id;

                $variant = StoreProductVariant::where('variant_value', $cartItem->product_variant)->first();

                if ($variant) {
                    $OrderPlayerDetail->color = $variant->id;
                }

                $OrderPlayerDetail->size = $cartItem->size_id;
                $OrderPlayerDetail->player_number = $cartItem->custom_number ?? NULL;
                $OrderPlayerDetail->player_name = $cartItem->custom_name ?? NULL;
                $OrderPlayerDetail->qty = $cartItem->qty;
                $OrderPlayerDetail->unit_price = $storeProductDetails->default_price + $storeProductDetails->priceAdditions->sum('addition_amount');
                $OrderPlayerDetail->total_amount = ($storeProductDetails->default_price + $storeProductDetails->priceAdditions->sum('addition_amount')) * $cartItem->qty;
                $OrderPlayerDetail->paid_amount = ($storeProductDetails->default_price + $storeProductDetails->priceAdditions->sum('addition_amount')) * $cartItem->qty;
                $OrderPlayerDetail->is_number_available = $storeProductDetails->set_individual_number;
                $OrderPlayerDetail->is_name_available = $storeProductDetails->set_individual_name;
                $OrderPlayerDetail->order_date = Carbon::now()->format('d/m/Y');
                $OrderPlayerDetail->save();

                $cartItem->delete();
            }

            $storeCartItem->delete();
        }

        $StoreOrder->active = 1;
        $StoreOrder->save();

        $StoreCustomer->is_ordered = 1;
        $StoreCustomer->save();

        $this->createOrderReceipt($StoreOrder->order_no);

        return redirect(makeStoreDomainRoute($store->direct_access_url))->with('success', $message_text);

    }

    public function createOrderReceipt($orderId){

        $storeOrder = StoreOrder::with('OrderItems', 'CustomerDetails', 'paymentDetails')->where('order_no',$orderId)->first();

        $orderData = [];

        foreach ($storeOrder->OrderItems as $orderItem) {
            $product = $orderItem->productDetails;

            $qty = $orderItem->qty;
            $price = $product->default_price + $product->priceAdditions->sum('addition_amount');
            $total_price = $qty * $price;

            $itemSizes = [];
            $itemDetails = StoreOrderPlayerDetail::with('SizeDetails')->where('store_order_item_id', $orderItem->id)->get();
            foreach ($itemDetails as $detail) {
                $itemSizes[$detail->id]['size'] = $detail->SizeDetails ? $detail->SizeDetails->size_name : '';
                $itemSizes[$detail->id]['qty'] = $detail->qty ?? 0;
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

        $orderData['order_details'] = [
                'sub_total' => $storeOrder->sub_total,
                'shipping' => $storeOrder->shipping,
                'handling_fee' => $storeOrder->handling_fee,
                'sales_tax' => $storeOrder->sales_tax,
                'total' => $storeOrder->total,
                'paid_invoice_amount' => $storeOrder->paid_invoice_amount,
                'paid_processing_fee' => $storeOrder->paid_processing_fee,
                'paid_amount' => $storeOrder->paid_amount,
                'notes' => $storeOrder->notes,
                'tracking_no' => $storeOrder->tracking_no,
                'tracking_link' => $storeOrder->tracking_link,
                'order_discount' => $storeOrder->discount,
                'coupon_code' => $storeOrder->coupon_code,
                'coupon_details' => $storeOrder->coupon_code ? StoreCoupon::where('store_id', $storeOrder->store_id)->where('coupon_code', $storeOrder->coupon_code)->first() : null,
            ];

        $orderData['shipping_details'] = [
                'first_name' => $storeOrder->first_name,
                'last_name' => $storeOrder->last_name,
                'street' => $storeOrder->street,
                'city' => $storeOrder->city,
                'state' => $storeOrder->state,
                'postal_code' => $storeOrder->postal_code,
                'country' => $storeOrder->country,
                'phone' => $storeOrder->phone,
                'email' => $storeOrder->email,
                'shipping_method' => $storeOrder->shippingMethodDetails ? $storeOrder->shippingMethodDetails->shipping_method_name : 'Direct Ship to Customers',
            ];

        if(!empty($storeOrder->CustomerDetails)){

            $orderData['customer_details'] = [
                    'first_name' => $storeOrder->CustomerDetails->first_name,
                    'last_name' => $storeOrder->CustomerDetails->last_name,
                    'street' => $storeOrder->CustomerDetails->street,
                    'city' => $storeOrder->CustomerDetails->city,
                    'state' => $storeOrder->CustomerDetails->state,
                    'postal_code' => $storeOrder->CustomerDetails->postal_code,
                    'country' => $storeOrder->CustomerDetails->country,
                    'phone' => $storeOrder->CustomerDetails->phone_number,
                    'email' => $storeOrder->CustomerDetails->email,
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

        $receipt->order_items = json_decode($receipt->order_items, true);
        $receipt->order_details = json_decode($receipt->order_details, true);
        $receipt->shipping_details = json_decode($receipt->shipping_details, true);
        $receipt->customer_details = $receipt->customer_details ? json_decode($receipt->customer_details, true) : null;

        $store = Store::with('themeDetails')->where('id', $receipt->store_id)->first();


        $paymentCard = StoreCardPayment::where('store_order_no', $receipt->store_order_no)->latest('id')->first();


        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_order_receipt', [
            'custom_email' => $receipt->customer_details['email'],
            'store' => $store,
            'order_no' => $receipt->store_order_no,
            'receipt' => $receipt,
            'removed_items' => [],
            'paymentCard' => $paymentCard,
        ]);

        $receipt->is_sent = 1;
        $receipt->save();

    }

    public function get_customer_payments(Request $request)
    {
        $order = StoreOrder::where('id', $request->order_id)->with('paymentDetails', 'OrderItems', 'CustomerDetails')->first();

        $teamStore = StoreTheme::where('store_id' , $order->store_id)->where('active', 1)->first();

        $store = Store::with('StoreAddedProducts')->find($order->store_id);

        $storeProductCategories = $this->get_store_edited_category($order->store_id);

        $totalPaid = $order->paymentDetails->where('is_success', 1)->where('is_refund', 0)->sum('payment_amount');
        $totalRefund = $order->paymentDetails->where('is_success', 1)->where('is_refund', 1)->sum('payment_amount');
        $paidProcessingFee = $order->paymentDetails->where('is_success', 1)->sum('processing_fee');

        $totalPaidAmount = $totalPaid - $totalRefund;

        $balanceToPay = $order->total- $totalPaidAmount;

        $isSessionAvailable = false;

        $months = array(1 => '01', 2 => '02', 3 => '03', 4 => '04', 5 => '05', 6 => '06', 7 => '07', 8 => '08', 9 => '09', 10 => '10', 11 => '11', 12 => '12');

        return view('pages.customer_team_store.home.get_customer_Payments', [
            'order' => $order,
            'months' => $months,
            'teamStore' => $teamStore,
            'store' => $store,
            'storeProductCategories' => $storeProductCategories,
            'balanceToPay' => $balanceToPay,
            'totalPaidAmount' => $totalPaidAmount,
            'paidProcessingFee' => $paidProcessingFee,
            'isSessionAvailable' => $isSessionAvailable,
        ]);

    }

    public function OrderExtraPaymentOnline(Request $request)
    {
        $formData = $request->all();

        $payment_details = [
                'store_order_id' => $formData['store_order_id'],
                'owner' => $formData['owner'],
                'card_number' => $formData['cardNumber'],
                'expiration' => [
                    'month' => $formData['expiration-month'],
                    'year' => $formData['expiration-year']
                ],
                'cvv' => $formData['cvv'],
                'order_total' => $formData['balance_to_pay'],
                'card_processing_fee' => $formData['fee_to_pay'],
                'total_amount' => $formData['total_balance_to_pay'],
            ];

        $paymentController = new TeamStorePaymentController();
        $response = app(TeamStorePaymentController::class)->CustomerOnlinePayment($payment_details);

        $responseData = json_decode($response->getContent(), true);
        $message_text = $responseData['message'] ?? 'Payment Successful';

        $storeId = StoreOrder::where('id', $formData['store_order_id'])->value('store_id');
        $store = Store::find($storeId);

        $controllerObject = new StoreController();
        $controllerObject->update_store_payment_record($storeId);

        return redirect(makeStoreDomainRoute($store->direct_access_url))->with('success', $message_text);
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

        config(['mail.host' => $this->smptHost]);
        config(['mail.port' => $this->smptPort]);
        config(['mail.encryption' => $this->smptEncryption]);
        config(['mail.username' => $this->mailUsername]);
        config(['mail.password' => $this->mailPassword]);

        config(['mail.from' => [
            'address' => $this->mailUsername,
            'name' => 'Encore Custom',
        ]]);

        if (count($emailArray)) {


            $data = [
                'store' => $store,
                'subject' => 'Your Team Store Orders Are Now in Production!',
            ];

            foreach ($emailArray as $recipient) {
                $data['customer_name'] = $recipient['name'];

                Mail::send('pages.stores.email_customer.store_close_email', $data, function ($message) use ($recipient, $data) {
                    $message->to($recipient['email'], $recipient['name'])
                            ->subject($data['subject']);
                });
            }
        }

        // Inform store admin

        $adminEmails = User::whereIn('id', [99,$store->salese_person])->pluck('email')->toArray();

        $data = [
            'store' => $store,
            'subject' => 'Store Closed: ' . $store->store_name,
        ];
        foreach ($adminEmails as $adminEmail) {
            Mail::send('pages.stores.email_customer.store_closed_admin_notification', $data, function ($message) use ($adminEmail, $data) {
                $message->to($adminEmail)
                        ->subject($data['subject']);
            });
        }

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
    public function showCartItems(){
        // ->whereIn('id', [1687,1693,1700,1703,1704,1705,1706])
        $storeOrders = StoreOrder::with('OrderItems', 'CustomerDetails')->whereIn('id', [1687,1693,1700,1703,1704,1705,1706])->get();
        foreach ($storeOrders as $storeOrder) {
            $customer = $storeOrder->CustomerDetails;
            $cartAddedItems = StoreCart::with('StoreCartItems', 'storeProduct')->where('session_id', $customer->session_id)->where('store_id', $storeOrder->store_id)->get();
            echo "Order No: " . $storeOrder->order_no . "<br>";
            echo "Customer: " . $customer->first_name . " " . $customer->last_name . "<br>";
            echo "Customer email: " . $customer->email . "<br>";

            foreach ($cartAddedItems as $cartItem) {
                $product = $cartItem->storeProduct;
                $cartItemDetails = $cartItem->StoreCartItems;
                echo "Product: " . $product->product_name . "<br>";
                echo "Quantity: " . $cartItem->qty . "<br>";
                echo "Cart Item Details: <br>";
                foreach ($cartItemDetails as $detail) {
                    $sizeName = $detail->SizeDetails ? $detail->SizeDetails->size_name : 'N/A';
                    echo "- Size: " . $sizeName . ", Player Name: " . $detail->custom_name . ", Player Number: " . $detail->custom_number . "<br>";
                }
                echo "<br>";
            }
        }
    }
}
