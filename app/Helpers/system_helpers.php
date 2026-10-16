<?php


use App\Models\SystemConfiguration;

if (!function_exists('getPaymentGatewayConfig')) {
    function getPaymentGatewayConfig(): array
    {
        // Get mode from DB (system_configurations table), fallback to env default
        $mode = SystemConfiguration::getValue('payment_mode', config('payment_gateway.mode'));

        // Validate mode
        if (!in_array($mode, ['sandbox', 'live'])) {
            $mode = 'live'; // default to safe sandbox
        }

        return config("payment_gateway.$mode");
    }
}

