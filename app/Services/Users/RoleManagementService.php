<?php

namespace App\Services\Users;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

final class RoleManagementService
{
    public function assertEditable(Role $role): void
    {
        if ((int) $role->getKey() === 1 || strcasecmp($role->name, 'Super Admin') === 0) {
            throw ValidationException::withMessages(['role' => 'The protected administrator role cannot be modified here.']);
        }
    }

    public function assertNameAllowed(string $name): void
    {
        if (strcasecmp(trim($name), 'Super Admin') === 0) {
            throw ValidationException::withMessages(['role' => 'The Super Admin role name is reserved.']);
        }
    }

    public function deactivate(Role $role): void
    {
        $this->assertEditable($role);

        DB::transaction(function () use ($role): void {
            $role->syncPermissions([]);
            $role->active = 0;
            $role->save();
        });
    }

    public function savePermission(Permission $permission, string $name, array $roleIds): void
    {
        DB::transaction(function () use ($permission, $name, $roleIds): void {
            $permission->name = $name;
            $permission->guard_name = $permission->guard_name ?? 'web';
            $permission->save();
            $roles = Role::whereIn('id', $roleIds)->where('guard_name', $permission->guard_name)->get();
            $permission->syncRoles($roles);
        });
    }
}
