<?php

namespace App\Http\Controllers\Site\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\UserService;

class LoginController extends Controller
{

    /**
     * Show the form for login.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('site.auth.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \App\Http\Requests\User\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (UserService::login($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('site.home'))->with('success', __('auth.success'));
        }

        if (!UserService::checkEmailIsVerified($credentials['email'])) {
            return redirect()->route('site.auth.verify-email', ['email' => $credentials['email']])
                ->with('message', __('auth.verify_email'));
        }

        return redirect()->route('site.auth.login')->with('error', __('auth.failed'));
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        UserService::logout();

        return redirect()->route('home');
    }
}
