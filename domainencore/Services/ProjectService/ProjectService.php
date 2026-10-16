<?php

namespace domainencore\Services\ProjectService;

use App\Models\CommentReaction;
use App\Models\PmInbox;
use App\Models\Project;
use App\Models\PmSection;
use App\Models\PmSectionDiscussion;
use App\Models\PmSectionDiscussionComment;
use App\Models\PmSectionSubDiscussion;
use App\Models\PmTaskAssignee;
use App\Models\ProductTemp;
use App\Models\ProjectIcon;
use App\Models\SubProductTemp;
use App\Models\TempPmDiscussionComment;
use App\Models\User;
use App\Services\NotificationBuilderService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class ProjectService
{
    protected $project;
    protected $pm_section;
    protected $pm_section_discussion;
    protected $pm_section_sub_discussion;
    protected $pm_section_discussion_comment;
    protected $project_icon;
    protected $user;
    protected $role;
    protected $notification_builder;
    protected $pm_inbox;
    protected $pm_task_assignee;
    protected $commentReaction;
    protected $temp_pm_section_discussion_comment;

    public function __construct()
    {
        $this->project = new Project();
        $this->pm_section = new PmSection();
        $this->pm_section_discussion = new PmSectionDiscussion();
        $this->pm_section_sub_discussion = new PmSectionSubDiscussion();
        $this->pm_section_discussion_comment = new PmSectionDiscussionComment();
        $this->project_icon = new ProjectIcon();
        $this->user = new User();
        $this->role = new Role();
        $this->notification_builder = new NotificationBuilderService();
        $this->pm_inbox = new PmInbox();
        $this->pm_task_assignee = new PmTaskAssignee();
        $this->commentReaction = new CommentReaction();
        $this->temp_pm_section_discussion_comment = new TempPmDiscussionComment();
    }

    public function project_delete($id)
    {
        try {
            $project = $this->project->find($id);
            $project->delete();
            return ['success','Success!', 'Project Deleted Successfully!'];
        } catch (\Throwable $th) {
            return ['error','Error!', $th->getMessage()];
        }
    }

    public function project_delete_new($id){
        try {

            DB::beginTransaction();

            $project = Project::find($id);

            if (!$project) {
                throw new \Exception('Project not found');
            }


            // Delete related temp product
            if ($project->product_level == 1) {

                $productTemp = ProductTemp::find($project->product_id);

            } else {

                $productTemp = SubProductTemp::find($project->product_id);
            }

            if ($productTemp) {
                $productTemp->delete();
            }

            $inbox = PmInbox::where('project_id', $id)->first();
            if ($inbox) {
                PmInbox::where('project_id', $id)->delete();
            }

            $pmSectionDiscussion = PmSectionDiscussion::where('project_id', $id)->first();
            if ($pmSectionDiscussion) {
                PmSectionDiscussion::where('project_id', $id)->delete();
            }

            $pmSectionDiscussionCommit = PmSectionDiscussionComment::where('project_id', $id)->first();
            if ($pmSectionDiscussionCommit) {
                PmSectionDiscussionComment::where('project_id', $id)->delete();
            }

            $pmSectionSubSection = PmSectionSubDiscussion::where('project_id', $id)->first();
            if ($pmSectionSubSection) {
                PmSectionSubDiscussion::where('project_id', $id)->delete();
            }

            $pmTaskAssignee = PmTaskAssignee::where('project_id', $id)->first();
            if ($pmTaskAssignee) {
                PmTaskAssignee::where('project_id', $id)->delete();
            }

            // Delete project
            $project->delete();

            DB::commit();

            return ['success', 'Success!', 'Project Deleted Successfully!'];

        } catch (\Throwable $th) {
            DB::rollback();
            return ['error', 'Error!', $th->getMessage()];
        }
    }


    public function addAssignee($projectId, $assigneeId, $assineeType)
    {
        try {
            $assignedUsers = null;
            $assignedGroups = null;
            $assigneeName = null;

            $editingProject = $this->project->find($projectId);
            if(!$editingProject){
                throw new \Exception('Project not found');
            }

            // Only allow adding assignees for active projects (status = 1)
            if($editingProject->status != 1){
                return ['error','Error!', 'Assignees can only be added to active projects.'];
            }
            if($assineeType == 'user'){
                $assignedUsers = $editingProject->project_assignee_users;
                if($assignedUsers != '' && $assignedUsers != null){
                    $assignedUsersArr = json_decode($assignedUsers);
                    $newAssignedUsers = array_merge($assignedUsersArr, [$assigneeId]);
                    $assignedUsers = json_encode( array_unique($newAssignedUsers) );
                } else {
                    $assignedUsers = json_encode([$assigneeId]);
                }
                $editingProject->project_assignee_users = $assignedUsers;
                $assigneeName = $this->user->find($assigneeId);
                $assigneeName = $assigneeName->name;
            } else if($assineeType == 'group'){
                $assignedGroups = $editingProject->project_assignee_groups;
                if($assignedGroups != '' && $assignedGroups != null){
                    $assignedGroupsArr = json_decode($assignedGroups);
                    $newAssignedGroups = array_merge($assignedGroupsArr, [$assigneeId]);
                    $assignedGroups = json_encode( array_unique($newAssignedGroups) );
                } else {
                    $assignedGroups = json_encode([$assigneeId]);
                }
                $editingProject->project_assignee_groups = $assignedGroups;
                $assigneeName = $this->role->find($assigneeId);
                $assigneeName = 'Group '.$assigneeName->name;

                // Also add all users of this group into the legacy `project_assignee` (comma-separated user ids)
                try {
                    $role = $this->role->find($assigneeId);
                    if($role){
                        $groupUserIds = $role->users()->pluck('id')->toArray();
                        if(!empty($groupUserIds)){
                            $currentAssignees = $editingProject->project_assignee;
                            $currentArr = [];
                            if($currentAssignees != '' && $currentAssignees != null){
                                $currentArr = array_filter(array_map('trim', explode(',', $currentAssignees)), function($v){ return $v !== ''; });
                            }
                            $merged = array_unique(array_merge($currentArr, $groupUserIds));
                            // Ensure values are strings
                            $merged = array_map('strval', $merged);
                            $editingProject->project_assignee = implode(',', $merged);
                        }
                    }
                } catch (\Throwable $e) {
                    // Non-fatal: don't break the whole operation if role->users fails
                }
            }
            $editingProject->update();

            return ['success','Success!', $assigneeName.' is added as Assignee, Successfully!'];
        } catch (\Throwable $th) {
            return ['error','Error!', $th->getMessage()];
        }
    }

    public function getAssignees($id)
    {
        $project = $this->project->withTrashed()->find($id);
        $assigneeUsers = $project->project_assignee;
        $createdUser = $project->created_by;
        // $assigneeUsers = $project->project_assignee_users;
        // $assigneeGroups = $project->project_assignee_groups;
        $assigneeDefaultImage = 'assets/img/user/default.png';

        $allUserArr = [];
        if($assigneeUsers != '' && $assigneeUsers != null){
            // $assignedUsers = $this->user->whereIn('id', json_decode($assigneeUsers))->get();
            $allUserArr = explode(',', $assigneeUsers);
        }

        // Merge $allUserArr with $createdUser
        if ($createdUser && !in_array($createdUser, $allUserArr)) {
            $allUserArr[] = $createdUser;
        }

        // Remove auth()->user()->id from $allUserArr if it exists
        // if (($key = array_search(auth()->user()->id, $allUserArr)) !== false) {
        //     unset($allUserArr[$key]);
        //     // Reindex array to avoid gaps in keys
        //     $allUserArr = array_values($allUserArr);
        // }

        $assignedUsers = $this->user->whereIn('id', $allUserArr)->get();

        // if($assigneeGroups != '' && $assigneeGroups != null){
        //     $assignedGroups = $this->role->whereIn('id', json_decode($assigneeGroups))->get();
        // } else {
        //     $assignedGroups = [];
        // }

        $userAssigneeCount = count($assignedUsers);
        // $groupAssigneeCount = count($assignedGroups);

        $allAssignees = [];
        foreach($assignedUsers as $assignedUser){
            $allAssignees[] = [
                'id'=>$assignedUser->id,
                'name'=>$assignedUser->name,
                'image'=>$assignedUser->profile_pic ?? $assigneeDefaultImage ,
                'type'=>'user',
            ];
        }
        // foreach($assignedGroups as $assignedGroup){
        //     $allAssignees[] = [
        //         'id'=>$assignedGroup->id,
        //         'name'=>$assignedGroup->name,
        //         'image'=>$assigneeDefaultImage ,
        //         'type'=>'group',
        //     ];
        // }

        // return [$allAssignees,$userAssigneeCount,$groupAssigneeCount]; // {all asignees with detail}, {users count}, {goup count}
        return [$allAssignees,$userAssigneeCount]; // {all asignees with detail}, {users count}, {goup count}
    }

    public function deleteAssignee($data)
    {
        try {
            $project = $this->project->withTrashed()->find($data->project_id);
            if($data->assignee_type == 'user'){
                $assigneeArr = json_decode($project->project_assignee_users);
                $newAssigneeArr = array_diff($assigneeArr, [$data->assignee_id]);
                $project->project_assignee_users = array_values($newAssigneeArr);

            } else if($data->assignee_type == 'group') {
                $assigneeArr = json_decode($project->project_assignee_groups);
                $newAssigneeArr = array_diff($assigneeArr, [$data->assignee_id]);
                $project->project_assignee_groups = array_values($newAssigneeArr);
            }

            $project->update();

            return ['success','Success!', 'Assignee Removed Successfully!'];
        } catch (\Throwable $th) {
            return ['error','Error!', $th->getMessage()];
        }
    }

    public function filter_search_data($request)
    {
        $input_text = $request->input('input_text');
        $projectQry = $this->project->with('projectType', 'projectStatus', 'projectCreatedBy');
        $discussionsQuery = $this->pm_section_discussion->whereHas('section');
        $subDiscussionsQuery = $this->pm_section_sub_discussion->whereHas('section')->whereHas('discussionDetail');
        $commentsQuery = $this->pm_section_discussion_comment->with('discussionInfo', 'subDiscussionInfo')->whereHas('sectionInfo')
            ->where(function($query) {
                $query->whereHas('discussionInfo')
                    ->orWhereHas('subDiscussionInfo');
            });
        if(!auth()->user()->hasAnyRole(['Super Admin', 'Admin'])){
            $projectQry->where(function($query) {
                $query->whereRaw("FIND_IN_SET(?, project_assignee)", [auth()->user()->id])
                      ->orWhere('created_by', auth()->user()->id);
            });
            $discussionsQuery->where(function($query) {
                $query->whereHas('projectDetail', function($q) {
                    $q->whereRaw("FIND_IN_SET(?, project_assignee)", [auth()->user()->id])
                      ->orWhere('created_by', auth()->user()->id);
                });
            });
            $subDiscussionsQuery->where(function($query) {
                $query->whereHas('projectDetail', function($q) {
                    $q->whereRaw("FIND_IN_SET(?, project_assignee)", [auth()->user()->id])
                      ->orWhere('created_by', auth()->user()->id);
                });
            });
            $commentsQuery->where(function($query) {
                $query->whereHas('projectDetail', function($q) {
                    $q->whereRaw("FIND_IN_SET(?, project_assignee)", [auth()->user()->id])
                      ->orWhere('created_by', auth()->user()->id);
                });
            });
        } else {
            $discussionsQuery->whereHas('projectDetail');
            $subDiscussionsQuery->whereHas('projectDetail');
            $commentsQuery->whereHas('projectDetail');
        }
        $userId = $this->user->where('name', 'LIKE', "%{$input_text}%")->pluck('id')->toArray();
        $roleId = $this->role->where('name', 'LIKE', "%{$input_text}%")->pluck('id')->toArray();
        $projectQry->where(function($query) use($input_text) {
                $query->where('project_name', 'LIKE', "%{$input_text}%")
                    ->orWhere('project_no', 'LIKE', "%{$input_text}%")
                    ->orWhere('project_description', 'LIKE', "%{$input_text}%");
                    // ->orWhereRaw("FIND_IN_SET(?, project_assignee)", $userId);
        });
        $discussionsQuery->where(function($query) use($input_text) {
            $query->where('discussion_name', 'LIKE', "%{$input_text}%")
                ->orWhere('discussion_description', 'LIKE', "%{$input_text}%");
                // ->orWhereIn('assignee_id', $userId);
        });
        $subDiscussionsQuery->where(function($query) use($input_text) {
            $query->where('discussion_name', 'LIKE', "%{$input_text}%")
                ->orWhere('discussion_description', 'LIKE', "%{$input_text}%");
                // ->orWhereIn('assignee_id', $userId);
        });
        $commentsQuery->where(function($query) use($input_text, $userId, $roleId) {
            $query->where('comment', 'LIKE', "%{$input_text}%");
            if (!empty($userId)) {
                foreach ($userId as $id) {
                    $query->orWhereRaw("FIND_IN_SET(?, mentioned_users)", [$id]);
                }
            }
            if (!empty($roleId)) {
                foreach ($roleId as $id) {
                    $query->orWhereRaw("FIND_IN_SET(?, mentioned_groups)", [$id]);
                }
            }
        });
        $projects = $projectQry->orderBy('id', 'DESC')->get();
        $discussions = $discussionsQuery->orderBy('created_at', 'DESC')->get();
        $subDiscussions = $subDiscussionsQuery->orderBy('created_at', 'DESC')->get();
        $combinedDiscussions = $discussions->merge($subDiscussions)
            ->sortByDesc('created_at')
            ->values();
        $comments = $commentsQuery->orderBy('id', 'DESC')->get();

        // $projectAssignees = $projects->pluck('project_assignee')
        //     ->flatMap(function($ids) { return explode(',', (string) $ids); })
        //     ->filter()
        //     ->unique()
        //     ->values()
        //     ->all();
        // $assigneeUsers = $this->user->whereIn('id', $projectAssignees)->get();
        $searchUsers = $this->user->whereIn('id', $userId)->get();
        return response()->json([$projects, $combinedDiscussions, $comments, $searchUsers, $input_text]);
        // return json_encode([$activities, $organizations, $contacts, $input_text]);

    }

    // public function getPaginatedProjects($request, $limit = 50)
    // {
    //     $projectQry = $this->project->with('projectType', 'projectStatus', 'projectCreatedBy')->where('status', 1);

    //     if(!auth()->user()->hasAnyRole(['Super Admin', 'Admin'])){
    //         $projectQry->whereRaw("FIND_IN_SET(?, project_assignee)", [auth()->user()->id])
    //                     ->orWhere('created_by', auth()->user()->id);

    //     }

    //     if($request->sr && $request->sr != ''){
    //         $projectQry->where('project_name', 'LIKE', '%'.$request->sr.'%')
    //                     ->orWhere('project_no', 'LIKE', '%'.$request->sr.'%')
    //                     ->orWhere('project_description', 'LIKE', '%'.$request->sr.'%');
    //     }
    //     if($request->owner && $request->owner != ''){
    //         $projectQry->where('created_by', $request->owner);
    //     }
    //     if($request->assignee && $request->assignee != ''){
    //         $projectQry->where('project_assignee', 'LIKE', '%'.$request->assignee.'%');
    //     }
    //     if($request->status && $request->status != ''){
    //         $projectQry->where('project_status_id', $request->status);
    //     }
    //     if($request->date_range){
    //         if($request->date_range == 'month'){
    //             $dtMax = Carbon::now()->endOfMonth()->toDateTimeString();
    //             $dtMmin = Carbon::now()->startOfMonth()->toDateTimeString();
    //         } elseif($request->date_range == 'week'){
    //             $dtMmin = Carbon::now()->startOfWeek()->startOfDay()->toDateTimeString();
    //             $dtMax = Carbon::now()->endOfWeek()->endOfDay()->toDateTimeString();
    //         } elseif($request->date_range == 'day'){
    //             $dtMmin = Carbon::now()->startOfDay()->toDateTimeString();
    //             $dtMax = Carbon::now()->endOfDay()->toDateTimeString();
    //         }
    //         $projectQry->where('created_at', '>=',$dtMmin)
    //                     ->where('created_at', '<=',$dtMax);
    //     }

    //     if($request->load_type){
    //         if($request->load_type == 'recent'){
    //             $limit = 6;
    //             $projectQry->where(function($query){
    //                 $query->where('project_assignee', 'LIKE', '%'.auth()->user()->id.'%')
    //                         ->orWhere('created_by', auth()->user()->id);
    //             });
    //             $projectQry->orderBy('created_at', 'DESC');
    //         } elseif($request->load_type == 'started'){
    //             $projectQry->where(function($query){
    //                 $query->where('project_assignee', 'LIKE', '%'.auth()->user()->id.'%')
    //                         ->orWhere('created_by', auth()->user()->id);
    //             });
    //         } elseif($request->load_type == 'all'){
    //             // Nothing to do here
    //         }
    //     } else {
    //         $projectQry->orderBy('id', 'DESC');
    //     }

    //     $project = $projectQry->paginate($limit);
    //     return $project;
    // }

    public function getPaginatedProjects($request)
    {
        $projectQry = $this->project
            ->with([
                'projectType',
                'projectStatus',
                'projectCreatedBy'
            ])
            ->where('status', 1);

        // Permission Filter
        if (auth()->user()->hasRole('Super Admin')) {

            if ($request->filled('assignee_id')) {

                $projectQry->where(function ($query) use ($request) {

                    $query->whereRaw(
                        "FIND_IN_SET(?, COALESCE(project_assignee,''))",
                        [$request->assignee_id]
                    )
                    ->orWhere(
                        'created_by',
                        $request->assignee_id
                    );

                });
            }

        } else {

            $projectQry->where(function ($query) {

                $query->whereRaw(
                    "FIND_IN_SET(?, COALESCE(project_assignee,''))",
                    [auth()->id()]
                )
                ->orWhere(
                    'created_by',
                    auth()->id()
                );

            });
        }

        switch ($request->load_type) {
            case 'recent':

                $projectQry->where(
                    'created_at',
                    '>=',
                    now()->subMonths(6)
                );

                break;

            case 'started':

                $projectQry->where(
                    'created_at',
                    '>=',
                    now()->subMonths(6)
                );

                break;

            case 'all':

                break;
        }

        return $projectQry
            ->orderBy('created_at', 'DESC')
            ->limit(20)
            ->get();
    }

    public function getPaginatedProjectsNew($request, $limit = 10)
    {
        $projectQry = $this->project->with('projectType', 'projectStatus', 'projectCreatedBy')->where('status', 1);



        if(!auth()->user()->hasAnyRole(['Super Admin'])){
            $projectQry->whereRaw("FIND_IN_SET(?, project_assignee)", [auth()->user()->id])
                        ->orWhere('created_by', auth()->user()->id);

        }

        if($request->sr && $request->sr != ''){
            $projectQry->where('project_name', 'LIKE', '%'.$request->sr.'%')
                        ->orWhere('project_no', 'LIKE', '%'.$request->sr.'%')
                        ->orWhere('project_description', 'LIKE', '%'.$request->sr.'%');
        }
        if($request->owner && $request->owner != ''){
            $projectQry->where('created_by', $request->owner);
        }
        if($request->assignee && $request->assignee != ''){
            $projectQry->where('project_assignee', 'LIKE', '%'.$request->assignee.'%');
        }
        if($request->status && $request->status != ''){
            $projectQry->where('project_status_id', $request->status);
        }
        if($request->date_range){
            if($request->date_range == 'month'){
                $dtMax = Carbon::now()->endOfMonth()->toDateTimeString();
                $dtMmin = Carbon::now()->startOfMonth()->toDateTimeString();
            } elseif($request->date_range == 'week'){
                $dtMmin = Carbon::now()->startOfWeek()->startOfDay()->toDateTimeString();
                $dtMax = Carbon::now()->endOfWeek()->endOfDay()->toDateTimeString();
            } elseif($request->date_range == 'day'){
                $dtMmin = Carbon::now()->startOfDay()->toDateTimeString();
                $dtMax = Carbon::now()->endOfDay()->toDateTimeString();
            }
            $projectQry->where('created_at', '>=',$dtMmin)
                        ->where('created_at', '<=',$dtMax);
        }

        if($request->load_type){
            if($request->load_type == 'recent'){
                $limit = 6;
                $projectQry->where(function($query){
                    $query->where('project_assignee', 'LIKE', '%'.auth()->user()->id.'%')
                            ->orWhere('created_by', auth()->user()->id);
                });
                $projectQry->orderBy('created_at', 'DESC');
            } elseif($request->load_type == 'started'){
                $projectQry->where(function($query){
                    $query->where('project_assignee', 'LIKE', '%'.auth()->user()->id.'%')
                            ->orWhere('created_by', auth()->user()->id);
                });
            } elseif($request->load_type == 'all'){
                // Nothing to do here
            }
        } else {
            $projectQry->orderBy('id', 'DESC');
        }

        $project = $projectQry->paginate($limit);
        return $project;
    }

    public function getCollaboratorsCount($request)
    {
        $collaborators = $this->getProjectsCollaborators($request);
        return str_pad(count($collaborators), 2, '0', STR_PAD_LEFT);
    }

    public function getProjectsCollaborators($request)
    {
        $projectQry = $this->project;
        $projectQry->where('created_by', auth()->user()->id)
                    ->orWhereRaw("FIND_IN_SET(?, project_assignee)", [auth()->user()->id]);
        // if($request->date_range){
        //     if($request->date_range == 'month'){
        //         $dtMax = Carbon::now()->endOfMonth()->toDateTimeString();
        //         $dtMmin = Carbon::now()->startOfMonth()->toDateTimeString();
        //     } elseif($request->date_range == 'week'){
        //         $dtMmin = Carbon::now()->startOfWeek()->startOfDay()->toDateTimeString();
        //         $dtMax = Carbon::now()->endOfWeek()->endOfDay()->toDateTimeString();
        //     } elseif($request->date_range == 'day'){
        //         $dtMmin = Carbon::now()->startOfDay()->toDateTimeString();
        //         $dtMax = Carbon::now()->endOfDay()->toDateTimeString();
        //     }

        //     $projectQry->where('created_at', '>=',$dtMmin)
        //                 ->where('created_at', '<=',$dtMax);
        // }
        $projects = $projectQry->get()->pluck('id');

        $allAssignees = [];
        foreach($projects as $projectId){
            array_push($allAssignees, ...$this->getAssignees($projectId)[0]);
        }

        $uniqueAssignee = [];
        $seen = [];

        foreach ($allAssignees as $assignee) {
            $key = $assignee['id'] . '-' . $assignee['name']; // or just $assignee['id'] if id is always unique
            if (!isset($seen[$key])) {
                $uniqueAssignee[] = $assignee;
                $seen[$key] = true;
            }
        }

        return $uniqueAssignee;
    }

    public function getCompletedTaskCount($request)
    {
        $discussionQry = $this->pm_section_discussion->whereHas('projectDetail');
        if (auth()->user()->id != 1) {
            $discussionQry->where('assignee_id', auth()->user()->id);
        }

        $dtMmin = Carbon::now()->toDateString();
        $dtMax = Carbon::now()->toDateString();

        if($request->date_range){
            if($request->date_range == 'month'){
                $dtMax = Carbon::now()->endOfMonth()->toDateString();
                $dtMmin = Carbon::now()->startOfMonth()->toDateString();
            } elseif($request->date_range == 'week'){
                $dtMmin = Carbon::now()->startOfWeek()->startOfDay()->toDateString();
                $dtMax = Carbon::now()->endOfWeek()->endOfDay()->toDateString();
            }
        }

        $discussionsCount = $discussionQry->where('due_date', '>=',$dtMmin)
                        ->where('due_date', '<=',$dtMax)
                        ->where('is_completed', 1)
                        ->orderBy('due_date', 'DESC')
                        ->count();
        return str_pad($discussionsCount, 2, '0', STR_PAD_LEFT);
    }

   public function getMyTasks($request)
   {
        $dtNow = Carbon::today()->toDateString();

        $discussionQry = PmSectionDiscussion::query()
            ->whereHas('projectDetail');

        $subDiscussionQry = PmSectionSubDiscussion::query()
            ->whereHas('projectDetail');

        // User Filtering
        if (auth()->user()->hasRole('Super Admin')) {

            if ($request->filled('assignee_id')) {

                $discussionQry->where('assignee_id', $request->assignee_id);

                $subDiscussionQry->where('assignee_id', $request->assignee_id);
            }

        } else {

            $discussionQry->where('assignee_id', auth()->id());

            $subDiscussionQry->where('assignee_id', auth()->id());
        }

        // Task Type Filtering
        switch ($request->task_type) {

            case 'upcoming':

                $discussionQry->where('is_completed', 0)
                    ->where(function ($q) use ($dtNow) {
                        $q->whereNull('due_date')
                        ->orWhere('due_date', '>=', $dtNow);
                    });

                $subDiscussionQry->where('is_completed', 0)
                    ->where(function ($q) use ($dtNow) {
                        $q->whereNull('due_date')
                        ->orWhere('due_date', '>=', $dtNow);
                    });

                break;

            case 'overdue':

                $discussionQry->where('is_completed', 0)
                    ->whereNotNull('due_date')
                    ->where('due_date', '<', $dtNow);

                $subDiscussionQry->where('is_completed', 0)
                    ->whereNotNull('due_date')
                    ->where('due_date', '<', $dtNow);

                break;

            case 'completed':

                $discussionQry->where('is_completed', 1);

                $subDiscussionQry->where('is_completed', 1);

                break;
        }

        $discussions = $discussionQry->get();

        $subDiscussions = $subDiscussionQry->get();

        $tasks = $discussions->concat($subDiscussions);

        $tasks = $tasks->sortByDesc(function ($task) {
            return $task->due_date ?? '1970-01-01';
        });

        return $tasks->take(20);
    }

    public function getMyTasksForCalendar($request)
    {
        $dtNow = Carbon::now()->toDateString();

        // Discussions query
        $discussionQry = PmSectionDiscussion::query()
            ->whereHas('projectDetail');

        // Sub discussions query
        $subDiscussionQry = PmSectionSubDiscussion::query()
            ->whereHas('projectDetail');

        // If not admin (ID 1), filter by current user's tasks only
        if(auth()->user()->id != 1) {
            $discussionQry->where('assignee_id', auth()->user()->id);
            $subDiscussionQry->where('assignee_id', auth()->user()->id);
        }

        // Handle assignee filter (for admin)
        if($request->assignee_id){
            $discussionQry->where('assignee_id', $request->assignee_id);
            $subDiscussionQry->where('assignee_id', $request->assignee_id);
        }

        // Handle task type filter
        if($request->task_type){
            // UPCOMING / PENDING
            if(in_array($request->task_type, ['upcoming','pending'])){
                $discussionQry->where('is_completed', 0)
                    ->where(function($qr) use($dtNow){
                        $qr->whereNull('due_date')
                            ->orWhere('due_date', '>=', $dtNow);
                    });

                $subDiscussionQry->where('is_completed', 0)
                    ->where(function($qr) use($dtNow){
                        $qr->whereNull('due_date')
                            ->orWhere('due_date', '>=', $dtNow);
                    });
            }
            // OVERDUE
            elseif($request->task_type == 'overdue'){
                $discussionQry->where('is_completed', 0)
                    ->whereNotNull('due_date')
                    ->where('due_date', '<', $dtNow);

                $subDiscussionQry->where('is_completed', 0)
                    ->whereNotNull('due_date')
                    ->where('due_date', '<', $dtNow);
            }
            // COMPLETED
            elseif($request->task_type == 'completed'){
                $discussionQry->where('is_completed', 1);
                $subDiscussionQry->where('is_completed', 1);
            }
        }

        // Handle calendar date range filtering
        if($request->start && $request->end){
            $dtMmin = $request->start;
            $dtMax = $request->end;

            $discussionQry->where('due_date', '>=', $dtMmin)
                      ->where('due_date', '<=', $dtMax);

            $subDiscussionQry->where('due_date', '>=', $dtMmin)
                      ->where('due_date', '<=', $dtMax);
        }


        $discussions = $discussionQry->with('section.project')->get();
        $subDiscussions = $subDiscussionQry->with('section.project')->get();


        return $discussions->concat($subDiscussions);
    }

    public function getMyTaskSections($request)
    {
        $dtNow = Carbon::now()->toDateString();

        $discussionQuery = $this->pm_section_discussion
            ->whereHas('projectDetail')
            ->whereHas('section');

        // If not admin (ID 1), filter by current user's tasks only
        if(auth()->user()->id != 1) {
            $discussionQuery->where('assignee_id', auth()->user()->id);
        }

        if($request->assignee_id) {
            $discussionQuery->where('assignee_id', $request->assignee_id);
        }

        $this->applyTaskTypeFilter($discussionQuery, $request->task_type, $dtNow);

        $sectionIds = $discussionQuery
            ->distinct()
            ->pluck('section_id')
            ->toArray();

        $subDiscussionQuery = $this->pm_section_sub_discussion
            ->whereHas('projectDetail')
            ->whereHas('section')
            ->whereHas('discussionDetail');

        if(auth()->user()->id != 1) {
            $subDiscussionQuery->where('assignee_id', auth()->user()->id);
        }

        if($request->assignee_id) {
            $subDiscussionQuery->where('assignee_id', $request->assignee_id);
        }

        $this->applyTaskTypeFilter($subDiscussionQuery, $request->task_type, $dtNow);

        $sectionIds = array_unique(array_merge($sectionIds, $subDiscussionQuery->distinct()->pluck('section_id')->toArray()));

        return $this->pm_section->with([
                'discussions' => function ($q) use ($request, $dtNow) {
                    $assigneeId = $request->assignee_id ?? (auth()->id() != 1 ? auth()->id() : null);

                    $q->where(function ($q2) use ($request, $dtNow, $assigneeId) {
                        if ($assigneeId) {
                            $q2->where(function ($q3) use ($request, $dtNow, $assigneeId) {
                                $q3->where('assignee_id', $assigneeId);
                                $this->applyTaskTypeFilter($q3, $request->task_type, $dtNow);
                            });

                            $q2->orWhereHas('subDiscussions', function ($subQ) use ($request, $dtNow, $assigneeId) {
                                $subQ->where('assignee_id', $assigneeId);
                                $this->applyTaskTypeFilter($subQ, $request->task_type, $dtNow);
                            });
                        } else {
                            $q2->where(function ($q3) use ($request, $dtNow) {
                                $this->applyTaskTypeFilter($q3, $request->task_type, $dtNow);
                            });

                            $q2->orWhereHas('subDiscussions', function ($subQ) use ($request, $dtNow) {
                                $this->applyTaskTypeFilter($subQ, $request->task_type, $dtNow);
                            });
                        }
                    });
                },
                // 'discussions.comments',
                'discussions.assigneeUser'
            ])->whereIn('id', $sectionIds)->get();
    }

    public function getMyTaskSectionById($sectionId)
    {
        return $this->pm_section->with('myDiscussions.mySubDiscussions', 'myDiscussions.comments', 'myDiscussions.assigneeUser' )->find($sectionId);
    }

    private function applyTaskTypeFilter($query, $taskType, $dtNow)
    {
        if (!$taskType) {
            return $query;
        }

        if (in_array($taskType, ['pending', 'upcoming'])) {
            return $query->where('is_completed', 0)
                         ->where(function ($qr) use ($dtNow) {
                             $qr->whereNull('due_date')
                                ->orWhere('due_date', '>=', $dtNow);
                         });
        }

        if ($taskType == 'overdue') {
            return $query->where('is_completed', 0)
                         ->whereNotNull('due_date')
                         ->where('due_date', '<', $dtNow);
        }

        if ($taskType == 'completed') {
            return $query->where('is_completed', 1);
        }

        return $query;
    }

    public function getPaginatedMyAllTasks($request, $limit = 10) {
        if ($request->has('per_page') && is_numeric($request->per_page)) {
            $limit = $request->per_page;
        }
        $userId = auth()->user()->id;
        $isAdmin = $userId == 1;
        // $isAdmin = $userId == 1 || auth()->user()->hasRole('Super Admin') || auth()->user()->can('view systemadmin dashboard');
        $dtNow = Carbon::now()->toDateString();
        $sortBy = $request->get('sort_by');
        $sortDir = strtolower($request->get('sort_dir', 'desc')) === 'asc' ? 'asc' : 'desc';
        $allowedSortBy = ['created_at', 'discussion_name', 'due_date', 'project', 'assigned_by'];
        if (!in_array($sortBy, $allowedSortBy, true)) {
            $sortBy = 'created_at';
        }

        $discussionsQuery = $this->pm_section_discussion
            ->select([
                'id',
                'section_id',
                'project_id',
                'assignee_id',
                'assigned_by',
                DB::raw('NULL as discussion_id'),
                'discussion_name',
                DB::raw("'discussion' as discussion_type"),
                'discussion_description',
                'due_date',
                'is_completed',
                'user_id',
                'priority',
                'sort_index',
                'created_at',
            ])
            ->whereHas('projectDetail')
            ->whereHas('section');

        if (!$isAdmin) {
            $discussionsQuery->where('assignee_id', $userId);
        }

        if ($request->assignee_id) {
            $discussionsQuery->where('assignee_id', $request->assignee_id);
        }

        if ($request->task_type) {
            if (in_array($request->task_type, ['pending', 'upcoming'])) {
                $discussionsQuery->where('is_completed', 0)
                    ->where(function($qr) use ($dtNow) {
                        $qr->whereNull('due_date')
                           ->orWhere('due_date', '>=', $dtNow);
                    });
            } elseif ($request->task_type == 'overdue') {
                $discussionsQuery->where('is_completed', 0)
                    ->whereNotNull('due_date')
                    ->where('due_date', '<', $dtNow);
            } elseif ($request->task_type == 'completed') {
                $discussionsQuery->where('is_completed', 1);
            }
        }

        $subDiscussionsQuery = $this->pm_section_sub_discussion
            ->select([
                'id',
                'section_id',
                'project_id',
                'assignee_id',
                'assigned_by',
                'discussion_id',
                'discussion_name',
                DB::raw("'sub_discussion' as discussion_type"),
                'discussion_description',
                'due_date',
                'is_completed',
                'user_id',
                'priority',
                'sort_index',
                'created_at',
            ])
            ->whereHas('projectDetail')
            ->whereHas('section')
            ->whereHas('discussionDetail');

        if (!$isAdmin) {
            $subDiscussionsQuery->where('assignee_id', $userId);
        }

        if ($request->assignee_id) {
            $subDiscussionsQuery->where('assignee_id', $request->assignee_id);
        }

        if ($request->task_type) {
            if (in_array($request->task_type, ['pending', 'upcoming'])) {
                $subDiscussionsQuery->where('is_completed', 0)
                    ->where(function($qr) use ($dtNow) {
                        $qr->whereNull('due_date')
                           ->orWhere('due_date', '>=', $dtNow);
                    });
            } elseif ($request->task_type == 'overdue') {
                $subDiscussionsQuery->where('is_completed', 0)
                    ->whereNotNull('due_date')
                    ->where('due_date', '<', $dtNow);
            } elseif ($request->task_type == 'completed') {
                $subDiscussionsQuery->where('is_completed', 1);
            }
        }

        // Total count (fast): do two separate counts instead of COUNT(*) over UNION
        $total = (clone $discussionsQuery)->toBase()->count() + (clone $subDiscussionsQuery)->toBase()->count();

        $unionQuery = $discussionsQuery->unionAll($subDiscussionsQuery);

        $outer = DB::query()
            ->fromSub($unionQuery, 'tasks')
            ->select('tasks.*');

        // Lightweight joins only for sorting by related columns
        if ($sortBy === 'project') {
            $outer->leftJoin('projects as sort_projects', 'sort_projects.id', '=', 'tasks.project_id');
        }
        if ($sortBy === 'assigned_by') {
            $outer->leftJoin('users as sort_assigned_by_users', 'sort_assigned_by_users.id', '=', 'tasks.assigned_by');
        }

        if ($sortBy === 'due_date') {
            // Put null due dates last, then sort by actual date
            $outer->orderByRaw('tasks.due_date IS NULL ASC');
            $outer->orderBy('tasks.due_date', $sortDir);
            // Tie-breaker
            $outer->orderBy('tasks.created_at', 'desc');
        } elseif ($sortBy === 'project') {
            $outer->orderBy('sort_projects.project_name', $sortDir);
            $outer->orderBy('tasks.created_at', 'desc');
        } elseif ($sortBy === 'assigned_by') {
            $outer->orderBy('sort_assigned_by_users.name', $sortDir);
            $outer->orderBy('tasks.created_at', 'desc');
        } else {
            $outer->orderBy('tasks.'.$sortBy, $sortDir);
            if ($sortBy !== 'created_at') {
                $outer->orderBy('tasks.created_at', 'desc');
            }
        }

        $page = (int) ($request->get('page', 1) ?: 1);
        $page = max(1, $page);

        $items = $outer
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get();

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $total,
            $limit,
            $page,
            [
                'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
                'query' => $request->query(),
            ]
        );
    }
    public function getMyAllTasks($request)
    {
        $userId = auth()->user()->id;
        $isAdmin = $userId == 1;
        // $isAdmin = $userId == 1 || auth()->user()->hasRole('Super Admin') || auth()->user()->can('view systemadmin dashboard');
        $dtNow = Carbon::now()->toDateString();

        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = strtolower($request->get('sort_dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        $allowedSortBy = [
            'created_at',
            'discussion_name',
            'due_date',
            'project',
            'assigned_by',
        ];

        if (!in_array($sortBy, $allowedSortBy, true)) {
            $sortBy = 'created_at';
        }

        $discussionsQuery = $this->pm_section_discussion
            ->select([
                'id',
                'section_id',
                'project_id',
                'assignee_id',
                'assigned_by',
                DB::raw('NULL as discussion_id'),
                'discussion_name',
                DB::raw("'discussion' as discussion_type"),
                'discussion_description',
                'due_date',
                'is_completed',
                'user_id',
                'priority',
                'sort_index',
                'created_at',
            ])
            ->whereHas('projectDetail')
            ->whereHas('section');

        if (!$isAdmin) {
            $discussionsQuery->where('assignee_id', $userId);
        }

        if ($request->filled('assignee_id')) {
            $discussionsQuery->where('assignee_id', $request->assignee_id);
        }

        if ($request->filled('task_type')) {
            if (in_array($request->task_type, ['pending', 'upcoming'])) {
                $discussionsQuery->where('is_completed', 0)
                    ->where(function ($qr) use ($dtNow) {
                        $qr->whereNull('due_date')
                            ->orWhere('due_date', '>=', $dtNow);
                    });
            } elseif ($request->task_type == 'overdue') {
                $discussionsQuery->where('is_completed', 0)
                    ->whereNotNull('due_date')
                    ->where('due_date', '<', $dtNow);
            } elseif ($request->task_type == 'completed') {
                $discussionsQuery->where('is_completed', 1);
            }
        }

        $subDiscussionsQuery = $this->pm_section_sub_discussion
            ->select([
                'id',
                'section_id',
                'project_id',
                'assignee_id',
                'assigned_by',
                'discussion_id',
                'discussion_name',
                DB::raw("'sub_discussion' as discussion_type"),
                'discussion_description',
                'due_date',
                'is_completed',
                'user_id',
                'priority',
                'sort_index',
                'created_at',
            ])
            ->whereHas('projectDetail')
            ->whereHas('section')
            ->whereHas('discussionDetail');

        if (!$isAdmin) {
            $subDiscussionsQuery->where('assignee_id', $userId);
        }

        if ($request->filled('assignee_id')) {
            $subDiscussionsQuery->where('assignee_id', $request->assignee_id);
        }

        if ($request->filled('task_type')) {
            if (in_array($request->task_type, ['pending', 'upcoming'])) {
                $subDiscussionsQuery->where('is_completed', 0)
                    ->where(function ($qr) use ($dtNow) {
                        $qr->whereNull('due_date')
                            ->orWhere('due_date', '>=', $dtNow);
                    });
            } elseif ($request->task_type == 'overdue') {
                $subDiscussionsQuery->where('is_completed', 0)
                    ->whereNotNull('due_date')
                    ->where('due_date', '<', $dtNow);
            } elseif ($request->task_type == 'completed') {
                $subDiscussionsQuery->where('is_completed', 1);
            }
        }

        $unionQuery = $discussionsQuery->unionAll($subDiscussionsQuery);

        $outer = DB::query()
            ->fromSub($unionQuery, 'tasks')
            ->select('tasks.*');

        if ($sortBy === 'project') {
            $outer->leftJoin('projects as sort_projects', 'sort_projects.id', '=', 'tasks.project_id');
        }

        if ($sortBy === 'assigned_by') {
            $outer->leftJoin('users as sort_assigned_by_users', 'sort_assigned_by_users.id', '=', 'tasks.assigned_by');
        }

        if ($sortBy === 'due_date') {
            $outer->orderByRaw('tasks.due_date IS NULL ASC');
            $outer->orderBy('tasks.due_date', $sortDir);
            $outer->orderBy('tasks.created_at', 'desc');
        } elseif ($sortBy === 'project') {
            $outer->orderBy('sort_projects.project_name', $sortDir);
            $outer->orderBy('tasks.created_at', 'desc');
        } elseif ($sortBy === 'assigned_by') {
            $outer->orderBy('sort_assigned_by_users.name', $sortDir);
            $outer->orderBy('tasks.created_at', 'desc');
        } else {
            $outer->orderBy('tasks.' . $sortBy, $sortDir);

            if ($sortBy !== 'created_at') {
                $outer->orderBy('tasks.created_at', 'desc');
            }
        }

        return $outer->get();
    }

    public function getPaginatedMyTasks($request, $limit = 20)
    {
        $today    = now()->toDateString();
        $taskType = $request->get('task_type');
        $perPage  = (int) $request->get('per_page', $limit);

        $query = $this->pm_inbox
            ->with([
                'discussion:id,discussion_name,due_date,is_completed,priority,assignee_id',
                'discussion.assigneeUser:id,name,profile_pic',
                'subDiscussion:id,discussion_name,due_date,is_completed,priority,assignee_id',
                'subDiscussion.assigneeUser:id,name,profile_pic',
                'assignedByUser:id,name,profile_pic',
                'projectDetail:id,project_name,project_type_id,product_id,product_level,project_color,project_icon_url',
                'projectDetail.productTemp:id,product_name,product_no',
                'projectDetail.subProductTemp:id,product_name,product_no',
            ])
            ->where('user_id', auth()->id());

        if ($taskType === 'completed') {

            $query->where(function ($q) {
                $q->where(function ($q2) {
                    $q2->where('is_sub_discussion', 0)
                    ->whereHas('discussion', fn($d) => $d->where('is_completed', 1));
                })->orWhere(function ($q2) {
                    $q2->where('is_sub_discussion', 1)
                    ->whereHas('subDiscussion', fn($d) => $d->where('is_completed', 1));
                });
            });

        } elseif ($taskType === 'overdue') {

            $query->where(function ($q) use ($today) {
                $q->where(function ($q2) use ($today) {
                    $q2->where('is_sub_discussion', 0)
                    ->whereHas('discussion', fn($d) =>
                        $d->where('is_completed', 0)
                            ->whereNotNull('due_date')
                            ->where('due_date', '<', $today)
                    );
                })->orWhere(function ($q2) use ($today) {
                    $q2->where('is_sub_discussion', 1)
                    ->whereHas('subDiscussion', fn($d) =>
                        $d->where('is_completed', 0)
                            ->whereNotNull('due_date')
                            ->where('due_date', '<', $today)
                    );
                });
            });

        } elseif ($taskType === 'upcoming') {

            $query->where(function ($q) use ($today) {
                $q->where(function ($q2) use ($today) {
                    $q2->where('is_sub_discussion', 0)
                    ->whereHas('discussion', fn($d) =>
                        $d->where('is_completed', 0)
                            ->where(fn($x) => $x->whereNull('due_date')
                                                ->orWhere('due_date', '>=', $today))
                    );
                })->orWhere(function ($q2) use ($today) {
                    $q2->where('is_sub_discussion', 1)
                    ->whereHas('subDiscussion', fn($d) =>
                        $d->where('is_completed', 0)
                            ->where(fn($x) => $x->whereNull('due_date')
                                                ->orWhere('due_date', '>=', $today))
                    );
                });
            });

        }

        return $query->orderByDesc('created_at')->paginate($perPage);
    }

public function newGetPaginatedMyTasks(array $filters = [], int $perPage = 20)
{
    $today = now()->toDateString();
    $taskType = $filters['task_type'] ?? null;

    $query = $this->pm_inbox
        ->with([
            'discussion:id,discussion_name,due_date,is_completed,priority,assignee_id',
            'discussion.assigneeUser:id,name,profile_pic',
            'subDiscussion:id,discussion_name,due_date,is_completed,priority,assignee_id',
            'subDiscussion.assigneeUser:id,name,profile_pic',
            'assignedByUser:id,name,profile_pic',
            'projectDetail:id,project_name,project_type_id,product_id,product_level',
            'projectDetail.productTemp:id,product_name,product_no',
            'projectDetail.subProductTemp:id,product_name,product_no',
        ])
        ->where('user_id', auth()->id());

    // Apply status filter at the DB level
    if ($taskType === 'completed') {
        $query->whereHas('discussion', fn($q) => $q->where('is_completed', 1))
              ->orWhereHas('subDiscussion', fn($q) => $q->where('is_completed', 1));

    } elseif ($taskType === 'overdue') {
        $query->where(function ($q) use ($today) {
            $q->whereHas('discussion', fn($sq) =>
                $sq->where('is_completed', 0)->where('due_date', '<', $today)
            )->orWhereHas('subDiscussion', fn($sq) =>
                $sq->where('is_completed', 0)->where('due_date', '<', $today)
            );
        });

    } elseif ($taskType === 'upcoming') {
        $query->where(function ($q) use ($today) {
            $q->whereHas('discussion', fn($sq) =>
                $sq->where('is_completed', 0)
                   ->where(fn($d) => $d->whereNull('due_date')->orWhere('due_date', '>=', $today))
            )->orWhereHas('subDiscussion', fn($sq) =>
                $sq->where('is_completed', 0)
                   ->where(fn($d) => $d->whereNull('due_date')->orWhere('due_date', '>=', $today))
            );
        });
    }

    return $query->orderByDesc('created_at')->paginate($perPage);
}

    public function changeMyTaskCompleteStatus($request, $taskId)
    {
        $task = $this->pm_section_discussion->find($taskId);
        $task->update($request->all());
    }

    // public function getProjectManagementByProjectId($projectId)
    // {
    //     return $this->pm_section->with(['discussions' => function($query) {
    //         $query->orderBy('sort_index', 'asc');
    //     }, 'discussions.comments', 'discussions.assigneeUser', 'discussions.subDiscussions' => function($query) {
    //         $query->orderBy('sort_index', 'asc');
    //     }])->where('project_id', $projectId)->orderBy('sort_index', 'asc')->get();
    // }
    public function getProjectManagementByProjectId($projectId)
    {
        // $sections = $this->pm_section->with([
        //     'discussions' => function($query) {
        //         $query->orderBy('sort_index', 'asc');
        //     },
        //     'discussions.comments',
        //     'discussions.assigneeUser',
        //     'discussions.subDiscussions' => function($query) {
        //         $query->orderBy('sort_index', 'asc');
        //     }
        // ])
        // ->where('project_id', $projectId)
        // ->orderBy('sort_index', 'asc')
        // ->get();

        // Load sections only (no task data — tasks are lazy-loaded per section on expand).
        // Paginated at 20 sections per page to avoid loading 1000+ sections at once.
        $sections = $this->pm_section
            ->where('project_id', $projectId)
            ->orderBy('sort_index', 'asc')
            ->paginate(10);

        foreach ($sections as $section) {
            $section->can_delete_section =
                auth()->user()->can('delete-section', $section);
        }

        return $sections;
    }
    public function getOrderProjectList($projectId,$orderId)
    {

        $sections = $this->pm_section
            ->where('project_id', $projectId)->where('order_id', $orderId)
            ->orderBy('sort_index', 'asc')->get();

        foreach ($sections as $section) {
            $section->can_delete_section =
                auth()->user()->can('delete-section', $section);
        }

        return $sections;
    }

    // public function getProjectManagementSectionById($sectionId)
    // {
    //     return $this->pm_section->with(['discussions' => function($query) {
    //         $query->orderBy('sort_index', 'asc');
    //     }, 'discussions.comments', 'discussions.assigneeUser', 'discussions.subDiscussions' => function($query) {
    //         $query->orderBy('sort_index', 'asc');
    //     }])->find($sectionId);
    // }

    public function getProjectManagementSectionById($sectionId)
    {
        $section = $this->pm_section->with([
            'discussions' => function($query) {
                $query->orderBy('sort_index', 'asc');
            },
            'discussions.comments',
            'discussions.assigneeUser',
            'discussions.subDiscussions' => function($query) {
                $query->orderBy('sort_index', 'asc');
            }
        ])->find($sectionId);

        // section permission
        $section->can_delete_section =
            auth()->user()->can('delete-section', $section);

        foreach ($section->discussions as $discussion) {

            // discussion permission
            $discussion->can_delete_discussion =
                auth()->user()->can('delete-discussion', $discussion);

            foreach ($discussion->subDiscussions as $subDiscussion) {

                // sub discussion permission
                $subDiscussion->can_delete_sub_discussion =
                    auth()->user()->can('delete-sub-discussion', $subDiscussion);
            }
        }

        return $section;
    }

    public function projectManagementSectionStore($data)
    {
        $data['user_id'] = auth()->id();

        $maxSortIndex = $this->pm_section
            ->where('project_id', $data['project_id'])
            ->max('sort_index') ?? 0;

        $data['sort_index'] = $maxSortIndex + 1;

        $section = $this->pm_section->create($data);

        $section->can_delete_section = auth()->user()->can('delete section');

        return $section;
    }

    public function projectManagementSectionUpdate($data, $id)
    {
        $pm_section = $this->pm_section->find($id);
        return $pm_section->update($data);
    }

    public function projectManagementSectionDelete($id)
    {
        $pm_section = $this->pm_section->find($id);
        $pm_section->delete();
    }

    // public function getprojectManagementSectionDiscussionById($id)
    // {
    //     $discussionData = $this->pm_section_discussion->with('projectDetail', 'comments.userInfo')->find( $id);
    //     $projectAssignees = $this->getAssignees($discussionData->project_id);
    //     $projectAssigneeInfo = [];
    //     foreach($projectAssignees[0] as $projectAssignee){
    //         $projectAssigneeInfo[] = array('id'=>$projectAssignee['id'], 'name'=>$projectAssignee['name'], 'profile_pic'=>$projectAssignee['image']);
    //     }

    //     return [$discussionData, $projectAssigneeInfo];
    // }

    public function getprojectManagementSectionDiscussionById($id)
    {
        $discussionData = $this->pm_section_discussion
            ->with([
                'projectDetail',
                'comments.userInfo'
            ])
            ->find($id);

        foreach ($discussionData->comments as $comment) {

            $comment->can_delete_comment = auth()->user()->can('delete-comment', $comment);
            $comment->can_edit_comment = auth()->user()->can('edit-comment', $comment);
            $comment->reactions_grouped = $comment->reactions_grouped;
            $comment->user_reaction = $comment->user_reaction;
        }

        $projectAssignees = $this->getAssignees($discussionData->project_id);
        $projectAssigneeInfo = [];

        foreach($projectAssignees[0] as $projectAssignee){
            $projectAssigneeInfo[] = [
                'id' => $projectAssignee['id'],
                'name' => $projectAssignee['name'],
                'profile_pic' => $projectAssignee['image']
            ];
        }

        return [$discussionData, $projectAssigneeInfo];
    }

    public function projectManagementSectionDiscussionStore($data)
    {
        $data['user_id'] = auth()->id();

        // Set sort_index to be the next available index for this section
        $maxSortIndex = $this->pm_section_discussion->where('section_id', $data['section_id'])->max('sort_index') ?? 0;
        $data['sort_index'] = $maxSortIndex + 1;

        return $this->pm_section_discussion->create($data);
    }

    public function projectManagementSectionDiscussionUpdate($data, $id)
    {
        if (isset($data['assignee_id'])) {
            $data['assigned_by'] = auth()->user()->id;
        }
        $pm_section_discussion = $this->pm_section_discussion->find($id);
        $pm_section_discussion->update($data);
        return $pm_section_discussion;
    }

    public function projectManagementSectionDiscussionDelete($id)
    {
        $pm_section_discussion = $this->pm_section_discussion->find($id);
        $pm_section_discussion->delete();
    }

    public function getprojectManagementSectionSubDiscussionByDiscussionId($id)
    {
        $discussion = $this->pm_section_discussion
        ->with([
            'subDiscussions' => function ($query) {
                $query->orderBy('sort_index', 'asc');
            },
            'subDiscussions.projectDetail',
            'subDiscussions.section',
            'subDiscussions.assigneeUser',
            'subDiscussions.comments.userInfo'
        ])
        ->find($id);

        foreach ($discussion->subDiscussions as $subDiscussion) {

            $subDiscussion->can_delete_sub_discussion =
                auth()->user()->can('delete-sub-discussion', $subDiscussion);
        }

        return $discussion;
    }

    public function getprojectManagementMyTaskSubDiscussionByDiscussionId($id)
    {
        return $this->pm_section_discussion->with('mySubDiscussions.projectDetail', 'mySubDiscussions.section', 'mySubDiscussions.assigneeUser', 'mySubDiscussions.comments.userInfo')->find($id);
    }

    // public function getprojectManagementSectionSubDiscussionById($id)
    // {
    //     $discussionData = $this->pm_section_sub_discussion->with('projectDetail', 'section', 'assigneeUser', 'comments.userInfo')->find($id);
    //     $projectAssignees = $this->getAssignees($discussionData->project_id);
    //     $projectAssigneeInfo = [];
    //     foreach($projectAssignees[0] as $projectAssignee){
    //         $projectAssigneeInfo[] = array('id'=>$projectAssignee['id'], 'name'=>$projectAssignee['name'], 'profile_pic'=>$projectAssignee['image']);
    //     }
    //     return [$discussionData, $projectAssigneeInfo];
    // }

    public function getprojectManagementSectionSubDiscussionById($id)
    {
        $discussionData = $this->pm_section_sub_discussion
            ->with([
                'projectDetail',
                'section',
                'assigneeUser',
                'comments.reactions',
                'comments.userInfo'
            ])
            ->find($id);

        foreach ($discussionData->comments as $comment) {

            $comment->can_delete_comment =
                auth()->user()->can('delete-comment', $comment);

            $comment->can_edit_comment =
                auth()->user()->can('edit-comment', $comment);

            $comment->reactions_grouped =
                $comment->reactions_grouped;

            $comment->user_reaction =
                $comment->user_reaction;
        }

        $projectAssignees = $this->getAssignees($discussionData->project_id);

        $projectAssigneeInfo = [];

        foreach ($projectAssignees[0] as $projectAssignee) {

            $projectAssigneeInfo[] = [
                'id' => $projectAssignee['id'],
                'name' => $projectAssignee['name'],
                'profile_pic' => $projectAssignee['image']
            ];
        }

        return [$discussionData, $projectAssigneeInfo];
    }

    public function projectManagementSectionSubDiscussionStore($data)
    {
        $data['user_id'] = auth()->id();

        // Set sort_index to be the next available index for this discussion
        $maxSortIndex = $this->pm_section_sub_discussion->where('discussion_id', $data['discussion_id'])->max('sort_index') ?? 0;
        $data['sort_index'] = $maxSortIndex + 1;

        return $this->pm_section_sub_discussion->create($data);
    }

    public function projectManagementSectionSubDiscussionUpdate($data, $id)
    {
        if (isset($data['assignee_id'])) {
            $data['assigned_by'] = auth()->user()->id;
        }
        $pm_section_sub_discussion = $this->pm_section_sub_discussion->find($id);
        $pm_section_sub_discussion->update($data);
        return $pm_section_sub_discussion;
    }

    public function projectManagementSectionSubDiscussionDelete($id)
    {
        $pm_section_sub_discussion = $this->pm_section_sub_discussion->find($id);
        $pm_section_sub_discussion->delete();
    }

    public function getAllComments()
    {
        return $this->pm_section_discussion_comment->all();
    }

    // public function projectManagementSectionDiscussionCommentStore($data)
    // {
    //     $data['user_id'] = auth()->id();
    //     $data['date'] = Carbon::now()->toDateTimeString();
    //     if($data['discussion_type'] == 'sub_discussion'){
    //         $data['is_sub_discussion'] = 1;
    //         $data['sub_section_discussion_id'] = $data['section_discussion_id'];
    //         $data['section_discussion_id'] = null;
    //     }
    //     $comment = $this->pm_section_discussion_comment->create($data);
    //     return $this->pm_section_discussion_comment->with('userInfo', 'discussionInfo', 'subDiscussionInfo')->find($comment->id);
    // }
    public function projectManagementSectionDiscussionCommentStore($data)
    {
        $data['user_id'] = auth()->id();
        $data['date'] = Carbon::now()->toDateTimeString();

        if($data['discussion_type'] == 'sub_discussion'){

            $data['is_sub_discussion'] = 1;
            $data['sub_section_discussion_id'] = $data['section_discussion_id'];
            $data['section_discussion_id'] = null;
        }

        $comment = $this->pm_section_discussion_comment->create($data);

        $commentData = $this->pm_section_discussion_comment
            ->with('userInfo', 'discussionInfo', 'subDiscussionInfo')
            ->find($comment->id);

        /* DELETE COMMENT PERMISSION */
        $commentData->can_delete_comment =
            auth()->user()->can('delete-comment', $commentData);

        /* EDIT COMMENT PERMISSION */
        $commentData->can_edit_comment =
            auth()->user()->can('edit-comment', $commentData) ||
            auth()->id() == $commentData->user_id;

        // Clear draft comment if it exists
        if (isset($data['discussion_type']) && $data['discussion_type'] == 'sub_discussion') {
            $subSectionDiscussionId = $data['sub_section_discussion_id'] ?? ($data['section_discussion_id'] ?? null);
            $this->temp_pm_section_discussion_comment
                ->where('user_id', $data['user_id'])
                ->where('sub_section_discussion_id', $subSectionDiscussionId)
                ->delete();
        } else {
            $sectionDiscussionId = $data['section_discussion_id'] ?? null;
            $this->temp_pm_section_discussion_comment
                ->where('user_id', $data['user_id'])
                ->where('section_discussion_id', $sectionDiscussionId)
                ->delete();
        }

        return $commentData;
    }

    public function projectManagementSectionDiscussionCommentSaveDraft($data)
    {
        $userId = auth()->id();
        $data['user_id'] = $userId;
        $data['date'] = Carbon::now()->toDateTimeString();

        $discussionType = $data['discussion_type'] ?? 'discussion';

        if ($discussionType == 'sub_discussion') {
            $subSectionDiscussionId = $data['sub_section_discussion_id'] ?? ($data['section_discussion_id'] ?? null);

            $existingDraft = $this->temp_pm_section_discussion_comment
                ->where('user_id', $userId)
                ->where('sub_section_discussion_id', $subSectionDiscussionId)
                ->first();

            $saveData = [
                'project_id' => $data['project_id'] ?? null,
                'section_id' => $data['section_id'] ?? null,
                'section_discussion_id' => null,
                'is_sub_discussion' => 1,
                'sub_section_discussion_id' => $subSectionDiscussionId,
                'comment' => $data['comment'] ?? '',
                'date' => $data['date'],
                'mentioned_groups' => $data['mentioned_groups'] ?? null,
                'mentioned_users' => $data['mentioned_users'] ?? null,
                'user_id' => $userId,
            ];
        } else {
            $sectionDiscussionId = $data['section_discussion_id'] ?? null;

            $existingDraft = $this->temp_pm_section_discussion_comment
                ->where('user_id', $userId)
                ->where('section_discussion_id', $sectionDiscussionId)
                ->first();

            $saveData = [
                'project_id' => $data['project_id'] ?? null,
                'section_id' => $data['section_id'] ?? null,
                'section_discussion_id' => $sectionDiscussionId,
                'is_sub_discussion' => 0,
                'sub_section_discussion_id' => null,
                'comment' => $data['comment'] ?? '',
                'date' => $data['date'],
                'mentioned_groups' => $data['mentioned_groups'] ?? null,
                'mentioned_users' => $data['mentioned_users'] ?? null,
                'user_id' => $userId,
            ];
        }

        if ($existingDraft) {
            $existingDraft->update($saveData);
            return $existingDraft;
        } else {
            return $this->temp_pm_section_discussion_comment->create($saveData);
        }
    }

    public function projectManagementSectionDiscussionCommentGetDraft($discussion_id, $discussion_type)
    {
        $userId = auth()->id();

        if ($discussion_type == 'sub_discussion') {
            $draft = $this->temp_pm_section_discussion_comment
                ->where('user_id', $userId)
                ->where('sub_section_discussion_id', $discussion_id)
                ->first();
        } else {
            $draft = $this->temp_pm_section_discussion_comment
                ->where('user_id', $userId)
                ->where('section_discussion_id', $discussion_id)
                ->first();
        }

        return $draft;
    }

    // public function projectManagementSectionDiscussionCommentUpdate($data, $id)
    // {
    //     $pm_section_discussion_comment = $this->pm_section_discussion_comment->find($id);
    //     $pm_section_discussion_comment->update($data);
    //     return $this->pm_section_discussion_comment->with('userInfo')->find($id);
    // }

    public function projectManagementSectionDiscussionCommentUpdate($data, $id)
    {
        $comment = $this->pm_section_discussion_comment->find($id);

        if (!$comment) {
            return false;
        }

        $oldHtml = $comment->comment;
        $newHtml = $data['comment'];

        $oldImages = [];
        $newImages = [];

        preg_match_all('/<img[^>]+src="([^"]+)"/i', $oldHtml, $oldMatches);
        preg_match_all('/<img[^>]+src="([^"]+)"/i', $newHtml, $newMatches);

        $oldImages = $oldMatches[1] ?? [];
        $newImages = $newMatches[1] ?? [];

        // Images removed by user
        $deletedImages = array_diff($oldImages, $newImages);

        foreach ($deletedImages as $imageUrl) {

            $path = parse_url($imageUrl, PHP_URL_PATH);

            $path = urldecode($path);

            // remove "/Encore-Cloud/"
            $path = str_replace('/Encore-Cloud/', '', $path);

            $fullPath = base_path($path);

            if (file_exists($fullPath)) {

                @unlink($fullPath);

                logger('Deleted Image: '.$fullPath);
            }
        }

        $comment->update($data);

        $commentData = $this->pm_section_discussion_comment
            ->with('userInfo')
            ->find($id);

        $commentData->can_delete_comment =
            auth()->user()->can('delete-comment', $commentData);

        $commentData->can_edit_comment =
            auth()->user()->can('edit-comment', $commentData)
            || auth()->id() == $commentData->user_id;

        return $commentData;
    }

    public function projectManagementSectionDiscussionCommentDelete($id)
    {
        $comment = $this->pm_section_discussion_comment->find($id);

        if (!$comment) {
            return false;
        }

        $html = $comment->comment;

        libxml_use_internal_errors(true);

        $dom = new \DOMDocument();
        $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        // Delete images
        foreach ($dom->getElementsByTagName('img') as $img) {

            $src = $img->getAttribute('src');

            if (!$src) {
                continue;
            }

            $fileName = basename(parse_url($src, PHP_URL_PATH));

            $projectPath = public_path('../assets/Product Master Temp');

            $files = glob($projectPath . '/*/discussion/' . $fileName);

            foreach ($files as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }

        // Delete attachments
        foreach ($dom->getElementsByTagName('a') as $a) {

            $href = $a->getAttribute('href');

            if (!$href) {
                continue;
            }

            $fileName = basename(parse_url($href, PHP_URL_PATH));

            $projectPath = public_path('../assets/Product Master Temp');

            $files = glob($projectPath . '/*/discussion/' . $fileName);

            foreach ($files as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }

        $comment->delete();

        return true;
    }

    public function getProjectManagementSectionAssigneesById($id)
    {
        $sectionDiscussionAssigneeIds = $this->pm_section_discussion->where('section_id', $id)->pluck('assignee_id');
        $sectionSubDiscussionAssigneeIds = $this->pm_section_sub_discussion->where('section_id', $id)->pluck('assignee_id');
        $allAssigneeIds = $sectionDiscussionAssigneeIds->merge($sectionSubDiscussionAssigneeIds)->unique()->filter()->values()->toArray();
        $assigneeDefaultImage = 'assets/img/user/default.png';
        $assignedUsers = $this->user->select('profile_pic')->whereIn('id', $allAssigneeIds)->get();
        return $assignedUsers;
    }

    public function get_all_project_icons(){
        return $this->project_icon->all();
    }

    public function get_project_icon_by_id($id){
        return $this->project_icon->find($id);
    }

    public function project_icons_create($imagePath)
    {
        return $this->project_icon->create(['icon'=>$imagePath]);
    }

    public function project_icons_update($imagePath, $projectIconId)
    {
        $projectIcon = $this->project_icon->find($projectIconId);
        $projectIcon->update(['icon'=>$imagePath]);
    }

    public function project_icons_delete($id)
    {
        $projectIcon = $this->project_icon->find($id);
        $projectIcon->delete();
    }

    public function sendNotificationOverdueDiscussion($nowDate)
    {
        $discussions = $this->pm_section_discussion->where('due_date', '<', $nowDate)->where('is_completed', 0)->get();
        foreach($discussions as $discussion){
            $section = $discussion->section;
            if ($section && !is_null($section->order_id)) {
                continue; // Skip notifications for order-linked sections
            }
            $this->projectManagementNotifyOverdueDiscussion($discussion->assignee_id, $discussion);
        }
    }

    public function sendNotificationOverdueSubDiscussion($nowDate)
    {
        $subDiscussions = $this->pm_section_sub_discussion->where('due_date', '<', $nowDate)->where('is_completed', 0)->get();
        foreach($subDiscussions as $subDiscussion){
            $section = $subDiscussion->section;
            if ($section && !is_null($section->order_id)) {
                continue; // Skip notifications for order-linked sections
            }
            $this->projectManagementNotifyOverdueSubDiscussion($subDiscussion->assignee_id, $subDiscussion);
        }
    }

    public function projectManagementNotifyProjectAssignee($notify_user_id, $data)
    {
        $avatarsHtml = $this->buildProjectAssigneeAvatars($data->project_assignee);
        $tasksHtml = $this->buildProjectTasksHtml($data->id);
        $user = auth()->user();

        $openDiscussionsCount = PmSectionDiscussion::where('project_id', $data->id)->where('is_completed', 0)->count();
        $openSubDiscussionsCount = PmSectionSubDiscussion::where('project_id', $data->id)->where('is_completed', 0)->count();
        $taskCount = $openDiscussionsCount + $openSubDiscussionsCount;

        $this->notification_builder->sendNotification('key_assign_project', [
            '{project_name}' => $data->project_name,
            '{project_level}' => $data->stage_status ?? '',
            '{assinged_name}' => $user ? $user->name : '',
            '{task_count}' => $taskCount,
            '{project_description}' => $data->project_description ?? 'No description provided.',
            '{user_name}' => $user ? $user->name : '',
            '{team_name}' => 'Project Management',
            '{assinged_pic}' => url($user->profile_pic),
            '{assinged_by}' => $user ? $user->name : '',
            '{openProjectLink}' =>  url('/projects/view-temp').'/'. $data->id,
            '{project_avatars}' => $avatarsHtml,
            '{tasks_html}' => $tasksHtml,
        ], [
            'project_id' => $data->id,
            'user_id' => $notify_user_id,
            'target_notification_field' => 'key_assign_project',
            'new_notification' => 1
        ]);
    }
    public function projectManagementNotifyDiscussionAssignee($notify_user_id, $data)
    {
        $commentsHtml = $this->buildCommentsHtml($data->id);
        $user = User::find($data->assigned_by);
        $project = Project::find($data->project_id);


        $this->notification_builder->sendNotification('key_assign_task', [
            '{task_name}' => $data->discussion_name,
            '{priority}' => $data->priority,
            '{due_date}' => $data->due_date,
            '{project_name}' => $project->project_name,
            '{assinged_name}' => $user->name,
            '{team_name}' => 'Project Management',
            '{description}' => $data->discussion_description,
            '{user_name}' => auth()->user()->name,
            '{assigned_by}' => $user->name,
            '{assinged_pic}' => url($user->profile_pic),
            '{openTaskLink}' => url('/projects/my_tasks') .'?open_chat=true&type=' . urlencode('"discussion"') .'&discussion_id=' . $data->id,
            '{openProjectLink}' =>  url('/projects/view-temp').'/'. $data->project_id,
            '{comments_html}'  => $commentsHtml,


        ], [
            // 'project_id' => $data->project_id,
            'task_id' => $data->id,
            'task_name' => $data->discussion_name,
            'user_id' => $notify_user_id,
            'target_notification_field' => 'key_assign_task',
            'new_notification' => 1
        ]);

        // logger($commentsHtml);

        $this->makeInboxRecord($notify_user_id, $data);
    }

    public function projectManagementNotifyOverdueDiscussion($notify_user_id, $data)
    {
        $commentsHtml = $this->buildCommentsHtml($data->id);
        $user = User::find($data->assigned_by);
        $project = Project::find($data->project_id);
        $assingedBy = User::find($data->assigned_by);

        $this->notification_builder->sendNotification('key_overdue_task', [
            '{task_name}' => $data->discussion_name,
            '{priority}' => $data->priority,
            '{due_date}' => $data->due_date,
            '{project_name}' => $project->project_name,
            '{assigned_name}' => $user->name,
            '{assigned_by}' => $assingedBy->name,
            '{assinged_pic}' => url($user->profile_pic),
            '{team_name}' => 'Project Management',
            '{description}' => $data->discussion_description,
            '{overdue_title}' => 'Overdue Task - Action Required',
            '{openTaskLink}' => url('/projects/my_tasks') .'?open_chat=true&type=' . urlencode('"discussion"') .'&discussion_id=' . $data->id,
            '{openProjectLink}' =>  url('/projects/view-temp').'/'. $data->project_id,
            '{comments_html}' => $commentsHtml,
        ], [
            // 'project_id' => $data->project_id,
            'task_id' => $data->id,
            'user_id' => $notify_user_id,
            'is_task_due' => 1,
            'target_notification_field' => 'key_overdue_task',
            'new_notification' => 1
        ]);
    }

    public function projectManagementNotifySubDiscussionAssignee($notify_user_id, $data)
    {
        $commentsHtml = $this->buildCommentsHtml($data->id, true);
        $user = User::find($data->assigned_by);
        $project = Project::find($data->project_id);

        $this->notification_builder->sendNotification('key_sub_assign_task', [
            '{task_name}' => $data->discussion_name,
            '{priority}' => $data->priority,
            '{due_date}' => $data->due_date,
            '{project_name}' => $project->project_name,
            '{assinged_name}' => $user->name,
            '{team_name}' => 'Project Management',
            '{description}' => $data->discussion_description,
            '{user_name}' => auth()->user()->name,
            '{assigned_by}' => $user->name,
            '{assinged_pic}' => url($user->profile_pic),
            '{openTaskLink}' => url('/projects/my_tasks') .'?open_chat=true&type=' . urlencode('"sub_discussion"') .'&discussion_id=' . $data->id,
            '{openProjectLink}' =>  url('/projects/view-temp').'/'. $data->project_id,
            '{comments_html}' => $commentsHtml,
        ], [
            // 'project_id' => $data->project_id,
            'sub_task_id' => $data->id,
            'user_id' => $notify_user_id,
            'target_notification_field' => 'key_sub_assign_task',
            'new_notification' => 1
        ]);

        $this->makeInboxRecord($notify_user_id, $data);
    }

    public function projectManagementNotifyOverdueSubDiscussion($notify_user_id, $data)
    {
        $commentsHtml = $this->buildCommentsHtml($data->id, true);
        $user = User::find($data->assigned_by);
        $project = Project::find($data->project_id);
        $assingedBy = User::find($data->assigned_by);

        $this->notification_builder->sendNotification('key_overdue_sub_task', [
           '{task_name}' => $data->discussion_name,
            '{priority}' => $data->priority,
            '{due_date}' => $data->due_date,
            '{project_name}' => $project->project_name,
            '{assigned_name}' => $user->name,
            '{assigned_by}' => $assingedBy->name,
            '{assinged_pic}' => url($user->profile_pic),
            '{team_name}' => 'Project Management',
            '{description}' => $data->discussion_description,
            '{overdue_title}' => 'Overdue Sub Task - Action Required',
            '{openTaskLink}' => url('/projects/my_tasks') .'?open_chat=true&type=' . urlencode('"sub_discussion"') .'&discussion_id=' . $data->id,
            '{openProjectLink}' =>  url('/projects/view-temp').'/'. $data->project_id,
            '{comments_html}' => $commentsHtml,
        ], [
            // 'project_id' => $data->project_id,
            'sub_task_id' => $data->id,
            'user_id' => $notify_user_id,
            'is_subtask_due' => 1,
            'target_notification_field' => 'key_overdue_sub_task',
            'new_notification' => 1
        ]);
    }

    public function projectManagementNotifyTaskComentMentionedUser($notify_user_id, $data)
    {
        $commentsHtml = $this->generateCommentHtml($data->section_discussion_id);
        $project = Project::find($data->project_id);
        $mentionByUser = User::with('userDetails')->find($data->user_id);
        $user = User::with('userDetails')->find($data->user_id);
        $discussion_info = PmSectionDiscussion::find($data->section_discussion_id);

        $this->notification_builder->sendNotification(
            'key_task_coment_mentioned_user',
            [
                '{task_name}'    => $discussion_info->discussion_name,
                '{priority}'     => $discussion_info->priority,
                '{due_date}'     => $discussion_info->due_date,
                '{project_name}' => $project->project_name,
                '{mention_by}'   => $mentionByUser->name,
                '{assinged_pic}' => url($user->profile_pic),
                '{team_name}'    => 'Project Management',
                '{user_name}'    => optional(auth()->user())->name ?? optional($data->user_info)->name,
                '{mention_user}'   => $mentionByUser->name,
                '{comments_html}' => $commentsHtml,
                '{openTaskLink}' => url('/projects/my_tasks') .'?open_chat=true&type=' . urlencode('"discussion"') .'&discussion_id=' . $data->section_discussion_id,
                '{openProjectLink}' =>  url('/projects/view-temp').'/'. $data->project_id
            ],
            [
                'task_id'            => $data->section_discussion_id,
                'comment_mention_id' => $data->id,
                'user_id'            => $notify_user_id,
                'target_notification_field' => 'key_task_coment_mentioned_user',
                'new_notification'   => 1,
            ]
        );

        $data->is_comment = true;

        $this->makeInboxRecord($notify_user_id, $data);
    }

    public function projectManagementNotifySubTaskComentMentionedUser($notify_user_id, $data)
    {
        $commentsHtml = $this->generateCommentHtml($data->sub_section_discussion_id,true);
        $project = Project::find($data->project_id);
        $mentionByUser = User::with('userDetails')->find($data->user_id);
        $user = User::with('userDetails')->find($data->user_id);
        $sub_discussion_info = PmSectionSubDiscussion::find($data->sub_section_discussion_id);


        $this->notification_builder->sendNotification(
            'key_sub_task_coment_mentioned_user',
            [
                '{task_name}'    => $sub_discussion_info->discussion_name,
                '{priority}'     => $sub_discussion_info->priority,
                '{due_date}'     => $sub_discussion_info->due_date,
                '{project_name}' => $project->project_name,
                '{mention_by}'   => $mentionByUser->name,
                '{assinged_pic}' => url($user->profile_pic),
                '{team_name}'    => 'Project Management',
                '{user_name}'    => $mentionByUser->name,
                '{mention_user}'   => $mentionByUser->name,
                '{comments_html}' => $commentsHtml,
                '{openTaskLink}' => url('/projects/my_tasks') .'?open_chat=true&type=' . urlencode('"sub_discussion"') .'&discussion_id=' . $data->sub_section_discussion_id,
                '{openProjectLink}' =>  url('/projects/view-temp').'/'. $data->project_id
            ],
            [
                'sub_task_id'        => $data->sub_section_discussion_id,
                'comment_mention_id' => $data->id,
                'user_id'            => $notify_user_id,
                'target_notification_field' => 'key_sub_task_coment_mentioned_user',
                'new_notification'   => 1,
            ]
        );

        $data->is_comment = true;
        $this->makeInboxRecord($notify_user_id, $data);
    }

    // Drag and Drop Reordering Methods
    public function reorderSections($projectId, $sectionIds)
    {
        try {
            foreach ($sectionIds as $index => $sectionId) {
                $this->pm_section->where('id', $sectionId)
                    ->where('project_id', $projectId)
                    ->update(['sort_index' => $index + 1]);
            }
            return ['success', 'Sections reordered successfully'];
        } catch (\Throwable $th) {
            return ['error', $th->getMessage()];
        }
    }

    public function reorderDiscussions($sectionId, $discussionIds)
    {
        try {
            foreach ($discussionIds as $index => $discussionId) {
                $this->pm_section_discussion->where('id', $discussionId)
                    ->where('section_id', $sectionId)
                    ->update(['sort_index' => $index + 1]);
            }
            return ['success', 'Discussions reordered successfully'];
        } catch (\Throwable $th) {
            return ['error', $th->getMessage()];
        }
    }

    public function reorderSubDiscussions($discussionId, $subDiscussionIds)
    {
        try {
            foreach ($subDiscussionIds as $index => $subDiscussionId) {
                $this->pm_section_sub_discussion->where('id', $subDiscussionId)
                    ->where('discussion_id', $discussionId)
                    ->update(['sort_index' => $index + 1]);
            }
            return ['success', 'Sub-discussions reordered successfully'];
        } catch (\Throwable $th) {
            return ['error', $th->getMessage()];
        }
    }

    public function makeInboxRecord($notify_user_id, $data)
    {
        $project_id = $data->project_id;
        $discussion_id = $data->id;
        $is_sub_discussion = 0;
        $sub_discussion_id = null;
        $is_comment = 0;
        $comment_id = null;
        if(isset($data->is_sub_discussion) && $data->is_sub_discussion == true){
            $discussion_id = $data->discussion_id;
            $is_sub_discussion = 1;
            $sub_discussion_id = $data->id;
        }
        if(isset($data->is_comment) && $data->is_comment == true){
            $project_id = $data->sectionInfo->project_id;
            $discussion_id = $data->section_discussion_id;
            $is_sub_discussion = $data->is_sub_discussion;
            $sub_discussion_id = $data->sub_section_discussion_id;
            $is_comment = 1;
            $comment_id = $data->id;
        }
        $inboxData = [
            'project_id' => $project_id,
            'section_id' => $data->section_id ?? null,
            'discussion_id' => $discussion_id,
            'is_sub_discussion' => $is_sub_discussion,
            'sub_discussion_id' => $sub_discussion_id,
            'is_comment' => $is_comment,
            'comment_id' => $comment_id,
            'user_id' => $notify_user_id,
            'assigned_by' => auth()->user()->id,
        ];
        $this->pm_inbox->create($inboxData);
    }

    public function makeTaskAssigneeRecord($notify_user_id, $data)
    {
        $discussion_id = $data->id;
        $is_sub_discussion = 0;
        $sub_discussion_id = null;
        if(isset($data->is_sub_discussion) && $data->is_sub_discussion == true){
            $discussion_id = $data->discussion_id;
            $is_sub_discussion = 1;
            $sub_discussion_id = $data->id;
        }
        $assigneeData = [
            'project_id' => $data->project_id,
            'section_id' => $data->section_id ?? null,
            'discussion_id' => $discussion_id,
            'is_sub_discussion' => $is_sub_discussion,
            'sub_discussion_id' => $sub_discussion_id,
            'assignee_id' => $notify_user_id,
            'assigned_by' => auth()->user()->id,
        ];
        $this->pm_task_assignee->create($assigneeData);
    }

    public function sectionCommentCount($sectionId) {
        $count = $this->pm_section_discussion_comment
            ->where('section_id', $sectionId)
            ->count();

        return [
            'section_id' => $sectionId,
            'count' => $count
        ];
    }


    public function discussionCount($sectionId) {
        $count = $this->pm_section_discussion
            ->where('section_id', $sectionId)
            ->count();

        return [
            'section_id' => $sectionId,
            'count' => $count
        ];
    }

    public function getSubSectionDiscussionCountById($id, $discussionId) {
        $count = $this->pm_section_sub_discussion
        ->where('section_id', $id)
        ->where('discussion_id', $discussionId)
            ->count();
        return [
            'discussion_id' => $discussionId,
            'count' => $count
        ];
    }

    public function getSubSectionDiscussionCommentCountById($id, $discussionId) {
        $count = $this->pm_section_discussion_comment
        ->where('section_id', $id)
        ->where('section_discussion_id', $discussionId)
            ->count();
        return [
            'discussion_id' => $discussionId,
            'count' => $count
        ];
    }

    public function projectManagementSectionDiscussionCommentTogglePin($comment_id)
    {
        $comment = $this->pm_section_discussion_comment->find($comment_id);

        if ($comment->is_pinned) {
            $comment->is_pinned = 0;
            $comment->pinned_at = null;
            $comment->pinned_by = null;
            $message = 'Comment unpinned successfully';
        } else {
            $comment->is_pinned = 1;
            $comment->pinned_at = now();
            $comment->pinned_by = auth()->id();
            $message = 'Comment pinned to top successfully';
        }

        $comment->save();

        return [
            'success' => true,
            'message' => $message,
            'comment' => $comment,
            'is_pinned' => $comment->is_pinned
        ];
    }


    public function toggleCommentReaction($commentId, $reactionType)
    {
        try {
            $comment = $this->pm_section_discussion_comment->findOrFail($commentId);
            $userId = auth()->id();

            // Find existing reaction
            $existingReaction = $this->commentReaction
                ->where('comment_id', $commentId)
                ->where('user_id', $userId)
                ->first();

            if ($existingReaction) {
                if (empty($reactionType) || $existingReaction->reaction_type === $reactionType) {

                    $existingReaction->delete();
                    $action = 'removed';
                } else {

                    $existingReaction->update(['reaction_type' => $reactionType]);
                    $action = 'updated';
                }
            } else {

                if (!empty($reactionType)) {
                    $this->commentReaction->create([
                        'comment_id' => $commentId,
                        'user_id' => $userId,
                        'reaction_type' => $reactionType,
                    ]);
                    $action = 'added';
                }
            }


            $reactionsGrouped = $comment->reactions_grouped;
            $userReaction = $comment->user_reaction;

            return [
                'success' => true,
                'action' => $action,
                'reactions' => $reactionsGrouped,
                'user_reaction' => $userReaction,
                'total_count' => array_sum($reactionsGrouped),
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }


    public function getProjects()
    {
        $userId = Auth::id();
        return Project::with([
            'projectType',
            'projectStatus',
            'projectCreatedBy'
            ])
            ->where(function ($query) use ($userId) {
                $query->where('created_by', $userId)
                ->orWhereRaw(
                    "FIND_IN_SET(?, project_assignee)",
                    [$userId]
                    );
                })
            ->orderByDesc('id')
            ->limit(6)
            ->get();
    }

    public function getTasksByStatus(string $status)
    {
        $discussionQuery = PmSectionDiscussion::query()
            ->with([
                'assigneeUser',
                'assignedUser',
                'projectDetail',
                'section',
                'subDiscussions'
            ])
            ->where('assignee_id', auth()->id());

        $subDiscussionQuery = PmSectionSubDiscussion::query()
            ->with([
                'assigneeUser',
                'assignedUser',
                'discussionDetail',
                'projectDetail',
                'section'
            ])
            ->where('assignee_id', auth()->id());

        switch ($status) {

            case 'upcoming':
                $discussionQuery->where('is_completed', 0)
                    ->whereDate('due_date', '>=', Carbon::today());

                $subDiscussionQuery->where('is_completed', 0)
                    ->whereDate('due_date', '>=', Carbon::today());
                break;

            case 'overdue':
                $discussionQuery->where('is_completed', 0)
                    ->whereDate('due_date', '<', Carbon::today());

                $subDiscussionQuery->where('is_completed', 0)
                    ->whereDate('due_date', '<', Carbon::today());
                break;

            case 'completed':
                $discussionQuery->where('is_completed', 1);

                $subDiscussionQuery->where('is_completed', 1);
                break;

            default:
                return [
                    'discussions' => collect(),
                    'sub_discussions' => collect(),
                ];
        }

        return [
            'discussions' => $discussionQuery->latest()->get(),
            'sub_discussions' => $subDiscussionQuery->latest()->get(),
        ];
    }


    private function buildProjectAssigneeAvatars($projectAssignee)
    {
        if (empty($projectAssignee)) {
            return '';
        }

        $userIds = array_filter(explode(',', $projectAssignee));

        $users = User::whereIn('id', $userIds)->get();

        $html = '';
        $maxToShow = 5;

        foreach ($users as $index => $user) {

            if ($index >= $maxToShow) {
                break;
            }

            $color = ['6366f1', '0d9488', 'f59e0b', 'dc2626', '3b82f6'][$index % 5];

            $pic = !empty($user->profile_pic)
                ? url($user->profile_pic)
                : 'https://ui-avatars.com/api/?name=' .
                    urlencode($user->name) .
                    '&background=' . $color .
                    '&color=fff&size=64';

            $html .= '
                <img
                    src="'.$pic.'"
                    alt="'.e($user->name).'"
                    title="'.e($user->name).'"
                    style="width:30px;height:30px;border-radius:50%;object-fit:cover;border:2px solid #fff;margin-left:-8px;">
            ';
        }

        if ($users->count() > $maxToShow) {

            $remaining = $users->count() - $maxToShow;

            $html .= '
                <div
                    style="width:30px;height:30px;border-radius:50%;background:#f3f4f6;border:2px solid #fff;margin-left:-8px;display:flex;align-items:center;justify-content:center;font-size:11.5px;font-weight:600;color:#4b5563;"
                    title="'.$remaining.' more users">
                    +'.$remaining.'
                </div>
            ';
        }

        return $html;
    }


    private function buildProjectTasksHtml($projectId)
    {
        $openTasks = PmSectionDiscussion::with('assignedUser')
            ->where('project_id', $projectId)
            ->where('is_completed', 0)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        if ($openTasks->isEmpty()) {
            return '
                <div style="padding:16px;text-align:center;color:#9ca3af;font-size:12.5px;">
                    No open tasks.
                </div>';
        }

        $html = '';

        foreach ($openTasks as $task) {

            $assignerName = optional($task->assignedUser)->name ?? 'Unknown';

            $date = $task->created_at->format('M j, Y \a\t g:i a');

            $html .= '
            <div style="padding:12px 16px;font-size:13px;color:#1f2937;border-bottom:1px solid #f0f0f0;">
                <div style="display:flex;align-items:center;gap:9px;">
                    <span style="width:7px;height:7px;border-radius:50%;background:#0d9488;flex-shrink:0;display:inline-block;"></span>
                    '.e($task->discussion_name).'
                </div>

                <div style="font-size:11.5px;color:#9ca3af;margin-top:4px;margin-left:16px;">
                    Assigned by: '.e($assignerName).' &nbsp;|&nbsp; '.$date.'
                </div>
            </div>';
        }

        return $html;
    }

   private function buildCommentsHtml($id, $isSubDiscussion = false)
    {
        $comments = PmSectionDiscussionComment::with('userInfo');

        if ($isSubDiscussion) {
            $comments->where('is_sub_discussion', 1)
                    ->where('sub_section_discussion_id', $id);
        } else {
            $comments->where('is_sub_discussion', 0)
                    ->where('section_discussion_id', $id);
        }

        $comments = $comments
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        if ($comments->isEmpty()) {
            return '
                <div style="padding:16px;text-align:center;color:#9ca3af;font-size:12.5px;">
                    No comments available.
                </div>';
        }

        $html = '';

        foreach ($comments as $comment) {

            $user = $comment->userInfo;

            $name = optional($user)->name ?? 'Unknown';

            $profile = $user && $user->profile_pic
                ? url($user->profile_pic)
                : 'https://ui-avatars.com/api/?name='.urlencode($name).'&background=6366f1&color=fff';

            $date = $comment->created_at->format('M d, Y \a\t g:i a');

            $html .= '
            <div style="padding:12px 16px;border-bottom:1px solid #f0f0f0;">

                <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;">
                    <img src="'.$profile.'"
                        style="width:24px;height:24px;border-radius:50%;object-fit:cover;">

                    <span style="font-size:11.5px;color:#9ca3af;">
                        '.$name.' &nbsp;|&nbsp; '.$date.'
                    </span>
                </div>

                <div style="font-size:13px;color:#1f2937;line-height:1.6;">
                    '.$comment->comment.'
                </div>

            </div>';
        }

        return $html;
    }


    private function generateCommentHtml($discussionId, $isSubDiscussion = false)
    {
        $query = PmSectionDiscussionComment::with('userInfo');

        if ($isSubDiscussion) {
            $query->where('is_sub_discussion', 1)
                ->where('sub_section_discussion_id', $discussionId);
        } else {
            $query->where('is_sub_discussion', 0)
                ->where('section_discussion_id', $discussionId);
        }

        $comments = $query->orderBy('created_at', 'desc')->limit(10)->get();

        if ($comments->isEmpty()) {
            return '
            <div style="padding:16px;text-align:center;color:#9ca3af;font-size:12.5px;">
                No comments available.
            </div>';
        }

        $html = '';

        foreach ($comments as $comment) {

            $user = $comment->userInfo;

            $name = optional($user)->name ?? 'Unknown User';

            $profilePic = ($user && $user->profile_pic)
                ? url($user->profile_pic)
                : 'https://ui-avatars.com/api/?name=' .
                    urlencode($name) .
                    '&background=6366f1&color=fff';

            $date = $comment->created_at->format('M d, Y \a\t g:i a');

            // Preserve Quill HTML (mentions, images, attachments, formatting)
            $commentHtml = $comment->comment;

            $html .= '
            <div style="padding:14px 16px;border-bottom:1px solid #f0f0f0;">

                <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">

                    <img
                        src="'.$profilePic.'"
                        style="width:28px;height:28px;border-radius:50%;object-fit:cover;">

                    <div>
                        <div style="font-size:13px;font-weight:600;color:#111827;">
                            '.$name.'
                        </div>

                        <div style="font-size:11px;color:#9ca3af;">
                            '.$date.'
                        </div>
                    </div>

                </div>

                <div class="notification-comment-body"
                    style="font-size:13px;color:#374151;line-height:1.7;">
                    '.$commentHtml.'
                </div>

            </div>';
        }

        return $html;
    }



}
