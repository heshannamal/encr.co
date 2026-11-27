<?php

namespace App\Http\Middleware;

use App\Services\Auth\PortalSession;
use Closure;
use Illuminate\Http\Request;

class CustomerPortalAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $portal = app(PortalSession::class);

        if ($portal->authenticated($request)) {
            return $next($request);
        }

        $portal->rememberDestination($request);

        return redirect()->route('customer_portal.login')
            ->with('error', 'Please log in to access the customer portal.');
    }
}
