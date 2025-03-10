<?php

namespace App\Application\Service;

use App\Domain\User\UserRepositoryInterface;

class UserService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUsers(): array
    {
        return $this->userRepository->fetchAll();
    }

    public function saveUsers(): array
    {
        $users = $this->userRepository->fetchAll();
        $this->userRepository->saveMultiple($users);
        
        return $users;
    }
}