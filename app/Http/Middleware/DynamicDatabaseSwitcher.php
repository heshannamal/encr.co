<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;

class DynamicDatabaseSwitcher
{
    public function handle($request, Closure $next)
    {
        if (Cache::has('selected_db')) {
            switchDatabaseConnection(Cache::get('selected_db'));
        }

        return $next($request);
    }
}

