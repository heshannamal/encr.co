<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sport;
use App\Models\Product;
use App\Models\Size;
use App\Models\MainCategory;
use App\Models\ProductCatalogTemporyUser;
use App\Models\ProductCatalogQuote;
use App\Models\ProductImage;
use App\Models\SubProduct;
use App\Models\CustomerEnquiry;
use App\Models\CustomerEnquiryItem;
use App\Models\CustomerPortalUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;


class ProductCatlogController extends Controller

{

    //product catalog views start

    public function index()
    {
        $sports = Sport::where('active', 1)
            ->orderBy('sport_name')
            ->get();

            $userToken = Cookie::get('user_browser_token');
            if(!$userToken){
                $userToken = Str::random(32);
                Cookie::queue('user_browser_token', $userToken);
            }

            //Cookie::queue(Cookie::forget('user_browser_token'));


        return view('pages.internal_product_catalog.product_catlog.index', ['sports' => $sports, 'token' => $userToken ]);
    }

    public function show($id)
    {
        $product = Product::find($id);

        $lifestyleImages = ProductImage::where('product_id', $id)->where('image_type', 1)->pluck('image_link');

        $Images3D = ProductImage::where('product_id', $id)->where('image_type', 2)->pluck('image_link');

        $categoryID = $product->product_category_id;

        $userToken = Cookie::get('user_browser_token');
            if(!$userToken){
                $userToken = Str::random(32);
                Cookie::queue('user_browser_token', $userToken);
            }

        $randomProducts = Product::inRandomOrder()
            ->where('product_category_id', $categoryID)
            ->where('active', 1)
            ->take(4)
            ->get();

        $size = Size::select('id', 'size_name','size_type')->get();
        $mainCategory = MainCategory::select('id', 'category_name')->get();

        return view('pages.internal_product_catalog.product_catlog.product_view', [
            'product' => $product,
            'lifestyleImages' => $lifestyleImages,
            'Images3D' => $Images3D,
            'randomProducts' => $randomProducts,
            'size' => $size,
            'mainCategory' => $mainCategory,
            'token' => $userToken
        ]);
    }


        public function quote()
        {
            // Check if the user is logged in
            $userToken = Cookie::get('user_browser_token');
                if(!$userToken){
                    $token = Str::random(32);
                    Cookie::queue('user_browser_token', $token);
                }

                return view('pages.internal_product_catalog.product_catlog.product_catalog_quote', ['token' => $userToken]);

        }

        public function submit_query(Request $request)
        {

            //return response()->json(['message' => 'Hello']);

            $userToken = $request->input('user_token');
            $dataArray = $request->input('dataArray');
            $userInputData = $request->input('userInputData');
            $OrderData = $request->input('commonArray');

            $organizationInput = $userInputData[0];
            $addressInput = $userInputData[1];
            $emailInput = $userInputData[2];
            $phoneNumberInput = $userInputData[3];
            $contactPersonInput = $userInputData[4];

            $existingUser = ProductCatalogTemporyUser::where('email', $emailInput)->first();


            if(!$existingUser){
            $temporaryUser = new ProductCatalogTemporyUser();

            $temporaryUser->organization = $organizationInput;
            $temporaryUser->address = $addressInput;
            $temporaryUser->email = $emailInput;
            $temporaryUser->phone_number = $phoneNumberInput;
            $temporaryUser->contact_person = $contactPersonInput;

            $temporaryUser->save();
            $temporuUserId = "TEMP-" . $temporaryUser->id;
        }else{
            $temporuUserId = "TEMP-" . $existingUser->id;
        }


            foreach ($dataArray as $data) {
                $userId = $data[0];
                $itemId = $data[1];
                $itemQuantity = $data[2];

                $existingQuote = ProductCatalogQuote::where('user_id', $userId)->where('product_id', $itemId)->first();

                if($existingQuote){
                    $existingQuote->user_id = $temporuUserId;
                    $existingQuote->qty = $itemQuantity;
                    $existingQuote->save();
                }

            }


        //store as order

            $order = new CustomerEnquiry();
            //$order->organization_id = $temporuUserId;
            //$order->contact_id = 20;
            //$order->order_no = $request->input('order_no');
            //$order->order_status_id = $request->input('order_status_id');
            $order->user_id = $temporuUserId;
            $order->sub_total = $OrderData[0];
            $order->sales_tax = $OrderData[1];
            $order->shipping = $OrderData[2];
            $order->artwork = $OrderData[3];
            $order->processing_fee = $OrderData[4];
            // $order->order_total = $request->input('order_total');
            // $order->is_editable = $request->input('is_editable');
            // $order->is_requested = $request->input('is_requested');
            // $order->request_reasons = $request->input('request_reasons');
            // $order->flag = $request->input('flag');
            // $order->open_date = $request->input('open_date');
            // $order->due_date = $request->input('due_date');
            $order->save();

            $OrderId = $order->id;

            foreach ($dataArray as $data) {
                $userId = $data[0];
                $itemId = $data[1];
                $itemQuantity = $data[2];

                $orderItem = new CustomerEnquiryItem();
                $orderItem->order_id = $OrderId;
                $orderItem->product_id = $itemId;
                $orderItem->qty = $itemQuantity;
                $orderItem->save();

            }

            Cookie::queue(Cookie::forget('user_browser_token'));

            return response()->json([
                'message' => 'Success!',
                'status' => 201]);

        }

    //product catalog views end

    //start here from common fuctions used for both portal and catalog

    public function filter(Request $request)
    {
    $category = $request->input('category', []);
    $category_new = [];

    foreach ($category as $index => $value) {
        if ($value === 'Sport') {
            $category_new[$index] = 1;
        } elseif ($value === 'Training') {
            $category_new[$index] = 2;
        } elseif ($value === 'Lifestyle') {
            $category_new[$index] = 3;
        } elseif ($value === 'Merch') {
            $category_new[$index] = 4;
        }
    }

    $style = $request->input('style', []);
    $gender = $request->input('genders', []);
    $sport = $request->input('sports', []);
    //$order = $request->input('order');
    // Log::info($order);
    //dd($request);

    // \Log::info('Selected Genders: ' . implode(',', $gender));
    // \Log::info('Selected Sports: ' . implode(',', $sport));


    $sports = Sport::where('active', 1)
        ->orderBy('sport_name')
        ->get();

    $query = Product::query();

    if (count($gender) > 0) {
        $query->where(function ($q) use ($gender) {
            foreach ($gender as $index => $value) {
                if ($index === 0) {
                    $q->where('gender', $value);
                } else {
                    $q->orWhere('gender', $value);
                }
            }
        });
    }

    if (count($sport) > 0) {
        $query->where(function ($q) use ($sport) {
            foreach ($sport as $index => $value) {
                if ($index === 0) {
                    $q->where('sport', $value);
                } else {
                    $q->orWhere('sport', $value);
                }
            }
        });
    }


    if (count($style) > 0) {
        $query->where(function ($q) use ($style) {
            foreach ($style as $index => $value) {
                if ($index === 0) {
                    $q->where('product_category_id', $value);
                } else {
                    $q->orWhere('product_category_id', $value);
                }
            }
        });
    }
    // if (in_array('Bras', $category_new)) {
    //     $key = array_search('Bras', $category_new);
    //     $category_new[$key] = "[['Tops']]";
    // }

    // if (in_array('Compress', $category_new)) {
    //     $key = array_search('Compress', $category_new);
    //     $category_new[$key] = "[['Bottoms'], ['Sweats']]";
    // }


    if (count($category_new) > 0) {
        $query->where(function ($q) use ($category_new) {
            foreach ($category_new as $index => $value) {
                if ($index === 0) {
                    $q->where('main_category_id', $value);
                } else {
                    $q->orWhere('main_category_id', $value);
                }
            }
        });
    }


    $products = $query->where('active', 1)->get();

    // if($order === 2)
    // {
    //     $products = $query->orderBy('product_name', 'desc')->get();
    // }else{
    //     $products = $query->orderBy('product_name')->get();
    // }


    //$products = $query->orderBy('product_name')->get();


    $loggedInUser = Session::get('loggedInUser');
            if($loggedInUser){
                $userProducts = ProductCatalogQuote::where('user_id', $loggedInUser)->get();
            }else{
                $userProducts = null;
            }

    return response()->json(['message' => 'Filter request processed successfully', 'products' => $products, 'userProducts' => $userProducts]);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        // $products = Product::where('product_name', 'LIKE', '%' . $keyword . '%')->where('active', 1)->get();

        $products = Product::where(function($query) use ($keyword) {
                $query->where('product_name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('product_no', $keyword)
                    ->orWhere('pattern_code', $keyword);
            })
            ->where('active', 1)
            ->get();

        $loggedInUser = Session::get('loggedInUser');
            if($loggedInUser){
                $userProducts = ProductCatalogQuote::where('user_id', $loggedInUser)->get();
            }else{
                $userProducts = null;
            }

        return response()->json(['message' => 'Search request processed successfully', 'products' => $products, 'userProducts' => $userProducts]);
    }

    public function commentSearch(Request $request)
    {
        $keyword = trim($request->input('keyword', ''));

        $productQuery = Product::where('active', 1);
        $subProductQuery = SubProduct::where('active', 1);

        if ($keyword !== '') {
            $productQuery->where(function ($query) use ($keyword) {
                $query->where('product_name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('product_no', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('pattern_code', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('id', $keyword);
            });

            $subProductQuery->where(function ($query) use ($keyword) {
                $query->where('product_name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('sub_product_no', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('pattern_code', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('id', $keyword);
            });
        }

        $products = $productQuery->limit(25)->get();
        $subProducts = $subProductQuery->limit(25)->get();

        $productItems = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->product_name,
                'no' => $product->product_no,
                'code' => $product->pattern_code,
                'type' => 'product'
            ];
        });

        $subProductItems = $subProducts->map(function ($subProduct) {
            return [
                'id' => $subProduct->id,
                'name' => $subProduct->product_name,
                'no' => $subProduct->sub_product_no,
                'code' => $subProduct->pattern_code,
                'type' => 'sub_product'
            ];
        });

        return response()->json([
            'products' => $productItems,
            'sub_products' => $subProductItems,
        ]);
    }


    public function add_to_quote(Request $request)
    {
        $user_id = $request->input('user_id');
        $product_id = $request->input('product_id');
        $qty = $request->input('qty');

        $existingQuote = ProductCatalogQuote::where('user_id', $user_id)->where('product_id', $product_id)->first();

        if ($existingQuote) {
            return response()->json(['message_exist' => 'Already added']);
        }

        // Create a new instance of ProductCatalogQuote model
        $quote = new ProductCatalogQuote();
        $quote->user_id = $user_id;
        $quote->product_id = $product_id;
        $quote->qty = $qty ?? 0;

        // Save the quote
        $quote->save();

        return response()->json(['message_success' => 'Store success']);
    }
    public function find_quote(Request $request)
    {
        $user_id = $request->input('user_id');
        $product_id = $request->input('product_id');

        $existingQuote = ProductCatalogQuote::where('user_id', $user_id)->where('product_id', $product_id)->first();

        if ($existingQuote) {
            return response()->json(['status' => 200]);
        }else{
            return response()->json(['status' => 400]);
        }
    }

    //This use to find the button text of catalog product views

    public function buttontext(Request $request)
    {
        $user_id = $request->input('user_id');
        $product_id = $request->input('product_id');

        $existingQuote = ProductCatalogQuote::where('user_id', $user_id)->where('product_id', $product_id)->first();

        if ($existingQuote) {
            return response()->json(['message_exist' => 'Already added']);
        }

    }

    public function remove_quote_item(Request $request)
    {
        $user_id = $request->input('user_id');
        $product_id = $request->input('product_id');

        $quote = ProductCatalogQuote::where('user_id', $user_id)
            ->where('product_id', $product_id)
            ->first();

        if ($quote) {
            // Delete the record
            $quote->delete();
            return response()->json(['message_remove' => 'Remove success']);
        } else {
            return response()->json(['message_notfound' => 'No record found']);
        }
    }

    //find the available records related user

    public function count_records(Request $request)
    {
        $user_id = $request->input('user_id');

        // Count the records
        $count = ProductCatalogQuote::where('user_id', $user_id)->count();

        return response()->json(['count' => $count]);
    }

    public function view_user_quotes(Request $request)
    {
        $user_id = $request->input('user_id');

        $quotes = ProductCatalogQuote::where('user_id', $user_id)->get(['product_id','qty','status','est_date']);

        if ($quotes->isNotEmpty()) {
            // Get the product IDs from the quotes
            $productIds = $quotes->pluck('product_id')->toArray();

            // Retrieve the products using the product IDs
            $products = Product::whereIn('id', $productIds)->get();

            // Return the quotes data along with the associated products
            return response()->json(['quotes' => $quotes, 'products' => $products]);
        } else {
            return response()->json(['message_notfound' => 'No records found']);
        }
    }


}
