<?php

namespace App\Http\Controllers\Site\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\RegisterRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    /**
     * Show the form for register.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('site.auth.register');
    }

    /**
     * Handle an register attempt.
     *
     * @param  \App\Http\Requests\Site\RegisterRequest  $request
     * @param  \App\Services\UserService  $userService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(RegisterRequest $request, UserService $userService)
    {
        $credentials = $request->only('name', 'email', 'password');

        if ($userService->register($credentials)) {
            return redirect()->route('site.home');
        }

        return redirect()->back()->with('error', __('auth.failed'));
    }

    /**
     * Show the view for verify email.
     *
     * @return \Illuminate\View\View
     */
    public function showVerifyEmail()
    {
        return view('site.auth.verify-email');
    }

}
