<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeGroup;
use App\Models\AttributeGroupAttribute;
use App\Models\AttributeGroupLayout;
use App\Models\ColumnLayout;
use App\Models\MainCategory;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Traits\OrderCommenHelper;
class AttributeGroupsController extends Controller
{
    use OrderCommenHelper;

    public function index(){
        if(auth()->user()->can('manage attribute group')){
            $attributeGroups = AttributeGroup::orderBy('name')->get();

            $attributeGroupLayout = AttributeGroupLayout::where('user_id', Auth::user()->id)->first();

            $columnLayout = ColumnLayout::where('interface_id', 15)->where('user_id', Auth::user()->id)->first();

            $productCategories = ProductCategory::where('active', 1)->orderBy('product_category_name')->get();

            $commenHelper = $this;

            return view('pages.masters.attribute_groups.index',[
                'attributeGroups'=>$attributeGroups, 'attributeGroupLayout'=>$attributeGroupLayout, 'columnLayout'=>$columnLayout, 'productCategories'=>$productCategories, 'commenHelper'=>$commenHelper
            ]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function create(Request $request)
    {
        try{
            $request->validate([
                'new_attribute_group' => 'required|string|max:255',
                'new_attribute_group_product_category' => 'required|array|min:1',
                'new_attribute_group_product_category.*' => 'required|exists:product_categories,id'
            ]);
            $attrGroup = new AttributeGroup();
            $attrGroup->name = $request->new_attribute_group;
            $attrGroup->product_category_id = json_encode($request->new_attribute_group_product_category);
            $attrGroup->save();

            return redirect()->route('attribute_groups.edit', $attrGroup->id)->withSuccess('Attribute Group Saved Successfully!');
        } catch(Exception $ex){
            return redirect()->back()->withError($ex->getMessage());
        }
    }

    public function edit($id)
    {
        $attributeGroup = AttributeGroup::find($id);
        $groupedAttributes = AttributeGroupAttribute::where('active', 1)->where('attribute_group_id', $id)->get();
        $subAttributes = Attribute::where('active', 1)->where('is_sub_attribute', 1)->get();
        $productCategories = ProductCategory::where('active', 1)->orderBy('product_category_name')->get();
        $commenHelper = $this;
        return view('pages.masters.attribute_groups.edit',[
            'subAttributes'=>$subAttributes, 'attributeGroup'=>$attributeGroup, 'groupedAttributes'=>$groupedAttributes, 'productCategories'=>$productCategories, 'commenHelper'=>$commenHelper
        ]);
    }

    public function update(Request $request, $id)
    {
        try{
            $attrGroup = AttributeGroup::find($id);
            $attrGroup->name = $request->edit_attribute_group;
            $attrGroup->product_category_id = json_encode($request->edit_attribute_group_product_category);
            $attrGroup->update();

            AttributeGroupAttribute::where('attribute_group_id', $id)->delete();

            if(isset($request->attribute_ids) && count($request->attribute_ids) > 0){
                foreach($request->attribute_ids as $attribute_id){
                    $newAttrGroupAttributes = new AttributeGroupAttribute();
                    $newAttrGroupAttributes->product_category_id = json_encode($request->edit_attribute_group_product_category);
                    $newAttrGroupAttributes->attribute_group_id = $attrGroup->id;
                    $newAttrGroupAttributes->attribute_id = $attribute_id;
                    $newAttrGroupAttributes->save();
                }
            }

            return redirect()->route('attribute_groups')->withSuccess('Attribute Group Updated Successfully!');
        } catch(Exception $ex){
            return redirect()->back()->withError($ex->getMessage());
        }
    }

    public function delete($id){
        $attribute = AttributeGroup:: find($id);
        $attribute->active = 0;
        $attribute->update();
        $attribute->delete();

        return redirect()->route('attribute_groups')->withSuccess('Attribute Group Deleted Successfully!');
    }

    public function layout(Request $request){
        if(AttributeGroupLayout::where('user_id', Auth::user()->id)->first()){
            $attributeLayout = AttributeGroupLayout::find($request->layout_id);
            $attributeLayout->attribute_group_name = $request->attribute_group_name;
            $attributeLayout->product_style = $request->product_style;
            $attributeLayout->attribute_name = $request->attribute_name;
            $attributeLayout->created = $request->created_at;
            $attributeLayout->updated = $request->updated_at;
            $attributeLayout->update();

            $successMsg = "Updated";

        } else {
            $attributeLayout = new AttributeGroupLayout();
            $attributeLayout->user_id = Auth::user()->id;
            $attributeLayout->attribute_group_name = 1;
            $attributeLayout->product_style = 1;
            $attributeLayout->attribute_name = 1;
            $attributeLayout->created = 1;
            $attributeLayout->updated = 1;
            $attributeLayout->save();

            $successMsg = "Saved";
        }

        return json_encode($successMsg);
    }
}
