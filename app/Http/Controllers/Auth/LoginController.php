<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Auth\AdminRememberPolicy;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Default redirect after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Only active users can log in.
     */
    protected function credentials(Request $request): array
    {
        return [
            $this->username() => $request->input($this->username()),
            'password' => $request->input('password'),
            'active' => 1,
        ];
    }

    /**
     * User ID 1 and 5 remain logged in for 30 days.
     * Other users use the normal session duration.
     */
    protected function attemptLogin(Request $request): bool
    {
        $credentials = $this->credentials($request);

        $user = User::query()
            ->where(
                $this->username(),
                $request->input($this->username())
            )
            ->where('active', 1)
            ->first();

        $policy = new AdminRememberPolicy(
            config('admin_auth.remember_user_ids', [1, 5]),
            (int) config('admin_auth.remember_duration_minutes', 43200)
        );

        $remember = $user !== null && $policy->shouldRemember((int) $user->id);

        if ($remember) {
            // 30 days in minutes
            $this->guard()->setRememberDuration($policy->durationMinutes());
        }

        return $this->guard()->attempt(
            $credentials,
            $remember
        );
    }

    /**
     * Optional custom redirect after login.
     */
    protected function authenticated(Request $request, $user)
    {

        return redirect()->intended($this->redirectPath());
    }
}
