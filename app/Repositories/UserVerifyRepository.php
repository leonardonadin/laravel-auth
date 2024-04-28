<?php

namespace App\Repositories;

use App\Models\UserVerify;

class UserVerifyRepository
{
    public static function create(array $data)
    {
        return UserVerify::create($data);
    }

    public static function update(UserVerify $verify, array $data)
    {
        return $verify->update($data);
    }

    public static function delete(UserVerify $verify)
    {
        return $verify->delete();
    }

    public static function find(int $id)
    {
        return UserVerify::find($id);
    }

    public static function findByEmail(string $email)
    {
        return UserVerify::where('email', $email)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public static function findByEmailAndToken(string $email, string $token)
    {
        return UserVerify::where('email', $email)
            ->where('token', $token)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public static function getExpiredUserVerifies()
    {
        return UserVerify::where('created_at', '<', now()->subDay())
            ->get();
    }
}
