<?php

namespace App\Domain\Task\Strategy;

use App\Domain\Task\AssignmentInterface;
use App\Domain\User\User;
use App\Infrastructure\UserRepository;

class AdminAssignment implements AssignmentInterface
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAssignedUser(User $currentUser, ?int $assignedUserId = null): User
    {
        if ($assignedUserId) {
            $assignedUser = $this->userRepository->findById($assignedUserId);
            if ($assignedUser) {
                return $assignedUser;
            }
        }

        return $currentUser; 
    }
}