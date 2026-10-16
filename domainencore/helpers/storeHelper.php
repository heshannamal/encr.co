<?php

use Illuminate\Support\Facades\Config;

if (!function_exists('makeStoreDomainRoute')) {
    function makeStoreDomainRoute(string $route): string
    {
        return rtrim(env('STORE_DOMAIN'), '/') . '/' . ltrim($route, '/');
    }
}
