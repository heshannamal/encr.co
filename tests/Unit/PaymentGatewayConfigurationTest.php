<?php

namespace Tests\Unit;

use App\Services\Modernization\PaymentGatewayConfiguration;
use App\Services\Modernization\PaymentMode;
use Illuminate\Config\Repository;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

class PaymentGatewayConfigurationTest extends TestCase
{
    public function test_selects_only_the_requested_configuration(): void
    {
        $sandbox = ['environment' => 'sandbox'];
        $live = ['environment' => 'production'];

        $service = new PaymentGatewayConfiguration(new Repository([
            'payment_gateway' => ['sandbox' => $sandbox, 'live' => $live],
        ]));

        self::assertSame($sandbox, $service->forMode(PaymentMode::Sandbox));
        self::assertSame($live, $service->forMode(PaymentMode::Live));
    }

    public function test_missing_configuration_is_rejected(): void
    {
        $service = new PaymentGatewayConfiguration(new Repository());

        $this->expectException(UnexpectedValueException::class);

        $service->forMode(PaymentMode::Sandbox);
    }
}
