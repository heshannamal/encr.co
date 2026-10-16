<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityAssignee;
use App\Models\CheckPayment;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentLog;
use App\Models\PaypalPayment;
use App\Models\User;
use App\Models\VenmoPayment;
use Carbon\Carbon;
use domainencore\Facades\OrderDatesFacade\ExFactoryDateFacade;
use domainencore\Facades\OrderDatesFacade\InHandDateFacade;
use domainencore\Facades\OrdersCommenFacade\OrdersCommenFacade;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CustomWorkController extends Controller
{
    public function create_role($roleName){
        $role = Role::create(['name' => $roleName]);
        dd($role);
    }

    public function create_permission($permissionName){
        $permission = Permission::create(['name' => $permissionName]);
        dd($permission);
    }

    public function get_all_permissions(){
        dd(\Auth::user()->getAllPermissions());
    }

    public function get_all_custom_user_permissions($id){
        $user = User::find($id);
        dd($user->getAllPermissions());
    }

    public function get_role_has_permissions($id){
        $role = Role::find($id);
        dd($role->getAllPermissions());
    }

    public function get_user_role(){
        dump(\Auth::user()->hasRole('Super Admin'));
        dump(\Auth::user()->roles->pluck('id'));
        dd(\Auth::user()->getRoleNames());
    }

    public function get_permission_has_role($id){
        $permission = Permission::find($id);
        dd($permission->roles);
    }

    public function user_role_details(){
        // $users = User::with('roles')->get();
        $user = User::with('roles')->find(\Auth::user()->id);
        $admin = Role::where('name', 'admin')->first();
        $user->assignRole($admin);
        dd($user->roles);
    }

    public function set_role_to_user($roleName){
        $user = User::with('roles')->find(\Auth::user()->id);
        $role = Role::where('name', $roleName)->first();
        $user->assignRole($role);
        dd($user->getRoleNames());
    }

    public function remove_role_from_user($roleName){
        $user = User::with('roles')->find(\Auth::user()->id);
        $role = Role::where('name', $roleName)->first();
        $user->removeRole($role);
        // $user->syncRoles($role);
        dd($user->getRoleNames());
    }

    public function set_permission_to_role($permissionName, $roleId){

        $role = Role::where('id', $roleId)->first();
        $permission = Permission::where('name', $permissionName)->first();
        $permission->assignRole($role);
        dd(\Auth::user()->permissions);
    }

    public function get_password(){
        $psw = 'Jon@123';
        dd(Hash::make($psw));
    }

    public function activity_assignees(){
        dd('no');
        $activities = Activity::where('active', 1)->get();
        foreach($activities as $activity){
            $newAssignee = new ActivityAssignee();
            $newAssignee->activity_id = $activity->id;
            $newAssignee->user_id = $activity->user_id;
            $newAssignee->active = 1;
            $newAssignee->created_by = $activity->created_by;
            $newAssignee->save();
        }
    }

    public function get_inhanddates(){
        // dump(InHandDateFacade::get(681)[0]->userDetail);
        // dd(InHandDateFacade::get(681));

        // dump(InHandDateFacade::get(681)[0]->userDetail);
        dd(ExFactoryDateFacade::get(681));
    }

    public function check_lost_payment_orders()
    {
        $onlinePayments = PaymentLog::where('response_code','1')->orderBy('created_at', 'DESC')->get();

        $checkPayments = CheckPayment::orderBy('created_at', 'DESC')->get();

        $venmoPayments = VenmoPayment::orderBy('created_at', 'DESC')->get();

        $paypalPayments = PaypalPayment::orderBy('created_at', 'DESC')->get();

        $checkOnline = [];
        $checkCheque = [];
        $checkVenmo = [];
        $checkPaypal = [];

        foreach($onlinePayments as $onlinePayment)
        {
            $orderDetails = Order::where('id',$onlinePayment->order_id)->first();
            if(!$orderDetails){
                $checkOnline[] = $onlinePayment->order_id;
            }
        }

        foreach($checkPayments as $checkPayment)
        {
            $orderDetails = Order::where('id',$checkPayment->order_id)->first();
            if(!$orderDetails){
                $checkCheque[] = $checkPayment->order_id;
            }
        }

        foreach($venmoPayments as $venmoPayment)
        {
            $orderDetails = Order::where('id',$venmoPayment->order_id)->first();
            if(!$orderDetails){
                $checkVenmo[] = $venmoPayment->order_id;
            }
        }

        foreach($paypalPayments as $paypalPayment)
        {
            $orderDetails = Order::where('id',$paypalPayment->order_id)->first();
            if(!$orderDetails){
                $checkPaypal[] = $paypalPayment->order_id;
            }
        }

        dump('online : '.json_encode($checkOnline));
        dump('check : '.json_encode($checkCheque));
        dump('venmo : '.json_encode($checkVenmo));
        dump('paypal : '.json_encode($checkPaypal));
    }

    public function bill_studio_order()
    {
        try {
            dump('Studio item billing order command started');

            $orderItems = OrderItem::where('is_studio_item', 1)
                                        ->where('is_billed', 0)
                                        ->where('active', 1)
                                        ->where('order_status_id', 4)
                                        ->get();

            if(count($orderItems) > 0){
                dump('Studio item billing order Start Prossecing');

                $contact = OrdersCommenFacade::getStudioContact();
                // $orgnization = Organization::find(1377); // Encore Inventory

                $maxId = Order::max('id');
                $orderNo = str_pad(($maxId+1), 6, "0", STR_PAD_LEFT);

                $newOrder = new Order();
                $newOrder->organization_id = 1377;
                $newOrder->contact_id = $contact->id;
                $newOrder->order_no = $orderNo;
                $newOrder->order_status_id = 4; // Fulfilled
                $newOrder->user_id = 1;
                // $newOrder->sub_total = $request->sub_total;
                // $newOrder->sales_tax = $request->sales_tax;
                // $newOrder->shipping = $request->shipping;
                // $newOrder->order_description = $request->order_description;
                // $newOrder->artwork = $request->artwork;
                // $newOrder->processing_fee = $request->processing_fee;
                // $newOrder->order_total = $request->order_total;
                $newOrder->open_date = Carbon::now()->format('m/d/Y');
                // $newOrder->encore_packing_date = $request->encore_packing_date;
                $newOrder->due_date = Carbon::now()->format('m/d/Y');
                $newOrder->ex_factory_date = Carbon::now()->format('m/d/Y');
                $newOrder->active = 1;

                $newOrder->ex_factory_date = Carbon::now()->format('m/d/Y');

                $newOrder->est_delivery_date = Carbon::now()->format('m/d/Y');

                $newOrder->is_new_shipping_address = 0;
                $newOrder->street = $contact->shipping_street;
                $newOrder->city = $contact->shipping_city;
                $newOrder->state = $contact->shipping_state;
                $newOrder->postal_code = $contact->shipping_zip;
                $newOrder->country = $contact->shipping_country;
                $newOrder->phone_no = $contact->phone_no;
                $newOrder->email = $contact->email;

                $newOrder->is_studio_item_order = 1;

                $newOrder->save();

                foreach ($orderItems as $orderItem) {
                    $itemOrderId = $orderItem->order_id;
                    $orderItem->parent_order_id = $itemOrderId;
                    $orderItem->order_id = $newOrder->id;
                    $orderItem->is_billed = 1;
                    $orderItem->update();
                }

                OrdersCommenFacade::create_invoice_by_factory_confirmation($newOrder->id);

                dump("Studio item billing order created successfully.");
            }
           dd("Studio item billing order command ended.");
        } catch(Exception $e) {
            dd("Error creating studio item billing order: " . $e->getMessage());
        }
    }
}
