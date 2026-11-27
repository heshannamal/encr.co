<?php

namespace App\Http\Middleware;

use App\Models\EMCustomer;
use Closure;
use Illuminate\Http\Request;

class EMCustomerAuth
{
    public function handle(Request $request, Closure $next)
    {
        $id = $request->session()->get('em_customer_id');

        if (!$id || !EMCustomer::whereKey($id)->where('is_active', 1)->exists()) {
            $request->session()->forget('em_customer_id');
            return redirect()->route('em.customer.landing.index');
        }

        return $next($request);
    }
}
