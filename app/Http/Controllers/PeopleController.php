<?php

namespace App\Http\Controllers;

use App\Models\ColumnLayout;
use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Contact;
use App\Models\Order;
use App\Models\PeopleLayout;
use App\Models\User;
use App\Models\OrderItemFile;
use App\Models\Sport;
use App\Models\ContactOrganization;
use App\Models\ColorMaster;
use App\Models\LeadSource;
use Illuminate\Support\Facades\Auth;

class PeopleController extends Controller
{
    public function index(Request $request){
        if(auth()->user()->can('view people')){
            $peopleQuery = Contact::select('contacts.id', 'contacts.first_name', 'contacts.last_name', 'contacts.phone_no', 'contacts.personal_phone_no', 'contacts.lead_source', 'contacts.email',
                                    'contacts.title', 'contacts.user_id', 'contacts.shipping_po_box', 'contacts.shipping_street', 'contacts.shipping_city',
                                    'contacts.shipping_state', 'contacts.shipping_zip', 'contacts.shipping_country', 'contacts.created_at', 'contacts.updated_at',
                                    'users.name')
                            ->join('users', 'users.id', '=', 'contacts.user_id')
                            ->where('contacts.active', 1)
                            ->with('contactOrganizations.organizations')
                            ->with('leadSourceDetails')
                            ->orderBy('contacts.first_name');

            // Orgnnization name serach
            if($request->org){
                $peopleQuery->where(function($query) use($request) {
                    $query->whereHas('contactOrganizations.organizations', function($subquery) use($request) {
                        $subquery->where('organization_name', 'LIKE', '%' . $request->org . '%');
                    })
                    ->orWhere('contacts.first_name', 'LIKE', '%' . $request->org . '%')
                    ->orWhere('contacts.last_name', 'LIKE', '%' . $request->org . '%')
                    ->orWhere('contacts.email', 'LIKE', '%' . $request->org . '%')
                    ->orWhereRaw("CONCAT(contacts.first_name, ' ', contacts.last_name) LIKE ?", ['%' . $request->org . '%'])
                    ->orWhere('contacts.title', 'LIKE', '%' . $request->org . '%');
                });
            }


            $peoples = $peopleQuery->paginate(50);

            $lead_sources = LeadSource::where('active', 1)->get();

            $peopleLayout = PeopleLayout::where('user_id', Auth::user()->id)->first();

            $columnLayout = ColumnLayout::where('interface_id', 1)->where('user_id', Auth::user()->id)->first();

            $organizations = Organization::select('id', 'organization_name')->where('active', 1)->orderBy('organization_name')->get();

            $sports = Sport::where('active', 1)->orderBy('sport_name')->get();

            $users = User::select('id', 'name')->get();

            $colorMasters = ColorMaster::get();

            return view('pages.contacts.people.index', ['peoples'=>$peoples,'colorMasters'=>$colorMasters, 'peopleLayout'=>$peopleLayout, 'organizations'=>$organizations, 'users'=>$users, 'sports'=>$sports, 'columnLayout'=>$columnLayout, 'lead_sources'=>$lead_sources]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function getOrganizationList() {
        $organizations = Organization::select('id', 'organization_name')->where('active', 1)->orderBy('organization_name')->get();
        return json_encode($organizations);
    }

    public function peopleAdd(){
        $organizations = Organization::select('id', 'organization_name')->where('active', 1)->orderBy('organization_name')->get();

        $users = User::select('id', 'name')->get();

        return view('pages.contacts.people.create', ['organizations'=>$organizations, 'users'=>$users]);
    }

    public function create(Request $request){
        if(auth()->user()->can('create people')){
            $people = new Contact();
            $people->first_name = $request->first_name;
            $people->last_name = $request->last_name;
            // $people->organization_id = $request->organization_id;
            $people->lead_source = $request->lead_source;
            $people->phone_no = $request->phone_no;
            $people->personal_phone_no = $request->personal_phone_no;
            $people->email = $request->email;
            $people->email_two = $request->email_Secondary;
            $people->title = $request->title;
            $people->user_id = $request->user_id;
            // $people->shipping_po_box = $request->shipping_po_box;
            $people->shipping_street = $request->shipping_street;
            $people->shipping_city = $request->shipping_city;
            $people->shipping_state = $request->shipping_state;
            $people->shipping_zip = $request->shipping_zip;
            $people->shipping_country = $request->shipping_country;

            $people->shipping_street_2 = $request->shipping_street_2;
            $people->shipping_city_2 = $request->shipping_city_2;
            $people->shipping_state_2 = $request->shipping_state_2;
            $people->shipping_zip_2 = $request->shipping_zip_2;
            $people->shipping_country_2 = $request->shipping_country_2;

            $people->active =  1;
            $people->save();

            if($request->new_organization_id!=null){
                foreach($request->new_organization_id as $organization){
                    $contactOrganization= new ContactOrganization();
                    $contactOrganization->contact_id = $people->id;
                    $contactOrganization->organization_id=$organization;
                    $contactOrganization->save();
                }
            }

            if($request->has('existing_organization')){
                return redirect()->to('organizations/info/'.$request->existing_organization)->withSuccess('People Saved Successfully!');
            } else {
                return redirect()->route('people')->withSuccess('People Saved Successfully!');
            }
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function createJson(Request $request){
        try {
            $people = new Contact();
            $people->first_name = $request->first_name;
            $people->last_name = $request->last_name;
            $people->organization_id = $request->organization_id;
            $people->lead_source = $request->lead_source;
            $people->phone_no = $request->phone_no;
            $people->personal_phone_no = $request->personal_phone_no;
            $people->email = $request->email;
            $people->email_two = $request->email_Secondary;
            $people->title = $request->title;
            $people->user_id = $request->user_id;
            // $people->shipping_po_box = $request->shipping_po_box;
            $people->shipping_street = $request->shipping_street;
            $people->shipping_city = $request->shipping_city;
            $people->shipping_state = $request->shipping_state;
            $people->shipping_zip = $request->shipping_zip;
            $people->shipping_country = $request->shipping_country;
            $people->active = 1;
            $people->save();

            $contactOrganization= new ContactOrganization();
            $contactOrganization->contact_id = $people->id;
            $contactOrganization->organization_id = $people->organization_id;
            $contactOrganization->save();

            $msg = array('success', $people);
        } catch (\Exception $ex) {
            $msg = array('error', $ex->errorInfo[2]);
        }
        return json_encode($msg);
    }

    public function createContactWithoutOrganizationRel(Request $request){
        try {
            $people = new Contact();
            $people->first_name = $request->first_name;
            $people->last_name = $request->last_name;
            $people->organization_id = $request->organization_id;
            $people->lead_source = $request->lead_source;
            $people->phone_no = $request->phone_no;
            $people->personal_phone_no = $request->personal_phone_no;
            $people->email = $request->email;
            $people->email_two = $request->email_Secondary;
            $people->title = $request->title;
            $people->user_id = $request->user_id;
            $people->shipping_street = $request->shipping_street;
            $people->shipping_city = $request->shipping_city;
            $people->shipping_state = $request->shipping_state;
            $people->shipping_zip = $request->shipping_zip;
            $people->shipping_country = $request->shipping_country;
            $people->active = 1;
            $people->save();

            $msg = array('success', $people);
        } catch (\Exception $ex) {
            $msg = array('error', $ex->errorInfo[2]);
        }
        return json_encode($msg);
    }

    public function cancel(Request $request){
        return redirect()->route('people')->withSuccess('People Saved Successfully!');
    }

    public function edit($peopleId){
        $people = Contact::find($peopleId);
        $organizations = Organization::select('id', 'organization_name')->where('active', 1)->orderBy('organization_name')->get();
        $users = User::select('id', 'name')->get();

        return view('pages.contacts.people.edit', ['people'=>$people, 'organizations'=>$organizations, 'users'=>$users]);
    }

    public function update(Request $request){
        if(auth()->user()->can('update people')){
            $people = Contact::find($request->people_id);
            $people->update($request->all());

            ContactOrganization::where('contact_id', $request->people_id)->delete();
            if($request->organization_id!=null){
                foreach($request->organization_id as $organization){
                    $contactOrganization= new ContactOrganization();
                    $contactOrganization->contact_id = $request->people_id;
                    $contactOrganization->organization_id=$organization;
                    $contactOrganization->save();
                }
            }

            return redirect()->route('people')->withSuccess('Person Updated Successfully!');
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function sortApphabet($id){
        if($id == 'num') {
            $peoples = Contact::select('contacts.id', 'contacts.first_name', 'contacts.last_name', 'contacts.phone_no', 'contacts.personal_phone_no', 'contacts.lead_source', 'contacts.email',
                                   'contacts.title', 'contacts.user_id', 'contacts.shipping_po_box', 'contacts.shipping_street', 'contacts.shipping_city',
                                   'contacts.shipping_state', 'contacts.shipping_zip', 'contacts.shipping_country', 'contacts.created_at', 'contacts.updated_at',
                                   'contacts.organization_id', 'organizations.organization_name', 'users.name')
                          ->join('organizations', 'organizations.id', '=', 'contacts.organization_id')
                          ->join('users', 'users.id', '=', 'contacts.user_id')
                          ->where('contacts.active', 1)
                          ->where('contacts.first_name', 'regexp', '^[0-9]+')
                        //   ->orWhere('contacts.last_name', 'REGEXP', '^[0-9]')
                          ->orderBy('contacts.first_name')
                          ->get();

        } else {
            $peoples = Contact::select('contacts.id', 'contacts.first_name', 'contacts.last_name', 'contacts.phone_no', 'contacts.personal_phone_no', 'contacts.lead_source', 'contacts.email',
                                   'contacts.title', 'contacts.user_id', 'contacts.shipping_po_box', 'contacts.shipping_street', 'contacts.shipping_city',
                                   'contacts.shipping_state', 'contacts.shipping_zip', 'contacts.shipping_country', 'contacts.created_at', 'contacts.updated_at',
                                   'contacts.organization_id', 'organizations.organization_name', 'users.name')
                          ->join('organizations', 'organizations.id', '=', 'contacts.organization_id')
                          ->join('users', 'users.id', '=', 'contacts.user_id')
                          ->where('contacts.active', 1)
                          ->where('contacts.first_name', 'LIKE', $id.'%')
                          ->orWhere('contacts.last_name', 'LIKE', $id.'%')
                          ->orderBy('contacts.first_name')
                          ->get();
        }

        return json_encode($peoples);
    }

    public function search(){
        $peoples = Contact::select('contacts.id', 'contacts.first_name', 'contacts.last_name', 'contacts.title', 'contacts.email', 'contacts.phone_no', 'contacts.personal_phone_no',
                                   'contacts.user_id', 'contacts.organization_id', 'organizations.organization_name', 'users.name')
                                ->join('organizations', 'organizations.id', '=', 'contacts.organization_id')
                                ->join('users', 'users.id', '=', 'contacts.user_id')
                                ->where('contacts.active', 1)
                                ->orderBy('contacts.first_name')
                                ->get();
        echo json_encode($peoples);
    }

    public function delete($peopleId){
        if(auth()->user()->can('delete people')){
            $peoples = Contact::find($peopleId);
            $peoples->active = 0;
            $peoples->update();
            return redirect()->route('people')->withSuccess('Person Deleted Successfully!');
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function info($id) {
        if(auth()->user()->can('view people')){
            $peoples = Contact::find($id);

            $users = User::select('id', 'name')->get();

            // $orders = Order::select('orders.id', 'orders.order_no', 'orders.order_total', 'order_statuses.status_name', 'users.name', 'organizations.organization_name')
            //                 ->join('order_statuses', 'order_statuses.id', '=', 'orders.order_status_id')
            //                 ->join('organizations', 'organizations.id', '=', 'orders.organization_id')
            //                 ->join('contacts', 'contacts.organization_id', '=', 'orders.organization_id')
            //                 ->join('users', 'users.id', '=', 'orders.user_id')
            //                 ->where('contacts.id', $id)
            //                 ->orderBy('orders.order_no')
            //                 ->get();

            $orders = Order::select('orders.id', 'orders.order_no', 'orders.order_total', 'order_statuses.status_name', 'users.name', 'organizations.organization_name')
                            ->join('order_statuses', 'order_statuses.id', '=', 'orders.order_status_id')
                            ->join('organizations', 'organizations.id', '=', 'orders.organization_id')
                            ->join('users', 'users.id', '=', 'orders.user_id')
                            ->where('orders.contact_id', $id)
                            ->orderBy('orders.order_no')
                            ->get();

            // $orderCount = Order::join('contacts', 'contacts.organization_id', '=', 'orders.organization_id')->where('contacts.id', $id)->count();
            $orderCount = Order::where('contact_id', $id)->count();

            $fileCount = OrderItemFile::where('contact_id', $id)->count();

            $sports = Sport::where('active', 1)->orderBy('sport_name')->get();

            $organizations = Organization::select('id', 'organization_name')->where('active', 1)->orderBy('organization_name')->get();

            $contactOrganizations = ContactOrganization::where('contact_id', $id)->get()->pluck('organization_id');

            $colorMasters = ColorMaster::get();

            $lead_sources = LeadSource::where('active', 1)->get();

            return view('pages.contacts.people.info', [
                'peoples'=>$peoples,'organizations'=>$organizations,'colorMasters'=>$colorMasters, 'users'=>$users, 'orders'=>$orders, 'orderCount'=>$orderCount, 'fileCount'=>$fileCount, 'sports'=>$sports,
                'contact_organizations'=>$contactOrganizations, 'lead_sources'=>$lead_sources
            ]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function exportCsv(){
        $fileName = 'people.csv';
        $contacts = Contact::with('organizationDetails', 'userDetails')->where('active', 1)->get();

        $headers = array(
            "Content-type"=>"text/csv",
            "Content-Disposition"=>"attachment; filename=$fileName",
            "Pragma"=>"no-cache",
            "Cache-Control"=>"must-revalidate, post-check=0, pre-check=0",
            "Expires"=>"0"
        );

        $columns = array('Name Title', 'First Name', 'Last Name', 'Organization', 'Lead Source', 'Office Phone',
                         'Mobile Phone', 'Primary Email', 'Secondary Email', 'Title', 'Assign To');

        $callback = function() use($contacts, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($contacts as $contact) {
                $row['First Name'] = $contact->first_name;
                $row['Last Name'] = $contact->last_name;
                $row['Organization'] = $contact->organizationDetails['organization_name'];
                $row['Lead Source'] = $contact->lead_source;
                $row['Office Phone'] = $contact->phone_no;
                $row['Mobile Phone'] = $contact->personal_phone_no;
                $row['Primary Email'] = $contact->email;
                $row['Secondary Email'] = $contact->email;
                $row['Title'] = $contact->title;
                $row['Assign To'] = $contact->userDetails['name'];

                fputcsv($file, array(
                    $row['Name Title'], $row['First Name'], $row['Last Name'], $row['Organization'], $row['Lead Source'],
                    $row['Office Phone'], $row['Mobile Phone'], $row['Primary Email'], $row['Secondary Email'],
                    $row['Title'], $row['Assign To']
                ));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function layout(Request $request){
        if(PeopleLayout::where('user_id', Auth::user()->id)->first()){
            $peopleLayout = PeopleLayout::find($request->layout_id);
            $peopleLayout->first_name = $request->first_name;
            $peopleLayout->last_name = $request->last_name;
            $peopleLayout->organization_id = $request->organization_id;
            $peopleLayout->lead_source = $request->lead_source;
            $peopleLayout->phone_no = $request->phone_no;
            $peopleLayout->personal_phone_no = $request->personal_phone_no;
            $peopleLayout->email = $request->email;
            $peopleLayout->title = $request->title;
            $peopleLayout->user = $request->user_id;
            // $peopleLayout->shipping_po_box = $request->shipping_po_box;
            $peopleLayout->shipping_street = $request->shipping_street;
            $peopleLayout->shipping_city = $request->shipping_city;
            $peopleLayout->shipping_state = $request->shipping_state;
            $peopleLayout->shipping_zip = $request->shipping_zip;
            $peopleLayout->shipping_country = $request->shipping_country;
            $peopleLayout->created = $request->created_at;
            $peopleLayout->updated = $request->updated_at;
            $peopleLayout->update();

            $successMsg = "Updated";

        } else {
            $peopleLayout = new PeopleLayout();
            $peopleLayout->user_id = Auth::user()->id;
            $peopleLayout->first_name = 1;
            $peopleLayout->last_name = 1;
            $peopleLayout->organization_id = 1;
            $peopleLayout->lead_source = $request->lead_source;
            $peopleLayout->phone_no = 1;
            $peopleLayout->personal_phone_no = 1;
            $peopleLayout->email = 1;
            $peopleLayout->title = 1;
            $peopleLayout->user = $request->user_id;
            // $peopleLayout->shipping_po_box = $request->shipping_po_box;
            $peopleLayout->shipping_street = $request->shipping_street;
            $peopleLayout->shipping_city = $request->shipping_city;
            $peopleLayout->shipping_state = $request->shipping_state;
            $peopleLayout->shipping_zip = $request->shipping_zip;
            $peopleLayout->shipping_country = $request->shipping_country;
            $peopleLayout->created = $request->created_at;
            $peopleLayout->updated = $request->updated_at;
            $peopleLayout->save();

            $successMsg = "Saved";
        }

        return json_encode($successMsg);
    }
//Heshan Namal added for email validation when peoples create process
    public function checkEmailExists(Request $request) {
        $email = $request->input('email');
        $exists = Contact::where('email', $email)->exists();

        return response()->json(['exists' => $exists]);
    }
    public function SavePeopleAddress(Request $request) {

        $customer_id = $request->input('customer_id');
        $shippingApartment = $request->input('new_Apartment');
        $shippingStreet = $request->input('new_street');
        $shippingCity = $request->input('new_city');
        $shippingState = $request->input('new_state');
        $shippingZip = $request->input('new_postal_code');
        $shippingCountry = $request->input('new_country');
        $receiver_name = $request->input('receiver_name');

        $selectedAddressType = $request->input('address_type') ?? 3;

        $customer = Contact::find($customer_id);

        $Order = Order::find($request->input('order_id'));

        if ($selectedAddressType == 2) {
            // All shipping details are null or empty
            $customer->update([
                'receiver_name' => $receiver_name,
                'shipping_street' => $shippingStreet,
                'apartment' => $shippingApartment,
                'shipping_city' => $shippingCity,
                'shipping_state' => $shippingState,
                'shipping_zip' => $shippingZip,
                'shipping_country' => $shippingCountry
            ]);

            $Order->is_new_shipping_address = 2;
            $Order->save();

            // Return a success response
            return response()->json(['success' => 'Primary contact details updated successfully !'], 200);
        }else{
            try {
                $customer->update([
                    'receiver_name2' => $receiver_name,
                    'shipping_street_2' => $shippingStreet,
                    'apartment2' => $shippingApartment,
                    'shipping_city_2' => $shippingCity,
                    'shipping_state_2' => $shippingState,
                    'shipping_zip_2' => $shippingZip,
                    'shipping_country_2' => $shippingCountry
                ]);
                $Order->is_new_shipping_address = 3;
                $Order->save();
            } catch (\Exception $e) {
                // Log the error
                logger()->error('Error updating customer: ' . $e->getMessage());
                // Return a response indicating failure
                return response()->json(['error' => 'Failed to update address !'], 500);
            }


            // Return a success response
            return response()->json(['success' => 'Second contact details updated successfully !'], 200);

        }

        return response()->json(['exists' => $exists]);
    }
}
