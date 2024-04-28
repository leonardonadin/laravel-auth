<?php

namespace App\Http\Controllers\Site\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class ResetPassworController extends Controller
{

    /**
     * Show the form for reset password.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('site.auth.reset-password');
    }

    /**
     * Handle an reset password attempt.
     *
     * @param  \App\Http\Requests\Auth\ResetPasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $credentials = $request->only('email');

        if (UserService::resetPassword($credentials)) {
            return redirect()->route('site.auth.verify-email', ['email' => $credentials['email']])
                ->with('success', __('auth.user_registered'));
        }

        return redirect()->back()->with('error', __('auth.failed'));
    }
}
