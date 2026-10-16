<?php

namespace App\Http\Controllers;

use App\Models\ColumnLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DatatableController extends Controller
{
    public function columnOrder(Request $request){
        $columnLayouts = ColumnLayout::where('interface_id', $request->interface_id)->where('user_id', Auth::user()->id)->first();

        if($columnLayouts){
            $columnLayout = ColumnLayout::find($columnLayouts->id);
            $columnLayout->column_order = $request->column_order;
            $columnLayout->update();

            $successMsg = "Updated";

        } else {
            $columnLayout = new ColumnLayout();
            $columnLayout->interface_name = $request->interface_name;
            $columnLayout->interface_id = $request->interface_id;
            $columnLayout->user_id = Auth::user()->id;
            $columnLayout->column_order = $request->column_order;
            $columnLayout->save();

            $successMsg = "Saved";
        }

        return json_encode($successMsg);
    }

    public function getColumnOrder($interfaceId){
        $columnLayouts = ColumnLayout::where('interface_id', $interfaceId)->where('user_id', Auth::user()->id)->first();
        return json_encode($columnLayouts);
    }
}
