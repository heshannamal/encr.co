<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\SizeType;
use App\Models\SizeLayout;
use App\Models\ColumnLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SizeController extends Controller
{
    public function index(){
        if(auth()->user()->can('manage sizes')){
            $sizes = Size::where('active',1)->get();

            $sizeLayout = SizeLayout::where('user_id', Auth::user()->id)->first();

            $sizeTypes = SizeType::get();

            $columnLayout = ColumnLayout::where('interface_id', 7)->where('user_id', Auth::user()->id)->first();

            return view('pages.masters.sizes.index',['sizes' => $sizes, 'sizeLayout'=>$sizeLayout, 'columnLayout'=>$columnLayout,
                                                    'sizeTypes'=>$sizeTypes]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function create(Request $request){
        $sizes = new Size();
        $sizes->size_name = $request->new_size_name;
        $sizes->size_type = $request->new_size_type;
        $sizes->active = 1;
        $sizes->save();

        return redirect()->route('sizes')->withSuccess('Size Saved Successfully!');
    }


    public function delete($id){
        $size = Size::find($id);
        $size->active = 0;
        $size->update();

        return redirect()->route('sizes')->withSuccess('Size Delete Successfully!');
    }

     public function edit($id){
        $size = Size::find($id);
        return json_encode($size);
    }

    public function update(Request $request){
        $size = Size:: find($request->size_id);
        $size->size_name = $request->edit_size_name;
        $size->size_type = $request->edit_size_type;
        $size->update();

        return redirect()->route('sizes')->withSuccess('Size Updated Successfully!');
    }

    public function sortApphabet($id){
        $sizes = Size::where('size_name', 'LIKE', $id.'%')->where('active',1)->get();
        return json_encode($sizes);
    }

    public function layout(Request $request){
        if(SizeLayout::where('user_id', Auth::user()->id)->first()){
            $sizeLayout = SizeLayout::find($request->layout_id);
            $sizeLayout->size_name = $request->size_name;
            $sizeLayout->size_type = $request->size_type;
            $sizeLayout->created = $request->created_at;
            $sizeLayout->updated = $request->updated_at;
            $sizeLayout->update();

            $successMsg = "Updated";

        } else {
            $sizeLayout = new SizeLayout();
            $sizeLayout->user_id = Auth::user()->id;
            $sizeLayout->size_name = 1;
            $sizeLayout->size_type = 1;
            $sizeLayout->created = 1;
            $sizeLayout->updated = 1;
            $sizeLayout->save();

            $successMsg = "Saved";
        }

        return json_encode($successMsg);
    }
}
