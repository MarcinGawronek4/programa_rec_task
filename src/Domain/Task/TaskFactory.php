<?php

namespace App\Domain\Task;

use App\Domain\User\User;

class TaskFactory
{
    public function create(string $name, ?string $description, User $assignedUser): Task
    {
        $task = new Task();
        $task->setName($name);
        $task->setDescription($description);
        $task->setStatus('to_do');
        $task->setAssignedUser($assignedUser);

        return $task;
    }
}