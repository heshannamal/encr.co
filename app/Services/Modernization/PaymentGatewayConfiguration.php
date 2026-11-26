<?php

namespace App\Services\Modernization;

use App\Models\SystemConfiguration;
use Illuminate\Contracts\Config\Repository;
use UnexpectedValueException;

final class PaymentGatewayConfiguration
{
    public function __construct(private Repository $config)
    {
    }

    public function resolve(): array
    {
        $mode = SystemConfiguration::getValue(
            'payment_mode',
            $this->config->get('payment_gateway.mode')
        );

        return $this->forMode(PaymentMode::fromConfiguration($mode));
    }

    public function forMode(PaymentMode $mode): array
    {
        $configuration = $this->config->get('payment_gateway.'.$mode->value);

        if (! is_array($configuration)) {
            throw new UnexpectedValueException('Payment gateway configuration is missing.');
        }

        return $configuration;
    }
}
