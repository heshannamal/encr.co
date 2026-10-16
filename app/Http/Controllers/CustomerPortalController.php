<?php

namespace App\Http\Controllers;

use App\Models\CustomerPortalUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Mail\PortalForgotPassword;
use Illuminate\Support\Facades\Session;
use App\Models\Sport;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Size;
use App\Models\MainCategory;
use App\Models\ProductCategory;
use App\Models\ProductCatalogQuote;
use App\Models\CustomerEnquiry;
use App\Models\CustomerEnquiryItem;
use App\Models\ProductAttribute;
use App\Models\SubProductColor;
use App\Models\ColorMaster;
use App\Models\Fabric;
use App\Models\Attribute;
use App\Models\EmbellishmentType;
use App\Models\ProductTaglineList;
use App\Models\ProductTagline;
use App\Models\ProductFit;
use App\Models\MasterFit;
use App\Models\SubProductImage;
use App\Models\CustomerEnquiryItemsDetail;
use Illuminate\Support\Facades\Cookie;
use App\Models\ProductMainCategory;
use App\Models\ProductSport;
use App\Models\ProductCategoryList;
use App\Models\SubProduct;
use App\Models\ProductEmbellishmentType;
use Illuminate\Support\Arr;

class CustomerPortalController extends Controller
{
    public function portallogin(){



        $loggedInUser = Session::get('loggedInUser');
        if($loggedInUser){
            return Redirect::route('portal_profile');
        }else{
            return view('pages.customer_portal.customer_portal.login');
        }
    }

    public function portalregister(){
        $loggedInUser = Session::get('loggedInUser');
        if($loggedInUser){
            return Redirect::route('portal_profile');
        }else{

        return view('pages.customer_portal.customer_portal.register');
        }

    }
    public function forgot_password(){
        $loggedInUser = Session::get('loggedInUser');
        if($loggedInUser){
            return Redirect::route('portal_profile');
        }else{

        return view('pages.customer_portal.customer_portal.forgot_password');
        }

    }
    public function reset_password(Request $request){
        $loggedInUser = Session::get('loggedInUser');
        if($loggedInUser){
            return Redirect::route('portal_profile');
        }else{



            $email = $request->email;
        $token = $request->token;

        return view('pages.customer_portal.customer_portal.reset_password', ['email' => $email, 'token' => $token]);

        }

        }


        public function portal_profile()
        {
            $loggedInUser = Session::get('loggedInUser');
            if($loggedInUser){
                $sports = Sport::where('active', 1)
                ->orderBy('sport_name')
                ->get();
                $userData = CustomerPortalUser::find($loggedInUser);


            return view('pages.customer_portal.customer_portal.customer_portal_dashboard', ['sports' => $sports, 'userData' => $userData]);

        }else{
            return Redirect::route('portallogin');
        }
    }

    public function portal_start_design()

        {
            $loggedInUser = Session::get('loggedInUser');
            if($loggedInUser){
            $userData = CustomerPortalUser::find($loggedInUser);


            return view('pages.customer_portal.customer_portal.portal_start_design', compact('userData'));
            }else{
                return Redirect::route('portallogin');
            }
        }
    public function portal_design_center()
        {
            $loggedInUser = Session::get('loggedInUser');
            if($loggedInUser){
            $userData = CustomerPortalUser::find($loggedInUser);


            return view('pages.customer_portal.customer_portal.portal_design_center', compact('userData'));

            }else{
                return Redirect::route('portallogin');
            }
        }
        public function picture_design_tool(){

            return view('pages.customer_portal.customer_portal.Picture Design Tool.index');

        }
    public function portal_logout()
        {
            $loggedInUser = Session::get('loggedInUser');
            if($loggedInUser){
            Auth::guard('custom')->logout();
            session()->forget('loggedInUser');


            return Redirect::route('portallogin');
            }else{
                return Redirect::route('portallogin');
            }
        }



    public function email_exist(Request $request)
    {
        $user = CustomerPortalUser::where('email', $request->input('email'))->first();
        if ($user) {
            return response()->json(['status' => 200]);
        }else{
            return response()->json(['status' => 400]);
        }
    }

    public function saveUser(Request $request){
            $user = new CustomerPortalUser();
            $user->name = $request->name;
            $user->organization = $request->organization;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json([
                'status' => 200,
                'message' => 'Register successfully!'
            ]);
    }

    public function loginUser(Request $request)
    {

        $user = CustomerPortalUser::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'Email not found']);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:100',
            'password' => 'required'
        ],[
            'email.required' => 'The email field is required.',
            'email.email' => 'Not match with email.',
            'password.required' => 'The password field is required.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->all()
            ]);
        } else {
            $user = CustomerPortalUser::where('email', $request->email)->first();
            if ($user) {


                if ($user) {
                    if (Hash::check($request->password, $user->password)) {
                        if (Session::has('loggedInUser')) {
                            return response()->json([
                                'status' => 200,
                                'message' => 'Already Logged !'
                            ]);
                        }else{
                        // Store the user ID in the custom session
                        session(['loggedInUser' => $user->id]);
                        //$loggedInUser = session('loggedInUser');
                        $loggedInUser = Session::get('loggedInUser');
                        return response()->json([
                            'status' => 200,
                            'message' => 'Login success'
                        ]);}
                    } else {
                        return response()->json([
                            'status' => 401,
                            'message' => 'E-mail or password is incorrect!'
                        ]);
                    }


                } else {
                    return response()->json([
                        'status' => 401,
                        'message' => 'E-mail or password is incorrect!'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 401,
                    'message' => 'User not found!'
                ]);
            }
        }
    }
    public function forgotPassword(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'message' => $validator->getMessageBag()
            ]);
        }else{
            $token = Str::random(32);
            $user = DB::table('customer_portal_users')->where('email', $request->email)->first();
            $details = [
                'body' => route('reset_password',['email' => $request->email, 'token' => $token])
            ];
            //print_r($details);
            if($user){
                CustomerPortalUser::where('email', $request->email)->update([
                    'token' => $token,
                    'token_expire' => Carbon::now()->addMinutes(10)->toDateTimeString()
                ]);
                Mail::to($request->email)->send(new PortalForgotPassword($details));
                return response()->json([
                    'status' => 200,
                    'message' => 'Password link send!'
                ]);
            }else{
                return response()->json([
                    'status' => 401,
                    'message' => 'This e-mail not registered!'
                ]);
            }
        }
    }

    public function resetUserPassword(Request $request){

        $validator = Validator::make($request->all(),[
            'Newpassword' => 'required|min:6|max:50',
            'confirmNewPassword' => 'required|min:6:max:50|same:Newpassword'
        ],[
            'confirmNewPassword.same' => 'Password not matched!',
            'Newpassword.required' => 'New Password required!'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->all()
            ]);
        }else{
            $user = DB::table('customer_portal_users')->where('email', $request->email)->whereNotNull('token')
            ->where('token',$request->token)->where('token_expire', '>',Carbon::now())->exists();

            if($user){
                CustomerPortalUser::where('email', $request->email)->update([
                    'password' => Hash::make($request->Newpassword),
                    'token' => null,
                    'token_expire' => null
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'New password updated'
                ]);
            }else{
                return response()->json([
                    'status' => 401,
                    'message' => 'Link expired'
                ]);
            }
        }

    }

    public function portal_product_view($id)
    {
        $product = Product::find($id);
        $loggedInUser = Session::get('loggedInUser');
        $userData = CustomerPortalUser::find($loggedInUser);
        $categoryID = $product->product_category_id;

        $randomProducts = Product::inRandomOrder()
            ->where('product_category_id', $categoryID)
            ->where('active', 1)
            ->take(4)
            ->get();

        $size = Size::select('id', 'size_name','size_type')->get();
        $mainCategory = MainCategory::select('id', 'category_name')->get();


        if($loggedInUser){
        return view('pages.customer_portal.customer_portal.portal_product_view', [
            'product' => $product,
            'userData' => $userData,
            'randomProducts' => $randomProducts,
            'size' => $size,
            'mainCategory' => $mainCategory
        ]);

        }else{
            return Redirect::route('portallogin');
        }
    }
    public function portal_product_quote()
        {
            $loggedInUser = Session::get('loggedInUser');
            if($loggedInUser){
            $userData = CustomerPortalUser::find($loggedInUser);

            return view('pages.customer_portal.customer_portal.portal_product_quote', compact('userData'));
            }else{
                return Redirect::route('portallogin');
            }
        }

    public function update_quote(Request $request)
        {
            $dataArray = $request->input('dataArray');
            $loggedInUser = Session::get('loggedInUser');
            $userData = CustomerPortalUser::find($loggedInUser);

            foreach ($dataArray as $data) {
                $userId = $data[0];
                $itemId = $data[1];
                $itemStatus = $data[2];
                $itemEstDate = $data[3];
                $itemQuantity = $data[4];

                $existingQuote = ProductCatalogQuote::where('user_id', $userId)->where('product_id', $itemId)->first();

                if($existingQuote){
                    $existingQuote->status = $itemStatus;
                    $existingQuote->est_date = $itemEstDate;
                    $existingQuote->qty = $itemQuantity;

                    $existingQuote->save();
                }

            }

            return response()->json(['status'=>201, 'message' => "updated!"]);
        }
    public function add_customer_order(Request $request)
        {
            $dataArray = $request->input('dataArray');
            $commonArray = $request->input('commonArray');
            $loggedInUser = Session::get('loggedInUser');
            $userData = CustomerPortalUser::find($loggedInUser);


            $order = new CustomerEnquiry();
            $order->organization_id = $userData->id;
            //$order->contact_id = 20;
            //$order->order_no = $request->input('order_no');
            //$order->order_status_id = $request->input('order_status_id');
            $order->user_id = $userData->id;
            $order->sub_total = $commonArray[0];
            $order->sales_tax = $commonArray[1];
            $order->shipping = $commonArray[2];
            $order->artwork = $commonArray[3];
            $order->processing_fee = $commonArray[4];
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
                $itemStatus = $data[2];
                $itemEstDate = $data[3];
                $itemQuantity = $data[4];

                $orderItem = new CustomerEnquiryItem();
                $orderItem->order_id = $OrderId;
                $orderItem->product_id = $itemId;
                $orderItem->est_delivery_date = $itemEstDate;
                $orderItem->qty = $itemQuantity;
                $orderItem->save();

            }

            return response()->json(['status'=>201, 'message' => "updated!"]);
        }


        //portal
        public function portal()
        {
                $sports = Sport::where('active', 1)
                ->orderBy('sport_name')
                ->get();
                $productCategory = ProductCategory::where('active', 1)->get();

                $mainCategory = MainCategory::get();
// dd($productCategory);
            return view('pages.internal_product_catalog.portal.index', [
                'sports' => $sports,
                'productCategory' => $productCategory,
                'mainCategory' => $mainCategory]);
        }
        public function portal_product($id, $type, Request $request)
            {
                // $product = Product::find($id);
                // $categoryID = $product->product_category_id;
                // $size = Size::select('id', 'size_name','size_type')->get();
                // $mainCategory = MainCategory::select('id', 'category_name')->get();

                // $lifestyleImages = ProductImage::where('product_id', $id)->where('image_type', 1)->pluck('image_link');

                // $Images3D = ProductImage::where('product_id', $id)->where('image_type', 2)->pluck('image_link');

                // $subProducts = SubProduct::where('parent_product_id', $id)->where('active', 1)->get();

                // $uniqueSubProducts = $subProducts->unique('standard_fabric');

                // $uniqueEmbellishments = $subProducts->pluck('type_of_embellishment')
                //     ->flatMap(function ($item) {
                //         return explode(' / ', $item);
                //     })
                //     ->unique()
                //     ->values();


                // return view('pages.internal_product_catalog.portal.product_view', [
                //     'product' => $product,
                //     'lifestyleImages' => $lifestyleImages,
                //     'Images3D' => $Images3D,
                //     'size' => $size,
                //     'mainCategory' => $mainCategory,
                //     'subProducts' =>$uniqueSubProducts,
                //     'uniqueEmbellishments'=>$uniqueEmbellishments
                // ]);


                $searchValue = $request->query('search', null);
                $selectedGender = $request->query('selectedGender', null);
                $selectedCategory = $request->query('selectedCategory', null);
                $selectedSport = $request->query('selectedSport', null);
                $selectedStyle = $request->query('selectedStyle', null);

                if ($type == 'product') {

                    $product = Product::find($id);
                    $product->size_chart = $product->size_chart ? 'assets'.$product->size_chart : null;

                    $fabricIDs = SubProduct::where('parent_product_id', $id)
                    ->where('active', 1)
                    ->pluck('standard_fabric')
                    ->toArray();

                    $lifestyleImages = ProductImage::where('product_id', $id)->where('image_type', 1)->pluck('image_link');
                    $Images3D = ProductImage::where('product_id', $id)->where('image_type', 2)->pluck('image_link');

                    $images_3d = ProductImage::where('active', 1)
                            ->where('product_id', $id)
                            ->where('image_type', 1)
                            ->take(2)
                            ->get();

                    $lifeStyle_images = ProductImage::where('active', 1)
                            ->where('product_id', $id)
                            ->where('image_type', 2)
                            ->take(2)
                            ->get();

                    $closeUp_images = ProductImage::where('active', 1)
                            ->where('product_id', $id)
                            ->where('image_type', 3)
                            ->take(2)
                            ->get();

                    $branding_images = ProductImage::where('active', 1)
                            ->where('product_id', $id)
                            ->where('image_type', 4)
                            ->take(2)
                            ->get();
                    $studio_images = ProductImage::where('active', 1)
                            ->where('product_id', $id)
                            ->where('image_type', 5)
                            ->take(2)
                            ->get();

                }elseif($type == 'subproduct'){

                    $sub_product_found = SubProduct::find($id);
                    $product = Product::find($sub_product_found->parent_product_id);

                    $product->product_no = $sub_product_found->sub_product_no;
                    $product->product_name = $sub_product_found->product_name;
                    $product->pattern_code = $sub_product_found->pattern_code;
                    $product->default_price = $sub_product_found->default_price;
                    $product->standard_fabric = $sub_product_found->standard_fabric;
                    $product->description = $sub_product_found->description;
                    $product->who_we_made_this_for = $sub_product_found->who_we_made_this_for;
                    $product->product_features = $sub_product_found->product_features;
                    $product->notes = $sub_product_found->notes;
                    $product->mockup_img_1 = $sub_product_found->mockup_img_1;
                    $product->mockup_img_2 = $sub_product_found->mockup_img_2;
                    $product->mockup_img_3 = $sub_product_found->mockup_img_3;
                    $product->size_chart = $sub_product_found->size_chart ?? ($product->size_chart ? 'assets'.$product->size_chart : null);

                    $fabricIDs = SubProduct::where('id', $id)
                    ->where('active', 1)
                    ->pluck('standard_fabric')
                    ->toArray();

                    $lifestyleImages = SubProductImage::where('sub_product_no', $sub_product_found->sub_product_no)->where('image_type', 1)->pluck('image_link');
                    $Images3D = SubProductImage::where('sub_product_no', $sub_product_found->sub_product_no)->where('image_type', 2)->pluck('image_link');

                    $images_3d = SubProductImage::where('active', 1)
                            ->where('sub_product_no', $sub_product_found->sub_product_no)
                            ->where('image_type', 1)
                            ->take(2)
                            ->get();

                    $lifeStyle_images = SubProductImage::where('active', 1)
                            ->where('sub_product_no', $sub_product_found->sub_product_no)
                            ->where('image_type', 2)
                            ->take(2)
                            ->get();

                    $closeUp_images = SubProductImage::where('active', 1)
                            ->where('sub_product_no', $sub_product_found->sub_product_no)
                            ->where('image_type', 3)
                            ->take(2)
                            ->get();

                    $branding_images = SubProductImage::where('active', 1)
                            ->where('sub_product_no', $sub_product_found->sub_product_no)
                            ->where('image_type', 4)
                            ->take(2)
                            ->get();
                    $studio_images = SubProductImage::where('active', 1)
                            ->where('sub_product_no', $sub_product_found->sub_product_no)
                            ->where('image_type', 5)
                            ->take(2)
                            ->get();

                }

                $fabricIDs = array_unique($fabricIDs);

                if (count($fabricIDs) > 0) {
                    $productFabric = implode(' | ', $fabricIDs);
                } else {
                    $productFabric = "No fabrics";
                }

                if (!$product) {
                    return redirect()->route('error.page');
                }
                $product_main_cat = ProductMainCategory::where('product_id' , $product->id)->first();
                $product->main_category_id = $product_main_cat->main_category_id;

                $categoryID = $product->product_category_id;

                $randomProducts = Product::inRandomOrder()
                    ->where('product_category_id', $categoryID)
                    ->where('show_in_catalog', 1)
                    ->take(4)
                    ->get();

                $size = Size::select('id', 'size_name', 'size_type')
                    ->where('size_name', 'not like', 'Extra%')
                    ->get();

                $mainCategory = MainCategory::select('id', 'category_name')->get();


                $EmbellishmentsFiltered = SubProduct::where('parent_product_id' , $id)->where('active' , 1)->pluck('type_of_embellishment')->toArray();
                if(count($EmbellishmentsFiltered) > 0){
                    $productEmblishment = $EmbellishmentsFiltered[0];
                }else{
                    $productEmblishment = "No available";
                }

                $productAttributes = ProductAttribute::where('product_id', $product->id)
                    ->whereIn('attribute_id', [3, 4, 5])
                    ->whereNull('deleted_at')
                    ->with('attributes')
                    ->get();

                $selectedMainCategory = MainCategory::where('id', $selectedCategory)->get();

                if ($productAttributes->isNotEmpty()) {
                    $attributeNames = [];
                    foreach ($productAttributes as $productAttribute) {
                        $attributeNames[] = $productAttribute->attributes->pluck('attribute_name')->implode(' | ');
                    }
                    $displayedAttributes = implode(' | ', $attributeNames);
                } else {
                    $displayedAttributes = "";
                }

                $mainCategories = MainCategory::orderBy('category_name')->get();

                $sports = Sport::orderBy('sport_name')->where('active', 1)->get();

                $productCategories = ProductCategory::orderBy('product_category_name')->where('active', 1)->get();

                $productColors = SubProductColor::where('id', $product->id)->get();

                $masterColors = ColorMaster::get();

                $relatedColors = [];

                foreach ($productColors as $productColor) {
                    foreach ($masterColors as $masterColor) {
                        if ($productColor->color_master_id == $masterColor->id) {
                            $relatedColors[] = $masterColor;
                        }
                    }
                }

                if ($type == 'subproduct') {
                    $fabricProducts = SubProduct::where('id', $id)
                    ->where('active', 1)
                    ->select('id', 'fabric_id')
                    ->get();
                }else{
                    $fabricProducts = SubProduct::where('parent_product_id', $id)
                    ->where('active', 1)
                    ->select('id', 'fabric_id')
                    ->get();
                }

                $fabricDetails = Fabric::get();

                $relatedFabric = [];

                foreach ($fabricProducts as $fabricProduct) {
                    foreach ($fabricDetails as $fabricDetail) {
                        if ($fabricProduct->fabric_id == $fabricDetail->id) {
                            $relatedFabric[] = [
                                'subproduct_id' => $fabricProduct->id,
                                'fabric_detail' => $fabricDetail,
                            ];
                        }
                    }
                }

                $attributeProducts = ProductAttribute::where('product_id', $id)
                    ->where('deleted_at', null)
                    ->get();

                $attributes = Attribute::get();

                $relatedAttributes = [];

                foreach ($attributeProducts as $attributeProduct) {
                    foreach ($attributes as $attribute) {
                        if ($attributeProduct->attribute_id == $attribute->id &&
                            $attribute->attribute_name != 'Player #' &&
                            $attribute->attribute_name != 'Player Name') {
                            $relatedAttributes[] = $attribute;
                        }
                    }
                }


                $embellishmentProducts = SubProduct::where('parent_product_id', $id)
                    ->where('active', 1)
                    ->pluck('type_of_embellishment')
                    ->toArray();

                $embellishmentTypes = EmbellishmentType::get();

                $relatedEmbellishments = [];

                foreach ($embellishmentProducts as $embellishmentProduct) {
                    $separatedEmbellishments = explode(' / ', $embellishmentProduct);

                    foreach ($separatedEmbellishments as $embellishment) {
                        foreach ($embellishmentTypes as $embellishmentType) {
                            if (trim($embellishment) == $embellishmentType->embellishment_name) {
                                if (!in_array($embellishmentType, $relatedEmbellishments)) {
                                    $relatedEmbellishments[] = $embellishmentType;
                                }
                            }
                        }
                    }
                }

            $productTaglineLists = ProductTaglineList::where('product_id', $product->id)->get();

            $masterTaglines = ProductTagline::get();

                $relatedTaglines = [];

                foreach ($productTaglineLists as $productTaglineList) {
                    foreach ($masterTaglines as $masterTagline) {
                        if ($productTaglineList->tagline_id == $masterTagline->id) {
                            $relatedTaglines[] = $masterTagline;
                        }
                    }
                }

                $productFits = ProductFit::where('product_id', $product->id)->get();

                $masterFits = MasterFit::get();

                $relatedFits = [];

                foreach ($productFits as $productFit) {
                    foreach ($masterFits as $masterFit) {
                        if ($productFit->fit_id == $masterFit->id) {
                            $relatedFits[] = $masterFit;
                        }
                    }
                }

                return view('pages.internal_product_catalog.portal.product_view', [
                    'searchValue'=> $searchValue,
                    'product' => $product,
                    'lifestyleImages' => $lifestyleImages,
                    'Images3D' => $Images3D,
                    'randomProducts' => $randomProducts,
                    'size' => $size,
                    'mainCategory' => $mainCategory,
                    'productFabric'=> $productFabric,
                    'selectedSport'=>$selectedSport,
                    'productEmblishment'=>$productEmblishment,
                    'productAttributes'=>$productAttributes,
                    'displayedAttributes'=>$displayedAttributes,
                    'mainCategories'=>$mainCategories,
                    'selectedCategory'=>$selectedCategory,
                    'selectedGender' =>$selectedGender,
                    'sports'=>$sports,
                    'selectedStyle'=>$selectedStyle,
                    'productCategories'=>$productCategories,
                    'relatedColors'=>$relatedColors,
                    'relatedFabric'=>$relatedFabric,
                    'relatedAttributes'=>$relatedAttributes,
                    'relatedEmbellishments'=>$relatedEmbellishments,
                    'images_3d'=>$images_3d,
                    'lifeStyle_images'=>$lifeStyle_images,
                    'relatedTaglines'=>$relatedTaglines,
                    'relatedFits'=>$relatedFits,
                    'closeUp_images'=>$closeUp_images,
                    'branding_images'=>$branding_images,
                    'studio_images'=>$studio_images
                ]);

            }

            public function adminProductFilter(Request $request)
            {
                $selectedCategories = $request->input('category', []);
                $selectedStyles = $request->input('style', []);
                $selectedGenders = $request->input('genders', []);
                $selectedSports = $request->input('sports', []);

                $selectedSports = Arr::flatten($selectedSports);

                $categoryMap = [
                    'Sport' => 1,
                    'Training' => 2,
                    'Lifestyle' => 3,
                    'Merch' => 4,
                ];

                $selectedCategoryIds = array_map(function ($value) use ($categoryMap) {
                    return ($value == '6') ? 3 : ($categoryMap[$value] ?? $value);
                }, $selectedCategories);

                $filteredCategoryIds = array_filter($selectedCategoryIds, fn($value) => $value != '5');

                $query = Product::where('show_in_catalog', 1)->where('active', '!=', 3);
                $subProducts = SubProduct::with('productDetails')->where('active', '!=', 3)->where('show_in_catalog', 1);

                if (!in_array('5', $selectedCategories)) {
                    if (!empty($filteredCategoryIds)) {
                        $mainCategoryRecords = ProductMainCategory::whereIn('main_category_id', $filteredCategoryIds)->pluck('product_id');
                        $query->whereIn('id', $mainCategoryRecords);

                        $subProducts->whereHas('productDetails', function ($query) use ($mainCategoryRecords) {
                            $query->whereIn('id', $mainCategoryRecords);
                        });
                    }
                }

                if (!empty($selectedGenders)) {

                    $query->where(function ($query) use ($selectedGenders) {
                        $query->whereIn('gender', $selectedGenders)
                            ->orWhere('gender', 'Uni');
                    });

                    $subProducts->whereHas('productDetails', function ($query) use ($selectedGenders) {
                        $query->whereIn('gender', $selectedGenders)
                              ->orWhere('gender', 'Uni');
                    });
                }

                if (!empty($selectedSports)) {
                    if (in_array('18', $selectedSports)) {
                        $query->where('id', '>', 0);
                    } else {
                        if (count($selectedSports) === 1) {
                            $selectedSport = $selectedSports[0];
                            $sportRecords = ProductSport::whereIn('sport_id', [$selectedSport, '18'])->pluck('product_id');
                            if ($sportRecords->isNotEmpty()) {
                                $query->whereIn('id', $sportRecords);

                                $subProducts->whereHas('productDetails', function ($query) use ($sportRecords) {
                                    $query->whereIn('id', $sportRecords);
                                });
                            }
                        } else {
                            if (!in_array('18', $selectedSports)) {
                                $selectedSports[] = '18';
                            }

                            $sportRecords = ProductSport::whereIn('sport_id', $selectedSports)->pluck('product_id');
                            if ($sportRecords->isNotEmpty()) {
                                $query->whereIn('id', $sportRecords);

                                $subProducts->whereHas('productDetails', function ($query) use ($sportRecords) {
                                    $query->whereIn('id', $sportRecords);
                                });
                            }
                        }
                    }
                }

                if (!empty($selectedStyles)) {
                    $styleRecords = ProductCategoryList::whereIn('product_category_id', $selectedStyles)->pluck('product_id');
                    if ($styleRecords->isNotEmpty()) {
                        $query->whereIn('id', $styleRecords);

                        $subProducts->whereHas('productDetails', function ($query) use ($styleRecords) {
                            $query->whereIn('id', $styleRecords);
                        });

                    }
                }

                $productsData = $query->get();
                $sub_products = $subProducts->get();

                $combinedProducts = collect();

                foreach ($productsData as $product) {
                    $combinedProducts->push([
                        'product_no' => $product->product_no,
                        'type' => 'main',
                        'data' => $product,
                    ]);
                }

                foreach ($sub_products as $subProduct) {
                    $combinedProducts->push([
                        'product_no' => $subProduct->sub_product_no,
                        'type' => 'sub',
                        'data' => $subProduct,
                    ]);
                }

                $sortedProducts = $combinedProducts->sort(function ($a, $b) {

                    $aNumber = preg_replace('/[^0-9.]/', '', $a['product_no']);
                    $bNumber = preg_replace('/[^0-9.]/', '', $b['product_no']);

                    $aParts = array_map('floatval', explode('.', $aNumber));
                    $bParts = array_map('floatval', explode('.', $bNumber));

                    foreach ($aParts as $index => $aPart) {
                        $bPart = $bParts[$index] ?? 0;
                        if ($aPart !== $bPart) {
                            return $aPart <=> $bPart;
                        }
                    }

                    return count($aParts) <=> count($bParts);
                })->values();

                $products = $sortedProducts->map(fn($item) => $item['data']);

                return response()->json([
                    'products' => $products,
                    'selectedSports' => $selectedSports,
                ]);
            }

    public function productSearchAdminCatalog(Request $request){

        $searchValue = $request->input('keyword');


        $matchingData = collect();
        $matchingSub = collect();
        $sub_products = SubProduct::with('productDetails')->where('active', '!=', 3)->where('show_in_catalog', 1)->get();

        // Query 1: Check the 'products' table
        $query1 = Product::query();
        $query1->select('products.*');
        $query1->where(function ($query) use ($searchValue) {
            $query->where('gender', 'LIKE', '%' . $searchValue . '%')
                ->orWhere('product_name', 'LIKE', '%' . $searchValue . '%')
                ->orWhere('product_no', $searchValue);
        });
        $query1->where('show_in_catalog', 1)->where('active', '!=', 3);
        $results1 = $query1->get();

        if (!$results1->isEmpty()) {
            $matchingData = $matchingData->merge($results1);
        }

        $filtered_sub1 = $sub_products->filter(function ($subProduct) use ($searchValue) {

            $matchesGender = $subProduct->productDetails && stripos($subProduct->productDetails->gender, $searchValue) !== false;

            $matchesProductName = stripos($subProduct->product_name, $searchValue) !== false;
            $matchesSubProductNo = stripos($subProduct->sub_product_no, $searchValue) !== false;

            return $matchesGender || $matchesProductName || $matchesSubProductNo;
        });

        if (!$filtered_sub1->isEmpty()) {
            $matchingSub = $matchingSub->merge($filtered_sub1);
        }

        // Query 2: Check the 'product_sports' and 'sports' tables
        $query2 = Product::query();
        $query2->select('products.*', 'sports.*', 'product_sports.*');
        $query2->join('product_sports', 'products.id', '=', 'product_sports.product_id');
        $query2->join('sports', 'product_sports.sport_id', '=', 'sports.id');
        $query2->where('sports.sport_name', 'LIKE', '%' . $searchValue . '%');
        $query2->where('product_sports.deleted_at', null);
        $query2->where('products.show_in_catalog', 1)->where('products.active', '!=', 3);
        $results2 = $query2->get();

        if (!$results2->isEmpty()) {
            $matchingData = $matchingData->merge($results2);
        }

        $filtered_sub2 = $sub_products->filter(function ($subProduct) use ($searchValue) {
            $matchesSports = $subProduct->productDetails && $subProduct->productDetails->productsport &&
                $subProduct->productDetails->productsport->contains(function ($productSport) use ($searchValue) {
                    return stripos($productSport->sport->sport_name, $searchValue) !== false;
            });

            return $matchesSports;
        });

        if (!$filtered_sub2->isEmpty()) {
            $matchingSub = $matchingSub->merge($filtered_sub2);
        }

        // Query 3: Check the 'product_main_categories' and 'main_categories' tables
        $query3 = Product::query()
            ->select('products.*', 'main_categories.*', 'product_main_categories.*')
            ->join('product_main_categories', 'products.id', '=', 'product_main_categories.product_id')
            ->join('main_categories', 'product_main_categories.main_category_id', '=', 'main_categories.id')
            ->where('product_main_categories.deleted_at', null)
            ->Where('main_categories.category_name', 'LIKE', '%' . $searchValue . '%')
            ->where('products.show_in_catalog', 1)->where('products.active', '!=', 3);
        $results3 = $query3->get();

        if (!$results3->isEmpty()) {
            $matchingData = $matchingData->merge($results3);
        }

        $filtered_sub3 = $sub_products->filter(function ($subProduct) use ($searchValue) {
            $matchesMain = $subProduct->productDetails && $subProduct->productDetails->productMainCategories &&
                $subProduct->productDetails->productMainCategories->contains(function ($productMainCategories) use ($searchValue) {
                    return stripos($productMainCategories->main_category->category_name, $searchValue) !== false;
            });

            return $matchesMain;
        });

        if (!$filtered_sub3->isEmpty()) {
            $matchingSub = $matchingSub->merge($filtered_sub3);
        }

        // Query 4: Check the 'product_category_lists' and 'product_categories' tables
        $query4 = Product::query()
            ->select('products.*', 'product_categories.*', 'product_category_lists.*')
            ->join('product_category_lists', 'products.id', '=', 'product_category_lists.product_id')
            ->join('product_categories', 'product_category_lists.product_category_id', '=', 'product_categories.id')
            ->where('product_category_lists.deleted_at', null)
            ->Where('product_categories.product_category_name', 'LIKE', '%' . $searchValue . '%')
            ->where('products.show_in_catalog', 1)->where('products.active', '!=', 3);
        $results4 = $query4->get();

        if (!$results4->isEmpty()) {
            $matchingData = $matchingData->merge($results4);
        }

        $filtered_sub4 = $sub_products->filter(function ($subProduct) use ($searchValue) {
            $matchesMain = $subProduct->productDetails &&
                           $subProduct->productDetails->productCategories &&
                           $subProduct->productDetails->productCategories->contains(function ($productCategory) use ($searchValue) {
                               return stripos($productCategory->categories[0]->product_category_name, $searchValue) !== false;
                           });

            return $matchesMain;
        });

        if (!$filtered_sub4->isEmpty()) {
            $matchingSub = $matchingSub->merge($filtered_sub4);
        }

        // $matchingSub = $matchingSub->unique('id');

        $matchingSub = $matchingSub->unique('id');
        $matchingData = $matchingData->unique('id');

        // Combine results into a single collection
        $combinedProducts = collect();

        foreach ($matchingData as $product) {
            $combinedProducts->push([
                'product_no' => $product->product_no,
                'type' => 'main',
                'data' => $product,
            ]);
        }

        foreach ($matchingSub as $subProduct) {
            $combinedProducts->push([
                'product_no' => $subProduct->sub_product_no,
                'type' => 'sub',
                'data' => $subProduct,
            ]);
        }

        $sortedProducts = $combinedProducts->unique('product_no')->sort(function ($a, $b) {
            $aNumber = preg_replace('/[^0-9.]/', '', $a['product_no']);
            $bNumber = preg_replace('/[^0-9.]/', '', $b['product_no']);

            $aParts = array_map('floatval', explode('.', $aNumber));
            $bParts = array_map('floatval', explode('.', $bNumber));

            foreach ($aParts as $index => $aPart) {
                $bPart = $bParts[$index] ?? 0;
                if ($aPart !== $bPart) {
                    return $aPart <=> $bPart;
                }
            }

            return count($aParts) <=> count($bParts);
        })->values();

        $products = $sortedProducts->map(fn($item) => $item['data']);


        return response()->json([
            'products' => $products,
            'searchValue' => $searchValue,
        ]);
    }

}
