<?php

namespace App\Controller;

use App\Application\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class TaskController extends AbstractController
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    #[Route('/tasks', name: 'task_list')]
    #[IsGranted("ROLE_USER")]
    public function listTasks()
    {
        $user = $this->getUser();
        $tasks = $this->taskService->getTasksForUser($user);

        return $this->render('list.html.twig', [
            'tasks' => $tasks,
        ]);
    }
}