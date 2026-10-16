<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use domainencore\Facades\SystemApiFacade\SystemApiFacade;
use Illuminate\Http\Request;

class SystemAPIController extends Controller
{
    public function index(){
        if(auth()->user()->can('manage system api')){
            return view('pages.settings.system_api.index');
        } else {
            return redirect()->back()->withError('You have no premission.');
        }
    }

    public function get_table_data(){
        return SystemApiFacade::getAllSystemAPIs();
    }

    public function store(Request $request)
    {
        if(auth()->user()->can('create system api')){
            try {
                SystemApiFacade::storeSystemAPI($request->all());
                return redirect()->back()->withSuccess('API Created Successfully!');
            } catch (\Throwable $th) {
                return redirect()->back()->withError($th->getMessage());
            }
        } else {
            return redirect()->back()->withError('You have no premission.');
        }
    }

    public function edit($id)
    {
        return SystemApiFacade::getSystemAPIById($id);
    }

    public function update(Request $request, $id)
    {
        if(auth()->user()->can('edit system api')){
            try {
                SystemApiFacade::updateSystemAPI($request->all(), $id);
                if(isset($request->is_json)) {
                    return response()->json(['response'=>'success', 'message'=>'API Updated Successfully!'], 200);
                } else {
                    return redirect()->back()->withSuccess('API Updated Successfully!');
                }
            } catch (\Throwable $th) {
                if(isset($request->is_json)) {
                    return response()->json(['response'=>'error', 'message'=>$th->getMessage()], 501);
                } else {
                    return redirect()->back()->withError($th->getMessage());
                }
            }
        } else {
            if(isset($request->is_json)) {
                return response()->json(['response'=>'error', 'message'=>'You have no premission.'], 403);
            } else {
                return redirect()->back()->withError('You have no premission.');
            }
        }
    }

    public function delete($id)
    {
        if(auth()->user()->can('delete system api')){
            try {
                SystemApiFacade::destroySystemAPIById($id);
                return response()->json(['response'=>'success', 'title'=>'Deleted!', 'message'=>'API Deleted Successfully!'], 200);
            } catch (\Throwable $th) {
                return response()->json(['response'=>'error', 'title'=>'Error!', 'message'=>$th->getMessage()], 501);
            }
        } else {
            return response()->json(['response'=>'error', 'title'=>'No Premission!', 'message'=>'You have no premission.'], 403);
        }
    }
}
