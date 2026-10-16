<?php

namespace App\Http\Controllers;

use App\Models\ColumnLayout;
use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\AttributeLayout;
use App\Models\ColorMaster;
use App\Models\AttributeColor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AttributesController extends Controller
{
    public function index(){
        if(auth()->user()->can('manage attribute')){
            $attributes = Attribute::where('active', 1)->orderBy('attribute_name')->get();

            $attributeLayout = AttributeLayout::where('user_id', Auth::user()->id)->first();

            $columnLayout = ColumnLayout::where('interface_id', 13)->where('user_id', Auth::user()->id)->first();

            $colorMasters = ColorMaster::get();

            return view('pages.masters.attributes.index',[
                'attributes'=>$attributes, 'attributeLayout'=>$attributeLayout, 'columnLayout'=>$columnLayout, 'colorMasters'=>$colorMasters
            ]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function create(Request $request){
        // dd($request);

        $imagePaths = [];

        $lastAttribute = Attribute::latest('id')->first();
        $nextId = $lastAttribute ? $lastAttribute->id + 1 : 1;

        if ($request->hasFile('attribute_images')) {
            foreach ($request->file('attribute_images') as $image) {
                $directoryPath = base_path('assets/Master/Attributes/' . $nextId);

                if (!File::exists($directoryPath)) {
                    File::makeDirectory($directoryPath, 0777, true, true);
                }

                $originalFileName = $image->getClientOriginalName();

                $uniqueFileName = $originalFileName;
                $imagePath = $directoryPath . '/' . $uniqueFileName;

                $image->move($directoryPath, $uniqueFileName);

                $imagePaths[] = 'assets/Master/Attributes/' . $nextId . '/' . $uniqueFileName;
            }
        }

        $attribute= new Attribute();
        $attribute->image_1 = $imagePaths[0] ?? null;
        $attribute->image_2 = $imagePaths[1] ?? null;
        $attribute->image_3 = $imagePaths[2] ?? null;
        $attribute->image_4 = $imagePaths[3] ?? null;
        $attribute->image_5 = $imagePaths[4] ?? null;

        $attribute->description = $request->input('new_description', '');

        $attribute->attribute_name = $request->new_attribute;

        if(isset($request->is_sub_attribute)){
            $attribute->is_sub_attribute = 1;
        } else {
            $attribute->is_sub_attribute = 0;
        }

        if($request->new_attribute_price!=""){
            $attribute->price = $request->new_attribute_price;
        }

        $attribute->active = 1;
        $attribute->save();

        if ($request->has('new_attribute_colors')) {
            foreach ($request->new_attribute_colors as $colorId) {

                $attributeColor= new AttributeColor();
                $attributeColor->attribute_id = $nextId;
                $attributeColor->color_master_id = $colorId;
                $attributeColor->save();
            }
        }

        return redirect()->route('attributes')->withSuccess('Attribute Saved Successfully!');
    }

    public function delete($id){
        $attribute = Attribute:: find($id);
        $attribute->active = 0;
        $attribute->update();

        return redirect()->route('attributes')->withSuccess('Attribute Delete Successfully!');
    }

    public function edit($id) {
        $attribute = Attribute::find($id);
        $attributeColor = AttributeColor::where('attribute_id',$id)->get();

        return response()->json([
            'attribute' => $attribute,
            'attributeColor' => $attributeColor,
            'images' => [
                $attribute->image_1,
                $attribute->image_2,
                $attribute->image_3,
                $attribute->image_4,
                $attribute->image_5
            ]
        ]);
    }

    public function update(Request $request){
        // dd($request);
        $attribute = Attribute::find($request->attribute_id);

        $imagePaths = [];

        if ($request->hasFile('edit_attribute_images')) {
            foreach ($request->file('edit_attribute_images') as $image) {
                $directoryPath = base_path('assets/Master/Attributes/' . $request->attribute_id);

                if (!File::exists($directoryPath)) {
                    File::makeDirectory($directoryPath, 0777, true, true);
                }

                $originalFileName = $image->getClientOriginalName();
                $fileName = pathinfo($originalFileName, PATHINFO_FILENAME);
                $fileExtension = $image->getClientOriginalExtension();

                $uniqueFileName = $originalFileName;
                $imagePath = $directoryPath . '/' . $uniqueFileName;
                $image->move($directoryPath, $uniqueFileName);
                $imagePaths[] = 'assets/Master/Attributes/' . $request->attribute_id . '/' . $uniqueFileName;
            }
        }

        $existingImages = $request->input('existing_images', []);
        $allImages = array_merge($existingImages, $imagePaths);

        $attribute->image_1 = $allImages[0] ?? null;
        $attribute->image_2 = $allImages[1] ?? null;
        $attribute->image_3 = $allImages[2] ?? null;
        $attribute->image_4 = $allImages[3] ?? null;
        $attribute->image_5 = $allImages[4] ?? null;

        $attribute->attribute_name = $request->edit_attribute;
        $attribute->description = $request->input('edit_description', '');

        if(isset($request->is_sub_attribute)){
            $attribute->is_sub_attribute = 1;
        } else {
            $attribute->is_sub_attribute = 0;
        }

        if($request->edit_attribute_price!=""){
            $attribute->price = $request->edit_attribute_price;
        }

        $attribute->save();

        AttributeColor::where('attribute_id', $request->attribute_id)->delete();

        if ($request->has('edit_attribute_colors')) {
            foreach ($request->edit_attribute_colors as $colorId) {

                $attributeColor= new AttributeColor();
                $attributeColor->attribute_id = $request->attribute_id;
                $attributeColor->color_master_id = $colorId;
                $attributeColor->save();
            }
        }
        return redirect()->route('attributes')->withSuccess('Attribute Updated Successfully!');
    }

    public function sortApphabet($id){
        $embellishmentType = EmbellishmentType::where('embellishment_name', 'LIKE', $id.'%')->where('active', 1)->get();
        return json_encode($embellishmentType);
    }

    public function layout(Request $request){
        if(AttributeLayout::where('user_id', Auth::user()->id)->first()){
            $attributeLayout = AttributeLayout::find($request->layout_id);
            $attributeLayout->attribute_name = $request->attribute_name;
            $attributeLayout->created = $request->created_at;
            $attributeLayout->updated = $request->updated_at;
            $attributeLayout->update();

            $successMsg = "Updated";

        } else {
            $attributeLayout = new AttributeLayout();
            $attributeLayout->user_id = Auth::user()->id;
            $attributeLayout->attribute_name = 1;
            $attributeLayout->created = 1;
            $attributeLayout->updated = 1;
            $attributeLayout->save();

            $successMsg = "Saved";
        }

        return json_encode($successMsg);
    }
}
