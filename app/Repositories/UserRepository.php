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

    public static function findByColumn(string $column, string $value)
    {
        return User::where($column, $value)->first();
    }

    public static function setEmailVerified(string $email): bool
    {
        $user = self::findByColumn('email', $email);

        if (!$user) {
            return false;
        }

        $user->markEmailAsVerified();

        return $user->hasVerifiedEmail();
    }
}
