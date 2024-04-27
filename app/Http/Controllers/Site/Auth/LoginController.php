<?php

namespace App\Http\Controllers\Site\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\LoginRequest;
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
        return view('site.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \App\Http\Requests\Site\LoginRequest  $request
     * @param  \App\Services\UserService  $userService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request, UserService $userService)
    {
        $credentials = $request->only('email', 'password');

        if ($userService->login($credentials)) {
            return redirect()->route('site.home');
        }

        return redirect()->back()->with('error', __('auth.failed'));
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        auth()->logout();
        return redirect()->route('site.home');
    }
}
