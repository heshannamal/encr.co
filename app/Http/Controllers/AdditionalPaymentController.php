<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdditionPayment;
use App\Http\Controllers\Controller;

class AdditionalPaymentController extends Controller
{
    public function index(){
        if(auth()->user()->can('manage additional payment')){
            $additionals = AdditionPayment::where('active', 1)->get();

            return view('pages.masters.additional_payment.index', ['additionals'=>$additionals]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function create(Request $request){

        $addition = new AdditionPayment();
        $addition->addition_type_name = $request->additional_payment_name;
        $addition->save();

        return redirect()->route('additional_payment')->withSuccess('Generate Additional Payment Type Successfully!');
    }

    public function edit(Request $request){

        $addition = AdditionPayment:: find($request->type_id);
        $addition->addition_type_name = $request->edit_additional_payment_name;
        $addition->update();

        return redirect()->route('additional_payment')->withSuccess('Update Additional Payment Type Successfully!');
    }

    public function delete($id){
        $projectType = AdditionPayment::find($id);
        $projectType->active = 0;
        $projectType->update();

        return redirect()->route('additional_payment')->withSuccess('Additional Payment Type Delete Successfully!');
    }
}
