<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{

    public static function getUserByEmail(string $email)
    {
        return UserRepository::findByEmail($email);
    }

    /**
     * Log the user into the application.
     *
     * @param array $data
     * @return bool
     */
    public static function login(array $credentials): bool
    {
        if (!self::checkEmailIsVerified($credentials['email'])) {
            return false;
        }

        if (auth()->attempt($credentials)) {
            return true;
        }

        return false;
    }

    /**
     * Log the user out of the application.
     */
    public static function logout()
    {
        auth()->logout();
    }

    /**
     * Register a new user.
     *
     * @param array $data
     * @return bool
     */
    public static function register(array $data): bool
    {
        $user = UserRepository::create($data);

        if ($user) {
            UserVerifyService::startVerification($data['email']);

            return true;
        }

        return false;
    }

    /**
     * Reset the user password.
     *
     * @param array $data
     * @return bool
     */
    public static function resetPassword(array $data): bool
    {
        if (!self::checkEmailIsVerified($data['email'])) {
            return false;
        }

        UserRepository::findByEmail($data['email'])->sendEmailResetPasswordNotification();

        return true;
    }

    public static function checkEmailIsVerified(string $email): bool
    {
        return UserRepository::findByEmail($email)->hasVerifiedEmail();
    }

    public static function verifyEmail(string $email): bool
    {
        $user = UserRepository::findByEmail($email);

        if (!$user) {
            return false;
        }

        $user->markEmailAsVerified();

        return $user->hasVerifiedEmail();
    }
}
