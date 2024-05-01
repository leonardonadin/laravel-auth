<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyEmailRequest;
use App\Http\Requests\Auth\VerifyEmailStoreRequest;
use App\Services\AuthService;
use App\Services\UserVerifyService;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{

    /**
     * Show the form for email verification.
     *
     * @param \App\Http\Requests\Auth\VerifyEmailRequest $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        if (!$request->email) {
            return view('auth.verify-email');
        }

        $this->redirectIfEmailIsVerified($request->email);

        return view('auth.verify-email', ['email' => $request->email]);
    }

    /**
     * Store the email verification.
     *
     * @param \App\Http\Requests\Auth\VerifyEmailStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(VerifyEmailStoreRequest $request)
    {
        $this->redirectIfEmailIsVerified($request->email);

        if ($request->token) {
            return $this->verifyTokenOrRedirect($request->email, $request->token);
        }

        UserVerifyService::startVerification($request->email);

        return redirect()->back()->with('success', __('auth.verify_email_sent'));
    }

    /**
     * Resend the verification email.
     *
     * @param \App\Http\Requests\Auth\VerifyEmailRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resend(VerifyEmailRequest $request)
    {
        $this->redirectIfEmailIsVerified($request->email);
        $this->redirectIfEmailCantBeVerified($request->email);

        UserVerifyService::resendVerificationEmail($request->email);

        return redirect()->route('auth.verify-email')
            ->with('success', __('auth.verify_email_sent'))
            ->withInput($request->only('email'));
    }

    /**
     * Verify the email.
     *
     * @param string $email
     * @param string $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(string $email, string $token)
    {
        $this->redirectIfEmailIsVerified($email);

        return $this->verifyTokenOrRedirect($email, $token);
    }

    /**
     * Redirect if the email is verified.
     *
     * @param string $email
     * @return \Illuminate\Http\RedirectResponse|null
     */
    private function redirectIfEmailIsVerified(string $email)
    {
        if (AuthService::checkUserIsVerifiedByLogin($email)) {
            return redirect()->route('auth.verify-email')->with('success', __('auth.verify_email_sent'));
        }
    }

    /**
     * Redirect if the email can't be verified.
     *
     * @param string $email
     * @return \Illuminate\Http\RedirectResponse|null
     */
    private function redirectIfEmailCantBeVerified(string $email)
    {
        if (UserVerifyService::emailCantBeVerified($email)) {
            return redirect()->route('auth.verify-email')->with('success', __('auth.verify_email_sent'));
        }
    }

    /**
     * Verify the email with the token or redirect.
     *
     * @param string $login
     * @param string $token
     * @return \Illuminate\Http\RedirectResponse
     */
    private function verifyTokenOrRedirect(string $login, string $token)
    {
        if (UserVerifyService::verifyEmailWithToken($login, $token)) {
            return redirect()->route('auth.login')->with('success', __('auth.email_verified'));
        }

        return redirect()->route('auth.verify-email')->with('success', __('auth.verify_email_sent'));
    }
}
