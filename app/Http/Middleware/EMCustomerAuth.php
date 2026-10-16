<?php

namespace App\Http\Middleware;

use Closure;

class EMCustomerAuth
{
    public function handle($request, Closure $next)
    {
        if (!session('em_customer_id')) {
            return redirect()->route('em.customer.landing.index');
        }
        return $next($request);
    }
}
