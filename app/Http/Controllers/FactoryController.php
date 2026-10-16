<?php

namespace App\Http\Controllers;

use App\Models\ColumnLayout;
use Illuminate\Http\Request;
use App\Models\Factory;
use App\Models\FactoryLayout;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class FactoryController extends Controller
{
    public function index(){
        if(auth()->user()->can('manage factories')){
            $factories = Factory::where('active', 1)->orderBy('factory_name')->get();
            $userGroups = Role::where('active', 1)
                                ->where('name', 'like', '%factory%')
                                ->orderBy('name')
                                ->get();

            $factoryLayout = FactoryLayout::where('user_id', Auth::user()->id)->first();

            $columnLayout = ColumnLayout::where('interface_id', 9)->where('user_id', Auth::user()->id)->first();

            return view('pages.masters.factories.index',['factories'=>$factories, 'factoryLayout'=>$factoryLayout, 'columnLayout'=>$columnLayout, 'userGroups'=>$userGroups]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function create(Request $request){
        $factory = new Factory();
        $factory->factory_name = $request->new_factory_name;
        $factory->factory_code = $request->new_factory_code;
        $factory->permission_id = $request->Group_id;
        $factory->active = 1;
        $factory->save();

        return redirect()->route('factories')->withSuccess('Factory Saved Successfully!');
    }

    public function delete($id){
        $factory = Factory::find($id);
        $factory->active = 0;
        $factory->update();

        return redirect()->route('factories')->withSuccess('Factory Delete Successfully!');
    }

    public function edit($id)
{
        $factory = Factory::find($id);
        $userGroups = Role::where('active', 1)
                            ->where('name', 'like', '%factory%')
                            ->orderBy('name')
                            ->get();

        return response()->json([
            'factory' => $factory,
            'userGroups' => $userGroups
    ]);
}


    public function update(Request $request){
        $factory = Factory::find($request->factory_id);
        $factory->factory_name = $request->edit_factory_name;
        $factory->factory_code = $request->edit_factory_code;
        $factory->permission_id = $request->edit_Group_id;
        $factory->update();

        return redirect()->route('factories')->withSuccess('Factory Updated Successfully!');
    }

    public function sortApphabet($id){
        $factory = Factory::where('factory_name', 'LIKE', $id.'%')->get();
        return json_encode($factory);
    }

    public function layout(Request $request){
        if(FactoryLayout::where('user_id', Auth::user()->id)->first()){
            $factoryLayout = FactoryLayout::find($request->layout_id);
            $factoryLayout->factory_name = $request->factory_name;
            $factoryLayout->factory_code = $request->factory_code;
            $factoryLayout->created = $request->created_at;
            $factoryLayout->updated = $request->updated_at;
            $factoryLayout->update();

            $successMsg = "Updated";

        } else {
            $factoryLayout = new FactoryLayout();
            $factoryLayout->user_id = Auth::user()->id;
            $factoryLayout->factory_name = 1;
            $factoryLayout->factory_code = 1;
            $factoryLayout->created = 1;
            $factoryLayout->updated = 1;
            $factoryLayout->save();

            $successMsg = "Saved";
        }

        return json_encode($successMsg);
    }
}
