<?php

namespace App\Repositories;

use App\Models\User;

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
}
