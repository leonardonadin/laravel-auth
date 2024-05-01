<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    public static function firstUserWhen(string $column, string $value): ?object
    {
        return UserRepository::findByColumn($column, $value);
    }

    public static function createUser(array $data): ?object
    {
        return UserRepository::create($data);
    }

    public static function updateUser(object $user, array $data): bool
    {
        return UserRepository::update($user, $data);
    }

    public static function setEmailVerified(string $email): bool
    {
        return UserRepository::setEmailVerified($email);
    }
}
