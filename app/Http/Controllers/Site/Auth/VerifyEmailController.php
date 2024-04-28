<?php

namespace App\Http\Controllers\Site\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyEmailRequest;
use App\Http\Requests\Auth\VerifyEmailStoreRequest;
use App\Services\UserService;
use App\Services\UserVerifyService;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{

    public function create(Request $request)
    {
        if (!$request->email) {
            return view('site.auth.verify-email');
        }

        $this->redirectIfEmailIsVerified($request->email);

        return view('site.auth.verify-email', ['email' => $request->email]);
    }

    public function store(VerifyEmailStoreRequest $request)
    {
        $this->redirectIfEmailIsVerified($request->email);

        if ($request->token) {
            return $this->verifyTokenOrRedirect($request->email, $request->token);
        }

        UserVerifyService::startVerification($request->email);

        return redirect()->back()->with('success', __('auth.verify_email_sent'));
    }

    public function resend(VerifyEmailRequest $request)
    {
        $this->redirectIfEmailIsVerified($request->email);
        $this->redirectIfEmailCantBeVerified($request->email);

        UserVerifyService::resendVerificationEmail($request->email);

        return redirect()->route('site.auth.verify-email')
            ->with('success', __('auth.verify_email_sent'))
            ->withInput($request->only('email'));
    }

    public function verify(string $email, string $token)
    {
        $this->redirectIfEmailIsVerified($email);

        return $this->verifyTokenOrRedirect($email, $token);
    }

    private function redirectIfEmailIsVerified($email)
    {
        if (UserService::checkEmailIsVerified($email)) {
            return redirect()->route('site.auth.verify-email')->with('success', __('auth.verify_email_sent'));
        }
    }

    private function redirectIfEmailCantBeVerified($email)
    {
        if (!UserVerifyService::emailCanBeVerified($email)) {
            return redirect()->route('site.auth.verify-email')->with('success', __('auth.verify_email_sent'));
        }
    }

    private function verifyTokenOrRedirect($email, $token)
    {
        if (UserVerifyService::verifyEmailWithToken($email, $token)) {
            return redirect()->route('site.auth.login')->with('success', __('auth.email_verified'));
        }

        return redirect()->route('site.auth.verify-email')->with('success', __('auth.verify_email_sent'));
    }
}
