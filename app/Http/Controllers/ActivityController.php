<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\PipedriveActivity;
use App\Models\ActivityAssignee;
use App\Models\ActivityLayout;
use App\Models\ColumnLayout;
use App\Models\Contact;
use App\Models\ContactOrganization;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Organization;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Services\NotificationBuilderService;
use App\Models\OrganizationEmail;

class ActivityController extends Controller
{
    public function index(){
        $roleId = Role::where('name', 'Activity Users')->value('id');

        $users = User::select('id', 'name')
            ->where('active', 1)
            ->whereJsonContains('role_id', (string) $roleId)
            ->orderBy('name')
            ->get();

        $all_persons = Contact::where('active' , 1)->get();
        $all_users = User::where('active' , 1)->get();
        $all_organizations = Organization::where('active' , 1)->get();


        // dd($users);
        if(auth()->user()->can('manage activities')){

            $activityLayout = ActivityLayout::where('user_id', Auth::user()->id)->first();

            $columnLayout = ColumnLayout::where('interface_id', 14)->where('user_id', Auth::user()->id)->first();

            return view('pages.settings.activity.index', [
                'users'=>$users, 'activityLayout'=>$activityLayout, 'columnLayout'=>$columnLayout, 'all_persons'=>$all_persons, 'all_organizations'=>$all_organizations, 'all_users'=>$all_users
            ]);

        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function getActivities($user_id, $filter, $from_date, $to_date){

        if($from_date != 0){

            if ($filter == 0) { // To do
                $activities = Activity::with('orderDetails', 'organizationDetails', 'contactDetails', 'assigneeDetails', 'userDetails')
                                        ->where('assigned_to', $user_id)
                                        ->where('is_done', 0)
                                        ->where('active', 1)->orderBy('start_date', 'desc')
                                        ->get();

            } else if ($filter == 1) { // Over due
                $activities = Activity::with('orderDetails', 'organizationDetails', 'contactDetails', 'assigneeDetails', 'userDetails')
                                        ->where('assigned_to', $user_id)
                                        ->where('is_done', 0)
                                        ->whereDate('start_date', '<', Carbon::now())
                                        ->where('active', 1)->orderBy('start_date', 'desc')
                                        ->get();

            } else if ($filter == 2) { // Today
                $activities = Activity::with('orderDetails', 'organizationDetails', 'contactDetails', 'assigneeDetails', 'userDetails')
                                        ->where('assigned_to', $user_id)
                                        ->whereDate('start_date', Carbon::now())
                                        ->where('is_done', 0)
                                        ->where('active', 1)->orderByRaw("CASE WHEN priority IS NULL THEN 4 ELSE priority END DESC")->orderBy('priority', 'desc')
                                        ->get();

            } else if ($filter == 3) { // Time period
                $activities = Activity::with('orderDetails', 'organizationDetails', 'contactDetails', 'assigneeDetails', 'userDetails')
                                        ->where('assigned_to', $user_id)
                                        ->whereBetween('start_date', [Carbon::createFromFormat('m-d-Y', $from_date)->format('Y-m-d'), Carbon::createFromFormat('m-d-Y', $to_date)->format('Y-m-d')])
                                        ->where('active', 1)->orderBy('start_date', 'desc')
                                        ->get();
            } else if ($filter == 4) { // Tommorow
                $activities = Activity::with('orderDetails', 'organizationDetails', 'contactDetails', 'assigneeDetails', 'userDetails')
                                        ->where('assigned_to', $user_id)
                                        ->whereDate('start_date', Carbon::now()->addDay())
                                        ->where('is_done', 0)
                                        ->where('active', 1)->orderBy('start_date', 'desc')
                                        ->get();
            } else if ($filter == 5) { // This week
                $from_date = Carbon::now()->startOfWeek()->format('m-d-Y');
                $to_date = Carbon::now()->endOfWeek()->format('m-d-Y');

                $activities = Activity::with('orderDetails', 'organizationDetails', 'contactDetails', 'assigneeDetails', 'userDetails')
                            ->where('assigned_to', $user_id)
                            ->whereBetween('start_date', [Carbon::createFromFormat('m-d-Y', $from_date)->format('Y-m-d'), Carbon::createFromFormat('m-d-Y', $to_date)->format('Y-m-d')])
                            ->where('active', 1)->orderBy('start_date', 'desc')
                            ->get();
            } else if ($filter == 6) { // Next week
                $from_date = Carbon::now()->addWeek()->startOfWeek()->format('m-d-Y');
                $to_date = Carbon::now()->addWeek()->endOfWeek()->format('m-d-Y');

                $activities = Activity::with('orderDetails', 'organizationDetails', 'contactDetails', 'assigneeDetails', 'userDetails')
                            ->where('assigned_to', $user_id)
                            ->whereBetween('start_date', [Carbon::createFromFormat('m-d-Y', $from_date)->format('Y-m-d'), Carbon::createFromFormat('m-d-Y', $to_date)->format('Y-m-d')])
                            ->where('active', 1)->orderBy('start_date', 'desc')
                            ->get();
            }
        }else{

            $text_input = $to_date;
            $activities = Activity::with('orderDetails', 'organizationDetails', 'contactDetails', 'assigneeDetails', 'userDetails')
            ->where('active', 1)
            ->where(function($query) use ($text_input) {
                $query->whereHas('contactDetails', function($query) use ($text_input) {
                    $query->where('first_name', 'like', '%' . $text_input . '%')
                        ->orWhere('last_name', 'like', '%' . $text_input . '%');
                })
                ->orWhere('activity_subject', 'like', '%' . $text_input . '%')
                ->orWhereHas('organizationDetails', function($query) use ($text_input) {
                    $query->where('organization_name', 'like', '%' . $text_input . '%');
                });
            })
            ->orderByRaw("assigned_to = " . auth()->user()->id . " DESC")
            ->orderByRaw("CASE WHEN assigned_to = " . auth()->user()->id . " THEN 0 ELSE 1 END")
            ->get();
        }

        // $activityCount = Activity::where('assigned_to', $user_id)->where('is_done', 0)->where('active', 1)->count();
        $activityCount = $activities->count();

        return json_encode([$activities, $activityCount]);
    }

    public function getAllData($activity_id) {
        $organizations = Organization::select('id', 'organization_name')->where('active', 1)->orderBy('organization_name')->get();

        $activity = Activity::find($activity_id);
        $organization = Organization::find($activity->organization_id);

        $orders = Order::select('id', 'order_no')->where('organization_id', $organization->id)->where('active', 1)->orderBy('id')->get();

        $contacts= ContactOrganization::with('contacts')->where('organization_id', $organization->id)
                                      ->whereHas('contacts', function($query){
                                        return $query->where('active', 1);
                                      })
                                      ->get();

        return json_encode([$organizations, $orders, $contacts]);
    }

    public function getOrganizations() {
        $organizations = Organization::select('id', 'organization_name')->where('active', 1)->orderBy('organization_name')->get();
        return json_encode($organizations);
    }

    public function getOrdersPeopleByOrganiation($organization_id) {
        $orders = Order::select('id', 'order_no')->where('organization_id', $organization_id)->where('active', 1)->orderBy('id', 'DESC')->get();

        $contacts= ContactOrganization::with('contacts')->where('organization_id', $organization_id)
                                      ->whereHas('contacts', function($query){
                                        return $query->where('active', 1);
                                      })
                                      ->get();

        return json_encode([$orders, $contacts]);
    }

    public function getActivityById($id) {
        $activity = Activity::find($id);
        return json_encode($activity);
    }

    public function getActivitiesByDate($user_id, $due_date) {
        $activities = Activity::select('id', 'activity_subject','start_date')->where('assigned_to', $user_id)->whereDate('start_date', Carbon::createFromFormat('m-d-Y', $due_date)->format('Y-m-d'))->where('active', 1)->where('is_done', 0)->where('activity_type', '!=', 2)->get();
        return json_encode($activities);
    }

    public function getActivitiesByDueDate($due_date) {
        $activities = Activity::select('id', 'activity_subject' ,'start_date')->whereDate('start_date', Carbon::createFromFormat('m-d-Y', $due_date)->format('Y-m-d'))->where('active', 1)->where('is_done', 0)->get();
        return json_encode($activities);
    }

    public function update_act_note($userID){
        $activities = Activity::where('is_synced', 1)
                    ->whereDate('updated_at', '<=', Carbon::parse('2024-04-23'))->where('activity_note', '<>', '')->where('assigned_to' , $userID)
                    ->get();

        foreach ($activities as $activity) {
            $contact = Contact::where('id', $activity->contact_id)->first();
            if($contact){
                $pipedrive_record = PipedriveActivity::where('is_synced', 1)->where('active' , 1)->where('subject',$activity->activity_subject)->where('user_id',$activity->assigned_to)->where('email', $contact->email)->where('user_id', $userID)->first();
                if($pipedrive_record){
                    $activity->activity_note = $pipedrive_record->note;
                    $activity->save();

                    dump($activity->id.' updated');
                }
            }
        }
        dd('All activity subject updated for user id: '.$userID.' !!!');
    }

    public function create(Request $request){
        // $due_date = Carbon::parse(str_replace('-', '/', $request->due_date))->format('Y-m-d');
        $start_date = Carbon::parse(str_replace('-', '/', $request->start_date))->format('Y-m-d');
        if(empty($request->start_time)){
            $start_time = Carbon::parse('12:00 AM')->format('H:i:s');
        }else{
            $start_time = Carbon::parse($request->start_time)->format('H:i:s');
        }

        if ($request->is_done == 'on') {
            $is_done = 1;
        } else {
            $is_done = 0;
        }

        $activity = New Activity();
        $activity->activity_subject = $request->activity_subject;
        $activity->activity_note = $request->activity_note;
        if(isset($request->priority)){
            $activity->priority = $request->priority;
        }

        $activity->assigned_to = $request->activity_user_id;
        $activity->order_id = $request->activity_order_id;
        $activity->contact_id = $request->activity_contact_id;
        $activity->organization_id = $request->activity_organization_id;
        // $activity->due_date = $due_date;
        $activity->start_date = $start_date.' '.$start_time;
        $activity->created_by = Auth::user()->id;
        $activity->modified_by = Auth::user()->id;
        $activity->is_done = $is_done;
        $activity->save();

        if (!($request->activity_user_id == Auth::user()->id)) {
            $notification_user_id = $request->activity_user_id;
        } else {
            $notification_user_id = null;
        }

        $assignToName = $request->activity_user_id
            ? optional(User::find($request->activity_user_id))->name
            : '-';

        $organizationName = $request->activity_organization_id
            ? optional(Organization::find($request->activity_organization_id))->organization_name
            : '-';

        $orderNo = $request->activity_order_id
            ? optional(Order::find($request->activity_order_id))->order_no
            : '-';

        $contactPerson = '-';
        if ($request->activity_contact_id) {
            $contact = Contact::find($request->activity_contact_id);
            $contactPerson = $contact ? trim($contact->first_name . ' ' . $contact->last_name) : '-';
        }

        $priorityLabels = [0 => null, 1 => 'Low', 2 => 'Medium', 3 => 'High'];
        $priorityColors = [1 => '#16a34a', 2 => '#d97706', 3 => '#dc2626'];
        $priorityLabel = $priorityLabels[$activity->priority] ?? null;
        $priorityBadge = $priorityLabel
            ? '<div style="margin-top:6px;font-size:13px;color:#374151"><span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:' . ($priorityColors[$activity->priority] ?? '#6b7280') . ';margin-right:6px;"></span>' . $priorityLabel . ' priority</div>'
            : '';

        $builder = new NotificationBuilderService();

        $builder->sendNotification(
            'key_new_activity',
            [
                '{User_name}'         => Auth::user()->name,
                '{activity_subject}'  => $activity->activity_subject,
                '{activity_link}'     => route('activities') . '?open_modal=true&activity_id=' . $activity->id,
                '{priority_badge}'    => $priorityBadge,
                '{start_date_time}'   => Carbon::parse($activity->start_date)->format('M d, Y  -  g:i A'),
                '{activity_note}'     => $activity->activity_note,
                '{assign_to}'         => $assignToName,
                '{organization}'      => $organizationName,
                '{order_no}'          => $orderNo,
                '{contact_person}'    => $contactPerson,
            ],
            [
                'order_id'    => $request->activity_order_id,
                'activity_id' => $activity->id,
                'user_id'     => $notification_user_id,
                'target_notification_field'  => 'key_new_activity',
                'new_notification'           => 1,
            ]
        );

        return redirect()->back()->withSuccess('Activity Saved Successfully!');
    }

    public function createOnEmail(Request $request){
        // $due_date = Carbon::parse(str_replace('-', '/', $request->due_date))->format('Y-m-d');
        $start_date = Carbon::parse(str_replace('-', '/', $request->start_date))->format('Y-m-d');
        if(empty($request->start_time)){
            $start_time = Carbon::parse('12:00 AM')->format('H:i:s');
        }else{
            $start_time = Carbon::parse($request->start_time)->format('H:i:s');
        }

        if ($request->is_done == 'on') {
            $is_done = 1;
        } else {
            $is_done = 0;
        }

        $activity = New Activity();
        $activity->activity_subject = $request->activity_subject;
        $activity->activity_note = $request->activity_note;
        $activity->assigned_to = $request->activity_user_id;
        $activity->order_id = $request->activity_order_id;
        $activity->contact_id = $request->activity_contact_id;
        $activity->organization_id = $request->activity_organization_id;
        // $activity->due_date = $due_date;
        $activity->start_date = $start_date.' '.$start_time;
        $activity->created_by = Auth::user()->id;
        $activity->email_message_no = $request->activity_email_no;
        $activity->is_done = $is_done;
        $activity->save();

        // $notification = new Notification();
        // $notification->notification_title = 'New Activity - '.$request->activity_subject;
        // $notification->notification_message = Auth::user()->name.' created a new activity';
        // $notification->is_read = 0;
        // $notification->user_id = $request->activity_user_id;
        // $notification->order_id = $request->activity_order_id;
        // $notification->save();

        $builder = new NotificationBuilderService();

        $builder->sendNotification('key_new_activity', [
            '{Activity_subject}' => $request->activity_subject,
            '{User_name}' => Auth::user()->name,
        ], [

            'order_id' => $request->activity_order_id,
            'activity_id' => $activity->id,
            'user_id' => $request->activity_user_id,
        ]);

        return redirect()->back()->withSuccess('Activity Saved Successfully!');
    }

    public function update(Request $request)
    {
        $start_date = Carbon::parse(str_replace('-', '/', $request->start_date))->format('Y-m-d');
        if (empty($request->start_time)) {
            $start_time = Carbon::parse('12:00 AM')->format('H:i:s');
        } else {
            $start_time = Carbon::parse($request->start_time)->format('H:i:s');
        }

        if ($request->is_done == 'on') {
            $is_done = 1;
        } else {
            $is_done = 0;
        }

        $activity = Activity::find($request->activity_id);

        // Snapshot original values before applying changes
        $originalValues = $activity->getOriginal();

        $activity->activity_subject = $request->activity_subject;
        if (isset($request->priority)) {
            $activity->priority = $request->priority;
        }
        $activity->activity_note     = $request->activity_note;
        $activity->assigned_to       = $request->activity_user_id;
        $activity->order_id          = $request->activity_order_id;
        $activity->contact_id        = $request->activity_contact_id;
        $activity->organization_id   = $request->activity_organization_id;
        $activity->start_date        = $start_date . ' ' . $start_time;
        $activity->created_by        = Auth::user()->id;
        $activity->modified_by       = Auth::user()->id;
        $activity->is_done           = $is_done;
        $activity->update();

        if (!($request->activity_user_id == Auth::user()->id)) {
            $notification_user_id = $request->activity_user_id;
        } else {
            $notification_user_id = null;
        }

       
        $fieldLabels = [
            'assigned_to' => [
                'label'   => 'Assign To',
                'resolve' => fn($id) => $id ? optional(User::find($id))->name : '-',
            ],
            'organization_id' => [
                'label'   => 'Organization',
                'resolve' => fn($id) => $id ? optional(Organization::find($id))->organization_name : '-',
            ],
            'order_id' => [
                'label'   => 'Order No',
                'resolve' => fn($id) => $id ? optional(Order::find($id))->order_no : '-',
            ],
            'contact_id' => [
                'label'   => 'Contact Person',
                'resolve' => function ($id) {
                    if (!$id) return '-';
                    $contact = Contact::find($id);
                    return $contact ? trim($contact->first_name . ' ' . $contact->last_name) : '-';
                },
            ],
        ];

        $rowsHtml = '';
        foreach ($fieldLabels as $key => $meta) {
            $prev    = e($meta['resolve']($originalValues[$key] ?? null));
            $updated = e($meta['resolve']($activity->{$key}));
            $rowsHtml .= "<tr>
                <td style=\"padding:10px 16px;border-bottom:1px solid #f3f4f6;color:#374151\">{$meta['label']}</td>
                <td style=\"padding:10px 16px;border-bottom:1px solid #f3f4f6;color:#6b7280\">{$prev}</td>
                <td style=\"padding:10px 16px;border-bottom:1px solid #f3f4f6;color:#111827;font-weight:600\">{$updated}</td>
            </tr>";
        }

        $priorityLabels = [0 => null, 1 => 'Low', 2 => 'Medium', 3 => 'High'];
        $priorityColors = [1 => '#16a34a', 2 => '#d97706', 3 => '#dc2626'];
        $priorityLabel  = $priorityLabels[$activity->priority] ?? null;
        $priorityBadge  = $priorityLabel
            ? '<div style="margin-top:6px;font-size:13px;color:#374151"><span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:' . ($priorityColors[$activity->priority] ?? '#6b7280') . ';margin-right:6px;"></span>' . $priorityLabel . ' priority</div>'
            : '';

        $builder = new NotificationBuilderService();

        $builder->sendNotification(
            'key_update_activity',
            [
                '{User_name}'        => Auth::user()->name,
                '{activity_subject}' => $activity->activity_subject,
                '{activity_link}'    => route('activities') . '?open_modal=true&activity_id=' . $activity->id,
                '{priority_badge}'   => $priorityBadge,
                '{start_date_time}'  => Carbon::parse($activity->start_date)->format('M d, Y  -  g:i A'),
                '{activity_note}'    => $activity->activity_note,
                '{changes_rows}'     => $rowsHtml,
            ],
            [
                'order_id'    => $request->activity_order_id,
                'activity_id' => $activity->id,
                'user_id'     => $notification_user_id,
                'target_notification_field'  => 'key_update_activity',
                'new_notification'           => 1,
            ]
        );

        $order_id = $request->activity_order_id;
        $contact_id = $request->activity_contact_id;
        $organization_id = $request->activity_organization_id;
        $to_do_available_org = $request->activity_organization_id;

        $is_todo_available = Activity::where('organization_id', $request->activity_organization_id)
            ->where('is_done', 0)
            ->where('active', 1)
            ->whereNull('deleted_at')
            ->exists();

        if ($request->is_done == 'on' && !$is_todo_available) {
            return redirect()->back()->with([
                'success'             => 'Activity Status Updated Successfully!',
                'order_id'            => $order_id,
                'contact_id'          => $contact_id,
                'organization_id'     => $organization_id,
                'to_do_available_org' => $to_do_available_org
            ]);
        } else {
            return redirect()->back()->withSuccess('Activity Updated Successfully!');
        }
    }

    public function markAsDone(Request $request){

        $is_todo_available = true;
        $to_do_available_org = '';
        $activities = explode(",", $request->input('mark_as_done_activites')[0]);
        foreach($activities as $activity) {
            $activity = Activity::find($activity);
            $activity->is_done = 1;
            $activity->update();

            if(!Activity::where('organization_id' , $activity->organization_id)->where('is_done' , 0)->where('active' , 1)->whereNull('deleted_at')->exists()){
                $is_todo_available = false;
                $to_do_available_org = $activity->organization_id;
            }


        }


        if (!$is_todo_available) {
            return redirect()->back()->with([
                'success' => 'Activity Status Updated Successfully!',
                'to_do_available_org' => $to_do_available_org
            ]);
        } else {
            return redirect()->back()->withSuccess('Activities Marked as Done!');
        }
    }
    public function mark_as_delete(Request $request){

        $is_todo_available = true;
        $to_do_available_org = '';
        $activities = explode(",", $request->input('mark_to_delete_activites')[0]);
        foreach($activities as $activity) {
            $activity = Activity::find($activity);
            $activity->active = 3;
            $activity->update();
            if(!Activity::where('organization_id' , $activity->organization_id)->where('is_done' , 0)->where('active' , 1)->whereNull('deleted_at')->exists()){
                $is_todo_available = false;
                $to_do_available_org = $activity->organization_id;
            }

        }

        if (!$is_todo_available) {
            return redirect()->back()->with([
                'success' => 'Activity Status Updated Successfully!',
                'to_do_available_org' => $to_do_available_org
            ]);
        } else {
            return redirect()->back()->withSuccess('Activities Deleted Successfully!');
        }

    }
    public function bulk_options(Request $request){

        $activities = explode(",", $request->input('mark_to_bulk_options_activites')[0]);
        $data = $request->input('bulk');

        foreach ($activities as $activity) {
            $record = Activity::find($activity);

            if($data['subject']['is_edit'] == 1 && !empty($data['subject']['val'])){
                $record->activity_subject = $data['subject']['val'];
            }
            if($data['user']['is_edit'] == 1){
                $record->assigned_to = $data['user']['val'] ? $data['user']['val'] : Auth::user()->id;
            }
            if($data['priority']['is_edit'] == 1){
                $record->priority = $data['priority']['val'] ? $data['priority']['val'] : 0;
            }
            if($data['done']['is_edit'] == 1){
                $record->is_done = isset($data['done']['val']) ? 1 : 0;
            }
            if($data['start_date']['is_edit'] == 1 && !empty($data['start_date']['val'])){
                if(!empty($data['start_date']['val'])){
                    $start_date = Carbon::parse(str_replace('-', '/', $data['start_date']['val']))->format('Y-m-d');
                    $start_time = Carbon::parse('12:00 AM')->format('H:i:s');
                    $record->start_date = $start_date.' '.$start_time;
                }
            }

            $record->save();
        }

        return redirect()->back()->withSuccess('Activities updated Successfully!');

    }

    public function markAsTodo(Request $request){
        foreach($request->mark_as_todo_activites as $activity) {
            $activity = Activity::find($activity);
            $activity->is_done = 0;
            $activity->update();
        }

        return redirect()->back()->withSuccess('Activities Marked as To Do!');
    }

    public function showColumn(Request $request){
        $activityLayout = ActivityLayout::where('user_id', Auth::user()->id)->first();

        if ($request->attribute_name == 'activity_done') {
            $activityLayout->activity_done = 1;

        } else if ($request->attribute_name == 'activity_description') {
            $activityLayout->activity_description = 1;

        } else if ($request->attribute_name == 'activity_start_date') {
            $activityLayout->activity_start_date = 1;

        } else if ($request->attribute_name == 'activity_start_time') {
            $activityLayout->activity_start_time = 1;

        } else if ($request->attribute_name == 'activity_due_date') {
            $activityLayout->activity_due_date = 1;

        } else if ($request->attribute_name == 'activity_notes') {
            $activityLayout->activity_notes = 1;

        } else if ($request->attribute_name == 'activity_assign_to') {
            $activityLayout->activity_assign_to = 1;

        } else if ($request->attribute_name == 'activity_order_no') {
            $activityLayout->activity_order_no = 1;

        } else if ($request->attribute_name == 'activity_organization') {
            $activityLayout->activity_organization = 1;

        } else if ($request->attribute_name == 'activity_contact_person') {
            $activityLayout->activity_contact_person = 1;

        } else if ($request->attribute_name == 'activity_created_by') {
            $activityLayout->activity_created_by = 1;

        }else if ($request->attribute_name == 'activity_priority') {
            $activityLayout->activity_priority = 1;

        }
        $activityLayout->update();

        return json_encode('Activities Column Show!');
    }

    public function hideColumn(Request $request){
        $activityLayout = ActivityLayout::where('user_id', Auth::user()->id)->first();

        if ($request->attribute_name == 'activity_done') {
            $activityLayout->activity_done = 0;

        } else if ($request->attribute_name == 'activity_description') {
            $activityLayout->activity_description = 0;

        } else if ($request->attribute_name == 'activity_start_date') {
            $activityLayout->activity_start_date = 0;

        } else if ($request->attribute_name == 'activity_start_time') {
            $activityLayout->activity_start_time = 0;

        } else if ($request->attribute_name == 'activity_due_date') {
            $activityLayout->activity_due_date = 0;

        } else if ($request->attribute_name == 'activity_notes') {
            $activityLayout->activity_notes = 0;

        } else if ($request->attribute_name == 'activity_assign_to') {
            $activityLayout->activity_assign_to = 0;

        } else if ($request->attribute_name == 'activity_order_no') {
            $activityLayout->activity_order_no = 0;

        } else if ($request->attribute_name == 'activity_organization') {
            $activityLayout->activity_organization = 0;

        } else if ($request->attribute_name == 'activity_contact_person') {
            $activityLayout->activity_contact_person = 0;

        } else if ($request->attribute_name == 'activity_created_by') {
            $activityLayout->activity_created_by = 0;

        }
        else if ($request->attribute_name == 'activity_priority') {
            $activityLayout->activity_priority = 0;

        }
        $activityLayout->update();

        return json_encode('Activities Column Hide!');
    }

    public function columnLayout(Request $request){
        $activityLayout = new ActivityLayout();
        $activityLayout->user_id = Auth::user()->id;
        $activityLayout->save();

        return json_encode('Activities Column Layout Created!');
    }

    public function getActivitiesByOrganization($organization_id){
        $activities = Activity::with('orderDetails', 'contactDetails', 'assigneeDetails', 'userDetails')
                                    ->where('organization_id', $organization_id)
                                    ->where('active', 1)->orderBy('start_date', 'desc')
                                    ->get();

        return json_encode($activities);
    }
    public function getOrganizationEmailBody($email_id)
    {
        $email = OrganizationEmail::select('id', 'body')
            ->where('id', $email_id)
            ->where('active', 1)
            ->firstOrFail();

        return response()->json([
            'id' => $email->id,
            'body' => $email->body,
        ]);
    }

    public function filter_search_data(Request $request){

        $input_text = $request->input('input_text');

        $activities = Activity::where('activity_subject', 'like', '%' . $input_text . '%')->get();

        $organizations = Organization::where('organization_name', 'like', '%' . $input_text . '%')->orWhere('website', 'like', '%' . $input_text . '%')->get();

        $contacts = Contact::where('first_name', 'like', '%' . $input_text . '%')->orWhere('last_name', 'like', '%' . $input_text . '%')->orWhere('email', 'like', '%' . $input_text . '%')->get();

        return json_encode([$activities, $organizations, $contacts, $input_text]);

    }
    public function exportCsv(Request $request){
        $fileName = 'activities.csv';
        $activities = json_decode($request->input('activities', '[]'), true)[0];

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array('id', 'activity subject', 'activity note', 'user name', 'order id', 'contact name', 'organization',
                        'due date', 'start date', 'created by', 'is done', 'priority');

        $callback = function() use ($activities, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($activities as $activity) {
                $priority = '';
                if ($activity['priority'] == 1) {
                    $priority = 'low';
                } elseif ($activity['priority'] == 2) {
                    $priority = 'medium';
                } elseif ($activity['priority'] == 3) {
                    $priority = 'high';
                }
                $contact = Contact::find($activity['created_by']);
                    if ($contact) {
                        $contact_name = $contact->first_name . ' ' . $contact->last_name;
                    } else {
                        $contact_name = '';
                    }
                $created = Contact::find($activity['created_by']);
                    if ($created) {
                        $created_by = $contact->first_name . ' ' . $contact->last_name;
                    } else {
                        $created_by = '';
                    }

                $row['id'] = $activity['id'];
                $row['activity_subject'] = $activity['activity_subject'];
                $row['activity_note'] = $activity['activity_note'];
                $row['assigned_to'] = $activity['assignee_details'] ? $activity['assignee_details']['name'] : '';
                $row['organization'] = $activity['organization_details'] ? $activity['organization_details']['organization_name'] : '';
                $row['order_id'] = $activity['order_id'];
                $row['contact_id'] = $contact_name;
                $row['due_date'] = $activity['due_date'];
                $row['start_date'] = $activity['start_date'];
                $row['created_by'] = $created_by;
                $row['is_done'] = $activity['is_done'] == 1 ? 'done' : 'not done';
                $row['priority'] = $priority;

                fputcsv($file, array(
                    $row['id'], $row['activity_subject'], $row['activity_note'], $row['assigned_to'], $row['order_id'], $row['contact_id'],
                    $row['organization'], $row['due_date'], $row['start_date'], $row['created_by'], $row['is_done'], $row['priority']
                ));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
