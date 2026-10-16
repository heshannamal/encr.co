<?php

namespace App\Http\Controllers;
use App\Models\MainCategory;
use Illuminate\Support\Facades\File;

use Illuminate\Http\Request;

class MainCategoryController extends Controller
{
    public function index(){

        $mainCategories = MainCategory::orderBy('category_name')->get();

        return view('pages.masters.main_categories.index',[ 'mainCategories'=>$mainCategories
        ]);
    }

    public function create(Request $request){

        $imagePath = null;

        if ($request->hasFile('new_profile_pic')) {
            $image = $request->file('new_profile_pic');

            $directoryPath = base_path('assets/Master/Style/');

            if (!File::exists($directoryPath)) {
                File::makeDirectory($directoryPath, 0777, true, true);
            }

            $originalFileName = $image->getClientOriginalName();

            $uniqueFileName = $originalFileName;

            $image->move($directoryPath, $uniqueFileName);

            $imagePath = 'assets/Master/Style/' . $uniqueFileName;
        }

        $catalogCategories = new MainCategory();
        $catalogCategories->category_name = $request->new_catalog_category_name;
        $catalogCategories->style_image = $imagePath;
        $catalogCategories->save();

        return redirect()->route('catalog_categories')->withSuccess('Catalog Category Saved Successfully!');
    }

    public function edit($id){
        $catalogCategory = MainCategory::where('id', $id)->first();

        if ($catalogCategory) {
            return response()->json($catalogCategory);
        } else {
            return response()->json(['error' => 'Product Tagline not found'], 404);
        }
    }

    public function update(Request $request){

        $mainCategories = MainCategory::find($request->catalog_category_id);
        $mainCategories->category_name = $request->edit_catalog_category_name;


        $imagePath = null;

        if ($request->hasFile('edit_profile_pic')) {
            $image = $request->file('edit_profile_pic');

            $directoryPath = base_path('assets/Master/Style/');

            if (!File::exists($directoryPath)) {
                File::makeDirectory($directoryPath, 0777, true, true);
            }

            $originalFileName = $image->getClientOriginalName();

            $uniqueFileName = $originalFileName;

            $image->move($directoryPath, $uniqueFileName);

            $imagePath = 'assets/Master/Style/' . $uniqueFileName;

            $mainCategories->style_image = $imagePath;

        }

        $mainCategories->update();

        return redirect()->route('catalog_categories')->withSuccess('Catalog Category Updated Successfully!');
    }

    public function delete($id){
        $mainCategory = MainCategory::find($id);
        $mainCategory->delete();

        return redirect()->route('catalog_categories')->withSuccess('Catalog Category Delete Successfully!');

    }
}
