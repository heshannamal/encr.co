<?php

namespace Tests\Unit;

use App\Services\Modernization\PaymentMode;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PaymentModeTest extends TestCase
{
    public function test_valid_modes_are_preserved(): void
    {
        self::assertSame(PaymentMode::Sandbox, PaymentMode::fromConfiguration('sandbox'));
        self::assertSame(PaymentMode::Live, PaymentMode::fromConfiguration('live'));
    }

    public function test_invalid_mode_is_rejected(): void
    {
        $this->expectException(InvalidArgumentException::class);

        PaymentMode::fromConfiguration('invalid');
    }

    public function test_missing_mode_is_rejected(): void
    {
        $this->expectException(InvalidArgumentException::class);

        PaymentMode::fromConfiguration(null);
    }
}
