<?php

use App\Services\Modernization\PaymentGatewayConfiguration;

if (! function_exists('getPaymentGatewayConfig')) {
    function getPaymentGatewayConfig(): array
    {
        return app(PaymentGatewayConfiguration::class)->resolve();
    }
}
