<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeGroupAttribute;
use App\Models\ColumnLayout;
use App\Models\PatternCode;
use App\Models\PatternCodeLayout;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\SubProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use domainencore\Facades\PatternCodeFacade\PatternCodeFacade;
use App\Traits\OrderCommenHelper;

class PatternCodeController extends Controller
{
    use OrderCommenHelper;
    public function index(){
        if(auth()->user()->can('manage pattern code')){
            $patternCodes = PatternCode::get();

            $subProducts = SubProduct::where('active', 1)->orderBy('product_name')->get();

            $columnLayout = ColumnLayout::where('interface_id', 16)->where('user_id', Auth::user()->id)->first();

            $patternCodeLayout = PatternCodeLayout::where('user_id', Auth::user()->id)->first();

            $helper = $this;

            return view('pages.masters.pattern_codes.index',[
                'patternCodes'=>$patternCodes, 'subProducts'=>$subProducts, 'columnLayout'=>$columnLayout, 'patternCodeLayout'=>$patternCodeLayout, 'helper'=>$helper
            ]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function getAttributes($subProductId)
    {
        $subProduct = SubProduct::find($subProductId);
        $attributes = PatternCodeFacade::getAttributeByProduct($subProduct->parent_product_id);
        return view('pages.masters.pattern_codes.partials.pattern_attributes',[
            'attributes'=>$attributes
        ]);
    }

    public function create(Request $request)
    {
        try{
            // Validate if sub_product_id exists
            if(!$request->has('new_sub_product_id')) {
                return redirect()->back()->withError('Sub Product ID is required!');
            }

            $attributes = [];
            if(isset($request->pattern_attribute)){
                $attributes = $request->pattern_attribute;
            }

            // Validate if pattern_attribute exists when sub_product_id is present
            if(empty($attributes)) {
                return redirect()->back()->withError('Pattern attributes are required!');
            }

            $subProduct = SubProduct::find($request->new_sub_product_id);
            if(!$subProduct) {
                return redirect()->back()->withError('Invalid Sub Product!');
            }

            // Check if pattern code with same sub_product_id and pattern_attribute already exists
            $existingPatternCode = PatternCode::where('sub_product_id', $request->new_sub_product_id)
                ->where('pattern_attribute', json_encode($attributes))
                ->first();

            if($existingPatternCode) {
                return redirect()->back()->withError('A pattern code with these attributes already exists for this sub product!');
            }

            $patterCode = new PatternCode();
            $patterCode->parent_product_id = $subProduct->parent_product_id;
            $patterCode->sub_product_id = $request->new_sub_product_id;
            $patterCode->pattern_code = $request->new_pattern_code;
            $patterCode->pattern_attribute = json_encode($attributes);
            $patterCode->save();

            return redirect()->back()->withSuccess('Pattern Code Saved Successfully!');
        } catch(Exception $ex){
            return redirect()->back()->withError($ex->getMessage());
        }
    }

    public function edit($id)
    {
        $patternCode = PatternCode:: find($id);
        $subProducts = SubProduct::where('active', 1)->orderBy('product_name')->get();
        $attributes = PatternCodeFacade::getAttributeByProduct($patternCode->parent_product_id);

        return view('pages.masters.pattern_codes.partials.pattern_code_edit',[
            'patternCode'=>$patternCode, 'attributes'=>$attributes, 'subProducts'=>$subProducts
        ]);
    }

    public function update(Request $request, $id)
    {
        try{
            // dd($request->all());
            $patternCode = PatternCode:: find($id);
            $attributes = [];
            if(isset($request->pattern_attribute)){
                $attributes = $request->pattern_attribute;
            }
            $subProduct = SubProduct::find($request->edit_sub_product_id);

            $patternCode->parent_product_id = $subProduct->parent_product_id;
            $patternCode->sub_product_id = $request->edit_sub_product_id;
            $patternCode->pattern_code = $request->edit_pattern_code;
            $patternCode->pattern_attribute = json_encode($attributes);
            $patternCode->update();

            return redirect()->back()->withSuccess('Pattern Code Updated Successfully!');
        } catch(Exception $ex){
            return redirect()->back()->withError($ex->getMessage());
        }
    }

    public function delete($id){
        $patternCode = PatternCode:: find($id);
        $patternCode->active = 0;
        $patternCode->update();
        $patternCode->delete();

        return redirect()->back()->withSuccess('Pattern Code Deleted Successfully!');
    }

    public function layout(Request $request){
        if(PatternCodeLayout::where('user_id', Auth::user()->id)->first()){
            $patterCodeLayout = PatternCodeLayout::find($request->layout_id);
            $patterCodeLayout->pattern_code = $request->pattern_code;
            $patterCodeLayout->product_name = $request->product_name;
            $patterCodeLayout->attribute_name = $request->attribute_name;
            $patterCodeLayout->created = $request->created_at;
            $patterCodeLayout->updated = $request->updated_at;
            $patterCodeLayout->update();

            $successMsg = "Updated";

        } else {
            $patterCodeLayout = new PatternCodeLayout();
            $patterCodeLayout->user_id = Auth::user()->id;
            $patterCodeLayout->pattern_code = 1;
            $patterCodeLayout->product_name = 1;
            $patterCodeLayout->attribute_name = 1;
            $patterCodeLayout->created = 1;
            $patterCodeLayout->updated = 1;
            $patterCodeLayout->save();

            $successMsg = "Saved";
        }

        return json_encode($successMsg);
    }
}
