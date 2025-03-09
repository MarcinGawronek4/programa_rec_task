<?php

namespace App\Controller;

use App\Application\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Domain\Task\Task;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\UserRepositoryInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Domain\Task\Event\TaskUpdatedEvent;

class TaskController extends AbstractController
{
    private TaskService $taskService;
    private EntityManagerInterface $entityManager;
    private UserRepositoryInterface $userRepository;
    private MessageBusInterface $eventBus;

    public function __construct(TaskService $taskService, EntityManagerInterface $entityManager, UserRepositoryInterface $userRepository, MessageBusInterface $eventBus)
    {
        $this->taskService = $taskService;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->eventBus = $eventBus;
    }

    #[Route('/tasks', name: 'task_list', methods: ['GET', 'POST'])]
    public function taskList(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $tasks = $this->taskService->getTasksForUser($this->getUser());
        $users = in_array('ROLE_ADMIN', $this->getUser()->getRoles()) ? $this->userRepository->findAll() : [];

        return $this->render('tasks/index.html.twig', [
            'tasks' => $tasks,
            'users' => $users,
        ]);
    }

    #[Route('/tasks/create', name: 'task_create', methods: ['POST'])]
    public function createTask(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['name'])) {
            return new JsonResponse(['error' => 'Task name is required'], 400);
        }

        $task = $this->taskService->createTask($data['name'], $data['description'] ?? null, $data['status'], $data['assignedUserId']);

        return new JsonResponse(['message' => 'Task created successfully', 'task' => $task], 201);
    }

    #[Route('/tasks/update-status/{id}', name: 'task_update_status', methods: ['POST'])]
    public function updateTaskStatus(Request $request, Task $task): JsonResponse
    {
        if (!$this->getUser()) {
            return new JsonResponse(['error' => 'Unauthorized'], 403);
        }

        $data = json_decode($request->getContent(), true);
        if (!isset($data['status'])) {
            return new JsonResponse(['error' => 'Status is required'], 400);
        }

        $oldStatus = $task->getStatus();
        $newStatus = $data['status'];

      
        if ($oldStatus !== $newStatus) {
            $task->setStatus($newStatus);
            $this->entityManager->flush();


            $this->eventBus->dispatch(new TaskUpdatedEvent($task->getId(), $oldStatus, $newStatus));
        }

        return new JsonResponse(['message' => 'Task status updated', 'status' => $task->getStatus()]);
    }

}