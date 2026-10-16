<?php

namespace App\Traits;

use App\Models\PmTaskAssignee;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;

trait ProjectHelper
{
    public function getUserImage($userId)
    {
        $userImage = 'assets/img/user/default_muted.png';
        if($userId){
            $user = User::find($userId);
            if($user && $user->profile_pic){
                $userImage = $user->profile_pic;
            }
        }

        return $userImage;
    }

    public function getFormatedDate($date, $format)
    {
        return Carbon::parse($date)->format($format);
    }

    public function getReadableDate($timestamp)
    {
        $date = Carbon::parse($timestamp);

        if ($date->diffInMonths(now()) >= 1) {
            // More than 1 month ago → show normal date
            return $date->format('M j, Y'); // e.g. "Jun 3, 2024"
        }

        // Otherwise, show "x time ago"
        return $date->diffForHumans();
    }

    public function getGreetingTime()
    {
        $hour = Carbon::now()->format('H');

        if ($hour >= 5 && $hour < 12) {
            $greeting = 'Morning';
        } elseif ($hour >= 12 && $hour < 17) {
            $greeting = 'Afternoon';
        } elseif ($hour >= 17 && $hour < 21) {
            $greeting = 'Evening';
        } else {
            $greeting = 'Night';
        }

        return $greeting;
    }

    public function getProjectDetailsById($projectId)
    {
        return Project::withTrashed()->find($projectId);
    }

    public function getProjectNameById($projectId)
    {
        $projectName = '';
        $project = $this->getProjectDetailsById($projectId);
        if($project){
            if($project->project_type_id == 2){
                if($project->product){
                    $projectName = $project->product->product_name ?? $project->product->product_no;
                } else {
                    $projectName = 'N/A';
                }
            } else {
                $projectName = $project->project_name;
            }
        }
        return $projectName;
    }

    public function getTaskAssignedByUser($taskId, $discussionType, $assigneeId = null)
    {
        $assigneeId = $assigneeId ?? auth()->user()->id;
        $discussionQuery = PmTaskAssignee::where('assignee_id', $assigneeId);
        if($discussionType == 'sub_discussion'){
            $discussionQuery->where('is_sub_discussion', 1)->where('sub_discussion_id', $taskId);
        } else {
            $discussionQuery->where('is_sub_discussion', 0)->where('discussion_id', $taskId);
        }
        $discussion = $discussionQuery->orderByDesc('id')->first();

        if($discussion){
            if($discussion->assigned_by == auth()->user()->id){
                $user = new \stdClass();
                $user->profile_pic = auth()->user()->profile_pic;
                $user->name = 'You';
                return $user;
            } else {
                return User::select('profile_pic', 'name')->find($discussion->assigned_by);
            }
        }
        return null;
    }
}
