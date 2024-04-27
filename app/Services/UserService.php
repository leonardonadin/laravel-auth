<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{

    public function __construct(private UserRepository $userRepository)
    {
    }

    /**
     * Log the user into the application.
     *
     * @param array $data
     * @return bool
     */
    public function login(array $credentials): bool
    {
        if (auth()->attempt($credentials)) {
            return true;
        }

        return false;
    }

    /**
     * Log the user out of the application.
     */
    public function logout()
    {
        auth()->logout();
    }

    /**
     * Register a new user.
     *
     * @param array $data
     * @return bool
     */
    public function register(array $data): bool
    {
        $user = $this->userRepository->create($data);

        if ($user) {
            $this->login($data);
            return true;
        }

        return false;
    }
}
