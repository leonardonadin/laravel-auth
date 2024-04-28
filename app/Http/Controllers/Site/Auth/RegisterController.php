<?php

namespace App\Http\Controllers\Site\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\UserService;

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
     * @param  \App\Http\Requests\Auth\RegisterRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(RegisterRequest $request)
    {
        $credentials = $request->only('name', 'email', 'phone', 'password');

        if (UserService::register($credentials)) {
            return redirect()->route('site.auth.verify-email', ['email' => $credentials['email']])
                ->with('success', __('auth.registered'));
        }

        return redirect()->back()->with('error', __('auth.register_failed'));
    }

}
