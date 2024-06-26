<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{

    /**
     * Show the form for reset password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $token
     * @return \Illuminate\View\View
     */
    public function create(Request $request, string $token)
    {
        return view('auth.password.reset', [
            'token' => $token,
            'email' => $request->email ?? ''
        ]);
    }

    /**
     * Handle an reset password attempt.
     *
     * @param  \App\Http\Requests\Auth\ResetPasswordRequest  $request
     * @param  string  $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ResetPasswordRequest $request, string $token)
    {
        $credentials = $request->only('email', 'password', 'password_confirmation');

        if (AuthService::resetPassword([
            ...$credentials,
            'token' => $token
        ])) {
            return redirect()->route('auth.login')
                ->with('success', __('auth.password_reseted'));
        }

        return redirect()->back()->withErrors([
            'email' => __('auth.password_reset_failed')
        ]);
    }
}
