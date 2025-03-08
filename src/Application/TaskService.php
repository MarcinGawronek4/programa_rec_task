<?php

namespace App\Application;

use App\Domain\Task\Event\TaskCreatedEvent;
use App\Domain\Task\Task;
use App\Infrastructure\Task\TaskRepository;
use App\Infrastructure\UserRepository;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Domain\User\User;
use Symfony\Bundle\SecurityBundle\Security;

class TaskService
{
    private TaskRepository $taskRepository;
    private UserRepository $userRepository;
    private Security $security;
    private MessageBusInterface $eventBus;

    public function __construct(
        TaskRepository $taskRepository, 
        UserRepository $userRepository, 
        Security $security,
    ) {
        $this->taskRepository = $taskRepository;
        $this->userRepository = $userRepository;
        $this->security = $security;
    }


    public function getTasksForUser(User $user): array
    {
        return $this->taskRepository->findAll($user);
    }

    public function createTask(string $name, ?string $description, string $status, ?int $assignedUserId = null): Task
    {
        $currentUser = $this->security->getUser();

        if (!$currentUser) {
            throw new \Exception("No authenticated user found.");
        }

        $task = new Task();
        $task->setName($name);
        $task->setDescription($description);
        $task->setStatus($status);
        if (in_array('ROLE_ADMIN', $currentUser->getRoles()) && $assignedUserId) {
            $assignedUser = $this->userRepository->findById($assignedUserId);
            if (!$assignedUser) {
                throw new \Exception("User not found.");
            }
            $task->setAssignedUser($assignedUser);
        } else {
            $task->setAssignedUser($currentUser);
        }
        $this->taskRepository->save($task);
        $this->eventBus->dispatch(new TaskCreatedEvent($task->getId(), $task->getName(), $task->getDescription(), $task->getStatus(), $assignedUserId));

        return $task;
    }
}