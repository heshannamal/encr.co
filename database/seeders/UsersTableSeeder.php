<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        if (! app()->environment('local', 'testing')) {
            throw new RuntimeException('Administrator bootstrap is for local and testing environments only.');
        }

        $email = config('bootstrap_admin.email');
        $password = config('bootstrap_admin.password');

        if (! is_string($email) || ! filter_var($email, FILTER_VALIDATE_EMAIL)
            || ! is_string($password) || $password === '') {
            throw new RuntimeException('Configure the bootstrap administrator email and password first.');
        }

        if (User::query()->exists()) {
            throw new RuntimeException('Administrator bootstrap requires an empty users table.');
        }

        DB::transaction(function () use ($email, $password): void {
            $role = Role::findOrCreate('Super Admin', 'web');
            $user = new User();
            $user->forceFill([
                'id' => 1,
                'name' => 'Super Admin',
                'email' => $email,
                'email_verified_at' => now(),
                'password' => Hash::make($password),
                'role_id' => json_encode([$role->getKey()]),
                'active' => 1,
            ]);
            $user->save();
            $user->assignRole($role);
        });

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
