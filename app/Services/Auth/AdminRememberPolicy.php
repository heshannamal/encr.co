<?php

namespace App\Services\Auth;

final class AdminRememberPolicy
{
    public function __construct(
        private array $userIds,
        private int $durationMinutes
    ) {
    }

    public function shouldRemember(int $userId): bool
    {
        return in_array($userId, $this->userIds, true);
    }

    public function durationMinutes(): int
    {
        return $this->durationMinutes;
    }
}
