<?php

namespace App\Http\Controllers;

use App\Imports\ActivitiesImport;
use App\Imports\ContactsImport;
use App\Imports\OrganizationsImport;
use App\Models\Contact;
use App\Models\Organization;
use App\Models\PipedriveActivity;
use App\Models\Activity;
use App\Models\PipedriveContact;
use App\Models\PipedriveOrganization;
use App\Models\Sport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PipedriveController extends Controller
{
    public function organizations(){
        $pDOrganizations = PipedriveOrganization::select('id', 'organization_name', 'organization_id', 'is_synced')->where('active', 1)->orderBy('is_synced')->orderBy('organization_name')->paginate(50);

        $pDOCount = PipedriveOrganization::where('active', 1)->count();

        $syncedPDOCount = PipedriveOrganization::where('active', 1)->where('is_synced', 1)->count();

        $organizations = Organization::select('id', 'organization_name', 'active')->orderBy('organization_name')->get();

        $peoples = Contact::select('id', 'first_name', 'last_name')->orderBy('first_name')->get();

        $sports = Sport::where('active', 1)->orderBy('sport_name')->get();

        $users = User::select('id', 'name')->where('user_role_id', 3)->get();

        return view('pages.settings.pipedrive.organizations', [
            'pDOrganizations'=>$pDOrganizations, 'pDOCount'=>$pDOCount, 'syncedPDOCount'=>$syncedPDOCount, 'organizations'=>$organizations, 'peoples'=>$peoples, 'sports'=>$sports, 'users'=>$users
        ]);
    }

    public function organizationsUpload(Request $request){
        $file = $request->file('organizations_csv');

        $import = new OrganizationsImport();
        Excel::import($import, $file);
        $sheet = $import->getArray();

        $insert_data = collect($sheet);
        $chunks = $insert_data->chunk(500);

        $datetime = Carbon::now()->format('m-d-Y h-i-s a');
        $filename = 'pipedrive_organizations - '.$datetime;
        $destinationPath = 'uploads/pipedrive/organizations';
        $file->move($destinationPath, $filename.'.'.$file->getClientOriginalExtension());

        foreach ($chunks as $chunk) {
            foreach ($chunk  as $organization) {
                $pDOrganization = PipedriveOrganization::where('organization_name', 'LIKE', trim($organization['organization_name']))->first();

                if (!isset($pDOrganization)) {
                    $encromsOrg = Organization::select('id')->where('organization_name', 'LIKE', trim($organization['organization_name']))->first();

                    $newPDOrganization = new PipedriveOrganization();
                    $newPDOrganization->organization_name = trim($organization['organization_name']);

                    if (isset($encromsOrg)) {
                        $newPDOrganization->organization_id = $encromsOrg->id;
                        $newPDOrganization->is_synced = 1;
                    }

                    $newPDOrganization->address = trim($organization['address']);
                    $newPDOrganization->website = trim($organization['website']);
                    $newPDOrganization->size_of_club = trim($organization['size_of_club']);
                    $newPDOrganization->country = trim($organization['country']);
                    $newPDOrganization->no_of_people = trim($organization['no_of_people']);
                    $newPDOrganization->no_of_closed_deals = trim($organization['no_of_closed_deals']);
                    $newPDOrganization->no_of_opened_deals = trim($organization['no_of_opened_deals']);
                    $newPDOrganization->next_activity_date = trim($organization['next_activity_date']);
                    $newPDOrganization->location = trim($organization['location']);
                    $newPDOrganization->owner = trim($organization['owner']);
                    $newPDOrganization->state = trim($organization['state']);
                    $newPDOrganization->save();
                }
            }
        }

        return redirect()->back()->withSuccess('Pipedrive Organizations Imported Successfully!');
    }

    public function organizationsSync(Request $request) {
        foreach($request->organization as $key => $organization){
            if ($organization) {
                $pDOrganization = PipedriveOrganization::find($key);
                $pDOrganization->organization_id = $organization;
                $pDOrganization->is_synced = 1;
                $pDOrganization->update();
            }
        }

        return redirect()->back()->withSuccess('Pipedrive Organizations Synced Successfully!');
    }

    public function activitiesSync(Request $request) {

        foreach ($request->PD_records as $key => $PD_record) {

            $pipedrive_record = PipedriveActivity::find($key);


            if($pipedrive_record->is_synced == 0){

                if($PD_record['organization_sync'] == 1){

                    $encore_activity = Activity::where('assigned_to', $pipedrive_record->user_id)
                        ->where('activity_subject', $pipedrive_record->subject)
                        ->where('activity_note', $pipedrive_record->note)
                        ->where('contact_id', $PD_record['user'])
                        ->where('organization_id', $PD_record['organization'])
                        ->first();

                        if($encore_activity){

                            $pipedrive_record->is_synced = 2;
                            $pipedrive_record->save();

                        }else{

                        $activity = new Activity();
                        $activity->activity_subject = $pipedrive_record->subject;
                        $activity->activity_note = $pipedrive_record->note;
                        $activity->activity_deal = $pipedrive_record->deal;
                        $activity->assigned_to = $PD_record['user_id'];
                        $activity->contact_id = $PD_record['user'];
                        $activity->organization_id = $PD_record['organization'];
                        $activity->created_by = Auth()->user()->id;
                        $activity->start_date = $pipedrive_record->due_date;
                        $activity->due_date = $pipedrive_record->due_date;
                        $activity->is_synced = 1;
                        if($pipedrive_record->done == 'Done'){
                            $activity->is_done = 1;
                        }else{
                            $activity->is_done = 0;
                        }
                        $activity->active = 1;
                        $activity->save();

                        $pipedrive_record->is_synced = 1;
                        $pipedrive_record->save();

                    }

                }

            }

        }
        return redirect()->back()->withSuccess('Pipedrive Activities Synced Successfully!');

    }

    public function people(){
        $pDContacts = PipedriveContact::select('id', 'contact_name', 'contact_id', 'is_synced', 'pd_organization', 'organization_id','email')->where('active', 1)->orderBy('is_synced')->orderBy('contact_name')->paginate(50);

        $pDCCount = PipedriveContact::where('active', 1)->count();

        $syncedPDCCount = PipedriveContact::where('active', 1)->where('is_synced', 1)->count();

        $peoples = Contact::select('id', 'first_name', 'last_name','email')->orderBy('first_name')->get();

        $organizations = Organization::select('id', 'organization_name', 'active')->orderBy('organization_name')->get();

        $sports = Sport::where('active', 1)->orderBy('sport_name')->get();

        $users = User::select('id', 'name')->where('user_role_id', 3)->get();

        return view('pages.settings.pipedrive.people', [
            'pDContacts'=>$pDContacts, 'pDCCount'=>$pDCCount, 'syncedPDCCount'=>$syncedPDCCount, 'peoples'=>$peoples, 'organizations'=>$organizations, 'sports'=>$sports, 'users'=>$users
        ]);
    }

    public function peopleUpload(Request $request){
        $file = $request->file('people_csv');

        $import = new ContactsImport();
        Excel::import($import, $file);
        $sheet = $import->getArray();

        $insert_data = collect($sheet);
        $chunks = $insert_data->chunk(500);

        $datetime = Carbon::now()->format('m-d-Y h-i-s a');
        $filename = 'pipedrive_contacts - '.$datetime;
        $destinationPath = 'uploads/pipedrive/contacts';
        $file->move($destinationPath, $filename.'.'.$file->getClientOriginalExtension());

        foreach ($chunks as $chunk) {
            foreach ($chunk as $contact) {
                $pDContact = PipedriveContact::where('contact_name', 'LIKE', trim($contact['contact_name']))->where('pd_organization', 'LIKE', trim($contact['pd_organization']))->first();

                if (!isset($pDContact)) {
                    $encromsContact = Contact::select('id', 'organization_id')->where(DB::raw('concat(first_name, " ", last_name)'), 'LIKE', trim($contact['contact_name']))->first();

                    $newPDContact = new PipedriveContact();
                    $newPDContact->contact_name = trim($contact['contact_name']);

                    if (isset($encromsContact) && isset($encromsContact->organization_id)) {
                        $newPDContact->contact_id = $encromsContact->id;
                        $newPDContact->organization_id = $encromsContact->organization_id;
                        $newPDContact->is_synced = 1;

                    } else if (isset($encromsContact) && !isset($encromsContact->organization_id)) {
                        $newPDContact->contact_id = $encromsContact->id;
                    }

                    $newPDContact->label = trim($contact['label']);
                    $newPDContact->pd_organization = trim($contact['pd_organization']);
                    $newPDContact->email = trim($contact['email']);
                    $newPDContact->phone_no = trim($contact['phone_no']);
                    $newPDContact->no_of_closed_deals = trim($contact['no_of_closed_deals']);
                    $newPDContact->no_of_opened_deals = trim($contact['no_of_opened_deals']);
                    $newPDContact->next_activity_date = trim($contact['next_activity_date']);
                    $newPDContact->owner = trim($contact['owner']);
                    $newPDContact->pd_created_date = trim($contact['pd_created_date']);
                    $newPDContact->save();
                }
            }
        }

        return redirect()->back()->withSuccess('Pipedrive Contacts Imported Successfully!');
    }

    public function peopleSync(Request $request) {
        foreach($request->contact as $key => $contact){
            if ($contact) {
                $pDContact = PipedriveContact::find($key);
                $pDContact->contact_id = $contact['contact_id'];
                $pDContact->organization_id = $contact['organization_id'];

                if (isset($contact['contact_id']) && isset($contact['organization_id'])) {
                    $pDContact->is_synced = 1;
                } else {
                    $pDContact->is_synced = 0;
                }

                $pDContact->update();
            }
        }

        return redirect()->back()->withSuccess('Pipedrive Organizations Synced Successfully!');
    }

    public function activities(Request $request){
        if (isset($request->userId)) {

            // $pDActivities = PipedriveActivity::with('pDODetails', 'pDCDetails')->where('user_id', $request->userId)->where('active', 1)->paginate(200);
            $pDActivities = PipedriveActivity::with('pDODetails', 'pDCDetails')->where('user_id', $request->userId)->where('active', 1)->orderBy('is_synced', 'asc')->paginate(200);

        } else {
            $pDActivities = '';
        }

        if(isset($request->userId)){
            $syncedCount = PipedriveActivity::where('user_id', $request->userId)->whereIn('is_synced', [1,2])->count();
            $ACTCount = PipedriveActivity::where('user_id', $request->userId)->where('active', 1)->count();
        }else{
            $syncedCount = PipedriveActivity::whereIn('is_synced', [1,2])->count();
            $ACTCount = PipedriveActivity::where('active', 1)->count();
        }



        $pDOCount = PipedriveOrganization::where('active', 1)->count();

        $syncedPDOCount = PipedriveOrganization::where('active', 1)->where('is_synced', 1)->count();

        $pDCCount = PipedriveContact::where('active', 1)->count();

        $syncedPDCCount = PipedriveContact::where('active', 1)->where('is_synced', 1)->count();

        $users = User::select('id', 'name')->where('active', 1)->get();

        return view('pages.settings.pipedrive.activities', [
            'pDActivities'=>$pDActivities, 'pDOCount'=>$pDOCount, 'syncedPDOCount'=>$syncedPDOCount, 'pDCCount'=>$pDCCount, 'syncedPDCCount'=>$syncedPDCCount, 'users'=>$users , 'syncedCount'=>$syncedCount , 'ACTCount'=>$ACTCount
        ]);
    }

    public function activitiesUpload(Request $request){
        $file = $request->file('activities_csv');

        $import = new ActivitiesImport();
        Excel::import($import, $file);
        $sheet = $import->getArray();

        $insert_data = collect($sheet);
        $chunks = $insert_data->chunk(500);

        $datetime = Carbon::now()->format('m-d-Y h-i-s a');
        $filename = 'pipedrive_activities - '.$datetime;
        $destinationPath = 'uploads/pipedrive/activities';
        $file->move($destinationPath, $filename.'.'.$file->getClientOriginalExtension());

        foreach ($chunks as $chunk) {
            foreach ($chunk as $activity) {
                $pDActivity = PipedriveActivity::where('subject', 'LIKE', trim($activity['subject']))
                                              ->where('deal', 'LIKE', trim($activity['deal']))
                                              ->where('contact_name', 'LIKE', trim($activity['contact_name']))
                                              ->where('organization_name', 'LIKE', trim($activity['organization_name']))
                                              ->first();

                if (!isset($pDActivity)) {
                    $newPDOrganization = new PipedriveActivity();
                    $newPDOrganization->user_id = $request->user_id;
                    $newPDOrganization->done = trim($activity['done']);
                    $newPDOrganization->subject = trim($activity['subject']);
                    $newPDOrganization->deal = trim($activity['deal']);
                    $newPDOrganization->note = trim($activity['note']);
                    $newPDOrganization->contact_name = trim($activity['contact_name']);
                    $newPDOrganization->email = trim($activity['email']);
                    $newPDOrganization->phone_no = trim($activity['phone_no']);
                    $newPDOrganization->organization_name = trim($activity['organization_name']);
                    $newPDOrganization->due_date = trim($activity['due_date']);
                    $newPDOrganization->duration = trim($activity['duration']);
                    $newPDOrganization->assigned_user_name = trim($activity['assigned_user_name']);
                    $newPDOrganization->save();
                }
            }
        }

        return redirect()->back()->withSuccess('Pipedrive Activities Imported Successfully!');
    }
    public function pipedrivesearch(Request $request)
    {
        $searchTerm = $request->input('q');

        // Perform the organization search based on the search term
        $organizations = Organization::where('organization_name', 'like', '%'.$searchTerm.'%')->get();

        // Return the organizations as JSON response
        return response()->json($organizations);
    }
    public function createorganization(Request $request)
    {


        // Create a new organization
        $newOrganization = new Organization();
        $newOrganization->organization_name = $request->organization_name;
        $newOrganization->active =  1;
        $newOrganization->user_id = 5; // Assuming you have authentication
        $newOrganization->save();

        // Create a new Pipedrive organization
        $newPDOrganization = new PipedriveOrganization();
        $newPDOrganization->organization_name = $request->organization_name;;
        $newPDOrganization->organization_id = $newOrganization->id;
        $newPDOrganization->is_synced = 1; // Assuming the organization is synced
        $newPDOrganization->save();

        // Update the Pipedrive activity with the new organization name
        $pDActivity = PipedriveActivity::find($request->activity_id);
        if ($pDActivity) {
            $pDActivity->organization_name = $request->organization_name;
            $pDActivity->save();
        } else {
            // Activity not found, handle the error (e.g., return an error response)
            return response()->json(['error' => 'Activity not found'], 404);
        }

        // Return a success response
        return response()->json(['success' => true, 'message' => 'Organization created successfully']);
    }
    public function linkorganization(Request $request)
    {



        $Organization = Organization::find($request->organizationId);

        // Create a new Pipedrive organization
        $newPDOrganization = new PipedriveOrganization();
        $newPDOrganization->organization_name = $Organization->organization_name;;
        $newPDOrganization->organization_id = $Organization->id;
        $newPDOrganization->is_synced = 1; // Assuming the organization is synced
        $newPDOrganization->save();

        // Update the Pipedrive activity with the new organization name
        $pDActivity = PipedriveActivity::find($request->activity_id);
        if ($pDActivity) {
            $pDActivity->organization_name = $Organization->organization_name;;
            $pDActivity->save();
        } else {
            // Activity not found, handle the error (e.g., return an error response)
            return response()->json(['error' => 'Activity not found'], 404);
        }

        // Return a success response
        return response()->json(['success' => true, 'message' => 'Organization created successfully']);
    }

}

