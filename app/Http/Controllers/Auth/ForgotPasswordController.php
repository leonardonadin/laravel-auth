<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{

    /**
     * Show the form for forgot password.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('auth.password.forgot', [
            'login' => $request->login ?? null,
        ]);
    }

    /**
     * Handle an forgot password attempt.
     *
     * @param  \App\Http\Requests\Auth\ForgotPasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ForgotPasswordRequest $request)
    {
        AuthService::forgotPassword($request->login);

        return redirect()->route('auth.password.forgot')
            ->with('success', __('auth.password_reset_link_sent'));
    }

    /**
     * Handle an forgot password resend attempt.
     *
     * @param  \App\Http\Requests\Auth\ForgotPasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resend(ForgotPasswordRequest $request)
    {
        AuthService::resendForgotPassword($request->login);
    }
}
