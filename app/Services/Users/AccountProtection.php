<?php

namespace App\Services\Users;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Auth\Access\AuthorizationException;

final class AccountProtection
{
    public function privileged(User $user): bool
    {
        return (int) $user->getKey() === 1 || $user->isAdmin() || $user->hasRole('Super Admin');
    }

    public function assertCanAssign(User $actor, Collection $roles): void
    {
        if ($roles->contains(fn ($role) => (int) $role->getKey() === 1 || strcasecmp($role->name, 'Super Admin') === 0)
            && ! $actor->hasRole('Super Admin')) {
            throw new AuthorizationException('Only a Super Admin can assign privileged roles.');
        }
    }

    public function assertCanEdit(User $actor, User $target): void
    {
        if ($this->privileged($target) && ! $actor->hasRole('Super Admin')) {
            throw new AuthorizationException('This account is protected.');
        }
    }

    public function assertCanDeactivate(User $actor, User $target): void
    {
        if ($this->privileged($target) || (int) $actor->getKey() === (int) $target->getKey()) {
            throw new AuthorizationException('Protected accounts and your own account cannot be deactivated.');
        }
    }
}
