<?php

namespace App\Application;

use App\Domain\Task;
use App\Domain\User;
use App\Infrastructure\TaskRepository;

class TaskService
{
    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getTasksForUser(User $user): array
    {
        return $this->taskRepository->findByUser($user);
    }

    public function createTask(string $name, string $description, string $status, User $assignedUser): void
    {
        $task = new Task($name, $description, $status, $assignedUser);
        $this->taskRepository->save($task);
    }
}