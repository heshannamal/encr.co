<?php

namespace App\Http\Controllers;

use App\Models\UserGroup;
use App\Models\ColumnLayout;
use App\Models\User;
use App\Models\UserGroupLayout;
use App\Models\UserGroupMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserGroupController extends Controller
{
    public function index(){
        if(auth()->user()->can('manage user group member')){
            // $userGroups = UserGroup::orderBy('user_group_name')->where('active', 1)->get();
            $userGroups = Role::orderBy('name')->where('active', 1)->get();

            $userGroupLayout = UserGroupLayout::where('user_id', Auth::user()->id)->first();

            $columnLayout = ColumnLayout::where('interface_id', 11)->where('user_id', Auth::user()->id)->first();

            return view('pages.users.user_groups.index', ['userGroups'=>$userGroups, 'userGroupLayout'=>$userGroupLayout, 'columnLayout'=>$columnLayout]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    // public function add(){
    //     return view('pages.users.user_groups.create');
    // }

    public function create(Request $request){
        $userGroup = new UserGroup();
        $userGroup->user_group_name = $request->new_user_group_name;
        $userGroup->narration = $request->new_narration;
        $userGroup->active = 1;
        $userGroup->save();

        return redirect()->route('user_groups')->withSuccess('User Group Saved Successfully!');
    }

    public function delete($id){
        $userGroup = UserGroup::find($id);
        $userGroup->active = 0;
        $userGroup->update();

        return redirect()->route('user_groups')->withSuccess('User Group Deleted Successfully!');
    }

    public function edit($userRoleId){
        $userGroup = UserGroup::find($userRoleId);
        return json_encode($userGroup);

        // return view('pages.users.user_groups.edit', ['userGroup'=>$userGroup]);
    }

    public function update(Request $request){
        $userGroup = UserGroup::find($request->user_group_id);
        $userGroup->user_group_name = $request->edit_user_group_name;
        $userGroup->narration = $request->edit_narration;
        $userGroup->update();

        return redirect()->route('user_groups')->withSuccess('User Group Updated Successfully!');
    }

    public function sortByAlphabet($id){
        $userGroups = UserGroup::where('user_group_name', 'LIKE', $id.'%')->where('active', 1)->orderBy('user_group_name')->get();

        return json_encode($userGroups);
    }

    public function layout(Request $request){
        if(UserGroupLayout::where('user_id', Auth::user()->id)->first()){
            $userRoleLayout = UserGroupLayout::find($request->layout_id);
            $userRoleLayout->user_group_name = $request->user_group_name;
            $userRoleLayout->narration = $request->narration;
            $userRoleLayout->permissions = $request->permissions;
            $userRoleLayout->created = $request->created_at;
            $userRoleLayout->updated = $request->updated_at;
            $userRoleLayout->update();

            $successMsg = "Updated";

        } else {
            $userRoleLayout = new UserGroupLayout();
            $userRoleLayout->user_id = Auth::user()->id;
            $userRoleLayout->user_group_name = 1;
            $userRoleLayout->narration = 1;
            $userRoleLayout->permissions = 1;
            $userRoleLayout->created = $request->created_at;
            $userRoleLayout->updated = $request->updated_at;
            $userRoleLayout->save();

            $successMsg = "Saved";
        }

        return json_encode($successMsg);
    }

    public function getMember($userGroupId){
        $usersHaveGrouped = User::whereHas("roles", function($q) use($userGroupId) {
                                        $q->where("id", $userGroupId);
                                    })->where('active', 1)
                                ->orderBy('name')
                                ->get();

        $usersHaveGroupedIds =  User::whereHas("roles", function($q) use($userGroupId) {
                                            $q->where("id", $userGroupId);
                                        })->where('active', 1)->get()->pluck('id');

        $usersHaveNoGroup = User::where('active', 1)->whereNotIn('id', $usersHaveGroupedIds)->orderBy('name')->get();

        return json_encode(array( $usersHaveGrouped, $usersHaveNoGroup));
    }
    public function addMember(Request $request){
        $role = Role::find($request->user_group_members_group_id);
        $editUser = User::find($request->user);
        $userRoleArr = json_decode($editUser->role_id);
        if($userRoleArr != null){
            if(!in_array($request->user_group_members_group_id, $userRoleArr)){
                array_push($userRoleArr, $request->user_group_members_group_id);
                $editUser->role_id = json_encode($userRoleArr);
                $editUser->update();
            }
        } else {
            $newArr = [];
            array_push($newArr, $request->user_group_members_group_id);
            $editUser->role_id = json_encode($newArr);
            $editUser->update();
        }
        $editUser->assignRole($role);
        return response()->json(['succcess' => 'updated !'], 200);
    }
    public function deleteMember(Request $request){
        $role = Role::find($request->user_group_members_group_id);
        $editUser = User::find($request->user);
        $userRoleArr = json_decode($editUser->role_id);

        if($userRoleArr != null){
            if(in_array($request->user_group_members_group_id, $userRoleArr)){
                $newArr = [];
                foreach($userRoleArr as $arr){
                    if($arr != $request->user_group_members_group_id){
                        array_push($newArr, $arr);
                    }
                }

                $editUser->role_id = json_encode($newArr);
                $editUser->update();
            }
        }
        $editUser->removeRole($role);
        return response()->json(['succcess' => 'updated !'], 200);
    }

    public function updateMember(Request $request){
        $role = Role::find($request->user_group_members_group_id);

        if(isset($request->users)){
            foreach($request->users as $user){
                $editUser = User::find($user);
                $userRoleArr = json_decode($editUser->role_id);
                if($userRoleArr != null){
                    if(!in_array($request->user_group_members_group_id, $userRoleArr)){
                        array_push($userRoleArr, $request->user_group_members_group_id);
                        $editUser->role_id = json_encode($userRoleArr);
                        $editUser->update();
                    }
                } else {
                    $newArr = [];
                    array_push($newArr, $request->user_group_members_group_id);
                    $editUser->role_id = json_encode($newArr);
                    $editUser->update();
                }
                $editUser->assignRole($role);
            }

            $otherUsers = User::whereNotIn('id', $request->users)->get();
            foreach($otherUsers as $otherUser){
                $otherUserRoleArr = json_decode($otherUser->role_id);
                if($otherUserRoleArr != null){
                    if(in_array($request->user_group_members_group_id, $otherUserRoleArr)){
                        $newArr = [];
                        foreach($otherUserRoleArr as $arr){
                            if($arr != $request->user_group_members_group_id){
                                array_push($newArr, $arr);
                            }
                        }
                        $otherUser->role_id = json_encode($newArr);
                        $otherUser->update();
                    }
                }
                $otherUser->removeRole($role);
            }
        } else {
            $allUsers = User::all();
            foreach($allUsers as $allUser){
                $allUserRoleArr = json_decode($allUser->role_id);
                if($allUserRoleArr != null){
                    if(in_array($request->user_group_members_group_id, $allUserRoleArr)){
                        $newArr = [];
                        foreach($allUserRoleArr as $arr){
                            if($arr != $request->user_group_members_group_id){
                                array_push($newArr, $arr);
                            }
                        }
                        $allUser->role_id = json_encode($newArr);
                        $allUser->update();
                    }
                }
                $allUser->removeRole($role);
            }
        }
        // $groupMembers = UserGroupMember::where('user_group_id', $request->user_group_members_group_id)->where('active', 1)->get();

        // if(count($groupMembers) > 0){
        //     dd('greater');
        // } else {
        //     if(isset($request->users)){
        //         foreach($request->users as $user){
        //             $newGroupMember = new UserGroupMember();
        //             $newGroupMember->user_group_id = $request->user_group_members_group_id;
        //             $newGroupMember->user_id = $user;
        //             $newGroupMember->active = 1;
        //             $newGroupMember->save();
        //         }
        //     }
        // }
        return redirect()->back()->withSuccess('User Group Members Updated Successfully!');
    }

    public function userGroupPermissionList(Request $request)
    {
        $role = Role::find($request->groupId);
        $permissions = $role->permissions;

        return response()->json(['permission' => $permissions]);
    }

    public function userGroupPermissions(){
        // $userRoles = UserRole::orderBy('user_role_name')->where('active', 1)->get();
        // $userGroups = Role::orderBy('name')->where('active', 1)->get();

        //     $userGroupLayout = UserGroupLayout::where('user_id', Auth::user()->id)->first();

        //     $columnLayout = ColumnLayout::where('interface_id', 11)->where('user_id', Auth::user()->id)->first();

        return view('pages.user_group_permissions.user_group_permissions');
}
}
