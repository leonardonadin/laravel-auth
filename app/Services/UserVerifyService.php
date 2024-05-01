<?php

namespace App\Services;

use App\Notifications\VerifyUserNotification;
use App\Repositories\UserVerifyRepository;

class UserVerifyService
{

    public static function getExpiredUserVerifies(): array
    {
        return UserVerifyRepository::getExpiredUserVerifies();
    }

    public static function emailCantBeVerified(string $email): bool
    {
        return UserVerifyRepository::findByEmail($email) !== null && !UserService::firstUserWhen('email', $email);
    }

    public static function startVerification(string $email): bool
    {
        if (self::emailCantBeVerified($email)) {
            return false;
        }

        $token = self::generateToken();
        UserVerifyRepository::create([
            'email' => $email,
            'token' => $token
        ]);

        self::sendVerificationEmail($email, $token);

        return true;
    }

    public static function resendVerificationEmail(string $email): bool
    {
        $userVerify = UserVerifyRepository::findByEmail($email);

        if (!$userVerify) {
            return false;
        }

        UserVerifyRepository::update($userVerify, [
            'token' => self::generateToken()
        ]);

        self::sendVerificationEmail($email, $userVerify->token);

        return true;
    }

    public static function verifyEmailWithToken(string $email, string $token): bool
    {
        $userVerify = UserVerifyRepository::findByEmailAndToken($email, $token);

        if (!$userVerify) {
            return false;
        }

        $userVerify->delete();

        return UserService::setEmailVerified($email);
    }

    private static function generateToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    private static function sendVerificationEmail(string $email, string $token): void
    {
        $user = UserService::firstUserWhen('email', $email);

        if (!$user) {
            return;
        }

        $user->notify(new VerifyUserNotification($email, $token));
    }
}
