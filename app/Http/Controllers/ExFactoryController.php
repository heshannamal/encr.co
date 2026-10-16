<?php

namespace App\Http\Controllers;

use App\Models\ExFactory;
use App\Models\Order;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderItem;
use App\Models\Contact;

class ExFactoryController extends Controller
{
    public function create(Request $request){
        try {
            $exFactory = new ExFactory();
            $exFactory->ex_factory_name = $request->ex_factory_name;
            $exFactory->po_box = $request->ex_factory_po_box;
            $exFactory->city = $request->ex_factory_city;
            $exFactory->state = $request->ex_factory_state;
            $exFactory->postal_code = $request->ex_factory_postal_code;
            $exFactory->country = $request->ex_factory_country;
            $exFactory->active = 1;
            $exFactory->created_by = Auth::user()->id;
            $exFactory->save();

            return response()->json(['success' => true, 'data' => $exFactory], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getAllAddresses(){
        $exFactory = ExFactory::where('active', 1)->orderBy('ex_factory_name')->get();

        return json_encode($exFactory);
    }

    public function getAddress($itemId, $exFactoryId){
        // dd($itemId, $exFactoryId);
        if($exFactoryId == 0) {
            $exFactory = Organization::select('organizations.shipping_po_box', 'organizations.shipping_city', 'organizations.shipping_state', 'organizations.shipping_postal_code', 'organizations.shipping_country')
                                     ->join('order_items', 'order_items.organization_id', '=', 'organizations.id')->where('order_items.id', $itemId)->get();

        } else {
            $exFactory = ExFactory::where('id', $exFactoryId)->first();
        }
        // dd($exFactory);
        return response()->json(['message' => 'Found', 'data' => $exFactory], 200);
        // return response()->json($exFactory);
        // return json_encode($exFactory);
    }
    public function createInItempage(Request $request){
        if(isset( $request->contactId)){
            $contact = Contact::find($request->contactId);


            $exFactory = new ExFactory();
            $exFactory->ex_factory_name = $contact->first_name . ' ' . $contact->last_name;
            $exFactory->order_item_id = $request->ItemId;
            $exFactory->contact_id = $request->contactId;
            $exFactory->apartment = $contact->apartment ?? '';
            $exFactory->po_box = $contact->shipping_po_box ?? '';
            $exFactory->city = $contact->shipping_city ?? '';
            $exFactory->state = $contact->shipping_state ?? '';
            $exFactory->postal_code = $contact->shipping_zip ?? '';
            $exFactory->country = $contact->shipping_country ?? '';
            $exFactory->active = 1;
            $exFactory->created_by = Auth::user()->id;
            $exFactory->save();
        }else{

            $exFactory = new ExFactory();
            $exFactory->ex_factory_name = $request->ex_factory_name ?? '';
            $exFactory->order_item_id = $request->ItemId;
            $exFactory->po_box = $request->ex_factory_po_box ?? '';
            $exFactory->apartment = $request->ex_factory_apartment ?? '';
            $exFactory->city = $request->ex_factory_city ?? '';
            $exFactory->state = $request->ex_factory_state ?? '';
            $exFactory->postal_code = $request->ex_factory_postal_code ?? '';
            $exFactory->country = $request->ex_factory_country ?? '';
            $exFactory->active = 1;
            $exFactory->created_by = Auth::user()->id;
            $exFactory->save();
        }

        // $orderItem = OrderItem::find($request->ItemId);
        // if($orderItem){
        //     $orderItem->ex_factory_id = $exFactory->id;
        //     $orderItem->save();
        // }
        $exFactoryset = ExFactory::where('id', $exFactory->id)->first();
        return response()->json($exFactoryset);
    }
}
