<?php

namespace App\Services\Auth;

final class SafeRedirect
{
    public function resolve(mixed $destination, string $origin): ?string
    {
        if (!is_string($destination) || $destination === '' || preg_match('/[\x00-\x20\x7f\\\\]/', $destination)) {
            return null;
        }

        if (str_starts_with($destination, '/') && !str_starts_with($destination, '//')) {
            return $destination;
        }

        $target = parse_url($destination);
        $base = parse_url($origin);

        if (!$target || !$base || isset($target['user'], $target['pass']) || isset($target['user']) || isset($target['pass'])) {
            return null;
        }

        $scheme = strtolower($target['scheme'] ?? '');
        if (!in_array($scheme, ['http', 'https'], true)
            || $scheme !== strtolower($base['scheme'] ?? '')
            || strtolower($target['host'] ?? '') !== strtolower($base['host'] ?? '')
            || ($target['port'] ?? ($scheme === 'https' ? 443 : 80)) !== ($base['port'] ?? ($scheme === 'https' ? 443 : 80))) {
            return null;
        }

        return $destination;
    }
}
