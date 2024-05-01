<?php

namespace App\Services;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthService
{

    /**
     * Log the user into the application.
     *
     * @param array $data
     * @return bool
     */
    public static function login(array $credentials): bool
    {
        if (Auth::attempt(self::sanitizeCredentials($credentials))) {
            return true;
        }

        return false;
    }

    /**
     * Log the user out of the application.
     */
    public static function logout(): void
    {
        Auth::logout();
    }

    /**
     * Register a new user.
     *
     * @param array $data
     * @return bool
     */
    public static function register(array $data): bool
    {
        $user = UserService::createUser($data);

        if ($user) {
            UserVerifyService::startVerification($data['email']);

            return true;
        }

        return false;
    }

    /**
     * Reset the user password.
     *
     * @param string $login
     * @return bool
     */
    public static function forgotPassword(string $login): bool
    {
        $user = self::getUserByLogin($login);

        if (!$user) {
            return false;
        }

        Password::deleteToken($user);

        ResetPassword::createUrlUsing(function (object $user, string $token) {
            return route('auth.password.reset', [
                'email' => $user->email,
                'token' => $token
            ]);
        });

        $result = Password::sendResetLink([
            'email' => $user->email
        ]);

        return $result === Password::RESET_LINK_SENT;
    }

    /**
     * Resend the user password.
     *
     * @param string $login
     * @return bool
     */
    public static function resendForgotPassword(string $login): bool
    {
        return self::forgotPassword($login);
    }

    /**
     * Reset the user password.
     *
     * @param array $data
     * @return bool
     */
    public static function resetPassword(array $data): bool
    {
        $result = Password::reset(self::sanitizeCredentials($data), function ($user, $password) {
            $user->password = $password;
            $user->save();

            event(new PasswordReset($user));
        });

        return $result === Password::PASSWORD_RESET;
    }

    public static function checkUserIsVerifiedByLogin(string $login): bool
    {
        $user = self::getUserByLogin($login);
        return $user && $user->is_verified;
    }



    public static function getUserByLogin(string $login): ?object
    {
        return UserService::firstUserWhen(static::identifyLoginType($login), $login);
    }

    private static function sanitizeCredentials(array $credentials): array
    {
        if (isset($credentials['login'])) {
            return self::assignLoginCredentials($credentials);
        }

        return $credentials;
    }

    private static function assignLoginCredentials(array $credentials): array
    {
        $login = $credentials['login'];
        $column = self::identifyLoginType($login);

        $credentials[$column] = $login;
        unset($credentials['login']);

        return $credentials;
    }

    private static function identifyLoginType(string $login): string
    {
        return filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
    }
}
