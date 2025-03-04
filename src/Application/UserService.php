<?php

namespace App\Application;

use App\Infrastructure\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUsers(): array
    {
        return $this->userRepository->fetchAll();
    }
}