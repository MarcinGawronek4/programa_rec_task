<?php

namespace App\Domain\Task\Strategy;

use App\Domain\Task\AssignmentInterface;
use App\Domain\User\User;

class SelfAssignment implements AssignmentInterface
{
    public function getAssignedUser(User $currentUser, ?int $assignedUserId = null): User
    {
        return $currentUser; 
    }
}