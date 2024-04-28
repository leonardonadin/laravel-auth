<?php

namespace App\Http\Controllers\Site\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Services\UserService;
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
        return view('site.auth.password.forgot', [
            'email' => $request->email ?? null,
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
        UserService::forgotPassword($request->email);

        return redirect()->route('site.auth.password.forgot')
            ->with('success', __('auth.password_reset_link_sent'));
    }
}
