<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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

        $remember = $user && (int) ($user->id === 5 || $user->id === 1);

        if ($remember) {
            // 30 days in minutes
            $this->guard()->setRememberDuration(43200);
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
