<?php

namespace App\Infrastructure\Task;

use App\Domain\Task\Task;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class TaskRepository
{
    private EntityManagerInterface $entityManager;
    private EntityRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Task::class);
    }

    public function findAll(): array
    {
        return $this->repository->findBy([], ['id' => 'DESC']); // Get tasks sorted by newest
    }

    public function save(Task $task): void
    {
        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }
}