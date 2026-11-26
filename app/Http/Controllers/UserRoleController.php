<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use App\Models\ColumnLayout;
use App\Models\UserRoleLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;
use App\Models\Role;
use App\Services\Users\RoleManagementService;
use Illuminate\Validation\Rule;

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
        $this->authorize('add usergroups');
        $request->validate([
            'new_user_role_name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->where('guard_name', 'web')],
            'new_narration' => ['nullable', 'string'],
        ]);
        app(RoleManagementService::class)->assertNameAllowed($request->new_user_role_name);
        $userRole = new Role();
        $userRole->guard_name = 'web';
        $userRole->name = $request->new_user_role_name;
        $userRole->narration = $request->new_narration;
        $userRole->active = 1;
        $userRole->save();

        return redirect()->route('user_roles')->withSuccess('User Role Saved Successfully!');
    }

    public function delete($id)
    {
        $this->authorize('delete usergroups');
        app(RoleManagementService::class)->deactivate(Role::findOrFail($id));

        return redirect()->route('user_roles')->withSuccess('User Role Deleted Successfully!');
    }

    public function edit($userRoleId)
    {
        // $userRole = UserRole::find($userRoleId);
        $this->authorize('edit usergroups');
        $userRole = Role::findOrFail($userRoleId);
        return json_encode($userRole);

        // return view('pages.users.user_roles.edit', ['userRole'=>$userRole]);
    }

    public function update(Request $request)
    {
        // $userRole = UserRole::find($request->user_role_id);
        $this->authorize('edit usergroups');
        $request->validate(['user_role_id' => ['required', 'integer', 'exists:roles,id']]);
        $userRole = Role::findOrFail($request->user_role_id);
        $service = app(RoleManagementService::class);
        $service->assertEditable($userRole);
        $request->validate([
            'edit_user_role_name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->where('guard_name', $userRole->guard_name)->ignore($userRole->getKey())],
            'edit_narration' => ['nullable', 'string'],
        ]);
        $service->assertNameAllowed($request->edit_user_role_name);
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
        $this->authorize('view usergroups');
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
            $userRoleLayout = UserRoleLayout::where('user_id', Auth::id())->findOrFail($request->layout_id);
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
        abort_unless(auth()->user()?->hasRole('Super Admin'), 403);
        $userPermissions = Permission::all();
        $roles = Role::where('active', 1)->get();

        return view('pages.permissions.permission', compact('userPermissions', 'roles'));
    }

    public function createPermissions(Request $request)
    {
        abort_unless(auth()->user()?->hasRole('Super Admin'), 403);
        $data = $request->validate([
            'permission_name' => ['required', 'string', 'max:255', Rule::unique('permissions', 'name')->where('guard_name', 'web')],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['integer', 'distinct', Rule::exists('roles', 'id')->where('active', 1)->where('guard_name', 'web')],
        ]);
        app(RoleManagementService::class)->savePermission(new Permission(), $data['permission_name'], $data['roles'] ?? []);
        return redirect()->back()->withSuccess('Permission Saved Successfully!');
    }

    public function editPermissions($id)
    {
        abort_unless(auth()->user()?->hasRole('Super Admin'), 403);
        $permission = Permission::findOrFail($id);
        $roleArr = $permission->roles;
        return json_encode(array($permission, $roleArr));
    }

    public function updatePermissions(Request $request)
    {
        abort_unless(auth()->user()?->hasRole('Super Admin'), 403);
        $request->validate(['permission_id' => ['required', 'integer', 'exists:permissions,id']]);
        $permission = Permission::findOrFail($request->permission_id);
        $data = $request->validate([
            'permission_name' => ['required', 'string', 'max:255', Rule::unique('permissions', 'name')->where('guard_name', $permission->guard_name)->ignore($permission->getKey())],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['integer', 'distinct', Rule::exists('roles', 'id')->where('active', 1)->where('guard_name', $permission->guard_name)],
        ]);
        app(RoleManagementService::class)->savePermission($permission, $data['permission_name'], $data['roles'] ?? []);
        return redirect()->back()->withSuccess('Permission Updated Successfully!');
    }

    public function deletePermissions($id)
    {
        abort_unless(auth()->user()?->hasRole('Super Admin'), 403);
        $permission = Permission::findOrFail($id);
        \Illuminate\Support\Facades\DB::transaction(function () use ($permission): void {
            $permission->syncRoles([]);
            $permission->delete();
        });
        return redirect()->back()->withSuccess('Permission Deleted Successfully!');
    }
}
