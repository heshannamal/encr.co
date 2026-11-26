<?php

namespace Tests\Unit;

use App\Services\Auth\AdminRememberPolicy;
use PHPUnit\Framework\TestCase;

class AdminRememberPolicyTest extends TestCase
{
    public function test_existing_administrator_policy(): void
    {
        $policy = new AdminRememberPolicy([1, 5], 43200);

        self::assertTrue($policy->shouldRemember(1));
        self::assertTrue($policy->shouldRemember(5));
        self::assertFalse($policy->shouldRemember(2));
        self::assertSame(43200, $policy->durationMinutes());
    }

    public function test_policy_can_be_configured(): void
    {
        $policy = new AdminRememberPolicy([7], 60);

        self::assertFalse($policy->shouldRemember(1));
        self::assertTrue($policy->shouldRemember(7));
        self::assertSame(60, $policy->durationMinutes());
    }
}
