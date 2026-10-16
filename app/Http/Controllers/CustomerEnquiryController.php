<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sport;
use App\Models\Product;
use App\Models\Size;
use App\Models\MainCategory;
use App\Models\ProductCatalogTemporyUser;
use App\Models\ProductCatalogQuote;
use App\Models\CustomerEnquiry;
use App\Models\CustomerEnquiryItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class CustomerEnquiryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */

    public function customer_enquiries(){

        //Registered user's items
        // $regularEnquiries = CustomerEnquiry::where('user_id', 'not like', 'TEMP-%')->get();

        //Tempory user's items
        $tempEnquiries = CustomerEnquiry::where('user_id', 'like', 'TEMP-%')->get();

        $enquiriesItems = CustomerEnquiryItem::all();

        $enquiriesItemsDetails = CustomerEnquiryItem::all();

        $catalogTemporyUsers = ProductCatalogTemporyUser::all();

        //$portalUsers = CustomerPortalUser::all();

        $products = Product::all();

        return view('pages.internal_product_catalog.customer_enquiries.index');
    }
    function getData(Request $request){

        $message = $request->input('message');

        //Registered user's items
        // $regularEnquiries = CustomerEnquiry::where('user_id', 'not like', 'TEMP-%')->get();

        //$portalUsers = CustomerPortalUser::all();

        //Tempory user's items
        $tempEnquiries = CustomerEnquiry::where('user_id', 'like', 'TEMP-%')->get();

        $enquiriesItems = CustomerEnquiryItem::all();

        $enquiriesItemsDetails = CustomerEnquiryItem::all();

        $catalogTemporyUsers = ProductCatalogTemporyUser::all();


        $products = Product::all();

        return response()->json([
            'status' => 201,
            'message' => 'Loading success !',
            'products' => $products,
            'enquiriesItemsDetails' => $enquiriesItemsDetails,
            'enquiriesItems' => $enquiriesItems,
            'tempEnquiries' => $tempEnquiries,
            'catalogTemporyUsers' => $catalogTemporyUsers]);
    }
}
