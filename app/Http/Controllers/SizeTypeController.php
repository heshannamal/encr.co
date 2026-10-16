<?php

namespace App\Http\Controllers;

use App\Models\SizeType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SizeTypeController extends Controller
{
    public function index() {

        if(auth()->user()->can('manage size types')){

            $sizeTypes = SizeType::orderBy('type_name')->where('active', 1)->get();

            return view('pages.masters.sizeType.index', ['sizeTypes'=>$sizeTypes]);

        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }
    public function create(Request $request){
        $sizeType = new SizeType();
        $sizeType->type_name = $request->new_sizeType;
        $sizeType->active = 1;
        $sizeType->save();

        return redirect()->route('size_type')->withSuccess('Size Type Saved Successfully!');
    }

    public function edit($id){
        $sizeTypes = SizeType::find($id);
        return json_encode($sizeTypes);
    }

    public function update(Request $request){
        $sizeTypes = SizeType::find($request->sizeType_id);
        $sizeTypes->type_name = $request->edit_sizeType_name;
        $sizeTypes->update();

        return redirect()->route('size_type')->withSuccess('Size Type Updated Successfully!');
    }

    public function delete($id){
        $sizeTypes = SizeType::find($id);
        $sizeTypes->active = 0;
        $sizeTypes->update();

        return redirect()->route('size_type')->withSuccess('Size Type Delete Successfully!');
    }

}
