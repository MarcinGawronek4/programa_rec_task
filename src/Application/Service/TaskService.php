<?php

namespace App\Application\Service;

use App\Domain\Task\Event\TaskCreatedEvent;
use App\Domain\Task\TaskFactory;
use App\Domain\Task\Task;
use App\Infrastructure\Task\TaskRepository;
use App\Infrastructure\User\UserRepository;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Domain\User\User;
use Symfony\Bundle\SecurityBundle\Security;

class TaskService
{
    private TaskRepository $taskRepository;
    private UserRepository $userRepository;
    private TaskFactory $taskFactory;
    private Security $security;
    private MessageBusInterface $eventBus;

    public function __construct(
        TaskRepository $taskRepository, 
        UserRepository $userRepository, 
        TaskFactory $taskFactory, 
        Security $security,
        MessageBusInterface $eventBus
    ) {
        $this->taskRepository = $taskRepository;
        $this->userRepository = $userRepository;
        $this->taskFactory = $taskFactory;
        $this->security = $security;
        $this->eventBus = $eventBus;
    }


    public function getTasksForUser(User $user): array
    {
        return $this->taskRepository->findAll($user);
    }

    public function createTask(string $name, ?string $description, $status, ?int $assignedUserId = null): Task
    {
        $currentUser = $this->security->getUser();
        if (!$currentUser) {
            throw new \Exception("No authenticated user found.");
        }

        $assignmentContext = new AssignmentContext($currentUser, $this->userRepository);
        $assignedUser = $assignmentContext->getAssignedUser($currentUser, $assignedUserId);

        if (!$assignedUser) {
            throw new \Exception("User not found.");
        }

        $task = $this->taskFactory->create($name, $description, $status, $assignedUser);
        $this->taskRepository->save($task);

        $this->eventBus->dispatch(new TaskCreatedEvent(
            $task->getId(), 
            $task->getName(), 
            $task->getDescription(),
            $task->getStatus(),
            $task->getAssignedUser()->getId()
        ));

        return $task;
    }
}