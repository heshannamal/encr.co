<?php

namespace App\Http\Controllers;

use App\Models\Indic;
use App\Models\Organization;
use App\Models\ProductStore;
use App\Models\Product;
use App\Models\Size;
use App\Models\OrganizationStores;
use App\Models\OrganizationStoreProduct;
use App\Models\OrganizationStoreProductSize;
use Illuminate\Http\Request;

class OrderPlaceController extends Controller
{
    //
    public function index(){
        if(auth()->user()->can('add omg store')){
            $organizations = Organization::select('id', 'organization_name')->where('active', 1)->orderBy('organization_name')->get();
            return view('pages.order_place.index', ['organizations'=>$organizations]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    /*
        public function uploadProfile(Request $request){
        // dd($request);

        // $coverpic=new Index();
        // $coverpic-> cover_pic=$request->cover_pic;
        // $coverpic-> profile_pic=$request->profile_pic;
        // $coverpic->save();
        // dd($request);
        request()->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
       ]);
       if ($files = $request->file('profile_image')) {
       // Define upload path
           $destinationPath = public_path('/profile_images/'); // upload path
         // Upload Orginal Image
           $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
           $files->move($destinationPath, $profileImage);

        //    $insert['image'] = "$profileImage";
        // Save In Database
            $imagemodel=Indic::first();
            $imagemodel->profile_pic="$profileImage";
            $imagemodel->update();
        }
        return back()->with('success', 'Image Upload successfully');

        }
        public function uploadCover(Request $request){
            // dd($request);
            request()->validate([
                'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($files = $request->file('cover_image')) {
        // Define upload path
            $destinationPath = public_path('/cover_image/'); // upload path
            // Upload Orginal Image
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profileImage);

            //    $insert['image'] = "$profileImage";
            // Save In Database
                // $imagemodel= new Indic();
                $imagemodel= Indic::first();
                $imagemodel->cover_pic="$profileImage";
                $imagemodel->update();
            }
            return back()->with('success', 'Image Upload successfully');


        }
        public function orderdescription(){
            return view('pages.order_place.description');

        }

    */

    public function addOrganizationStore(Request $request)
    {

        $profileImage = null;
        $coverImage = null;

        if ($files = $request->file('profile_image')) {
            // Define upload path
                $destinationPath = public_path('/profile_images/'); // upload path
              // Upload Orginal Image
                $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $profileImage);

             //    $insert['image'] = "$profileImage";
             // Save In Database
                 //$imagemodel=Indic::first();
                 //$imagemodel->profile_pic="$profileImage";
                 //$imagemodel->update();
        }
        if ($files = $request->file('cover_image')) {
            // Define upload path
                $destinationPath = public_path('/cover_image/'); // upload path
              // Upload Orginal Image
                $coverImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $coverImage);

             //    $insert['image'] = "$profileImage";
             // Save In Database
                 // $imagemodel= new Indic();
                 //$imagemodel= Indic::first();
                 //$imagemodel->cover_pic="$coverImage";
                 //$imagemodel->update();
        }

        $OrganizationStores = new OrganizationStores();
        $OrganizationStores->organization_id = $request->organization_id;
        $OrganizationStores->store_name = $request->store_name;
        $OrganizationStores->cover_pic = "$coverImage";
        $OrganizationStores->profile_pic = "$profileImage";
        $OrganizationStores->store_sport = $request->store_sport;
        $OrganizationStores->store_description = $request->store_description;
        $OrganizationStores->save();



        return redirect("/OMG/store/edit/$OrganizationStores->id")->with('success', 'Successfully created the store!');


        //return back()->with('success', 'Successfully created the store!');

    }

    public function editStore($id){
        $OrganizationStores = OrganizationStores::with('organizationDetails')
                                            ->where('id', $id)
                                            ->get();

                                            //return $organizations;

        $organizations = Organization::select('id', 'organization_name')->where('active', 1)->orderBy('organization_name')->get();

        return view('pages.order_place.edit_store', ['OrganizationStores'=>$OrganizationStores,'organizations'=>$organizations]);
    }

    public function editOrganizationStore(Request $request){

        $organizatinalStoreId = $request->organizatinalStoreId;
        $OrganizationStores = OrganizationStores::find($organizatinalStoreId);
        $OrganizationStores->organization_id = $request->organization_id;
        $OrganizationStores->store_name = $request->store_name;
        $OrganizationStores->store_sport = $request->store_sport;
        $OrganizationStores->store_description = $request->store_description;

        if ($files = $request->file('profile_image')) {
            // Define upload path
                $destinationPath = public_path('/profile_images/'); // upload path
                if(unlink($destinationPath."/".$OrganizationStores->profile_pic))
                {

                }

              // Upload Orginal Image
                $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $profileImage);

                $OrganizationStores->profile_pic = "$profileImage";
        }
        if ($files = $request->file('cover_image')) {
            // Define upload path
                $destinationPath = public_path('/cover_image/'); // upload path
                if(unlink($destinationPath."/".$OrganizationStores->cover_pic))
                {

                }
              // Upload Orginal Image
                $coverImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $coverImage);

                $OrganizationStores->cover_pic = "$coverImage";
        }


        $OrganizationStores->update();
        return redirect("/OMG/store/edit/$OrganizationStores->id")->with('success', 'Successfully Edited the store!');
    }

    public function addStoreProduct($id){

        $productsGenders = Product::select('gender')->distinct()->get();

        $productSizes = Size::select('id','size_name')->where('size_type',1)->whereNotIn('id',[17,18,19])->get();

        $OrganizationStores = OrganizationStores::with('organizationDetails')
                                                ->where('id', $id)
                                                ->get();


        return view('pages.order_place.add_organizational_store_product',['productsGenders'=>$productsGenders,'productSizes'=>$productSizes,'OrganizationStores'=>$OrganizationStores]);
    }

    public function getProductNames(Request $request)
    {
        $genderSelected = $request->genderCategorySelected;
        $productsNames = Product::select('id','product_name')->where('gender',$genderSelected)->get();

        $string = "<option value=''>Select a Product</option>";
        foreach ($productsNames as $productsName) {
            if($string == "")
            {
                $string .= "<option value='$productsName->id'>$productsName->product_name</option>";
            }
            else{
                $string .= "<option value='$productsName->id'>$productsName->product_name</option>";
            }
        }
        echo $string;
    }

    public function addOrganizationStoreProduct(Request $request)
    {
        $OrganizationStoreProduct = new OrganizationStoreProduct();
        $OrganizationStoreProduct->organization_store_id = $request->organizatinalStoreId;
        $OrganizationStoreProduct->product_id = $request->product_id;
        //$OrganizationStoreProduct->size_id = $request->
        $OrganizationStoreProduct->in_stock_status = $request->product_status;
        $OrganizationStoreProduct->sku_no = $request->product_sku;
        $OrganizationStoreProduct->price = $request->product_price;
        $OrganizationStoreProduct->discount = $request->product_discount;
        $OrganizationStoreProduct->short_description = $request->product_short_description;
        $OrganizationStoreProduct->qty = $request->product_qty;

        $OrganizationStoreProduct->category = $request->product_gender_category;

        if ($files = $request->file('pic_one')) {
            // Define upload path
                $destinationPath1 = public_path('/product_store_pic1/'); // upload path

              // Upload Orginal Image
                $profileImage1 = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath1, $profileImage1);

                $OrganizationStoreProduct->pic_one = "$profileImage1";
        }
        if ($files = $request->file('pic_two')) {
            // Define upload path
                $destinationPath2 = public_path('/product_store_pic2/'); // upload path

              // Upload Orginal Image
                $profileImage2 = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath2, $profileImage2);

                $OrganizationStoreProduct->pic_two = "$profileImage2";
        }
        if ($files = $request->file('pic_three')) {
            // Define upload path
                $destinationPath3 = public_path('/product_store_pic3/'); // upload path

              // Upload Orginal Image
                $profileImage3 = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath3, $profileImage3);

                $OrganizationStoreProduct->pic_three = "$profileImage3";
        }
        $OrganizationStoreProduct->save();

        foreach ($request->product_sizes_id as $productSizes) {

            $OrganizationStoreProductSize = new OrganizationStoreProductSize();
            $OrganizationStoreProductSize->organization_store_product_id = $OrganizationStoreProduct->id;
            $OrganizationStoreProductSize->size_id = $productSizes;
            $OrganizationStoreProductSize->save();

        }

        return redirect("OMG/store/product/edit/$OrganizationStoreProduct->id")->with('success', 'Successfully Added the product!');

    }


    public function allStores(){

        if(auth()->user()->can('manage omg store')){
        $OrganizationStores = OrganizationStores::with('organizationDetails')
                                        ->where('active_status','!=','0')
                                        ->orWhere('active_status',null)
                                        ->get();
            return view('pages.order_place.all_stores',['OrganizationStores' => $OrganizationStores]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function allStoreproducts($id)
    {
        $OrganizationStoreProduct = OrganizationStoreProduct::with('organizationStoreDetails','productDetails')
                                    ->where('active_status','!=','0')
                                    ->where('organization_store_id',$id)
                                    ->get();

        $OrganizationStores = OrganizationStores::with('organizationDetails')
                                    ->where('id',$id)
                                    ->get();

        $productsArray = [];
        $storeName = $OrganizationStores[0]->store_name;
        $OrganizationName = $OrganizationStores[0]->organizationDetails['organization_name'];
        foreach ($OrganizationStoreProduct as $OrganizationStoreProd) {

            $organizationInfo = Organization::select('id', 'organization_name')->where('id', $OrganizationStoreProd->organizationStoreDetails['organization_id'])->get();
            $Product = Product::select('product_name')->where('id',$OrganizationStoreProd->product_id)->get();

            /*if($storeName == "")
            {
                $storeName = $OrganizationStoreProd->organizationStoreDetails['store_name'];
            }
            if($OrganizationName == "")
            {
                $OrganizationName = $organizationInfo[0]->organization_name;
            }*/


            $productsArray[] = array('ID'=>$OrganizationStoreProd->id, 'OrganizationID'=>$organizationInfo[0]->id, 'Organization'=>$organizationInfo[0]->organization_name, 'Store_Id'=>$OrganizationStoreProd->organizationStoreDetails['id'], 'Store_Name'=>$OrganizationStoreProd->organizationStoreDetails['store_name'], 'Product'=>$Product[0]->product_name, 'SKU_No'=>$OrganizationStoreProd->sku_no, 'Price'=>$OrganizationStoreProd->price, 'Discount'=>$OrganizationStoreProd->discount, 'QTY'=>$OrganizationStoreProd->qty, 'Category'=>$OrganizationStoreProd->category, 'Created_At'=>$OrganizationStoreProd->created_at, 'Updated_At'=>$OrganizationStoreProd->updated_at );
        }

        return view('pages.order_place.all_store_products',['productsArray' => $productsArray,'storeName'=>$storeName,'OrganizationName'=>$OrganizationName]);
    }





    public function editProduct($id){

        $OrganizationStoreProduct = OrganizationStoreProduct::with('organizationStoreDetails','productDetails')
                                            ->where('id', $id)
                                            ->get();


        $organizationInfo = Organization::select('id', 'organization_name')->where('id', $OrganizationStoreProduct[0]->organizationStoreDetails['organization_id'])->get();


        $productsGenders = Product::select('gender')->distinct()->get();

        $productSizes = Size::select('id','size_name')->where('size_type',1)->whereNotIn('id',[17,18,19])->get();


        $OrganizationStoreProductSize = OrganizationStoreProductSize::Select('size_id')->where('organization_store_product_id',$id)->get();



        return view("pages.order_place.edit_organizational_store_product",['OrganizationStoreProduct'=>$OrganizationStoreProduct,'organizationInfo'=>$organizationInfo, 'productsGenders'=>$productsGenders, 'productSizes'=>$productSizes,'OrganizationStoreProductSize'=>$OrganizationStoreProductSize]);
    }

    public function editOrganizationStoreProduct(Request $request){

        $storeProductID = $request->organizatinalStoreProductId;

        $OrganizationStoreProduct = OrganizationStoreProduct::find($storeProductID);

        //$OrganizationStoreProduct->organization_store_id = $request->organizatinalStoreId;
        $OrganizationStoreProduct->product_id = $request->product_id;
        //$OrganizationStoreProduct->size_id = $request->
        $OrganizationStoreProduct->in_stock_status = $request->product_status;
        $OrganizationStoreProduct->sku_no = $request->product_sku;
        $OrganizationStoreProduct->price = $request->product_price;
        $OrganizationStoreProduct->discount = $request->product_discount;
        $OrganizationStoreProduct->short_description = $request->product_short_description;
        $OrganizationStoreProduct->qty = $request->product_qty;

        $OrganizationStoreProduct->category = $request->product_gender_category;

        if ($files = $request->file('pic_one')) {

            // Define upload path
                $destinationPath1 = public_path('/product_store_pic1/'); // upload path

                if(unlink($destinationPath1."/".$OrganizationStoreProduct->pic_one))
                {

                }
              // Upload Orginal Image
                $profileImage1 = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath1, $profileImage1);

                $OrganizationStoreProduct->pic_one = "$profileImage1";
        }
        if ($files = $request->file('pic_two')) {
            // Define upload path
                $destinationPath2 = public_path('/product_store_pic2/'); // upload path
                if(unlink($destinationPath2."/".$OrganizationStoreProduct->pic_two))
                {

                }

              // Upload Orginal Image
                $profileImage2 = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath2, $profileImage2);

                $OrganizationStoreProduct->pic_two = "$profileImage2";
        }
        if ($files = $request->file('pic_three')) {
            // Define upload path
                $destinationPath3 = public_path('/product_store_pic3/'); // upload path
                if(unlink($destinationPath3."/".$OrganizationStoreProduct->pic_three))
                {

                }

              // Upload Orginal Image
                $profileImage3 = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath3, $profileImage3);

                $OrganizationStoreProduct->pic_three = "$profileImage3";
        }
        $OrganizationStoreProduct->update();

        OrganizationStoreProductSize::where('organization_store_product_id',$storeProductID)->delete();

        foreach ($request->product_sizes_id as $productSizes) {

            $OrganizationStoreProductSize = new OrganizationStoreProductSize();
            $OrganizationStoreProductSize->organization_store_product_id = $OrganizationStoreProduct->id;
            $OrganizationStoreProductSize->size_id = $productSizes;
            $OrganizationStoreProductSize->save();

        }

        return redirect("OMG/store/product/edit/$storeProductID")->with('success', 'Successfully Edited the product!');
    }

    public function deleteStore(Request $request)
    {
        $OrganizationStores = OrganizationStores::find($request->storeID);
        $OrganizationStores->active_status = 0;
        $OrganizationStores->update();
        echo "deleted";
    }

    public function deleteStoreProduct(Request $request)
    {
        $OrganizationStoreProduct = OrganizationStoreProduct::find($request->storeProductID);
        $OrganizationStoreProduct->active_status = 0;
        $OrganizationStoreProduct->update();
        echo "deleted";
    }


    public function desstore(Request $request){

        // dump($request->cover_image);
        // dump($request->left_image);
        // dd($request->right_image);
        request()->validate([
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'left_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'right_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',



       ]);
    //    if ($files = $request->file('cover_image')) {
        $file1 = $request->file('cover_image');
        $file2 = $request->file('left_image');
        $file3 = $request->file('right_image');
       // Define upload path
           $destinationPath = public_path('/decription_image/'); // upload path
           $destinationPath1 = public_path('/decription_image1/'); // upload path
           $destinationPath2 = public_path('/decription_image2/'); // upload path

         // Upload Orginal Image
           $profileImage = date('YmdHis') . "." . $file1->getClientOriginalExtension();
           $profileImage1 = date('YmdHis') . "." . $file2->getClientOriginalExtension();
           $profileImage2 = date('YmdHis') . "." . $file3->getClientOriginalExtension();
           $file1->move($destinationPath, $profileImage);
           $file2->move($destinationPath1, $profileImage1);
           $file3->move($destinationPath2, $profileImage2);

        //    $insert['image'] = "$profileImage";
        // Save In Database
            // $imagemodel= new Indic();
           $store=new ProductStore();
           $store->price=$request->price;
           $store->description=$request->description;
           $store->gender=$request->gender;
           $store->picture=$profileImage;
           $store->picture1=$profileImage1;
           $store->picture2=$profileImage2;
           $store->save();

        //    dump($request->price);
        //    dump($request->description);
        //    dump($request->gender);
        //    dump($profileImage);
        //    dump($profileImage1);
        //    dump($profileImage2);
        //    dd($store);

        // }

        return back()->with('success', 'successfully Saved');


    }


    }

