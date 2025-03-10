<?php

namespace App\Application\Service;

use App\Domain\Task\AssignmentInterface;
use App\Domain\Task\Strategy\AdminAssignment;
use App\Domain\Task\Strategy\SelfAssignment;
use App\Domain\User\User;
use App\Infrastructure\User\UserRepository;

class AssignmentContext
{
    private AssignmentInterface $assignment;

    public function __construct(User $user, UserRepository $userRepository)
    {
        $this->assignment = in_array('ROLE_ADMIN', $user->getRoles()) 
            ? new AdminAssignment($userRepository)
            : new SelfAssignment();
    }

    public function getAssignedUser(User $currentUser, ?int $assignedUserId = null): User
    {
        return $this->assignment->getAssignedUser($currentUser, $assignedUserId);
    }
}