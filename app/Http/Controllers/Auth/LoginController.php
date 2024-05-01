<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;

class LoginController extends Controller
{

    /**
     * Show the form for login.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \App\Http\Requests\User\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('login', 'password');

        $user = AuthService::getUserByLogin($credentials['login']);

        if ($user) {
            if (!$user->is_verified) {
                return redirect()->route('auth.verify-email', [
                        'email' => $credentials['login']
                    ])
                    ->with('error', __('auth.verify_email'));
            }

            if (AuthService::login($credentials)) {
                $request->session()->regenerate();

                return redirect()->intended(route('app.home'))->with('success', __('auth.success'));
            }
        }

        return redirect()->route('auth.login')
            ->withErrors([
                'email' => __('auth.failed')
            ]);
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        AuthService::logout();

        return redirect()->route('home');
    }
}
