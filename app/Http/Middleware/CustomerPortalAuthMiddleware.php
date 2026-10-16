<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CustomerPortalAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Normal Customer Portal User
        |--------------------------------------------------------------------------
        */
        if (Session::has('customer_portal_user')) {
            return $next($request);
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Admin / System User Accessing Customer Portal
        |--------------------------------------------------------------------------
        |
        | Admin must still be logged in through Laravel Auth
        | AND must have selected an organization to view.
        |
        */
        if (
            Auth::check() &&
            Session::has('customer_portal_admin')
        ) {
            $portalAdmin = Session::get('customer_portal_admin');

            /*
            |--------------------------------------------------------------------------
            | Extra security check
            |--------------------------------------------------------------------------
            | Make sure the admin session belongs to the currently logged-in user.
            */
            if (
                isset($portalAdmin['user_id']) &&
                (int) $portalAdmin['user_id'] === (int) Auth::id() &&
                !empty($portalAdmin['organization_id'])
            ) {
                return $next($request);
            }

            /*
            |--------------------------------------------------------------------------
            | Invalid / stale admin portal session
            |--------------------------------------------------------------------------
            */
            Session::forget('customer_portal_admin');
        }

        /*
        |--------------------------------------------------------------------------
        | No Valid Customer Portal Authentication
        |--------------------------------------------------------------------------
        */
        Session::put('url.intended', $request->fullUrl());

        return redirect()
            ->route('customer_portal.login')
            ->with(
                'error',
                'Please log in to access the customer portal.'
            );
    }
}