<?php

namespace App\Http\Controllers;

use App\Models\Fabric;
use Illuminate\Http\Request;

class FabricPageController extends Controller
{
    public function commonFabricPage(){

        $fabrics = Fabric::where('active', 1)->orderBy('fabric_name')->get();

        return view('pages/common_fabric_page/index', ['fabrics'=>$fabrics]);
    }
}
