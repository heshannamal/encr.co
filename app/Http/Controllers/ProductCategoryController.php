<?php

namespace App\Http\Controllers;

use App\Models\ColumnLayout;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ProductCategoryLayout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProductCategoryController extends Controller
{
    public function index(){
        if(auth()->user()->can('manage product categories')){
            $productCategories = ProductCategory::where('active', 1)->orderBy('product_category_name')->get();

            $productCategoryLayout = productCategoryLayout::where('user_id', Auth::user()->id)->first();

            $columnLayout = ColumnLayout::where('interface_id', 6)->where('user_id', Auth::user()->id)->first();

            return view('pages.masters.product_categories.index',[
                'productCategories'=>$productCategories, 'productCategoryLayout'=>$productCategoryLayout, 'columnLayout'=>$columnLayout
            ]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function create(Request $request){

        $imagePath = null;

        if ($request->hasFile('new_profile_pic')) {
            $image = $request->file('new_profile_pic');

            $directoryPath = base_path('assets/Master/category/');

            if (!File::exists($directoryPath)) {
                File::makeDirectory($directoryPath, 0777, true, true);
            }

            $originalFileName = $image->getClientOriginalName();

            $uniqueFileName = $originalFileName;

            $image->move($directoryPath, $uniqueFileName);

            $imagePath = 'assets/Master/category/' . $uniqueFileName;
        }

        $productCategories = new ProductCategory();
        $productCategories->product_category_name = $request->new_product_category_name;
        $productCategories->active = 1;
        $productCategories->category_image = $imagePath;
        $productCategories->save();

        return redirect()->route('product_categories')->withSuccess('Product Style Saved Successfully!');
    }

    public function delete($id){
        $productCategories = ProductCategory::find($id);
        $productCategories->active = 0;
        $productCategories->update();

        return redirect()->route('product_categories')->withSuccess('Product Style Delete Successfully!');

    }

    public function edit($id){
        $productCategory = ProductCategory::find($id);
        return json_encode($productCategory);
    }

    public function update(Request $request){

        $productCategories = ProductCategory::find($request->product_category_id);
        $productCategories->product_category_name = $request->edit_product_category_name;


        $imagePath = null;

        if ($request->hasFile('edit_profile_pic')) {
            $image = $request->file('edit_profile_pic');

            $directoryPath = base_path('assets/Master/category/');

            if (!File::exists($directoryPath)) {
                File::makeDirectory($directoryPath, 0777, true, true);
            }

            $originalFileName = $image->getClientOriginalName();

            $uniqueFileName = $originalFileName;

            $image->move($directoryPath, $uniqueFileName);

            $imagePath = 'assets/Master/category/' . $uniqueFileName;
            
            $productCategories->category_image = $imagePath;

        }

        $productCategories->update();

        return redirect()->route('product_categories')->withSuccess('Product Style Updated Successfully!');
    }


    public function sortApphabet($id){
        $ProductCategory = ProductCategory::where('product_category_name', 'LIKE', $id.'%')->where('active',1)->get();
        return json_encode($ProductCategory);
    }

    public function layout(Request $request){
        if(ProductCategoryLayout::where('user_id', Auth::user()->id)->first()){
            $productCategoryLayout = ProductCategoryLayout::find($request->layout_id);
            $productCategoryLayout->product_category_name = $request->product_category_name;
            $productCategoryLayout->created = $request->created_at;
            $productCategoryLayout->updated = $request->updated_at;
            $productCategoryLayout->update();

            $successMsg = "Updated";

        } else {
            $productCategoryLayout = new ProductCategoryLayout();
            $productCategoryLayout->user_id = Auth::user()->id;
            $productCategoryLayout->product_category_name = 1;
            $productCategoryLayout->created = $request->created_at;
            $productCategoryLayout->updated = $request->updated_at;
            $productCategoryLayout->save();

            $successMsg = "Saved";
        }

        return json_encode($successMsg);
    }
}
