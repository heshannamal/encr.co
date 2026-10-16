<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\Sport;
use App\Models\User;
use App\Models\Fabric;
use App\Models\Factory;
use App\Models\Product;
use App\Models\Project;
use App\Models\ExFactory;
use App\Models\ProjectType;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\ProjectStatus;
use App\Models\ProductAttribute;
use App\Models\EmbellishmentType;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductEmbellishmentType;
use App\Models\OrderItemsDetailPlayerName;
use App\Models\ProductTemp;
use Aurora\System\Db\Func;
use domainencore\Facades\ProductFacade\ProductFacade;
use Illuminate\Support\Facades\DB as FacadesDB;

// use Illuminate\Http\Request;

class NewProjectController extends Controller
{
    public function index(){

        $maxId = Project::max('id');
        $projectNo = str_pad(($maxId+1), 6, "0", STR_PAD_LEFT);

        $projectStatuses = ProjectStatus::select('id', 'status_name')->orderBy('id')->get();

        $type = ProjectType::select('id', 'type_name')->orderBy('id')->get();

        $currentDate = Carbon::now()->format('m-d-Y');

        $users = User::select('id', 'name')->orderBy('name')->get();

        return view('pages.project.new_project.index', [
            'projectNo'=>$projectNo, 'users'=>$users, 'projectStatuses'=>$projectStatuses, 'type'=>$type, 'currentDate'=>$currentDate
        ]);
    }

    public function create(Request $request){
        if(auth()->user()->can('create project')){
            $productId = null;
            $maxId = Project::max('id');
            $projectNo = str_pad(($maxId+1), 6, "0", STR_PAD_LEFT);

            $project = new Project();
            $project->project_name = $request->project_name;
            $project->project_no = $projectNo;
            $project->project_status_id = $request->project_status;
            $project->project_type_id = $request->project_type;
            $project->project_description = $request->project_description;
            $project->created_by = Auth::id();
            $project->save();

            if($request->project_type == 2){
                if($request->product_development_type == 'exist_project'){
                    $productId = ProductFacade::createExistingProduct($request->product_for_create);
                } else {
                    $productId = ProductFacade::createNewProduct();
                }
            }

            $project->product_id = $productId;
            $project->update();

            return redirect()->route('projects.view',$project->id)->with('success','Project Created Successfully!');
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }


    public function create_temp(Request $request)
    {
        if (!auth()->user()->can('create project')) {
            return redirect()->back()->withError('Permission Not Granted!');
        }

        FacadesDB::beginTransaction();

        try {

            $maxId = Project::max('id') ?? 0;
            $projectNo = str_pad($maxId + 1, 6, '0', STR_PAD_LEFT);

            $project = new Project();
            $project->project_name = $request->project_name;
            $project->project_no = $projectNo;
            $project->project_status_id = $request->project_status;
            $project->project_type_id = $request->project_type;
            $project->project_description = $request->project_description;
            $project->created_by = Auth::id();

            $productId = null;

            if ($request->project_type == 2) {

                if ($request->product_development_type === 'exist_project') {

                    $productId = ProductFacade::createExistingProductTemp(
                        $request->product_for_create
                    );
                    $project->product_level = 1;

                } elseif ($request->product_development_type === 'new_sub_product') {

                    $productId = ProductFacade::createSubProductTemp(
                        $request->main_product_id
                    );
                    $project->product_level = 2;

                } elseif ($request->product_development_type === 'exist_sub_product') {

                    $productId = ProductFacade::createExistingSubProductTemp(
                        $request->sub_product_id
                    );
                    $project->product_level = 2;

                } else {

                    $productId = ProductFacade::createNewProductTemp();
                    $project->product_level = 1;
                }

                if (!$productId) {
                    throw new \Exception("Product temp creation failed");
                }

                $project->product_id = $productId;
            }

            $project->status = 1;
            $project->save();

            FacadesDB::commit();

            return redirect()->route('projects.view.temp', $project->id)->with('success', 'Project Created Successfully!');

        } catch (\Exception $e) {

            FacadesDB::rollBack();

            // return redirect()->back()->withError($e->getMessage());
        }
    }


    public function createOld(Request $request){

        if(auth()->user()->can('create order')){

            $user = Auth::id();
            $currentDate = Carbon::now();
            $selectedOptions = $request->input('project_assignee_id');

            $notifyAssignees = [];
            $assigneeGroupArr = [];
            $assigneeUserArr = [];
            if($request->project_assignee_groups != ''){
                $notifyGroups = json_decode($request->project_assignee_groups);
                $notifyGroupUsers = User::whereHas("roles", function($q) use($notifyGroups) {
                                                $q->whereIn("id", $notifyGroups);
                                            })->pluck('id')->toarray();
                $notifyAssignees = $notifyGroupUsers;
                $assigneeGroupArr = json_encode( array_unique($notifyGroups) );
            } else {
                $assigneeGroupArr = json_encode($assigneeGroupArr);
            }

            if($request->project_assignee_users != ''){
                $notifyAssignees = array_merge($notifyAssignees, json_decode($request->project_assignee_users));
                $assigneeUserArr = json_encode( array_unique( json_decode($request->project_assignee_users) ) );
            } else {
                $assigneeUserArr = json_encode($assigneeUserArr);
            }

            $project = new Project();
            $project->project_name = $request->project_name;
            $project->project_no = $request->project_no;
            $project->project_status_id = $request->project_status_id;
            $project->project_type_id = $request->type_id;
            $project->project_description = $request->project_description;
            // $project->project_assignee_users = $assigneeUserArr;
            // $project->project_assignee_groups = $assigneeGroupArr;
            $project->project_color = $request->project_color;
            $project->created_at = $currentDate;
            $project->created_by = $user;

            // var_dump($request->project_assignee_id);
            $assignee = explode("\n", $request->project_assignee_id);

            // $data_str = implode(',', $assignee);
            $data_str = implode(',', array_unique($notifyAssignees));
            $project->project_assignee = $data_str;

            $project->save();

            // $notifyAssignee = explode("\r\n", $request->project_assignee_id);
            $title = 'New Project - #'.$project->project_no.' | '.$project->project_name;
            $message = Auth::user()->name.' has created a new project #'.$project->project_no.' | '.$project->project_name.' by assigning you.';
            $this->notifyProjectAssigners($project->id, array_unique($notifyAssignees), $title, $message);
            // dd($message);
            return redirect()->route('projects')
                        ->with('success','Project Submitted Successfully!');
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function notifyProjectAssigners($project_id, $userIds, $title, $message){
        foreach($userIds as $user){
            if($user){
                $notification = new Notification();
                $notification->notification_title = $title;
                $notification->notification_message = $message;
                $notification->user_id = $user;
                $notification->project_id = $project_id;
                $notification->save();
            }
        }
    }
}
