<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\ColorMaster;
use App\Models\EmbellishmentType;
use App\Models\Fabric;
use App\Models\Factory;
use App\Models\MainCategory;
use App\Models\MasterFit;
use App\Models\Notification;
use App\Models\Price;
use App\Models\PriceTemp;
use App\Models\PriceType;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Models\ProductCategoryList;
use App\Models\ProductFactory;
use App\Models\ProductFit;
use App\Models\ProductImage;
use App\Models\ProductImageTemp;
use App\Models\ProductMainCategory;
use App\Models\ProductSport;
use App\Models\ProductTagline;
use App\Models\ProductTaglineList;
use App\Models\ProductTemp;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectIcon;
use App\Models\ProjectType;
use Illuminate\Http\Request;
use App\Models\ProjectStatus;
use App\Models\Size;
use App\Models\SizeType;
use App\Models\Sport;
use App\Models\SubProduct;
use App\Models\SubProductImageTemp;
use App\Models\SubProductTemp;
use App\Traits\ProjectHelper;
use domainencore\Facades\ProjectFacade\ProjectFacade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;



class ProjectController extends Controller
{
    use ProjectHelper;
    public function index(){

        $projects=DB::table('project_statuses')
            // ->join('projects', 'users.id', '=', 'projects.created_by')
            ->join('projects', 'project_statuses.id', '=', 'projects.project_status_id')
            ->join('project_types', 'project_types.id', '=', 'projects.project_type_id')
            ->join('users', 'users.id', '=', 'projects.project_assignee')
            ->select('projects.*', 'project_types.*', 'project_statuses.*', 'users.*', 'projects.id as pId')
            ->get();


        $project = Project::select('id', 'project_name','project_no', 'project_status_id', 'project_description', 'project_type_id', 'project_color', 'created_by', 'created_at', 'updated_at', 'project_assignee')->orderBy('id')->paginate(100);
// dd($project);
        $projectStatus = ProjectStatus::select('id', 'status_name')->orderBy('id')->get();

        $type = ProjectType::select('id', 'type_name')->orderBy('id')->get();

        $users = User::select('id', 'name')->orderBy('id')->get();

        $maxId = Project::max('id');
        $projectNo = str_pad(($maxId+1), 6, "0", STR_PAD_LEFT);

        $projectStatuses = ProjectStatus::select('id', 'status_name')->orderBy('id')->get();

        $type = ProjectType::select('id', 'type_name')->orderBy('id')->get();

        $currentDate = Carbon::now()->format('m-d-Y');

        $users = User::select('id', 'name')->orderBy('name')->get();

        $groups = Role::whereNotIn('id', [1])->where('active','1')->orderBy('name')->get();

        $products = Product::where('active','1')->orderBy('product_name')->get();

// dd($project);
        return view('pages.project.project', [
            'projectStatus'=>$projectStatus, 'type'=>$type,  'project'=>$project, 'projects'=>$projects, 'users'=>$users,
            'projectNo'=>$projectNo, 'users'=>$users, 'projectStatuses'=>$projectStatuses, 'currentDate'=>$currentDate,
            'groups'=>$groups, 'products'=>$products
        ]);
    }

    public function getProjects() {

        $otherTableData = DB::table('projects')->get();
        return response()->json($otherTableData);
    }

        public function edit($id){

            // $projects = Project::select('id', 'project_name','project_no', 'project_status_id', 'project_description', 'project_type_id', 'project_color', 'created_by', 'created_at', 'updated_at', 'project_assignee', 'project_assignee_users', 'project_assignee_groups')->where('projects.id', $id)->get();
            $project = Project::with('product')->where('id', $id)->first();

            $projectStatus = ProjectStatus::select('id', 'status_name')->orderBy('id')->get();

            $type = ProjectType::select('id', 'type_name')->orderBy('id')->get();

            $usersQuery = User::select('id', 'name');
            if($project->project_assignee_users != '' && $project->project_assignee_users != null){
                $usersQuery->whereNotIn('id',json_decode($project->project_assignee_users));
            }
            $users = $usersQuery->orderBy('id')->get();

            $groupsQery = Role::whereNotIn('id', [1])->where('active','1');
            if($project->project_assignee_groups != '' && $project->project_assignee_groups != null){
                $groupsQery->whereNotIn('id',json_decode($project->project_assignee_groups));
            }
            $groups = $groupsQery->orderBy('name')->get();

            $activeUsers = User::select('id', 'name', 'profile_pic', 'user_role_id')->orderBy('name')->where('active','1')->get();
            $activeUserGroups = Role::whereNotIn('id', [1])->where('active','1')->orderBy('name')->get();
            foreach($activeUsers as $user){
                $userList = array('id'=>$user->id, 'name'=>$user->name, 'profile_pic'=>$user->profile_pic);
                $userInfo[] = $userList;
            }

            // $productLayout = productLayout::where('user_id', Auth::user()->id)->first();

            // $columnLayout = ColumnLayout::where('interface_id', 5)->where('user_id', Auth::user()->id)->first();

            $sizes = Size::orderBy('id')->where('active', 1)->get();

            $productCategories = ProductCategory::orderBy('id')->where('active', 1)->get();

            $fabrics = Fabric::orderBy('fabric_name')->where('active', 1)->get();

            $embellishmentTypes = EmbellishmentType::orderBy('embellishment_name')->where('active', 1)->get();

            $productAttributes = Attribute::orderBy('attribute_name')->where('active', 1)->get();

            $sports = Sport::where('active', 1)->orderBy('sport_name')->get();

            $factories = Factory::where('active', 1)->orderBy('factory_name')->get();

            $sizeTypes = SizeType::get();

            $productSports = ProductSport::orderBy('id')->get();

            $mainCategories = MainCategory::get();

            $productImages = ProductImage::get();

            $priceTypes = PriceType::get();

            $price = Price::where('active', 1)->get();

        $isExist = 0;
        $productImages = null;
        $prices = null;
        $productID = null;
        $product = null;

        if ($project->project_type_id == 2)
        {
            $product = Product::find($project->product_id);
            if($product){
                $productImages = ProductImage::where('active', 1)->where('product_id', $project->product_id)->orderBy('id')->get();
                $prices = Price::where('product_id', $project->product_id)->where('active', 1)->orderBy('price_type')->get();
                $productID = $project->product_id;
                $isExist = 1;

                $product_main_category_ids = ProductMainCategory::where('product_id', $id)->pluck('main_category_id')->unique();
                if(!empty($product_main_category_ids)){
                    $product->main_category_id = $product_main_category_ids;
                }

                $product_category_ids = ProductCategoryList::where('product_id', $id)->pluck('product_category_id')->unique();
                if(!empty($product_category_ids)){
                    $product->product_category_id = $product_category_ids;
                }
                $product_sport_ids = ProductSport::where('product_id', $id)->pluck('sport_id')->unique();
                if(!empty($product_sport_ids)){
                    $product->sport = $product_sport_ids;
                }
                $product_attributes_ids = ProductAttribute::where('product_id', $id)->pluck('attribute_id')->unique();
                if(!empty($product_attributes_ids)){
                    $product->attributes = $product_attributes_ids;
                }
                $product_factory_ids = ProductFactory::where('product_id', $id)->pluck('product_factory_id')->unique();
                if(!empty($product_factory_ids)){
                    $product->factory = $product_factory_ids;
                }
            }
        }



        // dd($projects);
        return view('pages.project.project_details.edit', [
            'project'=>$project, 'projectStatus'=>$projectStatus, 'type'=>$type, 'users'=>$users, 'userInfo'=>$userInfo,
            'activeUsers'=>$activeUsers, 'activeUserGroups'=>$activeUserGroups, 'groups'=>$groups, 'sizes'=>$sizes, 'productCategories'=>$productCategories,
            'fabrics'=>$fabrics, 'embellishmentTypes'=>$embellishmentTypes, 'sports'=>$sports,
            'productAttributes'=>$productAttributes, 'factories'=>$factories, 'productSports'=>$productSports,'sizeTypes'=>$sizeTypes,
            'mainCategories'=>$mainCategories, 'priceTypes'=>$priceTypes, 'price'=>$price, 'prices'=>$prices, 'isExist'=>$isExist, 'productImages'=>$productImages,
            'productID'=>$productID, 'product'=>$product,
        ]);
    }

    public function update(Request $request){

        // $notifyAssignees = [];
        // $assigneeGroupArr = [];
        // $assigneeUserArr = [];
        // if($request->project_assignee_groups != ''){
        //     $notifyGroups = json_decode($request->project_assignee_groups);
        //     $notifyGroupUsers = User::whereHas("roles", function($q) use($notifyGroups) {
        //                                     $q->whereIn("id", $notifyGroups);
        //                                 })->pluck('id')->toarray();
        //     $notifyAssignees = $notifyGroupUsers;
        //     $assigneeGroupArr = json_encode( array_unique($notifyGroups) );
        // }

        // if($request->project_assignee_users != ''){
        //     $notifyAssignees = array_merge($notifyAssignees, json_decode($request->project_assignee_users));
        //     $assigneeUserArr = json_encode( array_unique( json_decode($request->project_assignee_users) ) );
        // }

        $projectIconId = null;
        $projectIcon = null;

        if($request->project_icon){
            $projectIcon = ProjectIcon::find($request->project_icon);
            if($projectIcon){
                $projectIconId = $request->project_icon;
                $projectIcon = $projectIcon->icon;
            }
        }

        $project = Project::find($request->project_id);
        // foreach($projects as $project){
            if ($project) {
                $preAssignees = explode(',', $project->project_assignee);
                $currentAssignees = $request->project_assignee_id;

                // Only get new IDs if preAssignees does not have more IDs than currentAssignees
                // and if currentAssignees has at least one ID not in preAssignees
                $newAssignees = [];
                // if (is_array($currentAssignees) && count($preAssignees) <= count($currentAssignees)) {
                if (is_array($currentAssignees)) {
                    $diff = array_diff($currentAssignees, $preAssignees);
                    if (!empty($diff)) {
                        $newAssignees = $diff;
                    }
                }

                $project->project_name = $request->project_name;
                $project->project_status_id = $request->project_status_id;
                $project->project_type_id = $request->type_id;
                $project->stage_status = $request->stage_status;

                $project->project_description = $request->project_description;
                // $project->project_assignee_users = $assigneeUserArr;
                // $project->project_assignee_groups = $assigneeGroupArr;
                $project->project_color = $request->project_color;
                $project->project_icon_id = $projectIconId;
                $project->project_icon_url  = $projectIcon;

                $data_str = null;
                // $assignee = explode("\n", $request->project_assignee_id);
                if($request->project_assignee_id){
                    $data_str = implode(',', $request->project_assignee_id);
                }
                // $data_str = implode(',', array_unique($notifyAssignees));
                $project->project_assignee = $data_str;
                $project->updated_by = auth()->user()->id;

                $project->update();

                $this->notifyProjectAssignees($project, $newAssignees);
                return redirect()->back()->with('success','Project Updated Successfully!');
            } else {
                return redirect()->back()->with('error','Someting went wrong!');
            }
        // }
    }

    public function updateStageStatus(Request $request){
        $project = Project::find($request->project_id);
        if ($project) {
            $project->stage_status = $request->stage_status;
            $project->update();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }

    public function notifyProjectAssignees($project, $newAssignees)
    {
        foreach($newAssignees as $assignee_id)
        {
            if($assignee_id != auth()->user()->id){
                ProjectFacade::projectManagementNotifyProjectAssignee($assignee_id, $project);
            }
        }
    }

    public function notifyProjectAssigners($project_id, $userIds, $title, $message){

        foreach($userIds as $user){
            $notification = new Notification();
            // $notification->notification_title = 'Moved To Production | Order - #'.$orderDetails->order_no.' | Item - '.$item->productDetails->product_name;
            $notification->notification_title = $title;

            // $message = 'Order #'.$orderDetails->order_no.' has been moved to production.<ul><li style="text-align: left; list-style-type: none;"><u>Items in this order:</u></li>';
            // $message = $message."</ul>";

            $notification->notification_message = $message;
            $notification->user_id = $user;
            $notification->project_id = $project_id;
            $notification->save();
        }
    }

    public function addAssignee(Request $request){
        $projectId = $request->project_id;
        $assigneeId = $request->assignee_id;
        $assineeType = $request->assignee_type;
        $addAssigneeStatus = ProjectFacade::addAssignee($projectId, $assigneeId, $assineeType);

        return json_encode(array($projectId,$assigneeId,$assineeType,$addAssigneeStatus));
    }

    public function getAssignees($id){
        $assignees = ProjectFacade::getAssignees($id);
        return json_encode($assignees);
    }

    public function deleteAssignee(Request $request)
    {
        $assignees = ProjectFacade::deleteAssignee($request);
        return json_encode($assignees);
    }

    public function changeFlag($projectId, $flagColor){
        try {
            $project = Project::find($projectId);
            $project->project_color = '#'.$flagColor;
            $project->update();
            return json_encode('success');
        } catch (\Exception $ex) {
            return json_encode($ex);
        }
        // return redirect()->route('orders')->withSuccess('Order Flag Changed  Successfully!');
    }

    public function changeStatus($projectId, $statusId){
        try {
            $project = Project::find($projectId);
            $project->project_status_id = $statusId;
            $project->update();
            return json_encode('success');
        } catch (\Throwable $th) {
            return json_encode($th->getMessage());

        }
    }

    // public function project_list(Request $request){
    //     $projects = ProjectFacade::getPaginatedProjectsNew($request);
    //     $helper = $this;
    //     $users = User::select('id', 'name')->whereNotIn('id', [auth()->user()->id])->orderBy('name')->get();
    //     $projectStatus = ProjectStatus::select('id', 'status_name')->orderBy('id')->get();
    //     $type = ProjectType::select('id', 'type_name')->orderBy('id')->get();
    //     $products = ProductTemp::where('active','1')->orderBy('product_name')->get();
    //     return view('pages.project.index', compact('projects', 'users', 'projectStatus', 'type', 'products', 'helper'));
    // }

    public function project_list(Request $request) {
        $perPage = $request->get('per_page', 10);
        $projects = ProjectFacade::getPaginatedProjectsNew($request, $perPage);
        $helper = $this;
        $users = User::select('id', 'name')->whereNotIn('id', [auth()->user()->id])->orderBy('name')->get();
        $projectStatus = ProjectStatus::select('id', 'status_name')->orderBy('id')->get();
        $type = ProjectType::select('id', 'type_name')->orderBy('id')->get();
        $products = Product::where('active','1')->orderBy('id')->get();
        $subProducts = SubProduct::where('active','1')->orderBy('id')->get();
        return view('pages.project.index', compact('projects', 'users', 'projectStatus', 'type', 'products', 'subProducts', 'helper'));
    }


    public function project_inbox(Request $request)
    {
        $myInboxTasks = ProjectFacade::getPaginatedMyTasks($request, 20);
        $helper       = $this;

        $activeUsers = User::select('id', 'name', 'profile_pic', 'user_role_id')
            ->orderBy('name')
            ->where('active', '1')
            ->get();

        $activeUserGroups = Role::whereNotIn('id', [1])
            ->where('active', '1')
            ->orderBy('name')
            ->get();

        return view('pages.project.inbox', compact(
            'myInboxTasks', 'helper', 'activeUsers', 'activeUserGroups'
        ));
    }

    public function project_my_tasks()
    {
        $helper = $this;
        $activeUsers = User::select('id', 'name', 'profile_pic', 'user_role_id')->orderBy('name')->where('active','1')->get();
        $projectStatus = ProjectStatus::select('id', 'status_name')->orderBy('id')->get();
        $type = ProjectType::select('id', 'type_name')->orderBy('id')->get();
        $myProjects = Project::whereRaw("FIND_IN_SET(?, project_assignee)", [auth()->user()->id])->orderBy('id')->get();
        foreach($activeUsers as $user){
            $userList = array('id'=>$user->id, 'name'=>$user->name, 'profile_pic'=>$user->profile_pic);
            $userInfo[] = $userList;
        }
        $activeUserGroups = Role::whereNotIn('id', [1])->where('active','1')->orderBy('name')->get();

        // Check if user is admin (ID 1) to show all tasks or just their own
        $isAdminViewingAll = auth()->user()->id == 1;
        $pageTitle = $isAdminViewingAll ? 'Tasks' : 'My Tasks';

        return view('pages.project.my_task', compact( 'userInfo', 'projectStatus', 'type', 'helper', 'activeUsers', 'activeUserGroups', 'myProjects', 'isAdminViewingAll', 'pageTitle'));
    }

    public function project_overview(){
        return view('pages.project.overview');
    }

    public function project_board(){
        return view('pages.project.board');
    }

    public function project_home(Request $request){
        $helper = $this;
        $activeUsers = User::select('id', 'name', 'profile_pic', 'user_role_id')->orderBy('name')->where('active','1')->get();
        $activeUserGroups = Role::whereNotIn('id', [1])->where('active','1')->orderBy('name')->get();
        foreach($activeUsers as $user){
            $userList = array('id'=>$user->id, 'name'=>$user->name, 'profile_pic'=>$user->profile_pic);
            $userInfo[] = $userList;
        }
        return view('pages.project.dashboard', compact( 'helper', 'activeUsers', 'activeUserGroups', 'userInfo'));
    }

    public function project_delete($id)
    {
       return ProjectFacade::project_delete($id);
    }

    public function project_delete_new($id)
    {
       return ProjectFacade::project_delete_new($id);
    }

    public function getPaginatedProjects(Request $request)
    {
        $projects = ProjectFacade::getPaginatedProjects($request, 20);
        return view('pages.project.partials.dashboard_recent_projects', compact('projects'));
    }

    public function filter_search_data(Request $request)
    {
       return ProjectFacade::filter_search_data($request);
    }

    public function getCompletedTaskCount(Request $request)
    {
        return ProjectFacade::getCompletedTaskCount($request);
    }

    public function getCollaboratorsCount(Request $request)
    {
        return ProjectFacade::getCollaboratorsCount($request);
    }

    public function getProjectsCollaborators(Request $request)
    {
        $collaborators = ProjectFacade::getProjectsCollaborators($request);
        return view('pages.project.partials.dashboard_projects_collaborators', compact('collaborators'));
    }

    public function getMyTasks(Request $request)
    {
        $tasks = ProjectFacade::getMyTasks($request);
        return view('pages.project.partials.dashboard_my_tasks', compact('tasks'));
    }

    public function getMyTasksForCalendar(Request $request)
    {
        $tasks = ProjectFacade::getMyTasksForCalendar($request);
        $calendarEvents = [];

        foreach ($tasks as $task) {
            // Skip tasks without due dates
            if (!$task->due_date) {
                continue;
            }

            // Determine discussion type
            $discussionType = isset($task->discussion_id) ? 'sub_discussion' : 'discussion';

            $calendarEvents[] = [
                'id' => $task->id,
                'title' => $task->discussion_name,
                'start' => $task->due_date,
                'end' => $task->due_date,
                'description' => $task->discussion_description,
                'completed' => $task->is_completed,
                'section_name' => $task->section->section_name ?? 'No Section',
                'project_name' => $task->section->project->project_name ?? 'No Project',
                'backgroundColor' => $task->is_completed ? '#28a745' : '#007bff',
                'borderColor' => $task->is_completed ? '#28a745' : '#28a745',
                'textColor' => '#ffffff',
                'discussion_type' => $discussionType
            ];
        }

        return response()->json($calendarEvents);
    }

    public function getMyTaskSections(Request $request)
    {
        return ProjectFacade::getMyTaskSections($request);
    }

    public function getMyTaskSectionById($sectionId)
    {
        return ProjectFacade::getMyTaskSectionById($sectionId);
    }

    public function getPaginatedMyAllTasks(Request $request)
    {
        $myTasks = ProjectFacade::getPaginatedMyAllTasks($request);
        $helper = $this;

        $projectIds = $myTasks->getCollection()
            ->pluck('project_id')
            ->filter()
            ->unique()
            ->values()
            ->all();

        $projectsById = Project::withTrashed()
            ->with(['product', 'productTemp', 'subProductTemp'])
            ->whereIn('id', $projectIds)
            ->get()
            ->keyBy('id');

        $assignedByIds = $myTasks->getCollection()
            ->pluck('assigned_by')
            ->filter()
            ->unique()
            ->values()
            ->all();

        $assignedByUsers = User::select('id', 'name', 'profile_pic')
            ->whereIn('id', $assignedByIds)
            ->get()
            ->keyBy('id');

        $authUserId = auth()->id();

        return view('pages.project.partials.my_tasks_inner_list_tasks', compact(
            'myTasks',
            'helper',
            'projectsById',
            'assignedByUsers',
            'authUserId'
        ));
    }
    public function getMyAllTasks(Request $request)
    {
        $myTasks = ProjectFacade::getMyAllTasks($request);

        $helper = $this;

        $projectIds = $myTasks
            ->pluck('project_id')
            ->filter()
            ->unique()
            ->values()
            ->all();

        $projectsById = Project::withTrashed()
            ->with(['product', 'productTemp', 'subProductTemp'])
            ->whereIn('id', $projectIds)
            ->get()
            ->keyBy('id');

        $assignedByIds = $myTasks
            ->pluck('assigned_by')
            ->filter()
            ->unique()
            ->values()
            ->all();

        $assignedByUsers = User::select('id', 'name', 'profile_pic')
            ->whereIn('id', $assignedByIds)
            ->get()
            ->keyBy('id');

        $authUserId = auth()->id();

        return view('pages.project.partials.my_tasks_inner_list_tasks', compact(
            'myTasks',
            'helper',
            'projectsById',
            'assignedByUsers',
            'authUserId'
        ));
    }

    public function changeMyTaskCompleteStatus(Request $request, $taskId)
    {
        try {
            ProjectFacade::changeMyTaskCompleteStatus($request, $taskId);
            $completeStatus = 'Not Completed';
            if($request->is_completed == 1){
                $completeStatus = 'Completed';
            }
            return response()->json(['response'=>'success', 'message'=>'Successfuly Changed Into '.$completeStatus] );
        } catch (\Throwable $th) {
            return response()->json(['response'=>'error', 'message'=>$th->getMessage()] );
        }
    }

    public function project_inner($id){
        $helper = $this;
        $project = Project::find($id);
        $projectAssignees = ProjectFacade::getAssignees($id);
        $activeUsers = User::select('id', 'name', 'profile_pic', 'user_role_id')->orderBy('name')->where('active','1')->get();
        $projectStatus = ProjectStatus::select('id', 'status_name')->orderBy('id')->get();
        $type = ProjectType::select('id', 'type_name')->orderBy('id')->get();
        $projectIcons = ProjectIcon::all();
        $activeUserGroups = Role::whereNotIn('id', [1])->where('active','1')->orderBy('name')->get();
        foreach($activeUsers as $user){
            $userList = array('id'=>$user->id, 'name'=>$user->name, 'profile_pic'=>$user->profile_pic);
            $userInfo[] = $userList;
        }
        $projectAssigneeInfo = [];
        foreach($projectAssignees[0] as $projectAssignee){
            $projectAssigneeInfo[] = array('id'=>$projectAssignee['id'], 'name'=>$projectAssignee['name'], 'profile_pic'=>$projectAssignee['image']);
        }

        if($project->project_type_id == 2){
            $productID = $project->product_id;

            $sizes = Size::orderBy('id')->where('active', 1)->get();

            $productCategories = ProductCategory::orderBy('id')->where('active', 1)->get();

            $embellishmentTypes = EmbellishmentType::orderBy('embellishment_name')->where('active', 1)->get();

            $productAttributes = Attribute::orderBy('attribute_name')->where('active', 1)->get();

            $sports = Sport::where('active', 1)->orderBy('sport_name')->get();

            $factories = Factory::where('active', 1)->orderBy('factory_name')->get();

            $sizeTypes = SizeType::get();

            $productSports = ProductSport::orderBy('id')->get();

            $mainCategories = MainCategory::get();

            $productImages = ProductImage::where('active', 1)->where('product_id', $productID)->orderBy('id')->get();

            $priceTypes = PriceType::get();

            $prices = Price::where('product_id', $productID)->where('active', 1)->orderBy('price_type')->get();

            // dd($prices);

            $isExist = 1;


            $product = Product::find($productID);

            $sub_product_found = SubProduct::where('parent_product_id', $productID)->first();
            if($sub_product_found){
                $product->attribute_on_price = array_map('trim', explode('/', $sub_product_found->attribute_on_price));
            }else{
                $product->attribute_on_price = [];
            }

            //Multi values for $product

            $product_main_category_ids = ProductMainCategory::where('product_id', $productID)->pluck('main_category_id')->unique();
            if(!empty($product_main_category_ids)){
                $product->main_category_id = $product_main_category_ids;
            }

            $product_category_ids = ProductCategoryList::where('product_id', $productID)->pluck('product_category_id')->unique();
            if(!empty($product_category_ids)){
                $product->product_category_id = $product_category_ids;
            }
            $product_sport_ids = ProductSport::where('product_id', $productID)->pluck('sport_id')->unique();
            if(!empty($product_sport_ids)){
                $product->sport = $product_sport_ids;
            }
            $product_attributes_ids = ProductAttribute::where('product_id', $productID)->pluck('attribute_id')->unique();
            if(!empty($product_attributes_ids)){
                $product->attributes = $product_attributes_ids;
            }
            $product_factory_ids = ProductFactory::where('product_id', $productID)->pluck('product_factory_id')->unique();
            if(!empty($product_factory_ids)){
                $product->factory = $product_factory_ids;
            }

            $colorMasters = ColorMaster::get();

            $productTaglines = ProductTagline::where('active', 1)->get();

            $product_tagline_ids = ProductTaglineList::where('product_id', $productID)->pluck('tagline_id')->unique();
            if(!empty($product_tagline_ids)){
                $product->tagline = $product_tagline_ids;
            }

            $masterFits = MasterFit::where('active', 1)->get();

            $product_fit_ids = ProductFit::where('product_id', $productID)->pluck('fit_id')->unique();
            if(!empty($product_fit_ids)){
                $product->fit = $product_fit_ids;
            }

            return view('pages.project.project_inner', compact(
                'project', 'projectAssignees', 'userInfo', 'projectAssigneeInfo', 'projectStatus', 'type', 'projectIcons',
                'productID', 'sizes', 'productCategories', 'product', 'embellishmentTypes', 'sports',
                'productAttributes', 'factories', 'productSports','sizeTypes', 'mainCategories', 'priceTypes', 'prices',
                'productImages', 'isExist', 'colorMasters', 'productTaglines', 'masterFits', 'helper', 'activeUserGroups', 'activeUsers'
            ));
        } else {
            return view('pages.project.project_inner', compact('project', 'projectAssignees', 'userInfo', 'projectAssigneeInfo', 'projectStatus', 'type', 'projectIcons', 'helper', 'activeUserGroups', 'activeUsers'));
        }
    }

    public function project_inner_temp($id){
        $helper = $this;
        $mainProduct = null;
        $fabrics = null;
        $subProductNo = null;
        $project = Project::findOrFail($id);

        if ($project->product_level == 1) {
            $project->load('productTemp');
        }

        if ($project->product_level == 2) {
            $project->load('subProductTemp');
            $mainProduct = Product::findOrFail($project->current_product->product_id);
            $fabrics = Fabric::orderBy('fabric_name')->where('active', 1)->get();
            if ($project->current_product->transferred == 1) {
                $subProductNo = SubProduct::findOrFail($project->current_product->transferred_id);
            }
        }

        $projectAssignees = ProjectFacade::getAssignees($id);
        $activeUsers = User::select('id', 'name', 'profile_pic', 'user_role_id')->orderBy('name')->where('active','1')->get();
        $projectStatus = ProjectStatus::select('id', 'status_name')->orderBy('id')->get();
        $type = ProjectType::select('id', 'type_name')->orderBy('id')->get();
        $projectIcons = ProjectIcon::all();
        $activeUserGroups = Role::whereNotIn('id', [1])->where('active','1')->orderBy('name')->get();
        foreach ($activeUsers as $user) {
            $userInfo[] = [
                'id' => $user->id,
                'name' => $user->name,
                'profile_pic' => $user->profile_pic
            ];
        }

        $projectAssigneeInfo = [];
        foreach($projectAssignees[0] as $projectAssignee){
            $projectAssigneeInfo[] = array('id'=>$projectAssignee['id'], 'name'=>$projectAssignee['name'], 'profile_pic'=>$projectAssignee['image']);
        }

        if($project->project_type_id == 2){
            $productID = $project->product_id;

            $sizes = Size::orderBy('id')->where('active', 1)->get();

            $productCategories = ProductCategory::orderBy('id')->where('active', 1)->get();

            $embellishmentTypes = EmbellishmentType::orderBy('embellishment_name')->where('active', 1)->get();

            $productAttributes = Attribute::orderBy('attribute_name')->where('active', 1)->get();

            $sports = Sport::where('active', 1)->orderBy('sport_name')->get();

            $factories = Factory::get();

            $sizeTypes = SizeType::get();

            $productSports = ProductSport::orderBy('id')->get();

            $mainCategories = MainCategory::get();

            if ($project->product_level == 1) {
                $productImages = ProductImageTemp::where('active', 1)->where('product_id', $productID)->orderBy('id')->get();
            } else {
                $productImages = SubProductImageTemp::where('active', 1)->where('product_id', $productID)->orderBy('id')->get();

            }

            $priceTypes = PriceType::where('active',1)->get();

            $prices = PriceTemp::where('product_id', $productID)->where('active',1)->get()->keyBy('price_type');

            $isExist = 1;

            $colorMasters = ColorMaster::get();

            $productTaglines = ProductTagline::where('active', 1)->get();

            $masterFits = MasterFit::where('active', 1)->get();

            return view('pages.project.project_inner', compact(
                'project', 'mainProduct', 'fabrics', 'projectAssignees', 'userInfo', 'projectAssigneeInfo', 'projectStatus', 'type', 'projectIcons', 'subProductNo',
                'productID', 'sizes', 'productCategories', 'embellishmentTypes', 'sports',
                'productAttributes', 'factories', 'productSports','sizeTypes', 'mainCategories', 'priceTypes', 'prices',
                'productImages', 'isExist', 'colorMasters', 'productTaglines', 'masterFits', 'helper', 'activeUserGroups', 'activeUsers'
            ));
        } else {
            return view('pages.project.project_inner', compact('project', 'projectAssignees', 'userInfo', 'projectAssigneeInfo', 'projectStatus', 'type', 'projectIcons', 'helper', 'activeUserGroups', 'activeUsers'));
        }
    }

    public function getProjectManagement($projectId)
    {
        return ProjectFacade::getProjectManagementByProjectId($projectId);
    }

    public function getProjectManagementAll(Request $request)
    {
        $projectId = $request->project_id;
        $orderId = $request->order_id;
        return ProjectFacade::getOrderProjectList($projectId,$orderId);
    }

    public function getProjectManagementSectionById($sectionId)
    {
        return ProjectFacade::getProjectManagementSectionById($sectionId);
    }

    public function getProjectManagementSectionAssigneesById($sectionId)
    {
        return ProjectFacade::getProjectManagementSectionAssigneesById($sectionId);
    }

    public function projectManagementSectionStore(Request $request){
        try {
            return ProjectFacade::projectManagementSectionStore($request->all());
        } catch (\Throwable $th) {
            return json_encode(['error','Error!', $th->getMessage()]);
        }
    }

    public function projectManagementSectionUpdate(Request $request, $id){
        try {
            return ProjectFacade::projectManagementSectionUpdate($request->all(), $id);
        } catch (\Throwable $th) {
            return json_encode(['error','Error!', $th->getMessage()]);
        }
    }

    public function projectManagementSectionDelete($id){
        try {
            ProjectFacade::projectManagementSectionDelete($id);
        } catch (\Throwable $th) {
            return json_encode(['error','Error!', $th->getMessage()]);
        }
    }

    public function getprojectManagementSectionDiscussionById($id)
    {
        return ProjectFacade::getprojectManagementSectionDiscussionById($id);
    }

    public function projectManagementSectionDiscussionStore(Request $request){
        try {
            return ProjectFacade::projectManagementSectionDiscussionStore($request->all());
        } catch (\Throwable $th) {
            return json_encode(['error','Error!', $th->getMessage()]);
        }
    }

    public function projectManagementSectionDiscussionUpdate(Request $request, $id){
        try {
            $discussion = ProjectFacade::projectManagementSectionDiscussionUpdate($request->all(), $id);
            if(isset($request->assignee_id)){
                ProjectFacade::makeTaskAssigneeRecord($request->assignee_id, $discussion);
                // if($request->assignee_id != auth()->user()->id){
                $section = $discussion->section;
                if($request->assignee_id != auth()->user()->id && (!$section || is_null($section->order_id))){
                    ProjectFacade::projectManagementNotifyDiscussionAssignee($request->assignee_id, $discussion);
                }
            }
            return $discussion;
        } catch (\Throwable $th) {
            return json_encode(['error','Error!', $th->getMessage()]);
        }
    }

    public function projectManagementSectionDiscussionDelete($id){
        try {
            ProjectFacade::projectManagementSectionDiscussionDelete($id);
        } catch (\Throwable $th) {
            return json_encode(['error','Error!', $th->getMessage()]);
        }
    }

    public function getprojectManagementSectionSubDiscussionByDiscussionId($id)
    {
        return ProjectFacade::getprojectManagementSectionSubDiscussionByDiscussionId($id);
    }

    public function getprojectManagementMyTaskSubDiscussionByDiscussionId($id)
    {
        return ProjectFacade::getprojectManagementMyTaskSubDiscussionByDiscussionId($id);
    }

    public function getprojectManagementSectionSubDiscussionById($id)
    {
        return ProjectFacade::getprojectManagementSectionSubDiscussionById($id);
    }

    public function projectManagementSectionSubDiscussionStore(Request $request){
        try {
            return ProjectFacade::projectManagementSectionSubDiscussionStore($request->all());
        } catch (\Throwable $th) {
            return json_encode(['error','Error!', $th->getMessage()]);
        }
    }

    public function projectManagementSectionSubDiscussionUpdate(Request $request, $id){
        try {
            $discussion = ProjectFacade::projectManagementSectionSubDiscussionUpdate($request->all(), $id);
            if(isset($request->assignee_id)){
                $discussion->is_sub_discussion = true;
                ProjectFacade::makeTaskAssigneeRecord($request->assignee_id, $discussion);
                // if($request->assignee_id != auth()->user()->id){
                $section = $discussion->section;
                if($request->assignee_id != auth()->user()->id && (!$section || is_null($section->order_id))){
                    ProjectFacade::projectManagementNotifySubDiscussionAssignee($request->assignee_id, $discussion);
                }
            }
            return $discussion;
        } catch (\Throwable $th) {
            return json_encode(['error','Error!', $th->getMessage()]);
        }
    }

    public function projectManagementSectionSubDiscussionDelete($id){
        try {
            ProjectFacade::projectManagementSectionSubDiscussionDelete($id);
        } catch (\Throwable $th) {
            return json_encode(['error','Error!', $th->getMessage()]);
        }
    }

    public function projectManagementSectionDiscussionCommentStore(Request $request)
    {
        try {
            $commentData = ProjectFacade::projectManagementSectionDiscussionCommentStore($request->all());
            if(isset($request->mentioned_users)){
                $this->notifyComentMentionedUser($request->discussion_type, $commentData, $request->mentioned_users);

            }
            if(isset($request->mentioned_groups)){
                $this->notifyComentMentionedGroup($request->discussion_type, $commentData, $request->mentioned_groups);
            }
            return $commentData;
        } catch (\Throwable $th) {
            return json_encode(['error','Error!', $th->getMessage()]);
        }
    }

    public function projectManagementSectionDiscussionCommentSaveDraft(Request $request)
    {
        try {
            $draft = ProjectFacade::projectManagementSectionDiscussionCommentSaveDraft($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Draft comment saved successfully',
                'data' => $draft
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function projectManagementSectionDiscussionCommentGetDraft($discussion_id, $discussion_type)
    {
        try {
            $draft = ProjectFacade::projectManagementSectionDiscussionCommentGetDraft($discussion_id, $discussion_type);
            return response()->json([
                'success' => true,
                'data' => $draft
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function projectManagementSectionDiscussionCommentTogglePin($comment_id)
    {
        try {
            $result = ProjectFacade::projectManagementSectionDiscussionCommentTogglePin($comment_id);
            return response()->json($result);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle pin status: ' . $th->getMessage()
            ], 500);
        }
    }


    public function notifyComentMentionedUser($discussionType, $commentData, $assignees)
    {
        $newAssignees = explode(',', $assignees);

        foreach($newAssignees as $assignee_id)
        {
            if($assignee_id != auth()->user()->id){
                if($discussionType == 'sub_discussion'){
                    ProjectFacade::projectManagementNotifySubTaskComentMentionedUser($assignee_id, $commentData);
                } elseif($discussionType == 'discussion'){
                    ProjectFacade::projectManagementNotifyTaskComentMentionedUser($assignee_id, $commentData);
                }
            }
        }
    }

    public function notifyComentMentionedGroup($discussionType, $commentData, $mentionedGroups)
    {
        $groupedUserArr = [];
        $groupArray = array_map('intval', explode(',', $mentionedGroups));
        $userIds =  User::whereHas("roles", function($q) use($groupArray) {
                            $q->whereIn("id", $groupArray);
                        })->whereNotIn('id', [Auth::user()->id])->where('active', 1)->get()->pluck('id');

        foreach($userIds as $user){
            array_push($groupedUserArr, $user);
        }

        foreach(array_unique($groupedUserArr) as $user_id)
        {
            if($user_id != auth()->user()->id){
                if($discussionType == 'sub_discussion'){
                    ProjectFacade::projectManagementNotifySubTaskComentMentionedUser($user_id, $commentData);
                } elseif($discussionType == 'discussion'){
                    ProjectFacade::projectManagementNotifyTaskComentMentionedUser($user_id, $commentData);
                }
            }
        }
    }

    public function notifyOverdueTasksByCroneJob(){
        $date = Carbon::now();
        $nowDate = $date->format('Y-m-d');
        ProjectFacade::sendNotificationOverdueDiscussion($nowDate);
        ProjectFacade::sendNotificationOverdueSubDiscussion($nowDate);
    }

    public function projectManagementSectionDiscussionCommentUpdate(Request $request, $id)
    {
        try {
            return ProjectFacade::projectManagementSectionDiscussionCommentUpdate($request->all(), $id);
        } catch (\Throwable $th) {
            return json_encode(['error','Error!', $th->getMessage()]);
        }
    }

    public function projectManagementSectionDiscussionCommentDelete($id){
        try {
            ProjectFacade::projectManagementSectionDiscussionCommentDelete($id);
        } catch (\Throwable $th) {
            return json_encode(['error','Error!', $th->getMessage()]);
        }
    }

    public function projectManagementSectionDiscussionCommentFileUpload(Request $request){

        try {
            $projectId = $request->input('project_id') ?: 'misc';
            $storageDir = 'project_management/' . $projectId;

            $uploaded = $request->file('upload_file');
            $providedNames = $request->input('upload_file_name');

            if (!$uploaded) {
                return response()->json(['error' => true, 'message' => 'No file(s) provided'], 400);
            }

            // Normalize to arrays
            $files = is_array($uploaded) ? $uploaded : [$uploaded];
            $names = is_array($providedNames) ? $providedNames : [$providedNames];

            $results = [];
            foreach ($files as $index => $file) {
                if (!$file->isValid()) {
                    continue;
                }

                $originalName = $file->getClientOriginalName();
                $givenName = $names[$index] ?? $originalName;
                $safeName = str_replace(["'", '\\'], ' ', $givenName);

                // Ensure unique filename if already exists
                $finalName = $safeName;
                $counter = 1;
                $pathCandidate = $storageDir . '/' . $finalName;
                while (Storage::disk('public')->exists($pathCandidate)) {
                    $nameOnly = pathinfo($safeName, PATHINFO_FILENAME);
                    $ext = pathinfo($safeName, PATHINFO_EXTENSION);
                    $finalName = $nameOnly . ' (' . $counter . ')' . ($ext ? ('.' . $ext) : '');
                    $pathCandidate = $storageDir . '/' . $finalName;
                    $counter++;
                }

                $storedPath = $file->storeAs($storageDir, $finalName, 'public');
                $publicUrl = asset('public/storage/'.$storedPath);

                $results[] = [
                    'name' => $finalName,
                    'path' => $storedPath,
                    'url' => $publicUrl,
                    'mime' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ];
            }

            return response()->json(['data' => $results]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()], 500);
        }
    }


    public function projectManagementSectionDiscussionCommentFileUploadTemp(Request $request)
    {
        try {

            $projectId = $request->input('project_id') ?: 'misc';

            if(!$request->hasFile('upload_file')){
                return response()->json([
                    'error'=>true,
                    'message'=>'No file(s) provided'
                ],400);
            }

            // VALIDATION
            $request->validate([
                'upload_file.*' => 'required|file|max:102400'
            ]);

            $files = $request->file('upload_file');

            if(!is_array($files)){
                $files = [$files];
            }

            $directoryPath = base_path('assets/Product Master Temp/' . $projectId . '/discussion');
            $relativePath  = 'assets/Product Master Temp/' . $projectId . '/discussion/';

            if (!File::exists($directoryPath)) {
                File::makeDirectory($directoryPath, 0777, true, true);
            }

            $results = [];

            foreach ($files as $file) {

                if(!$file || !$file->isValid()){
                    continue;
                }

                $originalName = $file->getClientOriginalName();

                $safeName = str_replace(["'", "\\", "/", ":"], " ", $originalName);

                $finalName = $safeName;

                $counter = 1;

                while(file_exists($directoryPath.'/'.$finalName)){

                    $nameOnly = pathinfo($safeName, PATHINFO_FILENAME);

                    $ext = pathinfo($safeName, PATHINFO_EXTENSION);

                    $finalName = $nameOnly.' ('.$counter.')'.($ext ? '.'.$ext : '');

                    $counter++;
                }

                $file->move($directoryPath, $finalName);

                $storedPath = $relativePath.$finalName;

                $results[] = [
                    'name' => $finalName,
                    'path' => $storedPath,
                    'url'  => asset($storedPath)
                ];
            }

            return response()->json(['data'=>$results]);

        } catch (\Throwable $th) {

            return response()->json([
                'error'=>true,
                'message'=>$th->getMessage()
            ],500);
        }
    }



    public function project_icons() {

        if(auth()->user()->can('manage project icons')){

            $projectIcons = ProjectFacade::get_all_project_icons();

            return view('pages.masters.project_icons.index', compact('projectIcons'));

        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function get_project_icon_by_id($id) {
        return ProjectFacade::get_project_icon_by_id($id);
    }
    public function project_icons_create(Request $request)
    {
        if(auth()->user()->can('add project icon')){
            $file = $request->file('new_project_icon');
            $originalName = $file->getClientOriginalName();
            $fileName = strtolower(preg_replace('/[^a-zA-Z0-9\s.]/', '', $originalName));
            $fileName = str_replace(' ', '_', $fileName);
            $timestamp = time();
            $fileName = $timestamp . '_' . $fileName;

            // $destinationPath = 'assets/img/icons/project_icons)';
            $directoryPath = base_path('assets/img/icons/project_icons/');

            if (!File::exists($directoryPath)) {
                File::makeDirectory($directoryPath, 0777, true, true);
            }

            $file->move($directoryPath, $fileName);

            $imagePath = 'assets/img/icons/project_icons/' . $fileName;

            ProjectFacade::project_icons_create($imagePath);
            return redirect()->back()->withSuccess('Project Icon Created Successfully!');
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function project_icons_update(Request $request)
    {
        if(auth()->user()->can('edit project icon')){
            if ($request->hasFile('edit_project_icon')) {
                $projectIconId = $request->project_icon_id;
                $file = $request->file('edit_project_icon');
                $originalName = $file->getClientOriginalName();
                $fileName = strtolower(preg_replace('/[^a-zA-Z0-9\s.]/', '', $originalName));
                $fileName = str_replace(' ', '_', $fileName);
                $timestamp = time();
                $fileName = $timestamp . '_' . $fileName;

                // $destinationPath = 'assets/img/icons/project_icons)';
                $directoryPath = base_path('assets/img/icons/project_icons/');

                if (!File::exists($directoryPath)) {
                    File::makeDirectory($directoryPath, 0777, true, true);
                }

                $file->move($directoryPath, $fileName);

                $imagePath = 'assets/img/icons/project_icons/' . $fileName;

                ProjectFacade::project_icons_update($imagePath, $projectIconId);
                return redirect()->back()->withSuccess('Project Icon Created Successfully!');
            } else {
                return redirect()->back()->withSuccess('Nothing To Update!');
            }
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function project_icons_delete($id)
    {
        if(auth()->user()->can('delete project icon')){
            ProjectFacade::project_icons_delete($id);
            return redirect()->back()->withSuccess('Project Icon Deleted Successfully!');
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }

    }

    // Drag and Drop Reordering Methods
    public function reorderSections(Request $request)
    {
        try {
            $projectId = $request->input('project_id');
            $sectionIds = $request->input('section_ids');

            if (!$projectId || !$sectionIds || !is_array($sectionIds)) {
                return response()->json(['error' => 'Invalid data provided'], 400);
            }

            $result = ProjectFacade::reorderSections($projectId, $sectionIds);

            if ($result[0] === 'success') {
                return response()->json(['success' => true, 'message' => $result[1]]);
            } else {
                return response()->json(['error' => $result[1]], 500);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function reorderDiscussions(Request $request)
    {
        try {
            $sectionId = $request->input('section_id');
            $discussionIds = $request->input('discussion_ids');

            if (!$sectionId || !$discussionIds || !is_array($discussionIds)) {
                return response()->json(['error' => 'Invalid data provided'], 400);
            }

            $result = ProjectFacade::reorderDiscussions($sectionId, $discussionIds);

            if ($result[0] === 'success') {
                return response()->json(['success' => true, 'message' => $result[1]]);
            } else {
                return response()->json(['error' => $result[1]], 500);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function reorderSubDiscussions(Request $request)
    {
        try {
            $discussionId = $request->input('discussion_id');
            $subDiscussionIds = $request->input('sub_discussion_ids');

            if (!$discussionId || !$subDiscussionIds || !is_array($subDiscussionIds)) {
                return response()->json(['error' => 'Invalid data provided'], 400);
            }

            $result = ProjectFacade::reorderSubDiscussions($discussionId, $subDiscussionIds);

            if ($result[0] === 'success') {
                return response()->json(['success' => true, 'message' => $result[1]]);
            } else {
                return response()->json(['error' => $result[1]], 500);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function sectionCommentCount($sectionId) {
        return ProjectFacade::sectionCommentCount($sectionId);
    }

    public function discussionCount($sectionId) {
        return ProjectFacade::discussionCount($sectionId);
    }

    public function getSubSectionDiscussionCountById($id, $discussionId) {
        return ProjectFacade::getSubSectionDiscussionCountById($id, $discussionId);
    }

    public function getSubSectionDiscussionCommentCountById($id, $discussionId) {
        return ProjectFacade::getSubSectionDiscussionCommentCountById($id, $discussionId);
    }

    public function toggleReaction(Request $request, $commentId) {
        $reactionType = $request->reaction_type;
        $result = ProjectFacade::toggleCommentReaction($commentId, $reactionType);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'reactions' => $result['reactions'],
                'user_reaction' => $result['user_reaction'],
                'total_count' => $result['total_count'],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 500);
        }
    }

}
