<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;

class RegisterController extends Controller
{

    /**
     * Show the form for register.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('auth.register');
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

        if (AuthService::register($credentials)) {
            return redirect()->route('auth.verify-email', ['email' => $credentials['email']])
                ->with('success', __('auth.registered'));
        }

        return redirect()->route('auth.register')->with('error', __('auth.register_failed'));
    }

}
