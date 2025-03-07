<?php

namespace App\Application;

use App\Domain\Task\Task;
use App\Infrastructure\Task\TaskRepository;

class TaskService
{
    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getAllTasks(): array
    {
        return $this->taskRepository->findAll();
    }

    public function createTask(string $name, ?string $description, string $status): Task
    {
        $task = new Task();
        $task->setName($name);
        $task->setDescription($description);
        $task->setStatus($status);
        $this->taskRepository->save($task);

        return $task;
    }
}