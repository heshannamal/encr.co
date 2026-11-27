<?php

namespace Tests\Unit;

use App\Services\Auth\SafeRedirect;
use PHPUnit\Framework\TestCase;

class SafeRedirectTest extends TestCase
{
    public function test_allows_internal_and_same_origin_destinations(): void
    {
        $service = new SafeRedirect();
        self::assertSame('/checkout', $service->resolve('/checkout', 'https://example.com'));
        self::assertSame('https://example.com/orders', $service->resolve('https://example.com/orders', 'https://example.com'));
    }

    public function test_rejects_untrusted_destinations(): void
    {
        $service = new SafeRedirect();

        foreach (['//evil.example', 'https://evil.example', 'http://example.com', 'https://example.com:444', 'https://example.com@evil.example', '/\\evil.example', 'javascript:alert(1)', null, []] as $destination) {
            self::assertNull($service->resolve($destination, 'https://example.com'));
        }
    }
}
