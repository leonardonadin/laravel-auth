<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create(array $data)
    {
        return User::create($data);
    }

    public function update(User $user, array $data)
    {
        return $user->update($data);
    }

    public function delete(User $user)
    {
        return $user->delete();
    }

    public function find(int $id)
    {
        return User::find($id);
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }
}
