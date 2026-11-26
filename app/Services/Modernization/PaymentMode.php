<?php

namespace App\Services\Modernization;

use InvalidArgumentException;

enum PaymentMode: string
{
    case Sandbox = 'sandbox';
    case Live = 'live';

    public static function fromConfiguration(mixed $value): self
    {
        if (! is_string($value) || self::tryFrom($value) === null) {
            throw new InvalidArgumentException('Invalid payment gateway mode.');
        }

        return self::from($value);
    }
}
