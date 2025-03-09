<?php

namespace App\Domain\Task;

use App\Domain\User\User;

interface AssignmentInterface
{
    public function getAssignedUser(User $currentUser, ?int $assignedUserId = null): User;
}