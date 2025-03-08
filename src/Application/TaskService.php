<?php

namespace App\Application;

use App\Domain\Task\Event\TaskCreatedEvent;
use App\Domain\Task\Task;
use App\Infrastructure\Task\TaskRepository;
use Symfony\Component\Messenger\MessageBusInterface;

class TaskService
{
    private TaskRepository $taskRepository;
    private MessageBusInterface $eventBus;

    public function __construct(TaskRepository $taskRepository, MessageBusInterface $eventBus)
    {
        $this->taskRepository = $taskRepository;
        $this->eventBus = $eventBus;
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
        $task->setAssignedUserId(1);
        $this->taskRepository->save($task);
        $this->eventBus->dispatch(new TaskCreatedEvent($task->getId(), $task->getName(), $task->getDescription(), $task->getStatus(), $task->getAssignedUserId()));

        return $task;
    }
}