<?php

namespace App\Controller;

use App\Application\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/tasks')]
class TaskController extends AbstractController
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    #[Route('/get',  methods: ['POST'])]
    #[IsGranted("ROLE_USER")]
    public function listTasks()
    {
        $user = $this->getUser();
        $tasks = $this->taskService->getTasksForUser($user);

        return $this->render('tasks/list.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    #[Route('/create',  methods: ['POST'])]
    #[IsGranted("ROLE_USER")]
    public function createTask(Request $request): JsonResponse
    {
        $taskName = $request->request->get('taskName');
        $taskDescription = $request->request->get('taskDescription');
        $taskStatus = $request->request->get('taskStatus');

        if (!$taskName || !$taskDescription || !$taskStatus) {
            return new JsonResponse(['message' => 'All fields are required!'], 400);
        }

        $user = $this->getUser(); // Get the logged-in user

        $this->taskService->createTask($taskName, $taskDescription, $taskStatus, $user);

        return new JsonResponse(['message' => 'Task successfully created!']);
    }
}