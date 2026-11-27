<?php

namespace App\Services\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class PortalSession
{
    public const INTENDED = 'customer_portal.intended';

    public function isCustomer(Request $request): bool
    {
        $context = $request->session()->get('customer_portal_user');

        return is_array($context) && !empty($context[0]) && !empty($context[1]);
    }

    public function isAdmin(Request $request): bool
    {
        $context = $request->session()->get('customer_portal_admin');
        $valid = is_array($context) && Auth::check()
            && (int) Auth::user()->active === 1
            && isset($context['user_id'])
            && (int) $context['user_id'] === (int) Auth::id()
            && !empty($context['organization_id']);

        if (!$valid && $context !== null) {
            $request->session()->forget('customer_portal_admin');
        }

        return $valid;
    }

    public function authenticated(Request $request): bool
    {
        return $this->isCustomer($request) || $this->isAdmin($request);
    }

    public function clear(Request $request): void
    {
        $request->session()->forget([
            'customer_portal_user', 'customer_portal_admin',
            'customer_portal_org_image', 'customer_portal_org_name',
            'portal_notice_acknowledged', self::INTENDED,
        ]);
    }

    public function rememberDestination(Request $request): void
    {
        if ($request->isMethod('GET')) {
            $request->session()->put(self::INTENDED, $request->fullUrl());
        }
    }
}
