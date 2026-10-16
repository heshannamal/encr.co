<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EMSchedule;
use App\Models\User;
use App\Models\UserLeave;
use App\Traits\ProjectHelper;
use Carbon\Carbon;
use domainencore\Facades\ProjectFacade\ProjectFacade;
use domainencore\Services\ProjectService\ProjectService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserDashboardController extends Controller
{
    use ProjectHelper;
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index()
    {
        
        if (!auth()->user()->can('user dashboard')) {
            return response()->json('Access denied. You do not have permission to access the dashboard.');
        }

        $helper = $this;
        $activeUsers = User::select('id', 'name', 'profile_pic', 'user_role_id')->orderBy('name')->where('active', '1')->get();
        $activeUserGroups = Role::whereNotIn('id', [1])->where('active', '1')->orderBy('name')->get();
        foreach ($activeUsers as $user) {
            $userList = array('id' => $user->id, 'name' => $user->name, 'profile_pic' => $user->profile_pic);
            $userInfo[] = $userList;
        }
        return view('dashboards.normal_user_dashboard', compact('helper', 'activeUsers', 'activeUserGroups'));
    }

    public function getProjects(Request $request)
    {
        $projects = ProjectFacade::getProjects();

        return response()->json([
            'success' => true,
            'data' => $projects
        ]);
    }

    public function getTasks(Request $request)
    {
        $data = ProjectFacade::getTasksByStatus($request->status);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function myLeaves(Request $request)
    {
        $leaves = UserLeave::with('user')
            ->where('status', 1)
            ->where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $leaves
        ]);
    }

    public function myLeavesPending(Request $request)
    {
        $leaves = UserLeave::with('user')
            ->where('status', 0)
            ->where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $leaves
        ]);
    }

    public function othersLeaves()
    {

        $todayDMY = now()->format('d/m/Y');
        $todayMDY = now()->format('m/d/Y');

        $leaves = UserLeave::with('userDetails')
            ->where('status', 1)
            ->where(function ($query) use ($todayDMY, $todayMDY) {
                $query->whereIn('start_date', [$todayDMY, $todayMDY])
                    ->orWhereIn('end_date', [$todayDMY, $todayMDY]);
            })
            ->get();

        return response()->json([
            'success' => true,
            'data' => $leaves
        ]);
    }

    public function myMeetings()
    {
        $meetings = EMSchedule::where('user_id', auth()->id())
            ->orderByDesc('id')
            ->take(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $meetings
        ]);
    }
}
