<?php

namespace App\Domain\Task;

use App\Domain\User\User;

class TaskFactory
{
    public function create(string $name, ?string $description, string $status, User $assignedUser): Task
    {
        $task = new Task();
        $task->setName($name);
        $task->setDescription($description);
        $task->setStatus($status);
        $task->setAssignedUser($assignedUser);

        return $task;
    }
}