<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterFit;

class FitController extends Controller
{
    public function fits() {

        $masterFits = MasterFit::where('active', 1)->get();

        return view('pages.masters.fits.index',[
            'masterFits'=>$masterFits
        ]);
    }

    public function create(Request $request){

        $masterFit = new MasterFit();
        $masterFit->fit_name = $request->new_product_fit;
        $masterFit->description = $request->input('new_description', '');

        $masterFit->active = 1;
        $masterFit->save();

        return redirect()->route('fits')->withSuccess('Product Fit Saved Successfully!');
    }

    public function update(Request $request){

        $masterFit = MasterFit::find($request->master_fit_id);

        $masterFit->fit_name = $request->edit_master_fit;
        $masterFit->description = $request->edit_description;


        $masterFit->update();

        return redirect()->route('fits')->withSuccess('Product Fit Updated Successfully!');
    }

    public function edit($id){
        $masterFit = MasterFit::where('id', $id)->first();

        return response()->json($masterFit);

    }

    public function delete(Request $request){
        $masterFitId = $request->id;

        $masterFit = MasterFit:: find($masterFitId);
        $masterFit->active = 0;
        $masterFit->update();

        return response()->json(['success' => true]);
    }
}
