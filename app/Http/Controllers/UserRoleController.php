<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use App\Models\ColumnLayout;
use App\Models\UserRoleLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;
use App\Models\Role;

class UserRoleController extends Controller
{
    public function index()
    {
        if (auth()->user()->can('view user group')) {
            // $userRoles = UserRole::orderBy('user_role_name')->where('active', 1)->get();
            $userRoles = Role::orderBy('name')->where('active', 1)->get();

            $userRoleLayout = UserRoleLayout::where('user_id', Auth::user()->id)->first();

            $columnLayout = ColumnLayout::where('interface_id', 10)->where('user_id', Auth::user()->id)->first();

            return view('pages.users.user_roles.index', ['userRoles' => $userRoles, 'userRoleLayout' => $userRoleLayout, 'columnLayout' => $columnLayout]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    // public function add(){
    //     return view('pages.users.user_roles.create');
    // }

    public function create(Request $request)
    {
        // $userRole = new UserRole();
        $userRole = new Role();
        $userRole->name = $request->new_user_role_name;
        $userRole->narration = $request->new_narration;
        $userRole->active = 1;
        $userRole->save();

        return redirect()->route('user_roles')->withSuccess('User Role Saved Successfully!');
    }

    public function delete($id)
    {
        // $userRole = UserRole::find($id);
        $userRole = Role::find($id);
        $userRole->syncPermissions([]);
        $userRole->active = 0;
        $userRole->update();

        return redirect()->route('user_roles')->withSuccess('User Role Deleted Successfully!');
    }

    public function edit($userRoleId)
    {
        // $userRole = UserRole::find($userRoleId);
        $userRole = Role::find($userRoleId);
        return json_encode($userRole);

        // return view('pages.users.user_roles.edit', ['userRole'=>$userRole]);
    }

    public function update(Request $request)
    {
        // $userRole = UserRole::find($request->user_role_id);
        $userRole = Role::find($request->user_role_id);
        $userRole->name = $request->edit_user_role_name;
        $userRole->narration = $request->edit_narration;
        $userRole->update();

        return redirect()->route('user_roles')->withSuccess('User Role Updated Successfully!');
    }

    public function sortByAlphabet($id)
    {
        // $userRoles = UserRole::where('user_role_name', 'LIKE', $id.'%')->where('active', 1)->orderBy('user_role_name')->get();
        $userRoles = Role::where('name', 'LIKE', $id . '%')->where('active', 1)->orderBy('name')->get();

        return json_encode($userRoles);
    }

    public function detail($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['error' => 'Not found'], 404);
        }

        $users = $role->users()->get()->map(function ($user) {
            return [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'profile_pic' => $user->profile_pic ?? null,
            ];
        });

        return response()->json([
            'name'      => $role->name,
            'narration' => $role->narration,
            'users'     => $users,
        ]);
    }
    public function layout(Request $request)
    {
        if (UserRoleLayout::where('user_id', Auth::user()->id)->first()) {
            $userRoleLayout = UserRoleLayout::find($request->layout_id);
            $userRoleLayout->user_role_name = $request->user_role_name;
            $userRoleLayout->narration = $request->narration;
            $userRoleLayout->created = $request->created_at;
            $userRoleLayout->updated = $request->updated_at;
            $userRoleLayout->update();

            $successMsg = "Updated";
        } else {
            $userRoleLayout = new UserRoleLayout();
            $userRoleLayout->user_id = Auth::user()->id;
            $userRoleLayout->user_role_name = 1;
            $userRoleLayout->narration = 1;
            $userRoleLayout->created = $request->created_at;
            $userRoleLayout->updated = $request->updated_at;
            $userRoleLayout->save();

            $successMsg = "Saved";
        }

        return json_encode($successMsg);
    }

    public function permissions()
    {
        $userPermissions = Permission::all();
        $roles = Role::where('active', 1)->get();

        return view('pages.permissions.permission', compact('userPermissions', 'roles'));
    }

    public function createPermissions(Request $request)
    {
        $permission = Permission::create(['name' => $request->permission_name]);
        if (isset($request->roles)) {
            foreach ($request->roles as $permissionRole) {
                $role = Role::find($permissionRole);
                $permission->assignRole($role);
            }
        }
        return redirect()->back()->withSuccess('Permission Saved Successfully!');
    }

    public function editPermissions($id)
    {
        $permission = Permission::find($id);
        $roleArr = $permission->roles;
        return json_encode(array($permission, $roleArr));
    }

    public function updatePermissions(Request $request)
    {
        $permission = Permission::find($request->permission_id);
        $permission->name = $request->permission_name;
        $permission->save();
        $rIds = [];
        if (isset($request->roles)) {
            foreach ($request->roles as $permissionRole) {
                array_push($rIds, $permissionRole);
            }
        }
        $role = Role::whereIn('id', $rIds)->get();
        $permission->syncRoles($role);
        return redirect()->back()->withSuccess('Permission Updated Successfully!');
    }

    public function deletePermissions($id)
    {
        $permission = Permission::find($id);
        $permission->syncRoles([]);
        $permission->delete();
        return redirect()->back()->withSuccess('Permission Deleted Successfully!');
    }
}
