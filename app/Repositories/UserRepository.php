<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Password;

class UserRepository
{
    public static function create(array $data)
    {
        return User::create($data);
    }

    public static function update(User $user, array $data)
    {
        return $user->update($data);
    }

    public static function delete(User $user)
    {
        return $user->delete();
    }

    public static function find(int $id)
    {
        return User::find($id);
    }

    public static function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public static function forgotPassword(string $email): bool
    {
        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return route('site.auth.password.reset', [
                'email' => $user->email,
                'token' => $token
            ]);
        });

        $result = Password::sendResetLink([
            'email' => $email
        ]);

        return $result === Password::RESET_LINK_SENT;
    }

    public static function resetPassword(array $credentials): bool
    {
        $result = Password::reset($credentials, function ($user, $password) {
            $user->password = $password;
            $user->save();

            event(new PasswordReset($user));
        });

        return $result === Password::PASSWORD_RESET;
    }
}
